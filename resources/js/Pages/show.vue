<template>
    <h1>
        {{ props.body.title }}
    </h1>
</template>

<script setup>
import { onMounted } from "vue";

const props = defineProps({
    header: Object,
    body: Object,
    footer: Object,
});
onMounted(() => {
    console.log(props);
});
</script>

<style></style>
