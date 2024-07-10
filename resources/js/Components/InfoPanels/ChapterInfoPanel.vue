<script setup>
import Button from "primevue/button";
import {useForm} from "@inertiajs/vue3";
import TiptapEditor from "@/Components/TiptapEditor.vue";
import {computed, ref, watch} from "vue";
import TinymceEditor from "@/Components/TinymceEditor.vue";

const props = defineProps(['adventure', 'chapter']);

const form = useForm({
    title: props.chapter.title,
    content: props.chapter.content
});

const saveData = () => {
    form.put(route('adventures.chapters.update', [props.adventure.slug, props.chapter.slug]), {preserveScroll: true}); // Save to the database
};

const isEditable = ref(false);

const makeEditable = () => {
    isEditable.value = true;
};

const saveEditorContent = () => {
    isEditable.value = false;
    saveData();
};

const closeEditor = () => {
    isEditable.value = false;
};

const tooltipData = computed(() => {
    return {
        value: 'Zum Bearbeiten klicken', showDelay: 500, hideDelay: 300
    }
})

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
                    <section>
                        <h3 class="text-lg font-semibold mt-4 mb-1">Abenteuerbeschreibung</h3>
                        <div v-if="!isEditable"
                             @click="makeEditable"
                             class="bg-surface-0 rounded-lg"
                             :class="props.isReadOnly ? 'hover:cursor-default' : 'hover:cursor-pointer'"
                             v-tooltip.top="tooltipData"
                        >
                            <div class="p-4 prose prose-sm max-w-none bg-surface-0 rounded-lg"
                                 v-html="chapter.content"></div>
                        </div>
                        <div v-else>
                            <TinymceEditor v-model="form.content"
                                           @saveEditorContent="saveEditorContent"
                                           @closeEditor="closeEditor"/>
                        </div>
                        <div v-if="form.errors.description"
                             class="text-red-500 mt-2">
                            {{ form.errors.description }}
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
