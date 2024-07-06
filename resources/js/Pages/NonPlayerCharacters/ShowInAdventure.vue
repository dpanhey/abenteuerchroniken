<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import PageHeading from "@/Components/PageHeading.vue";
import MainPanel from "@/Components/MainPanel.vue";
import SidePanel from "@/Components/SidePanel.vue";
import NonPlayerCharacterInfoPanel from "@/Components/InfoPanels/NonPlayerCharacterInfoPanel.vue";

const props = defineProps(['nonPlayerCharacter', 'adventure', 'isOwner']);
</script>

<template>
    <AppLayout title="NSC-Übersicht">
        <template #header>
            <PageHeading>{{ adventure.title }}</PageHeading>
        </template>

        <MainPanel>
            <div class="flex w-full gap-10">
                <SidePanel :adventure="adventure"/>
                <NonPlayerCharacterInfoPanel :nonPlayerCharacter="nonPlayerCharacter"
                                   :adventure="adventure"
                                   :isOwner="isOwner"/>
            </div>
        </MainPanel>
    </AppLayout>
</template>
