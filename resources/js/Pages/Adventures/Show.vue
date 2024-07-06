<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import PageHeading from "@/Components/PageHeading.vue";
import MainPanel from "@/Components/MainPanel.vue";
import SidePanel from "@/Components/SidePanel.vue";
import AdventureInfoPanel from "@/Components/InfoPanels/AdventureInfoPanel.vue";

const props = defineProps(['adventure', 'isOwner']);

</script>

<template>
    <AppLayout title="Abenteuerübersicht">
        <template #header>
            <PageHeading>{{ adventure.title }}</PageHeading>
        </template>

        <MainPanel>
            <div class="flex w-full gap-10">
                <SidePanel :adventure="adventure"/>
                <AdventureInfoPanel :adventure="adventure"
                                    :isOwner="isOwner"/>
            </div>
        </MainPanel>
    </AppLayout>
</template>
