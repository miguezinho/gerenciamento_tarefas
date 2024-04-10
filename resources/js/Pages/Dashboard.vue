<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import { router } from '@inertiajs/vue3';

export default {
    components: {
        AppLayout,
    },

    props: {
        projects: Object,
        project_tasks_pending: Object,
        project_tasks_late: Object,
    },

    methods: {
        projectsRedirect() {
            router.get(route('projects.index'));
        },

        tasksRedirect(id) {
            router.get(route('project_tasks.index', id));
        },
    },

    mounted() {
        console.log(this.projects)
    }

}
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div>
                        <div
                            class="bg-gray-200 bg-opacity-25 grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8 p-6 lg:p-8">
                            <div>
                                <div class="flex items-center text-blue-500">
                                    <i class="fa-solid fa-diagram-project fa-2xl"></i>
                                    <h2 class="ms-3 text-xl font-semibold text-gray-900">
                                        <a href="#" @click="projectsRedirect()">Projetos</a>
                                    </h2>
                                </div>

                                <div class="mt-4" v-if="projects.length">
                                    <p class="text-blue-800 text-sm font-semibold leading-relaxed my-4">
                                        Você atualmente é membro em {{ projects.length }} projeto(s).
                                    </p>
                                    <p v-for="project in projects" class="text-gray-500 text-sm leading-relaxed">
                                        - {{ project.title }}
                                    </p>
                                </div>

                                <p v-if="!projects.length"
                                    class="text-blue-800 text-sm font-semibold leading-relaxed my-4">
                                    Você ainda não é membro de nenhum projeto.
                                </p>

                                <p class="mt-4 text-sm">
                                    <a href="#" @click="projectsRedirect()"
                                        class="inline-flex items-center font-semibold text-indigo-700">
                                        Ir para os projetos

                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                            class="ms-1 w-5 h-5 fill-indigo-500">
                                            <path fill-rule="evenodd"
                                                d="M5 10a.75.75 0 01.75-.75h6.638L10.23 7.29a.75.75 0 111.04-1.08l3.5 3.25a.75.75 0 010 1.08l-3.5 3.25a.75.75 0 11-1.04-1.08l2.158-1.96H5.75A.75.75 0 015 10z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </a>
                                </p>
                            </div>

                            <div>
                                <div class="flex items-center text-yellow-500">
                                    <i class="fa-solid fa-list-check fa-2xl"></i>
                                    <h2 class="ms-3 text-xl font-semibold text-gray-900">
                                        <a href="#" @click="tasksRedirect()">Tarefas Pendentes</a>
                                    </h2>
                                </div>

                                <div class="mt-4" v-if="project_tasks_pending.length">
                                    <p class="text-yellow-600 text-sm font-semibold leading-relaxed my-4">
                                        Você atualmente tem {{ project_tasks_pending.length }} tarefa(s) pendente(s).
                                    </p>
                                    <p v-for="task in project_tasks_pending"
                                        class="text-gray-500 text-sm leading-relaxed">
                                        - {{ task.title }}
                                    </p>
                                </div>

                                <p v-if="!project_tasks_pending.length"
                                    class="text-yellow-800 text-sm font-semibold leading-relaxed my-4">
                                    Você não possui nenhuma tarefa pendente.
                                </p>

                                <p class="mt-4 text-sm">
                                    <a href="#" @click="tasksRedirect()"
                                        class="inline-flex items-center font-semibold text-indigo-700">
                                        Ir para as tarefas

                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                            class="ms-1 w-5 h-5 fill-indigo-500">
                                            <path fill-rule="evenodd"
                                                d="M5 10a.75.75 0 01.75-.75h6.638L10.23 7.29a.75.75 0 111.04-1.08l3.5 3.25a.75.75 0 010 1.08l-3.5 3.25a.75.75 0 11-1.04-1.08l2.158-1.96H5.75A.75.75 0 015 10z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </a>
                                </p>
                            </div>

                            <div class="">
                                <div class="flex items-center text-red-700">
                                    <i class="fa-solid fa-triangle-exclamation fa-2xl"></i>
                                    <h2 class="ms-3 text-xl font-semibold text-gray-900">
                                        <a href="#" @click="tasksRedirect()">Tarefas Atrasadas</a>
                                    </h2>
                                </div>

                                <div class="mt-4" v-if="project_tasks_late.length">
                                    <p class="text-red-600 text-sm font-semibold leading-relaxed my-4">
                                        Você atualmente tem {{ project_tasks_late.length }} tarefa(s) atrasada(s).
                                    </p>
                                    <p v-for="task in project_tasks_late"
                                        class="text-gray-500 text-sm leading-relaxed">
                                        - {{ task.title }}
                                    </p>
                                </div>

                                <p v-if="!project_tasks_late.length"
                                    class="text-red-800 text-sm font-semibold leading-relaxed my-4">
                                    Você não possui nenhuma tarefa atrasada.
                                </p>

                                <p class="mt-4 text-sm">
                                    <a href="#" @click="tasksRedirect()"
                                        class="inline-flex items-center font-semibold text-indigo-700">
                                        Ir para as tarefas

                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                            class="ms-1 w-5 h-5 fill-indigo-500">
                                            <path fill-rule="evenodd"
                                                d="M5 10a.75.75 0 01.75-.75h6.638L10.23 7.29a.75.75 0 111.04-1.08l3.5 3.25a.75.75 0 010 1.08l-3.5 3.25a.75.75 0 11-1.04-1.08l2.158-1.96H5.75A.75.75 0 015 10z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
