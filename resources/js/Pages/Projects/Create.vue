<template>
    <AppLayout title="Novo Projeto">
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">Novo Projeto</h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <form @submit.prevent="submit" class="px-8 pt-6 pb-8 m-auto mb-4" id="form_projects"
                        enctype="multipart/form-data">
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
                            <label class="block mb-2 text-sm font-bold text-gray-700" for="start_date">
                                Data Início <span class="text-red-500">*</span>
                            </label>
                            <input v-model="form.start_date"
                                class="w-full px-3 py-2 mb-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                                id="start_date" type="date" />
                            <span class="text-red-500">{{ errors.start_date }}</span>
                        </div>

                        <div class="mb-4">
                            <label class="block mb-2 text-sm font-bold text-gray-700" for="expected_completion_date">
                                Previsão de Conclusão <span class="text-red-500">*</span>
                            </label>
                            <input v-model="form.expected_completion_date"
                                class="w-full px-3 py-2 mb-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                                id="expected_completion_date" type="date" />
                            <span class="text-red-500">{{ errors.expected_completion_date }}</span>
                        </div>

                        <div class="mb-4">
                            <label class="block mb-2 text-sm font-bold text-gray-700" for="members">
                                Adicionar Membros
                            </label>
                            <select multiple
                                class="w-full px-3 py-2 mb-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                                data-default id="members">
                                <option v-for="user in users" selected :value="`${user.id}`">
                                    {{ user.name }}
                                </option>
                            </select>
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
        users: Object,
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
        submit() {
            this.form.members = $("#form_projects #members").val();
            this.form.post(this.route("projects.store"), {
                _token: this.$page.props.csrf_token,
            });
        },
        back() {
            router.get(route('projects.index'));
        },
    },
    mounted: function () {
        this.$nextTick(function () {
            $("#form_projects #members").select2().val(this.$page.props.auth.user.id).trigger('change');
        });

        let date = new Date();
        let start_date = date.toISOString().slice(0, 10);
        date.setMonth(date.getMonth() + 1);
        let expected_completion_date = date.toISOString().slice(0, 10);

        this.form.start_date = start_date;
        this.form.expected_completion_date = expected_completion_date;
    }
};

</script>