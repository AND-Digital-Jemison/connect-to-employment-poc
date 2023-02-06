<template>
     <h1>Header:{{ props.header.pageTitle }}</h1>
    <p>{{ props.body.introText }}</p>

    <div>
        <h2>Articles</h2>
    <div v-for="article in props.body.articles">
        <h3>{{ article.fields.title }}</h3>
        <p>{{ article.fields.intro}}</p>
    </div>
    
    </div>
   

    <div>
        <h3>Footer</h3>
        <p>{{ props.footer.footerText }}</p>
        </div>
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

<style scoped></style>
