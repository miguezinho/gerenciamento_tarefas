<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectTasks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ProjectTasksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $project_tasks = ProjectTasks::with(['user', 'project'])
            ->whereHas('project.members', function ($query) {
                $query->where('user_id', Auth::user()->id);
            })
            ->get();

        return Inertia::render('ProjectTasks/Index', ['project_tasks' => $project_tasks]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $projects = Project::where(['user_id' => Auth::user()->id])->get();

        if (count($projects) == 0)
            return redirect()->route('project_tasks.index')->with('error', 'Você precisa criar um projeto antes de criar uma tarefa!');

        return Inertia::render('ProjectTasks/Create', [
            'projects' => $projects,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate(
            [
                'project_id' => 'required',
                'title' => 'required',
                'description' => 'required',
                'due_date' => 'required',
                'priority' => 'required',
                'status' => 'required',
            ],
            [
                'project_id.required' => 'O Projeto é obrigatório.',
                'title.required' => 'O título é obrigatório.',
                'description.required' => 'A descrição é obrigatória.',
                'due_date.required' => 'O vencimento é obrigatório.',
                'priority.required' => 'A prioridade é obrigatória.',
                'status.required' => 'O status é obrigatório.',
            ]
        );

        $validatedData['user_id'] = Auth::user()->id;

        ProjectTasks::create($validatedData);

        return redirect()->route('project_tasks.index')->with('success', 'Tarefa criada com sucesso!');
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
        $project_tasks = ProjectTasks::with(['user', 'project'])
            ->where("id", $id)
            ->whereHas('project.members', function ($query) {
                $query->where('user_id', Auth::user()->id);
            })
            ->first();

        if (!$project_tasks)
            return redirect()->route('projects.index')->with('error', 'Somente membros do projeto podem editar as tarefas!');

        return Inertia::render('ProjectTasks/Edit', [
            'project_task' => $project_tasks
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $project_task = ProjectTasks::with(['user', 'project'])
            ->where("id", $id)
            ->whereHas('project.members', function ($query) {
                $query->where('user_id', Auth::user()->id);
            })
            ->first();

        if (!$project_task)
            return redirect()->route('projects.index')->with('error', 'Somente membros do projeto podem editar as tarefas!');

        $validatedData = $request->validate(
            [
                'project_id' => 'required',
                'title' => 'required',
                'description' => 'required',
                'due_date' => 'required',
                'priority' => 'required',
                'status' => 'required',
            ],
            [
                'project_id.required' => 'O Projeto é obrigatório.',
                'title.required' => 'O título é obrigatório.',
                'description.required' => 'A descrição é obrigatória.',
                'due_date.required' => 'O vencimento é obrigatório.',
                'priority.required' => 'A prioridade é obrigatória.',
                'status.required' => 'O status é obrigatório.',
            ]
        );

        $project_task->update($validatedData);

        return redirect()->route('project_tasks.index')->with('success', 'Tarefa alterada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $projectTasks = ProjectTasks::findOrFail($id);

        if ($projectTasks->project->user_id != Auth::user()->id)
            return redirect()->route('project_tasks.index')->with('error', 'Somente o criador do projeto pode excluir tarefas relacionadas ao mesmo!');

        if (!$projectTasks->delete())
            return redirect()->route('project_tasks.index')->with('error', 'Erro ao deletar o tarefa!');

        return redirect()->route('project_tasks.index')->with('success', 'Tarefa deletada com sucesso!');
    }
}
