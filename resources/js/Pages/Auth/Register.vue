<script setup>
import {Head, Link, useForm} from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import FloatLabel from "primevue/floatlabel";
import InputText from "primevue/inputtext";
import Button from "primevue/button";

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    terms: false,
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <Head title="Registrieren"/>

    <div :class="['min-h-screen p-8 flex items-center justify-center transition-all duration-200 bg-welcome-page bg-cover bg-top']">

        <div class="bg-white/10 p-9 rounded-xl backdrop-blur-xl flex flex-col gap-6 shadow-xl">

            <form @submit.prevent="submit">
                <div class="flex flex-col gap-8">
                    <div>
                        <FloatLabel>
                            <InputText
                                class="w-full"
                                id="name"
                                v-model="form.name"
                                type="name"
                                required
                                autocomplete="name"
                            />
                            <label id="name"
                                   for="name">Name</label>
                        </FloatLabel>

                        <InputError class="mt-2 px-2 py-1 font-light bg-red-100 rounded-sm"
                                    :message="form.errors.name"/>
                    </div>

                    <div>
                        <FloatLabel>
                            <InputText
                                class="w-full"
                                id="email"
                                v-model="form.email"
                                type="email"
                                required
                                autocomplete="username"
                            />
                            <label id="email"
                                   for="email">Email</label>
                        </FloatLabel>

                        <InputError class="mt-2 px-2 py-1 font-light bg-red-100 rounded-sm"
                                    :message="form.errors.email"/>
                    </div>

                    <div>
                        <FloatLabel>
                            <InputText
                                class="w-full"
                                id="password"
                                v-model="form.password"
                                type="password"
                                required
                                autocomplete="current-password"
                            />
                            <label id="password"
                                   for="password">Passwort</label>
                        </FloatLabel>

                        <InputError class="mt-2 px-2 py-1 font-light bg-red-100 rounded-sm"
                                    :message="form.errors.password"/>
                    </div>

                    <div>
                        <FloatLabel>
                            <InputText
                                class="w-full"
                                id="password_confirmation"
                                v-model="form.password_confirmation"
                                type="password"
                                required
                                autocomplete="new-password"
                            />
                            <label id="password"
                                   for="password">Passwort bestätigen</label>
                        </FloatLabel>

                        <InputError class="mt-2 px-2 py-1 font-light bg-red-100 rounded-sm"
                                    :message="form.errors.password_confirmation"/>
                    </div>
                </div>

                <div class="flex items-center justify-between mt-4 gap-4">
                    <Link :href="route('login')">
                        <Button raised
                                severity="info"
                                :class="{ 'opacity-25': form.processing }"
                                :disabled="form.processing">
                            Bereits registriert?
                        </Button>
                    </Link>

                    <Button raised
                            type="submit"
                            :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing">
                        Registrieren
                    </Button>
                </div>
            </form>
        </div>
    </div>
</template>
