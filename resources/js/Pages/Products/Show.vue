<script setup>
import ShopLayout from '@/Layouts/ShopLayout.vue';
import { Head } from '@inertiajs/vue3';
import { useCart } from '@/Composables/useCart';
import { PhShoppingCart, PhCheckCircle, PhArrowLeft } from "@phosphor-icons/vue";

const props = defineProps({ product: Object, seo: Object });
const { addToCart } = useCart();
</script>

<template>
    <ShopLayout>
        <Head>
            <title>{{ seo?.title || product.name }}</title>
            <meta name="description" :content="seo?.description || product.description">
        </Head>

        <div class="max-w-7xl mx-auto px-6 py-12">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-16 items-start">
                
                <div class="bg-white rounded-3xl p-8 border border-slate-100 shadow-xl overflow-hidden">
                    <div class="aspect-square bg-slate-50 rounded-2xl flex items-center justify-center">
                        <img v-if="product.image" :src="product.image" class="max-h-full object-contain">
                        <PhPackage v-else :size="120" weight="thin" class="text-slate-200" />
                    </div>
                </div>

                <div class="space-y-8">
                    <div>
                        <span class="text-brand-blue font-bold uppercase tracking-widest text-sm">{{ product.category.name }}</span>
                        <h1 class="text-5xl font-heading uppercase italic text-slate-900 mt-2">{{ product.name }}</h1>
                    </div>

                    <p class="text-slate-600 text-lg leading-relaxed font-body">
                        {{ product.description }}
                    </p>

                    <div class="flex items-center gap-4 py-6 border-y border-slate-100">
                        <p class="text-5xl font-heading text-brand-blue">{{ (product.price_cents / 100).toFixed(2) }}€</p>
                        <div v-if="product.stock_quantity > 0" class="flex items-center gap-2 text-green-600 font-bold text-sm uppercase">
                            <PhCheckCircle :size="20" weight="fill" /> En stock ({{ product.stock_quantity }})
                        </div>
                    </div>

                    <button @click="addToCart(product)" 
                            class="w-full md:w-auto bg-brand-yellow text-brand-blue font-heading px-12 py-5 rounded-2xl flex items-center justify-center gap-4 hover:bg-brand-blue hover:text-white transition-all shadow-lg active:scale-95 text-xl">
                        <PhShoppingCart :size="28" weight="bold" />
                        AJOUTER AU PANIER
                    </button>
                </div>
            </div>
        </div>
    </ShopLayout>
</template>