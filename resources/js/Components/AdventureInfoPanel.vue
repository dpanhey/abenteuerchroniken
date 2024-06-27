<script setup>
import Button from "primevue/button";
import InputSwitch from "primevue/inputswitch";
import {useForm} from "@inertiajs/vue3";
import {watch} from "vue";
import TiptapEditor from "@/Components/TiptapEditor.vue";

const props = defineProps(['adventure', 'isOwner']);

const form = useForm({
    title: props.adventure.title,
    description: props.adventure.description,
    public: props.adventure.public
});

const saveData = () => {
    form.put(route('adventures.update', props.adventure.slug), {preserveScroll: true}); // Save to the database
};

watch(() => props.adventure, (newAdventure) => {
    form.title = newAdventure.title;
    form.description = newAdventure.description;
    form.public = newAdventure.public;
}, {immediate: true});

</script>

<template>
    <div class="min-h-screen h-fit flex flex-col w-full p-6 bg-surface-100 dark:bg-surface-900 rounded-lg gap-24">
        <div class="flex flex-col w-full">
            <div class="flex justify-between gap-5">
                <h2 class="font-semibold text-2xl mb-4 ml-4">Abenteuerübersicht</h2>
                <div v-if="isOwner"
                    class="flex gap-10 items-center ">
                    <div class="flex flex-row items-center gap-2">
                        <label class="font-semibold text-lg">Öffentlich</label>
                        <InputSwitch v-model="form.public"
                                     @update:model-value="value => { form.public = value; saveData();}"/>
                    </div>
                    <div class="flex gap-5">
                        <div class="text-nowrap">
                            <form @submit.prevent="form.delete(route(`adventures.destroy`, adventure.slug))">
                                <Button type="submit"
                                        raised
                                        severity="danger"
                                        label="Abenteuer löschen"
                                        icon="ri-delete-bin-line"/>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex flex-col">
                <div class="flex gap-10">
                    <div class="flex flex-col w-1/2 max-w-md">
                        <h3 class="text-lg font-semibold mt-4 mb-1">Abenteuertitel</h3>
                        <TiptapEditor :modelValue="form.title"
                                      @update:modelValue="value => form.title = value"
                                      @saveData="saveData"
                                      :isMenuActive="false"
                                      :isReadOnly="!isOwner"/>
                        <div v-if="form.errors.title"
                             class="text-red-500 mt-2">
                            {{ form.errors.title }}
                        </div>
                    </div>
                    <div class="w-1/2 max-w-md">
                        <h3 class="text-lg font-semibold mt-4 mb-1">Abenteuercover</h3>
                        <img class="block xl:block mx-auto rounded-md object-cover"
                             :src="`${adventure.cover}`"
                             :alt="adventure.title"/>
                    </div>
                </div>
                <h3 class="text-lg font-semibold mt-4 mb-1">Abenteuerbeschreibung</h3>
                <TiptapEditor :modelValue="form.description"
                              :htmlContent="props.adventure.html"
                              @update:modelValue="value => form.description = value"
                              @saveData="saveData"
                              :isReadOnly="!isOwner"/>
                <div v-if="form.errors.description"
                     class="text-red-500 mt-2">
                    {{ form.errors.description }}
                </div>
            </div>
        </div>
        <div class="flex">
            <h2 class="font-semibold text-xl mb-4 ml-4 text-surface-400 hover:underline cursor-not-allowed">
                Private Notiz hinzufügen</h2>
        </div>
    </div>
</template>
