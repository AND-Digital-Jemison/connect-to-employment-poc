<template>
    
</template>

<script setup>
import { onMounted } from "vue"
    const props = defineProps({
        article: Object
    })

    onMounted(() => {
        console.log(props.article);

    })

</script>

<style>

</style>