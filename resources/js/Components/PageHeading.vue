<template>
    <div class="flex justify-between items-center">
        <h1 class="font-semibold text-2xl text-gray-800 leading-tight">
            <slot/>
        </h1>
<!--        v-if für button hinzufügen-->
<!--        <Button label="Neues XYZ erstellen" icon="pi pi-plus" />-->
    </div>
</template>

<script setup>
import Button from "primevue/button";
</script>
