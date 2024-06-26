<script setup>
import InputLabel from "@/Components/InputLabel.vue";
import InputText from "primevue/inputtext";
import Textarea from "primevue/textarea";
import Button from "primevue/button";
import {useForm} from "@inertiajs/vue3";

const adventure = defineModel('adventure');
const visible = defineModel('visible');

const emits = defineEmits('formSubmitted')

const form = useForm({
    title: adventure.title,
    description: adventure.description,
    cover: 'https://via.placeholder.com/640x480.png/0066bb?text=fugiat',
    status: adventure.status,
});

const submitForm = async () => {
    form.post(route('adventures.store', adventure), {
        onSuccess: () => {
            emits('formSubmitted', true)
        },
        onError: () => {
            emits('formSubmitted', false)
        }
    })
}

</script>

<template>
    <form class="flex flex-col w-full gap-4"
          @submit.prevent="submitForm">
        <!-- title -->
        <InputLabel for="title"
                    value="Titel"/>
        <InputText id="title"
                   label="Titel"
                   v-model="form.title"
                   required/>
        <!-- content -->
<!--        <InputLabel for="description"-->
<!--                    value="Beschreibung"/>-->
<!--        <Textarea id="description"-->
<!--                  label="Beschreibung"-->
<!--                  v-model="form.description"-->
<!--                  rows="10"/>-->
        <!-- submit -->
        <Button type="submit"
                class="min-w-[12rem] w-[35%] mx-auto"
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
                @click="visible = false"
                label="Abenteuer erstellen"
                icon="ri-add-box-line"/>
    </form>
</template>

<style scoped>

</style>
