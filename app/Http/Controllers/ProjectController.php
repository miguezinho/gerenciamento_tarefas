<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectMembers;
use App\Models\ProjectTasks;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::with(['user', 'members.user'])->get();

        return Inertia::render('Projects/Index', ['projects' => $projects]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::orderBy('name')->get();

        return Inertia::render('Projects/Create', ['users' => $users]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'start_date' => 'required',
            'expected_completion_date' => 'required',
        ], [
            'title.required' => 'O título é obrigatório.',
            'description.required' => 'A descrição é obrigatória.',
            'start_date.required' => 'A data de início é obrigatória.',
            'expected_completion_date.required' => 'A previsão de conclusão é obrigatória.',
        ]);

        $validatedData['user_id'] = Auth::user()->id;

        $project = Project::create($validatedData);

        if ($request->members) {
            foreach ($request->members as $user_id) {
                $project_member = [
                    'user_id' => $user_id,
                    'project_id' => $project->id
                ];
                ProjectMembers::create($project_member);
            }
        }

        return redirect()->route('projects.index')->with('success', 'Projeto criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $project = Project::with('members')->findOrFail($id);

        if ($project->user_id != Auth::user()->id)
            return redirect()->route('projects.index')->with('error', 'Você não tem permissão para editar esse projeto!');

        $users = User::orderBy('name')->get();

        return Inertia::render('Projects/Edit', [
            'users' => $users,
            'project' => $project
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $project = Project::findOrFail($id);

        if ($project->user_id != Auth::user()->id)
            return redirect()->route('projects.index')->with('error', 'Você não tem permissão para editar esse projeto!');

        $validatedData = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'start_date' => 'required',
            'expected_completion_date' => 'required',
        ], [
            'title.required' => 'O título é obrigatório.',
            'description.required' => 'A descrição é obrigatória.',
            'start_date.required' => 'A data de início é obrigatória.',
            'expected_completion_date.required' => 'A previsão de conclusão é obrigatória.',
        ]);

        $project->update($validatedData);

        if ($request->members) {
            if ($project->members) {
                foreach ($project->members as $member) {
                    $member->delete();
                }
            }

            foreach ($request->members as $user_id) {
                $project_member = [
                    'user_id' => $user_id,
                    'project_id' => $project->id
                ];
                ProjectMembers::create($project_member);
            }
        }

        return redirect()->route('projects.index')->with('success', 'Projeto alterado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $project = Project::findOrFail($id);

        if ($project->user_id != Auth::user()->id)
            return redirect()->route('projects.index')->with('error', 'Você não tem permissão para excluir esse projeto!');

        if ($project->members) {
            foreach ($project->members as $member) {
                $member->delete();
            }
        }

        if ($project->tasks) {
            foreach ($project->tasks as $task) {
                $task->delete();
            }
        }

        if (!Project::destroy($id))
            return redirect()->route('projects.index')->with('error', 'Erro ao deletar o projeto!');

        return redirect()->route('projects.index')->with('success', 'Projeto deletado com sucesso!');
    }
}
