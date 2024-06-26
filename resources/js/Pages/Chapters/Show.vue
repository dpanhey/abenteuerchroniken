<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import PageHeading from "@/Components/PageHeading.vue";
import MainPanel from "@/Components/MainPanel.vue";
import SidePanel from "@/Components/SidePanel.vue";
import ChapterInfoPanel from "@/Components/ChapterInfoPanel.vue";

const props = defineProps(['chapter', 'adventure']);
</script>

<template>
    <AppLayout title="Kapitelübersicht">
        <template #header>
            <PageHeading>{{ adventure.title }}</PageHeading>
        </template>

        <MainPanel>
            <div class="flex w-full gap-10">
                <SidePanel :adventure="adventure"
                           :chapter="chapter"/>
                <ChapterInfoPanel :chapter="chapter"
                                  :adventure="adventure"/>
            </div>
        </MainPanel>
    </AppLayout>
</template>
