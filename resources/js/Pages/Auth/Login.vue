<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import Button from "primevue/button";
import FloatLabel from "primevue/floatlabel";
import InputText from "primevue/inputtext";

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.transform(data => ({
        ...data,
        remember: form.remember ? 'on' : '',
    })).post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <Head title="Log in" />

    <div :class="['min-h-screen p-8 flex items-center justify-center transition-all duration-200 bg-welcome-page bg-cover bg-top']">

        <div class="bg-white/10 p-9 rounded-xl backdrop-blur-xl flex flex-col gap-6 shadow-xl">
            <form @submit.prevent="submit">
                <div class="flex flex-col gap-8">
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

                </div>

                <div class="block mt-4">
                    <label class="flex items-center">
                        <Checkbox v-model:checked="form.remember"
                                  name="remember"/>
                        <span class="ml-2 text-sm font-semibold text-gray-100">Eingeloggt bleiben</span>
                    </label>
                </div>

                <div class="flex items-center mt-4">
                    <Button type="submit"
                            raised
                            class="w-full"
                            :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing">
                        Anmelden
                    </Button>
                </div>

                <div class="flex items-center mt-4">
                    <Link
                        :href="route('register')"
                        class="w-full">
                        <Button severity="info"
                                raised
                                class="w-full"
                                :class="{ 'opacity-25': form.processing }"
                                :disabled="form.processing">
                            Noch kein Account?
                        </Button>
                    </Link>
                </div>
            </form>
        </div>
    </div>
</template>
