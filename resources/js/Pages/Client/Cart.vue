<script setup>
import { Head, router } from '@inertiajs/vue3';
import { PhTrash, PhShoppingCart, PhArrowRight, PhCreditCard } from "@phosphor-icons/vue";

// On imagine que le panier est géré via un store (Pinia) ou transmis par Inertia
const props = defineProps({ cartItems: Array, total: Number });

const checkout = () => {
    router.post(route('checkout'), {
        total: props.total
    });
};
</script>

<template>
    <div class="max-w-4xl mx-auto p-6 font-body">
        <h1 class="font-heading text-4xl text-brand-blue mb-8 flex items-center gap-3">
            <PhShoppingCart weight="fill" class="text-brand-yellow" />
            VOTRE PANIER
        </h1>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="md:col-span-2 space-y-4">
                <div v-for="item in cartItems" :key="item.id" 
                     class="bg-white p-4 rounded-2xl border border-slate-200 flex items-center justify-between shadow-sm">
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 bg-slate-100 rounded-lg"></div>
                        <div>
                            <h3 class="font-bold text-slate-800">{{ item.name }}</h3>
                            <p class="text-brand-blue font-bold">{{ item.price }}€</p>
                        </div>
                    </div>
                    <button class="text-red-400 hover:text-red-600 p-2">
                        <PhTrash :size="20" />
                    </button>
                </div>
            </div>

            <div class="bg-brand-blue text-white p-6 rounded-3xl shadow-xl h-fit">
                <h2 class="font-heading text-xl mb-6 border-b border-blue-800 pb-4 italic">RÉSUMÉ</h2>
                <div class="flex justify-between mb-4">
                    <span>Sous-total</span>
                    <span class="font-bold">{{ total }}€</span>
                </div>
                <div class="flex justify-between mb-8 text-brand-yellow text-xl">
                    <span class="font-heading">TOTAL TTC</span>
                    <span class="font-heading">{{ total }}€</span>
                </div>

                <button @click="checkout" 
                        class="w-full bg-brand-yellow text-brand-blue font-heading py-4 rounded-xl flex items-center justify-center gap-2 hover:bg-yellow-400 transition-transform active:scale-95 shadow-lg">
                    <PhCreditCard :size="24" weight="bold" />
                    PAYER LA COMMANDE
                </button>
                
                <p class="text-[10px] text-blue-300 mt-4 text-center uppercase tracking-widest">
                    Paiement sécurisé via Stripe
                </p>
            </div>
        </div>
    </div>
</template>