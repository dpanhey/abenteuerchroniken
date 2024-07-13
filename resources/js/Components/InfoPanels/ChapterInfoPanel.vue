<script setup>
import Button from "primevue/button";
import {useForm} from "@inertiajs/vue3";
import {ref, watch} from "vue";
import InputText from "primevue/inputtext";
import WysiwygEditor from "@/Components/WysiwygEditor.vue";

const props = defineProps(['adventure', 'chapter']);

const form = useForm({
    title: props.chapter.title,
    content: props.chapter.content
});

const saveData = () => {
    form.put(route('adventures.chapters.update', [props.adventure.slug, props.chapter.slug]), {preserveScroll: true}); // Save to the database
};

const editorIsOpen = ref(false);
const inputIsOpen = ref(false);

const openEditor = () => {
    editorIsOpen.value = true;
}

const saveEditor = () => {
    editorIsOpen.value = false;
    saveData();
}

const closeEditor = () => {
    editorIsOpen.value = false;
    form.description = props.chapter.content;
};

const openInput = () => {
    inputIsOpen.value = true;
}

const saveInput = () => {
    inputIsOpen.value = false;
    saveData();
}

const closeInput = () => {
    inputIsOpen.value = false;
    form.title = props.chapter.title;
};

watch(() => props.chapter, (newChapter) => {
    form.title = newChapter.title;
    form.content = newChapter.content;
}, {immediate: true});
</script>

<template>
    <div class="min-h-screen h-fit flex flex-col w-full p-6 bg-surface-100 dark:bg-surface-900 rounded-lg gap-24">
        <div class="flex flex-col w-full">
            <div class="flex justify-between gap-5">
                <h2 class="font-semibold text-2xl mb-4 ml-4">Kapitelübersicht</h2>
                <div class="flex gap-5">
                    <div class="text-nowrap">
                        <form @submit.prevent="form.delete(route('adventures.chapters.destroy', [adventure.slug, chapter.slug]))">
                            <Button type="submit"
                                    raised
                                    severity="danger"
                                    label="Kapitel löschen"
                                    icon="ri-delete-bin-line"/>
                        </form>
                    </div>
                </div>
            </div>
            <div class="flex gap-10">
                <div class="w-full">
                    <div class="flex gap-2 mt-4 mb-1 items-center">
                        <h3 class="text-lg font-semibold">Kapiteltitel</h3>
                        <div v-if="!inputIsOpen">
                            <Button rounded
                                    raised
                                    class="font-medium text-lg !p-0"
                                    aria-label="Bearbeiten"
                                    severity="contrast"
                                    icon="ri-edit-2-line"
                                    @click="openInput"/>
                        </div>
                        <div v-else
                             class="flex gap-2">
                            <Button rounded
                                    raised
                                    class="font-medium text-lg !p-0"
                                    aria-label="Speichern"
                                    severity="success"
                                    icon="ri-save-2-line"
                                    @click="saveInput"/>
                            <Button rounded
                                    raised
                                    class="font-medium text-lg !p-0"
                                    aria-label="Abbrechen"
                                    severity="danger"
                                    icon="ri-close-line"
                                    @click="closeInput"/>
                        </div>
                    </div>
                    <div v-if="!inputIsOpen"
                         class="bg-surface-0 rounded-lg">
                        <div class="prose prose-sm px-4 py-2 bg-surface-0 rounded-lg"
                             v-html="chapter.title">
                        </div>
                    </div>
                    <div class="bg-surface-0 rounded-lg"
                         v-else>
                        <InputText class="w-full prose prose-sm px-4 py-2 bg-surface-0 rounded-lg"
                                   v-model="form.title"/>
                    </div>
                    <div v-if="form.errors.title"
                         class="text-red-500 mt-2">
                        {{ form.errors.title }}
                    </div>
                    <section>
                        <div class="flex gap-2 mt-4 mb-1 items-center">
                            <h3 class="text-lg font-semibold">Kapitelbeschreibung</h3>
                            <div v-if="!editorIsOpen">
                                <Button rounded
                                        raised
                                        class="font-medium text-lg !p-0"
                                        aria-label="Bearbeiten"
                                        severity="contrast"
                                        icon="ri-edit-2-line"
                                        @click="openEditor"/>
                            </div>
                            <div class="flex gap-2"
                                 v-else>
                                <Button rounded
                                        raised
                                        class="font-medium text-lg !p-0"
                                        aria-label="Speichern"
                                        severity="success"
                                        icon="ri-save-2-line"
                                        @click="saveEditor"/>
                                <Button rounded
                                        raised
                                        class="font-medium text-lg !p-0"
                                        aria-label="Abbrechen"
                                        severity="danger"
                                        icon="ri-close-line"
                                        @click="closeEditor"/>
                            </div>
                        </div>
                        <div v-if="!editorIsOpen"
                             class="bg-surface-0 rounded-lg">
                            <div class="p-4 prose prose-sm max-w-none bg-surface-0 rounded-lg"
                                 v-html="chapter.content">
                            </div>
                        </div>
                        <div v-else>
                            <WysiwygEditor v-model="form.content"/>
                        </div>
                        <div v-if="form.errors.content"
                             class="text-red-500 mt-2">
                            {{ form.errors.content }}
                        </div>
                    </section>
                </div>
            </div>
        </div>
        <div class="flex">
            <h2 class="font-semibold text-xl mb-4 ml-4 text-surface-400 hover:underline cursor-not-allowed">
                Private Notiz hinzufügen</h2>
        </div>
    </div>
</template>
