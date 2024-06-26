<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import PageHeading from "@/Components/PageHeading.vue";
import MainPanel from "@/Components/MainPanel.vue";
import SidePanel from "@/Components/SidePanel.vue";
import LocationInfoPanel from "@/Components/LocationInfoPanel.vue";

const props = defineProps(['location', 'adventure', 'isOwner']);
</script>

<template>
    <AppLayout title="Ortsübersicht">
        <template #header>
            <PageHeading>{{ adventure.title }}</PageHeading>
        </template>

        <MainPanel>
            <div class="flex w-full gap-10">
                <SidePanel :adventure="adventure"/>
                <LocationInfoPanel :location="location"
                                   :adventure="adventure"
                                   :isOwner="isOwner"/>
            </div>
        </MainPanel>
    </AppLayout>
</template>
