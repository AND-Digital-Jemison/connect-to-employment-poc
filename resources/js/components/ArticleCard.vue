<template>
    <section class='card_container'>
        <h2>{{ props.article.title }}</h2>
        <p>{{ props.article.intro }}</p>
        <img :src="props.article.image.asset.url" alt="">
    </section>
</template>

<script setup>
import { onMounted } from "vue"
const props = defineProps({
    article: { title: String, image: { asset: { url: String } }, intro: String }
})

onMounted(() => {
    // console.log(props.article);

})

</script>

<style scoped>
    .card_container{
        background-color: #efefef;
        cursor: pointer;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        width: 400px;
        margin: auto;
    }
    .card_container img{
        width: 250px;
    }
</style>
