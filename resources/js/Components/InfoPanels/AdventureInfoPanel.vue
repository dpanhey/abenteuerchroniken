<script setup>
import Button from "primevue/button";
import InputSwitch from "primevue/inputswitch";
import {useForm} from "@inertiajs/vue3";
import {ref, watch} from "vue";
import WysiwygEditor from "@/Components/WysiwygEditor.vue";
import InputText from "primevue/inputtext";
import {useConfirm} from "primevue/useconfirm";
import ConfirmPopup from "primevue/confirmpopup";
import FileUpload from 'primevue/fileupload';
import Image from 'primevue/image';

const props = defineProps(['adventure', 'isOwner', 'img']);

const form = useForm({
    title: props.adventure.title,
    description: props.adventure.description,
    public: props.adventure.public,
    cover: null,
    _method: 'PUT'
});

const deleteAdventure = () => {
    form.delete(route('adventures.destroy', props.adventure.slug), {preserveScroll: true});
};

const saveData = () => {
    form.post(route('adventures.update', props.adventure.slug),
        {
            preserveScroll: true,
            onSuccess: () => {
                form.cover = null;
            }
        });
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
    form.description = props.adventure.description;
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
    form.title = props.adventure.title;
};

const confirm = useConfirm();

const confirmDelete = () => {
    confirm.require({
        target: event.currentTarget,
        message: 'Abenteuer löschen?',
        icon: 'ri-alert-line',
        acceptLabel: 'Löschen',
        rejectLabel: 'Abbrechen',
        accept: () => {
            deleteAdventure();
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

const handleFileUpload = (event) => {
    form.cover = event.files[0];
    saveData();
};

watch(() => props.adventure, (newAdventure) => {
    form.title = newAdventure.title;
    form.description = newAdventure.description;
    form.public = newAdventure.public;
}, {immediate: true});

</script>

<template>
    <ConfirmPopup></ConfirmPopup>
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
                            <Button raised
                                    @click="confirmDelete($event)"
                                    severity="danger"
                                    label="Abenteuer löschen"
                                    icon="ri-delete-bin-line"/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex flex-col">
                <div class="flex gap-10">
                    <div class="flex flex-col w-1/2 max-w-md">
                        <div class="flex gap-2 mt-4 mb-1 items-center">
                            <h3 class="text-lg font-semibold">Abenteuertitel</h3>
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
                            <div class="prose prose-sm px-4 py-2 bg-surface-0 rounded-lg"
                                 v-html="adventure.title">
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
                        <h3 class="text-lg font-semibold mt-4 mb-1">Erstellt von</h3>
                        <p class="prose prose-sm px-4 py-2 bg-surface-0 rounded-lg">{{ adventure.user_name }}</p>
                    </div>
                    <div class="flex flex-col w-1/2 max-w-md">
                        <div class="flex gap-2 mt-4 mb-1 items-center">
                            <h3 class="text-lg font-semibold">Abenteuercover</h3>
                            <div v-if="isOwner">
                                <FileUpload class="font-bold text-sm text-white !bg-black !h-[24px]"
                                            mode="basic"
                                            name="cover"
                                            accept="image/*"
                                            :maxFileSize="1000000"
                                            customUpload
                                            @uploader="handleFileUpload"
                                            :auto="true"
                                            choose-label="Bild hochladen"/>
                            </div>
                        </div>
                        <div class="flex justify-center w-full max-h-[18rem] overflow-hidden">
                            <Image alt="Adventure-Cover"
                                   preview>
                                <template #indicatoricon>
                                    <i class="ri-search-eye-line"></i>
                                </template>
                                <template #image>
                                    <img :src="adventure.cover"
                                         class="w-full h-full object-cover"
                                         alt="Adventure-Cover-Thumbnail"/>
                                </template>
                                <template #preview="slotProps">
                                    <img :src="adventure.cover"
                                         alt="Adventure-Cover-Preview"
                                         :style="slotProps.style"
                                         @click="slotProps.onClick"/>
                                </template>
                            </Image>
                        </div>
                    </div>
                </div>
                <section>
                    <div class="flex gap-2 mt-4 mb-1 items-center">
                        <h3 class="text-lg font-semibold">Abenteuerbeschreibung</h3>
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
                             v-html="adventure.description">
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
        <div class="flex">
            <h2 class="font-semibold text-xl mb-4 ml-4 text-surface-400 hover:underline cursor-not-allowed">
                Private Notiz hinzufügen</h2>
        </div>
    </div>
</template>
