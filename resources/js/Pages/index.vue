<template>
    <div>
        <h1>
            {{ props.header.title }}
        </h1>
        <ArticleCard
            v-for="(article, index) in props.body.articleListItemsCollection
                .items"
            :key="index"
            :article="article"
        />
        <footer>
            {{ props.footer.text }}
        </footer>
    </div>
</template>

<script setup>
import ArticleCard from "../components/ArticleCard.vue";
const props = defineProps({
    header: Object,
    body: Object,
    footer: Object,
});
</script>

<style scoped></style>
