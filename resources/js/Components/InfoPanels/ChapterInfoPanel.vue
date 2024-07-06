<script setup>
import Button from "primevue/button";
import {useForm} from "@inertiajs/vue3";
import TiptapEditor from "@/Components/TiptapEditor.vue";
import {watch} from "vue";

const props = defineProps(['adventure', 'chapter']);

const form = useForm({
    title: props.chapter.title,
    content: props.chapter.content
});

const saveData = () => {
    form.put(route('adventures.chapters.update', [props.adventure.slug, props.chapter.slug]), {preserveScroll: true}); // Save to the database
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
                    <h3 class="text-lg font-semibold mt-4 mb-1">Kapiteltitel</h3>
                    <TiptapEditor :modelValue="form.title"
                                  @update:modelValue="value => form.title = value"
                                  @saveData="saveData()"
                                  :isMenuActive="false"/>
                    <div v-if="form.errors.title" class="text-red-500 mt-2">
                        {{ form.errors.title }}
                    </div>
                    <h3 class="text-lg font-semibold mt-4 mb-1">Kapitelinhalt</h3>
                    <TiptapEditor :modelValue="form.content"
                                  :htmlContent="props.chapter.html"
                                  @update:modelValue="value => form.content = value"
                                  @saveData="saveData()"/>
                    <div v-if="form.errors.content" class="text-red-500 mt-2">
                        {{ form.errors.content }}
                    </div>
                </div>
            </div>
        </div>
        <div class="flex">
            <h2 class="font-semibold text-xl mb-4 ml-4 text-surface-400 hover:underline cursor-not-allowed">
                Private Notiz hinzufügen</h2>
        </div>
    </div>
</template>
