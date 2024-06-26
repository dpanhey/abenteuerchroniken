<script setup>
import {Link} from "@inertiajs/vue3";
import Button from "primevue/button";
import PanelMenu from "primevue/panelmenu";
import Dialog from "primevue/dialog";
import CreateChapterDialogForm from "@/Components/CreateChapterDialogForm.vue";
import {ref, toRef} from "vue";
import useAdventureMenuItems from "@/Composables/useAdventureMenuItems";
import CreateLocationDialogForm from "@/Components/CreateLocationDialogForm.vue";

const props = defineProps(['adventure', 'chapter']);
const chapterDialogVisible = ref(false);
const locationDialogVisible = ref(false);

function handleChapterFormSubmitted(success) {
    if (success) {
        chapterDialogVisible.value = false;
    }
}
function handleLocationFormSubmitted(success) {
    if (success) {
        visible.value = false;
    }
}

const adventureRef = toRef(props, 'adventure');
const {adventureItems} = useAdventureMenuItems(adventureRef);
</script>

<template>
    <div class="min-w-20 md:min-w-40 lg:min-w-60">
        <div class="flex flex-col">
            <Link :href="route(`adventures.show`, props.adventure.slug)">
                <Button raised
                        outlined
                        severity="secondary"
                        label="Übersicht"
                        class="w-full text-start mb-4 border-1 !border-surface-300">
                </Button>
            </Link>
            <PanelMenu :model="adventureItems"
                       multiple>
                <template #item="{ item }">
                    <Link v-if="item.route"
                          :href="item.route">
                        <Button
                            link
                            outlined
                            size="small"
                            :label="item.label"
                            class="max-w-60 w-full text-start">
                        </Button>
                    </Link>
                    <Button v-else-if="item.type === 'createChapter'"
                            raised
                            size="small"
                            :label="item.label"
                            class="max-w-60 mt-1"
                            icon="ri-add-box-line"
                            @click="chapterDialogVisible = true">
                    </Button>
                    <Button v-else-if="item.type === 'createLocation'"
                            raised
                            size="small"
                            :label="item.label"
                            class="max-w-60 mt-1"
                            icon="ri-add-box-line"
                            @click="locationDialogVisible = true">
                    </Button>
                    <Button v-else
                            raised
                            outlined
                            severity="secondary"
                            :label="item.label"
                            class="w-full text-start border-none rounded-b-none">
                    </Button>
                </template>
            </PanelMenu>
        </div>
    </div>

    <Dialog v-model:visible="chapterDialogVisible"
            modal
            header="Neues Kapitel erstellen">
        <CreateChapterDialogForm :adventure="props.adventure"
                                 v-model:chapter="props.adventure.chapters"
                                 @formSubmitted="handleChapterFormSubmitted"/>
    </Dialog>
    <Dialog v-model:visible="locationDialogVisible"
            modal
            header="Neues Kapitel erstellen">
        <CreateLocationDialogForm :adventure="props.adventure"
                                 v-model:location="props.adventure.locations"
                                 @formSubmitted="handleLocationFormSubmitted"/>
    </Dialog>
</template>
