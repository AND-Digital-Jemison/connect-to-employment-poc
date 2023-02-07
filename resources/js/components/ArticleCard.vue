<template>
    <a :href="slug">
        <section class="card_container">
            <h2>{{ props.article.title }}</h2>
            <p>{{ props.article.intro }}</p>
            <img :src="props.article.image.asset.url" alt="" />
        </section>
    </a>
</template>

<script setup>
import { computed } from "vue";
const slug = computed(() => {
    return `/${props.article.slug}`;
});
const props = defineProps({
    article: {
        title: String,
        image: { asset: { url: String } },
        intro: String,
        slug: String,
    },
});
</script>

<style scoped>
.card_container {
    background-color: #efefef;
    cursor: pointer;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    width: 400px;
    margin: auto;
}
.card_container img {
    width: 250px;
}
</style>
