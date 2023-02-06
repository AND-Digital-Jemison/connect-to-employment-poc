<template>
    <div>
        <h1>
            {{ props.content.header.title }}
        </h1>
        <footer>
            {{ props.content.footer.text }}
        </footer>
    </div>
</template>

<script setup>
import { onMounted } from "vue";
const props = defineProps({
    content: Object,
});

onMounted(() => {
    console.log(props.content);
});
</script>

<style scoped></style>
