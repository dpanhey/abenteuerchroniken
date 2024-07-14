<script setup>
import Button from "primevue/button";
import {useForm} from "@inertiajs/vue3";
import {ref, watch} from "vue";
import InputSwitch from "primevue/inputswitch";
import InputText from "primevue/inputtext";
import WysiwygEditor from "@/Components/WysiwygEditor.vue";
import {useConfirm} from "primevue/useconfirm";
import ConfirmPopup from "primevue/confirmpopup";

const props = defineProps(['adventure', 'enemy', 'isOwner']);

const form = useForm({
    name: props.enemy.name,
    description: props.enemy.description,
    public: props.enemy.public
});

const saveData = () => {
    form.put(route('adventures.enemies.update', [props.adventure.slug, props.enemy.slug]), {preserveScroll: true}); // Save to the database
};

const deleteEnemy = () => {
    form.delete(route('adventures.enemies.destroy', [props.adventure, props.enemy.slug]), {preserveScroll: true});
};

const editorIsOpen = ref(false);
const inputIsOpen = ref(false);

const openEditor = () => {
    if (props.isOwner) {
        editorIsOpen.value = true;
    }
}

const saveEditor = () => {
    editorIsOpen.value = false;
    saveData();
}

const closeEditor = () => {
    editorIsOpen.value = false;
    form.description = props.enemy.description;
};

const openInput = () => {
    if (props.isOwner) {
        inputIsOpen.value = true;
    }
}

const saveInput = () => {
    inputIsOpen.value = false;
    saveData();
}

const closeInput = () => {
    inputIsOpen.value = false;
    form.title = props.enemy.name;
};

const confirm = useConfirm();

const confirmDelete = () => {
    confirm.require({
        target: event.currentTarget,
        message: 'Gegner löschen?',
        icon: 'ri-alert-line',
        acceptLabel: 'Löschen',
        rejectLabel: 'Abbrechen',
        accept: () => {
            deleteEnemy();
        }
    });
};

const confirmCloseInput = () => {
    confirm.require({
        target: event.currentTarget,
        message: 'Änderungen verwerfen?',
        icon: 'ri-alert-line',
        acceptLabel: 'Verwerfen',
        rejectLabel: 'Abbrechen',
        accept: () => {
            closeInput();
        }
    });
};

const confirmCloseEditor = () => {
    confirm.require({
        target: event.currentTarget,
        message: 'Änderungen verwerfen?',
        icon: 'ri-alert-line',
        acceptLabel: 'Verwerfen',
        rejectLabel: 'Abbrechen',
        accept: () => {
            closeEditor();
        }
    });
};

watch(() => props.enemy, (newEnemy) => {
    form.name = newEnemy.name;
    form.description = newEnemy.description;
    form.public = newEnemy.public;
}, {immediate: true});
</script>

<template>
    <ConfirmPopup></ConfirmPopup>
    <div class="min-h-screen h-fit flex flex-col w-full p-6 bg-surface-100 dark:bg-surface-900 rounded-lg gap-24">
        <div class="flex flex-col w-full">
            <div class="flex justify-between gap-5">
                <h2 class="font-semibold text-2xl mb-4 ml-4">Gegner-Übersicht</h2>
                <div class="flex gap-5">
                    <div class="text-nowrap">
                        <form @submit.prevent="form.put(route('adventures.enemies.detach', [props.adventure, enemy.slug]))">
                            <Button type="submit"
                                    raised
                                    severity="help"
                                    label="Gegner entfernen"
                                    icon="ri-delete-bin-line"/>
                        </form>
                    </div>
                    <div v-if="isOwner" class="text-nowrap">
                            <Button @click="confirmDelete($event)"
                                    raised
                                    severity="danger"
                                    label="Gegner löschen"
                                    icon="ri-delete-bin-line"/>
                    </div>
                </div>
            </div>
            <div class="flex gap-10">
                <div class="w-full">
                    <div class="flex gap-10 justify-between">
                        <div class="w-1/2 max-w-md">
                            <div class="flex gap-2 mt-4 mb-1 items-center">
                                <h3 class="text-lg font-semibold">Gegner-Name</h3>
                                <div v-if="!inputIsOpen && isOwner">
                                    <Button rounded
                                            raised
                                            class="font-medium text-lg !p-0"
                                            aria-label="Bearbeiten"
                                            severity="contrast"
                                            icon="ri-edit-2-line"
                                            @click="openInput"/>
                                </div>
                                <div v-if="inputIsOpen && isOwner"
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
                                            @click="confirmCloseInput"/>
                                </div>
                            </div>
                            <div v-if="!inputIsOpen"
                                 class="bg-surface-0 rounded-lg">
                                <div class="prose max-w-none w-full prose-sm px-4 py-2 bg-surface-0 rounded-lg"
                                     v-html="enemy.name">
                                </div>
                            </div>
                            <div class="bg-surface-0 rounded-lg"
                                 v-else>
                                <InputText class="max-w-none w-full prose prose-sm px-4 py-2 bg-surface-0 rounded-lg"
                                           v-model="form.name"/>
                            </div>
                            <div v-if="form.errors.name" class="text-red-500 mt-2">
                                {{ form.errors.name }}
                            </div>
                        </div>
                        <div class="w-1/2 max-w-md">
                            <h3 class="text-lg font-semibold mt-4 mb-1">Verwaltet von</h3>
                            <p class="prose prose-sm px-4 py-2 bg-surface-0 rounded-lg">{{ enemy.user_name }}</p>
                        </div>
                        <div v-if="isOwner" class="flex flex-col items-center mt-4 gap-2">
                            <label class="font-semibold text-lg">Öffentlich</label>
                            <InputSwitch v-model="form.public"
                                         @update:model-value="value => { form.public = value; saveData();}"/>
                        </div>
                    </div>
                    <section>
                        <div class="flex gap-2 mt-4 mb-1 items-center">
                            <h3 class="text-lg font-semibold">Gegner-Beschreibung</h3>
                            <div v-if="!editorIsOpen && isOwner">
                                <Button rounded
                                        raised
                                        class="font-medium text-lg !p-0"
                                        aria-label="Bearbeiten"
                                        severity="contrast"
                                        icon="ri-edit-2-line"
                                        @click="openEditor"/>
                            </div>
                            <div class="flex gap-2"
                                 v-if="editorIsOpen && isOwner">
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
                                        @click="confirmCloseEditor"/>
                            </div>
                        </div>
                        <div v-if="!editorIsOpen"
                             class="bg-surface-0 rounded-lg">
                            <div class="p-4 prose prose-sm max-w-none bg-surface-0 rounded-lg"
                                 v-html="enemy.description">
                            </div>
                        </div>
                        <div v-else>
                            <WysiwygEditor v-model="form.description"/>
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
