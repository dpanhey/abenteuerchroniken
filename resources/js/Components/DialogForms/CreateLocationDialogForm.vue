<script setup>
import InputLabel from "@/Components/InputLabel.vue";
import InputText from "primevue/inputtext";
import Button from "primevue/button";
import {useForm} from "@inertiajs/vue3";

const props = defineProps(['adventure']);
const location = defineModel('location');
const visible = defineModel('visible');

const emits = defineEmits(['formSubmitted'])

const form = useForm({
    name: location.name,
    description: location.description
});

const submitForm = async () => {
    form.post(route('adventures.locations.store', props.adventure), {
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
        <!-- name -->
        <InputLabel for="name"
                    value="Name"/>
        <InputText id="name"
                   label="Name"
                   v-model="form.name"
                   required/>
        <!-- description -->
        <!--        <InputLabel for="description"-->
        <!--                    value="Inhalt"/>-->
        <!--        <Textarea id="description"-->
        <!--                  label="Inhalt"-->
        <!--                  v-model="form.description"-->
        <!--                  rows="10"/>-->
        <!-- submit -->
        <Button type="submit"
                class="min-w-[12rem] w-[35%] mx-auto"
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
                @click="visible = false"
                label="Ort erstellen"
                icon="ri-add-box-line"/>
    </form>
</template>

<style scoped>

</style>
