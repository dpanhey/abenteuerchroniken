<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import PageHeading from "@/Components/PageHeading.vue";
import MainPanel from "@/Components/MainPanel.vue";
import SidePanel from "@/Components/SidePanel.vue";
import EnemyInfoPanel from "@/Components/InfoPanels/EnemyInfoPanel.vue";


const props = defineProps(['enemy', 'adventure', 'isOwner']);
</script>

<template>
    <AppLayout title="Gegner-Übersicht">
        <template #header>
            <PageHeading>{{ adventure.title }}</PageHeading>
        </template>

        <MainPanel>
            <div class="flex w-full gap-10">
                <SidePanel :adventure="adventure"/>
                <EnemyInfoPanel :enemy="enemy"
                                             :adventure="adventure"
                                             :isOwner="isOwner"/>
            </div>
        </MainPanel>
    </AppLayout>
</template>
