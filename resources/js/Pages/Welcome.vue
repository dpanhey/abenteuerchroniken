<script setup>
import {Head, Link,} from '@inertiajs/vue3';
import Button from "primevue/button";

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    }
});
</script>

<template>
    <Head title="Willkommen"/>
    <div :class="['min-h-screen p-8 flex items-center justify-center transition-all duration-200 bg-welcome-page bg-cover bg-top']">

        <div class="bg-white/10 p-9 rounded-xl backdrop-blur-xl flex flex-col gap-6 shadow-xl">
            <h1 class="text-3xl font-bold text-white">Willkommen bei den Abenteuerchroniken</h1>
            <div v-if="canLogin"
                 class="flex flex-col">
                <Link
                    v-if="$page.props.auth.user"
                    :href="route('dashboard')">
                    <Button raised
                            class="w-full">
                        Zum Dashboard
                    </Button>
                </Link>

                <div v-else
                     class="flex gap-3">
                    <Link
                        :href="route('login')">
                        <Button raised
                                class="w-full">
                            Einloggen
                        </Button>
                    </Link>

                    <Link
                        v-if="canRegister"
                        :href="route('register')">
                        <Button raised
                                class="w-full">
                            Registrieren
                        </Button>
                    </Link>
                </div>
            </div>
        </div>
    </div>
</template>
