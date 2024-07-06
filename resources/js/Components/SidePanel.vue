<script setup>
import {Link} from "@inertiajs/vue3";
import Button from "primevue/button";
import PanelMenu from "primevue/panelmenu";
import Dialog from "primevue/dialog";
import CreateChapterDialogForm from "@/Components/DialogForms/CreateChapterDialogForm.vue";
import CreateEnemyDialogForm from "@/Components/DialogForms/CreateEnemyDialogForm.vue";
import CreateLocationDialogForm from "@/Components/DialogForms/CreateLocationDialogForm.vue";
import CreateNonPlayerCharacterDialogForm from "@/Components/DialogForms/CreateNonPlayerCharacterDialogForm.vue";
import {ref, toRef} from "vue";
import useAdventureMenuItems from "@/Composables/useAdventureMenuItems";

// chapter aus props entfernen? nötig?
const props = defineProps(['adventure', 'chapter']);
const chapterDialogVisible = ref(false);
const locationDialogVisible = ref(false);
const nonPlayerCharacterDialogVisible = ref(false);
const enemyDialogVisible = ref(false);

function handleChapterFormSubmitted(success) {
    if (success) {
        chapterDialogVisible.value = false;
    }
}
function handleLocationFormSubmitted(success) {
    if (success) {
        locationDialogVisible.value = false;
    }
}
function handleNonPlayerCharacterFormSubmitted(success) {
    if (success) {
        nonPlayerCharacterDialogVisible.value = false;
    }
}
function handleEnemyFormSubmitted(success) {
    if (success) {
        enemyDialogVisible.value = false;
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
                    <Button v-else-if="item.type === 'createNonPlayerCharacter'"
                            raised
                            size="small"
                            :label="item.label"
                            class="max-w-60 mt-1"
                            icon="ri-add-box-line"
                            @click="nonPlayerCharacterDialogVisible = true">
                    </Button>
                    <Button v-else-if="item.type === 'createEnemy'"
                            raised
                            size="small"
                            :label="item.label"
                            class="max-w-60 mt-1"
                            icon="ri-add-box-line"
                            @click="enemyDialogVisible = true">
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
            header="Neuen Ort erstellen">
        <CreateLocationDialogForm :adventure="props.adventure"
                                 v-model:location="props.adventure.locations"
                                 @formSubmitted="handleLocationFormSubmitted"/>
    </Dialog>
    <Dialog v-model:visible="nonPlayerCharacterDialogVisible"
            modal
            header="Neuen NSC erstellen">
        <CreateNonPlayerCharacterDialogForm :adventure="props.adventure"
                                 v-model:nonplayercharacter="props.adventure.nonPlayerCharacters"
                                 @formSubmitted="handleNonPlayerCharacterFormSubmitted"/>
    </Dialog>
    <Dialog v-model:visible="enemyDialogVisible"
            modal
            header="Neuen Gegner erstellen">
        <CreateEnemyDialogForm :adventure="props.adventure"
                                 v-model:enemy="props.adventure.enemies"
                                 @formSubmitted="handleEnemyFormSubmitted"/>
    </Dialog>
</template>
