<template>
    <AppLayout title="Projetos">
        <template #header>
            <h2 class="flex justify-between text-xl font-semibold leading-tight text-gray-800">
                <p>
                    Projetos
                </p>

                <a href="projects/create">
                    <a
                        class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        Novo Projeto
                    </a>
                </a>
            </h2>
        </template>

        <div class="py-12">
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
                    <table class="min-w-full divide-y divide-gray-200 md:table-fixed">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-xs font-medium tracking-wider text-center text-gray-500 uppercase">
                                    ID
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-xs font-medium tracking-wider text-center text-gray-500 uppercase">
                                    Título
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-xs font-medium tracking-wider text-center text-gray-500 uppercase">
                                    Criado por
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-xs font-medium tracking-wider text-center text-gray-500 uppercase">
                                    Membros
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-xs font-medium tracking-wider text-center text-gray-500 uppercase">
                                    Início
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-xs font-medium tracking-wider text-center text-gray-500 uppercase">
                                    Previsão de término
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-xs font-medium tracking-wider text-center text-gray-500 uppercase">
                                    Descrição
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-xs font-medium tracking-wider  text-gray-500 uppercase">Ações
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="project in projects" :key="project.id">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-center text-gray-900">
                                        {{ project.id }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center justify-center">
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ project.title }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-center text-gray-900">
                                        {{ project.user.name }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span v-for="member in project.members"
                                        class="inline-flex px-2 text-xs font-semibold leading-5 text-green-800 bg-green-100 rounded-full">
                                        {{ member.user.name }} 
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center whitespace-nowrap">
                                    <div class="text-sm text-center text-gray-900">
                                        {{ project.start_date }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center whitespace-nowrap">
                                    <div class="text-sm text-center text-gray-900">
                                        {{ project.expected_completion_date }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-justify ">
                                    <div class="text-sm text-justify text-gray-900">
                                        {{ project.description }}
                                    </div>
                                </td>
                                <td class="pl-5 text-sm font-medium text-center whitespace-nowrap">
                                    <a href="#" @click="edit(project.id)"
                                        class="float-left  duration-100 rounded hover:text-green-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>

                                    <a href="#" @click="deleteProject(project)"
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
        projects: Object,
    },

    data() {
        return {
            form: this.$inertia.form({
                title: "",
                description: "",
                start_date: "",
                expected_completion_date: "",
                members: [],
            }),
        };
    },

    methods: {
        edit(id) {
            router.get(route('projects.edit', id));
        },

        confirmAction: function (message, callback) {
            if (confirm(message)) {
                callback();
            }
        },

        deleteProject: function (project) {
            this.confirmAction(
                "Tem certeza que deseja deletar o projeto?",
                function () {
                    this.$inertia.delete(route("projects.destroy", project.id));
                }.bind(this)
            );
        },
    },

    mounted: function () {
        // console.log(this.projects);
    }
}

</script>