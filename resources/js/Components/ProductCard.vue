<script setup>
import { ref, computed } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { useCart } from '@/Composables/useCart';
import { PhShoppingCart, PhPlus, PhTag } from "@phosphor-icons/vue";

const props = defineProps({ product: Object });
const user = computed(() => usePage().props.auth.user);

// Moteur de calcul du prix (Remise de 15% pour les Pros)
const displayPrice = computed(() => {
    const originalPrice = props.product.price_cents / 100;
    if (user.value?.is_pro) {
        return (originalPrice * 0.85).toFixed(2); // Application des -15%
    }
    return originalPrice.toFixed(2);
});

const { addToCart } = useCart();

// Gestion intelligente de la quantité initiale selon l'unité
const quantityInput = ref(props.product.unit === 'unit' ? 1 : 0.5);
</script>

<template>
    <div class="bg-white rounded-3xl border border-slate-100 p-6 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col h-full group">
        <div class="flex justify-between items-start mb-4">
            <span class="text-[10px] font-black uppercase tracking-widest text-slate-400 flex items-center gap-1">
                <PhTag :size="12" /> {{ product.category?.name || 'Général' }}
            </span>
        </div>

        <h3 class="font-heading uppercase italic text-xl mb-4 text-slate-900 group-hover:text-brand-blue transition-colors leading-tight">
            {{ product.name }}
        </h3>
        
        <div class="flex flex-col mb-6">
            <span v-if="user?.is_pro" class="text-xs text-red-500 font-bold line-through ml-1">
                {{ (product.price_cents / 100).toFixed(2) }}€
            </span>

            <div class="flex items-baseline gap-2">
                <span class="text-3xl font-heading text-brand-blue italic">
                    {{ displayPrice }}€
                </span>
                
                <span v-if="user?.is_pro" class="bg-brand-yellow text-brand-blue text-[10px] px-2 py-0.5 rounded-lg font-black uppercase italic shadow-sm animate-pulse">
                    Prix Pro
                </span>

                <span class="text-xs text-slate-400 uppercase font-bold tracking-wider">
                    / {{ product.unit === 'unit' ? 'pièce' : product.unit }}
                </span>
            </div>
        </div>

        <div class="mt-auto flex flex-col gap-3">
            <div class="flex gap-2">
                <div v-if="product.unit !== 'unit'" class="flex flex-col gap-1">
                    <label class="text-[9px] font-black uppercase text-slate-400 ml-1">Quantité ({{ product.unit }})</label>
                    <input v-model="quantityInput" 
                           type="number" step="0.1" min="0.1"
                           class="w-24 bg-slate-50 border-2 border-slate-100 rounded-xl text-center font-bold focus:ring-2 focus:ring-brand-yellow focus:border-brand-yellow transition-all">
                </div>
                
                <button @click="addToCart(product, quantityInput)" 
                        :disabled="product.stock_quantity <= 0"
                        class="flex-1 bg-brand-yellow text-brand-blue font-heading py-4 rounded-2xl flex items-center justify-center gap-2 hover:bg-brand-blue hover:text-white transition-all shadow-lg shadow-brand-yellow/10 active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed">
                    <PhPlus weight="bold" /> 
                    <span class="uppercase italic">Ajouter</span>
                </button>
            </div>

            <p v-if="product.stock_quantity > 0 && product.stock_quantity < 5" class="text-[10px] text-red-500 font-bold uppercase text-center">
                Attention : Plus que {{ product.stock_quantity }} en stock
            </p>
        </div>
    </div>
</template>