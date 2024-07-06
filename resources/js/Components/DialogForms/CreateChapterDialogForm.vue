<script setup>
import InputLabel from "@/Components/InputLabel.vue";
import InputText from "primevue/inputtext";
import Textarea from "primevue/textarea";
import Button from "primevue/button";
import {useForm} from "@inertiajs/vue3";

const props = defineProps(['adventure']);
const chapter = defineModel('chapter');
const visible = defineModel('visible');

const emits = defineEmits(['formSubmitted'])

const form = useForm({
    title: chapter.title,
    content: chapter.content
});

const submitForm = async () => {
    form.post(route('adventures.chapters.store', props.adventure), {
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
<!--        <InputLabel for="content"-->
<!--                    value="Inhalt"/>-->
<!--        <Textarea id="content"-->
<!--                  label="Inhalt"-->
<!--                  v-model="form.content"-->
<!--                  rows="10"/>-->
        <!-- submit -->
        <Button type="submit"
                class="min-w-[12rem] w-[35%] mx-auto"
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
                @click="visible = false"
                label="Kapitel erstellen"
                icon="ri-add-box-line"/>
    </form>
</template>

<style scoped>

</style>
