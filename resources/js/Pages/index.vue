<template>
    <div>1</div>
</template>

<script setup>
import { onMounted } from "vue";
const props = defineProps({
    entries: Object,
});

onMounted(() => {
    console.log(props.entries.items[0].fields.animals);
});
</script>

<style scoped></style>
