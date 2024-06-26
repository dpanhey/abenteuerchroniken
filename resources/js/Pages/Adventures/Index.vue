<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import DataView from "primevue/dataview/dataview.esm.js";
import Button from "primevue/button/button.esm.js";
import {Link} from "@inertiajs/vue3";
import PageHeading from "@/Components/PageHeading.vue";
import MainPanel from "@/Components/MainPanel.vue";
import CreateAdventureForm from "@/Components/CreateAdventureForm.vue";
import Dialog from "primevue/dialog";
import {ref} from "vue";

const visible = ref(false);

function handleFormSubmitted(success) {
    if (success) {
        visible.value = false;
    }
}

defineProps(['adventures']);
</script>

<template>
    <AppLayout title="Abenteuer">
        <template #header>
            <PageHeading>Abenteuer</PageHeading>
        </template>

        <MainPanel>
            <div class="flex w-full justify-end mb-4">
                <Button
                    raised
                    label="Neues Abenteuer erstellen"
                    icon="ri-add-box-line"
                    @click="visible = true"
                />
            </div>
            <div class="w-full">
                <DataView :value="adventures.data"
                          paginator
                          :rows="3">
                    <template #list="slotProps">
                        <div class="grid gap-6 bg-surface-0">
                            <div v-for="(adventure, index) in slotProps.items"
                                 :key="index"
                                 class="col-12 max-h-[60rem] min-h-[15rem] flex">
                                <div class="bg-surface-100 dark:bg-surface-900 flex p-4 gap-10 w-full border-1 border-surface-200 dark:border-surface-700 rounded-xl shadow-md shadow-surface-400 dark:shadow-surface-700">
                                    <div class="w-3/5 h-full">
                                        <img class="block xl:block mx-auto h-full rounded-md object-cover"
                                             :src="`${adventure.cover}`"
                                             :alt="adventure.title"/>
                                    </div>
                                    <div class="flex justify-between gap-4 w-full">
                                        <div>
                                            <div class="flex flex-col justify-between h-full">
                                                <div class="text-xl font-bold text-surface-700 dark:text-surface-0/80 mt-2">
                                                    <h3>
                                                        {{ adventure.title }}
                                                    </h3>
                                                </div>
                                                <div v-html="adventure.html"
                                                     class="prose prose-sm text-surface-700 dark:text-surface-0/80 mt-2 text-justify overflow-ellipsis">
                                                </div>

                                                <div v-if="adventure.chapters.length === 0" class="flex mx-auto mt-4">
                                                    <Link :href="route(`adventures.show`, adventure.slug)">
                                                        <Button raised
                                                                icon="ri-eye-line"
                                                                label="Abenteuer ansehen"/>
                                                    </Link>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div v-if="adventure.chapters.length > 0" class="flex flex-col justify-between gap-5 w-full">
                                        <div>
                                            <div class="text-lg font-bold text-surface-700 dark:text-surface-0/80">
                                                <h4>
                                                    Kapitel
                                                </h4>
                                            </div>
                                            <ul class="flex flex-col gap-2 list-disc list-inside text-surface-700 dark:text-surface-0/80">
                                                <li class="text-md font-medium mt-2"
                                                    v-if="adventure.chapters.length === 0">
                                                    Neues Kapitel erstellen
                                                </li>
                                                <li class="text-md font-medium mt-2"
                                                    v-for="chapters in adventure.chapters.slice(0, 4)">
                                                    {{ chapters.title }}
                                                </li>
                                                <li v-if="adventure.chapters.length > 4">
                                                    ...
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="flex mx-auto mt-4">
                                            <Link :href="route(`adventures.show`, adventure.slug)">
                                                <Button raised
                                                        icon="ri-eye-line"
                                                        label="Abenteuer ansehen"/>
                                            </Link>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                </DataView>
            </div>
        </MainPanel>

        <Dialog v-model:visible="visible"
                modal
                header="Neues Abenteuer erstellen">
            <CreateAdventureForm @formSubmitted="handleFormSubmitted"/>
        </Dialog>
    </AppLayout>
</template>
