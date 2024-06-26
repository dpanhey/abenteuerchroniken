<script setup>
import Button from "primevue/button";
import {useForm} from "@inertiajs/vue3";
import TiptapEditor from "@/Components/TiptapEditor.vue";
import {watch} from "vue";
import InputSwitch from "primevue/inputswitch";

const props = defineProps(['adventure', 'location', 'isOwner']);

const form = useForm({
    name: props.location.name,
    description: props.location.description,
    public: props.location.public
});

const saveData = () => {
    form.put(route('adventures.locations.update', [props.adventure.slug, props.location.slug]), {preserveScroll: true}); // Save to the database
};

watch(() => props.location, (newLocation) => {
    form.name = newLocation.name;
    form.description = newLocation.description;
    form.public = newLocation.public;
}, {immediate: true});
</script>

<template>
    <div class="min-h-screen h-fit flex flex-col w-full p-6 bg-surface-100 dark:bg-surface-900 rounded-lg gap-24">
        <div class="flex flex-col w-full">
            <div class="flex justify-between gap-5">
                <h2 class="font-semibold text-2xl mb-4 ml-4">Ortsübersicht</h2>
                <div class="flex gap-5">
                    <div class="text-nowrap">
                        <form @submit.prevent="form.put(route('adventures.locations.detach', [props.adventure, location.slug]))">
                            <Button type="submit"
                                    raised
                                    severity="help"
                                    label="Ort entfernen"
                                    icon="ri-delete-bin-line"/>
                        </form>
                    </div>
                    <div v-if="isOwner" class="text-nowrap">
                        <form @submit.prevent="form.delete(route('adventures.locations.destroy', [props.adventure, location.slug]))">
                            <Button type="submit"
                                    raised
                                    severity="danger"
                                    label="Ort löschen"
                                    icon="ri-delete-bin-line"/>
                        </form>
                    </div>
                </div>
            </div>
            <div class="flex gap-10">
                <div class="w-full">
                    <div class="flex gap-10 justify-between">
                        <div class="w-1/2 max-w-md">
                            <h3 class="text-lg font-semibold mt-4 mb-1">Ortsname</h3>
                            <TiptapEditor :modelValue="form.name"
                                          @update:modelValue="value => form.name = value"
                                          @saveData="saveData()"
                                          :isMenuActive="false"
                                          :isReadOnly="!isOwner"/>
                            <div v-if="form.errors.name" class="text-red-500 mt-2">
                                {{ form.errors.name }}
                            </div>
                        </div>
                        <div class="w-1/2 max-w-md">
                            <h3 class="text-lg font-semibold mt-4 mb-1">Verwaltet von</h3>
                            <p class="prose prose-sm px-4 py-2 bg-surface-0 rounded-lg">{{ location.user_name }}</p>
                        </div>
                        <div class="flex flex-col items-center mt-4 gap-2">
                            <label class="font-semibold text-lg">Öffentlich</label>
                            <InputSwitch v-model="form.public"
                                         @update:model-value="value => { form.public = value; saveData();}"/>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold mt-4 mb-1">Ortsbeschreibung</h3>
                        <TiptapEditor :modelValue="form.description"
                                      :htmlContent="props.location.html"
                                      @update:modelValue="value => form.description = value"
                                      @saveData="saveData()"
                                      :isReadOnly="!isOwner"/>
                        <div v-if="form.errors.description" class="text-red-500 mt-2">
                            {{ form.errors.description }}
                        </div>
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
