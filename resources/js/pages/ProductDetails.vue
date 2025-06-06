<template>
    <Header @toggleSidebar="handleSideBarVisibility" :isloged="getUser().bool" />
    <SideBar :isopen="isSidebarOpen" @toggleSidebar="handleSideBarVisibility" />
    <div class="flex items-center flex-wrap h-screen p-6 gap-4 mt-20">
        <!-- Product Image Section -->
        <div class="flex flex-col gap-3">
            <div ref="mainImage"
                class="md:h-[70vh] md:w-[40vw] h-[40vh] w-[90vw] bg-contain bg-no-repeat rounded-md shadow bg-center">
            </div>
            <div v-if="product && product.product_image.length > 1" class="flex gap-3">
                <div ref="subImage" v-for="image in product.product_image"
                    class="md:flex-col h-24 w-24 gap-3 z-50 bg-contain bg-no-repeat rounded-md shadow bg-center"
                    :class="{ 'border-2 border-black': selectedImg == image.id }" :style="{ backgroundImage: `url(${image.image})` }">
                </div>
            </div>
        </div>

        <!-- Product Details Section -->

        <div class="p-6 relative w-[45vw]">

            <div class="">
                <Tag v-for="tag in product.tag" :title="tag.title" :id="tag.id" :key="tag.id" />
            </div>
            <h2 class=" mt-6 text-2xl font-bold text-gray-800">{{ product.title }}</h2>

            <p class="text-gray-500 text-sm mt-1">
                <span class="font-medium">{{ product.category[0].title }}</span>
            </p>
            <p class="mt-4 text-gray-600">
                {{ product.desc }}
            </p>
            <div class="mt-6">
                <span class="block text-3xl font-bold text-green-500">{{ product.price }} DT</span>
            </div>
            <button @click="handleAddProductToCart"
                class="flex items-center mt-6 h-[3rem] gap-3 px-6 py-3 bg-black text-white rounded-lg text-lg hover:bg-blue-700 transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                    @click="emit('addProductToCart', props.product.id)" viewBox="0 0 24 24" stroke="white">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                Add to Cart
            </button>
        </div>
    </div>
</template>
<script setup>
import { onMounted, ref, useTemplateRef } from "vue";
import { getUser, navigate, toggleSidebar } from "../utils/utils";
import { fetchProductById, addProductToCard } from "../utils/api";

import Header from "../components/Header.vue";
import SideBar from "../components/SideBar.vue";
import Tag from "../components/Tag.vue";


const props = defineProps(['id']);
const product = ref([]);
const selectedImg = ref(0);
const isSidebarOpen = ref(false);
const mainImage = useTemplateRef('mainImage');
const subImage = useTemplateRef('subImage');

// get product data 
fetchProductById(props.id).then((data) => {
    product.value = data;
    selectedImg.value = product.value.product_image[0].id;
});

const handleSideBarVisibility = () => {
    toggleSidebar(isSidebarOpen);
};

const handleAddProductToCart = () => {
    if(!getUser().bool) navigate('/login');
    addProductToCard(props.id);
};

onMounted(() => {

    mainImage.value.style.backgroundImage = `url('${product.value.product_image[0].image}')`;
    if (subImage.value) {
        subImage.value.forEach((element, index) => {
            element.style.backgroundImage = `url('${product.value.product_image[index].image}')`;
        });
    }

});
</script>
<style scoped></style>