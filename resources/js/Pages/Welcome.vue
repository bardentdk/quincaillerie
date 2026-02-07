<script setup>
import ShopLayout from '@/Layouts/ShopLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { 
    PhArrowRight, 
    PhCube, 
    PhTag, 
    PhShoppingCart, 
    PhMagnifyingGlass,
    PhPackage 
} from "@phosphor-icons/vue";
import { useCart } from '@/Composables/useCart';

const props = defineProps({
    products: Object,
    categories: Array,
    filters: Object
});

const { addToCart } = useCart();

const filterByCategory = (slug) => {
    router.get('/', { category: slug }, { preserveState: true });
};
</script>

<template>
    <ShopLayout>
        <Head title="La Quincaillerie Pro - Outillage et Matériel" />

        <header class="bg-brand-blue text-white py-16 px-6">
            <div class="max-w-7xl mx-auto">
                <h1 class="text-5xl md:text-7xl font-heading uppercase italic tracking-tighter leading-none mb-6">
                    Tout pour vos <span class="text-brand-yellow">Chantiers</span>
                </h1>
                <p class="max-w-xl text-blue-100 font-body text-lg">
                    Découvrez notre sélection de matériel professionnel. Qualité garantie et livraison express pour les pros du bâtiment.
                </p>
            </div>
        </header>

        <main class="max-w-7xl mx-auto px-6 py-12">
            <div class="flex flex-col md:flex-row gap-12">
                
                <aside class="w-full md:w-64 space-y-8">
                    <div>
                        <h3 class="font-heading text-lg mb-4 flex items-center gap-2 italic">
                            <PhTag class="text-brand-blue" /> Rayons
                        </h3>
                        <div class="space-y-2">
                            <button @click="filterByCategory('')" 
                                    :class="!filters.category ? 'bg-brand-blue text-white' : 'hover:bg-slate-200'"
                                    class="w-full text-left px-4 py-2 rounded-xl text-sm font-bold uppercase transition-all">
                                Tous les produits
                            </button>
                            <button v-for="cat in categories" :key="cat.id"
                                    @click="filterByCategory(cat.slug)"
                                    :class="filters.category === cat.slug ? 'bg-brand-blue text-white shadow-lg' : 'hover:bg-slate-200'"
                                    class="w-full text-left px-4 py-2 rounded-xl text-sm font-bold uppercase transition-all">
                                {{ cat.name }}
                            </button>
                        </div>
                    </div>
                </aside>

                <div class="flex-1">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                        <div v-for="product in products.data" :key="product.id" 
                             class="group bg-white rounded-3xl border border-slate-100 overflow-hidden shadow-sm hover:shadow-2xl transition-all duration-300 flex flex-col">
                            
                            <div class="relative aspect-square bg-slate-100 flex items-center justify-center text-slate-300 group-hover:bg-brand-yellow/10 transition-colors overflow-hidden">
                                <img v-if="product.image" 
                                     :src="'/storage/' + product.image" 
                                     class="w-full h-full object-contain group-hover:scale-110 transition-transform duration-500" />
                                <PhCube v-else :size="64" weight="thin" />
                                
                                <div v-if="product.stock_quantity > 0 && product.stock_quantity < 5" 
                                     class="absolute top-4 right-4 bg-red-100 text-red-600 px-2 py-1 rounded-lg text-[10px] font-black uppercase tracking-tighter shadow-sm">
                                    Stock Bas
                                </div>
                                <div v-if="product.stock_quantity <= 0" 
                                     class="absolute inset-0 bg-slate-900/40 backdrop-blur-[2px] flex items-center justify-center">
                                    <span class="bg-white text-slate-900 px-4 py-1 rounded-full text-xs font-black uppercase italic">Épuisé</span>
                                </div>
                            </div>

                            <div class="p-6 flex-1 flex flex-col">
                                <div class="flex justify-between items-start mb-2">
                                    <span class="text-[10px] font-black uppercase tracking-widest text-slate-400">
                                        {{ product.category?.name || 'Général' }}
                                    </span>
                                </div>
                                
                                <h3 class="font-heading text-xl text-slate-800 mb-4 group-hover:text-brand-blue transition-colors leading-tight">
                                    {{ product.name }}
                                </h3>

                                <div class="mt-auto flex items-center justify-between pt-4 border-t border-slate-50">
                                    <p class="text-2xl font-heading text-brand-blue italic">
                                        {{ (product.price_cents / 100).toFixed(2) }}€
                                    </p>
                                    
                                    <button @click="addToCart(product)" 
                                            :disabled="product.stock_quantity <= 0"
                                            :class="product.stock_quantity <= 0 ? 'bg-slate-100 text-slate-300 cursor-not-allowed' : 'bg-slate-900 text-white hover:bg-brand-blue shadow-lg'"
                                            class="p-3 rounded-2xl transition-all active:scale-90 group/btn">
                                        <PhShoppingCart :size="20" weight="bold" class="group-hover/btn:rotate-12 transition-transform" />
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div v-if="products.data.length === 0" class="text-center py-20 bg-white rounded-3xl border-2 border-dashed border-slate-100">
                        <PhPackage :size="80" weight="thin" class="mx-auto text-slate-200 mb-4" />
                        <p class="text-slate-500 font-bold uppercase italic tracking-widest">Aucun article trouvé dans ce rayon</p>
                    </div>
                </div>
            </div>
        </main>
    </ShopLayout>
</template>