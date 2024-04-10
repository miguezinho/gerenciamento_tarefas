<template>
    <AppLayout title="Tarefas">
        <template #header>
            <h2 class="flex justify-between text-xl font-semibold leading-tight text-gray-800">
                <p>
                    Tarefas
                </p>

                <a href="#" @click="create()">
                    <a
                        class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        Nova Tarefa
                    </a>
                </a>
            </h2>
        </template>

        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class=" bg-white shadow-xl sm:rounded-lg">
                <div class="grid grid-cols-2 lg:gap-4 m-6">
                    <div class="m-6">
                        <label class="block mb-2 text-sm font-bold text-gray-700" for="priority">
                            Prioridade
                        </label>
                        <select @change="filter()" id="priority"
                            class="w-full px-3 py-2 mb-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline">
                            <option value="T">Todas</option>
                            <option value="Baixa">Baixa</option>
                            <option value="Média">Média</option>
                            <option value="Alta">Alta</option>
                        </select>
                    </div>
                    <div class="m-6">
                        <label class="block mb-2 text-sm font-bold text-gray-700" for="priority">
                            Status
                        </label>
                        <select @change="filter()" id="status"
                            class="w-full px-3 py-2 mb-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline">
                            <option value="T">Todos</option>
                            <option value="Pendente">Pendente</option>
                            <option value="Andamento">Andamento</option>
                            <option value="Concluída">Concluída</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="py-2">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 overflow-x-auto">
                <div class=" bg-white shadow-xl sm:rounded-lg">
                    <div class="flex">
                        <div class="min-w-full">
                            <div v-if="$page.props.flash.success"
                                class="rounded-md text-white font-extrabold text-center bg-emerald-500 p-4 m-4">
                                <span class="m-4">{{ $page.props.flash.success }}</span>
                            </div>
                            <div v-if="$page.props.flash.error"
                                class="rounded-md text-white font-extrabold text-center bg-red-500 p-4 m-4">
                                <span class="m-4">{{ $page.props.flash.error }}</span>
                            </div>
                        </div>
                    </div>
                    <table class="min-w-full divide-y divide-gray-200 md:table-fixed" id="table_list_tasks">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-xs font-medium tracking-wider text-center text-gray-500 uppercase">
                                    Projeto
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-xs font-medium tracking-wider text-center text-gray-500 uppercase">
                                    Tarefa
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-xs font-medium tracking-wider text-center text-gray-500 uppercase">
                                    Vencimento
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                    Descrição
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-xs font-medium tracking-wider text-center text-gray-500 uppercase">
                                    Prioridade
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-xs font-medium tracking-wider text-center text-gray-500 uppercase">
                                    Status
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                    Ações
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr>
                                <td colspan="7" class="px-6 py-4 whitespace-nowrap" v-if="!project_tasks.length">
                                    <div class="text-sm text-center text-gray-900">
                                        Nenhuma tarefa encontrada.
                                    </div>
                                </td>
                            </tr>
                            <tr v-for="task in project_tasks" :key="task.id" :priority="task.priority"
                                :status="task.status">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-center text-gray-900">
                                        {{ task.project.title }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center justify-center">
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ task.title }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center whitespace-nowrap">
                                    <div class="text-sm text-center text-gray-900">
                                        {{ task.due_date }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-justify ">
                                    <div class="text-sm text-justify text-gray-900">
                                        {{ task.description }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span :class="{
                                                    'inline-flex px-2 text-xs font-semibold leading-5 rounded-full': true,
                                                    'text-yellow-800 bg-yellow-100': task.priority === 'Baixa',
                                                    'text-orange-800 bg-orange-100': task.priority === 'Média',
                                                    'text-red-800 bg-red-100': task.priority === 'Alta'
                                                }">
                                        {{ task.priority }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span :class="{
                                                    'inline-flex px-2 text-xs font-semibold leading-5 rounded-full': true,
                                                    'text-red-800 bg-red-100': task.status === 'Pendente',
                                                    'text-blue-800 bg-blue-100': task.status === 'Andamento',
                                                    'text-green-800 bg-green-100': task.status === 'Concluída'
                                                }">
                                        {{ task.status }}
                                    </span>
                                </td>
                                <td class="pl-6 text-sm font-medium text-center whitespace-nowrap">
                                    <a href="#" @click="edit(task.id)"
                                        class="float-left  duration-100 rounded hover:text-green-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>

                                    <a href="#" @click="deleteTask(task)"
                                        class="float-left  text-red-400 duration-100 rounded hover:text-red-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script>

import { router } from '@inertiajs/vue3';
import AppLayout from "@/Layouts/AppLayout.vue";


export default {
    components: {
        AppLayout,
    },

    props: {
        success: Object,
        project_tasks: Object,
    },

    methods: {
        create() {
            router.get(route('project_tasks.create'));
        },

        edit(id) {
            router.get(route('project_tasks.edit', id));
        },

        filter() {
            let priority = $("#priority").val();
            let status = $("#status").val();
            let rows = $("#table_list_tasks > tbody").find("tr");

            rows.map((index, row) => {
                if ((priority !== "T" && priority !== $(row).attr("priority")) || (status !== "T" && status !== $(row).attr("status"))) {
                    $(row).addClass("hidden");
                } else {
                    $(row).removeClass("hidden");
                }
            });
        },

        confirmAction: function (message, callback) {
            if (confirm(message)) {
                callback();
            }
        },

        deleteTask: function (task) {
            this.confirmAction(
                "Tem certeza que deseja deletar a tarefa?",
                function () {
                    this.$inertia.delete(route("project_tasks.destroy", task.id));
                }.bind(this)
            );
        },
    },

    mounted: function () {
        // console.log(this.projects);
    }
}

</script>