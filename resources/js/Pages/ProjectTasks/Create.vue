<template>
    <AppLayout title="Nova Tarefa">
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">Nova Tarefa</h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <form @submit.prevent="submit" class="px-8 pt-6 pb-8 m-auto mb-4" id="form_project_tasks"
                        enctype="multipart/form-data">
                        <div class="mb-4">
                            <label class="block mb-2 text-sm font-bold text-gray-700" for="project_id">
                                Projeto
                            </label>
                            <select v-model="form.project_id" id="project_id" multiple
                                class="w-full px-3 py-2 mb-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline">
                                <option v-for="project in projects" :value="`${project.id}`">
                                    {{ project.title }}
                                </option>
                            </select>
                            <span class="text-red-500">{{ errors.project_id }}</span>
                        </div>
                        <div class="mb-4">
                            <label class="block mb-2 text-sm font-bold text-gray-700" for="title">
                                Título <span class="text-red-500">*</span>
                            </label>
                            <input v-model="form.title"
                                class="w-full px-3 py-2 mb-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                                id="title" type="text" />
                            <span class="text-red-500">{{ errors.title }}</span>
                        </div>

                        <div class="mb-4">
                            <label class="block mb-2 text-sm font-bold text-gray-700" for="description">
                                Descrição <span class="text-red-500">*</span>
                            </label>
                            <textarea v-model="form.description"
                                class="w-full px-3 py-2 mb-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                                id="description" type="text" rows="5"></textarea>
                            <span class="text-red-500">{{ errors.description }}</span>
                        </div>

                        <div class="mb-4">
                            <label class="block mb-2 text-sm font-bold text-gray-700" for="due_date">
                                Vencimento <span class="text-red-500">*</span>
                            </label>
                            <input v-model="form.due_date"
                                class="w-full px-3 py-2 mb-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                                id="due_date" type="date" />
                            <span class="text-red-500">{{ errors.due_date }}</span>
                        </div>

                        <div class="mb-4">
                            <label class="block mb-2 text-sm font-bold text-gray-700" for="priority">
                                Prioridade <span class="text-red-500">*</span>
                            </label>
                            <select v-model="form.priority"
                                class="w-full px-3 py-2 mb-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline">
                                <option value="B">Baixa</option>
                                <option value="M">Média</option>
                                <option value="A">Alta</option>
                            </select>
                            <span class="text-red-500">{{ errors.priority }}</span>
                        </div>

                        <div class="mb-4">
                            <label class="block mb-2 text-sm font-bold text-gray-700" for="status">
                                Status <span class="text-red-500">*</span>
                            </label>
                            <select v-model="form.status"
                                class="w-full px-3 py-2 mb-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline">
                                <option value="P">Pendente</option>
                                <option value="A">Andamento</option>
                                <option value="C">Concluída</option>
                            </select>
                            <span class="text-red-500">{{ errors.status }}</span>
                        </div>

                        <div class="flex items-center justify-between">
                            <SecondaryButton :form="form" @click="back()">Voltar</SecondaryButton>
                            <Button :form="form"></Button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script>

import Button from '@/Components/Button.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import AppLayout from "@/Layouts/AppLayout.vue";
import { router } from '@inertiajs/vue3';

export default {
    components: {
        AppLayout,
        Button,
        PrimaryButton,
        SecondaryButton,
    },
    props: {
        errors: Object,
        projects: Object,
    },
    data() {
        return {
            form: this.$inertia.form({
                project_id: "",
                title: "",
                description: "",
                due_date: "",
                priority: "M",
                status: "P",
            }),
        };
    },
    methods: {
        submit() {
            this.form.project_id = $("#form_project_tasks #project_id").val()[0];
            this.form.post(this.route("project_tasks.store"), {
                _token: this.$page.props.csrf_token,
            });
        },
        back() {
            router.get(route('project_tasks.index'));
        },
    },
    mounted: function () {
        this.$nextTick(function () {
            $("#form_project_tasks #project_id").select2({
                maximumSelectionLength: 1
            });
        });

        $("#form_project_tasks #project_id").trigger("change");

        let date = new Date();
        date.setMonth(date.getMonth() + 1);
        let due_date = date.toISOString().slice(0, 10);
        this.form.due_date = due_date;
    }
};

</script>