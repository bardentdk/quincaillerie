<script setup>
import ShopLayout from '@/Layouts/ShopLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import { useCart } from '@/Composables/useCart';
import { PhTrash, PhMinus, PhPlus, PhCreditCard, PhArrowLeft } from "@phosphor-icons/vue";

const { state, addToCart, removeFromCart, total, count } = useCart();

const updateQuantity = (item, amount) => {
    if (amount === -1 && item.quantity === 1) return;
    item.quantity += amount;
    localStorage.setItem('quincaillerie_cart', JSON.stringify(state.items));
};

const proceedToCheckout = () => {
    // On envoie les IDs et quantités au serveur
    router.post(route('checkout.store'), {
        items: state.items
    });
};
</script>

<template>
    <ShopLayout>
        <Head title="Mon Panier - Quincaillerie ARCS" />

        <div class="max-w-7xl mx-auto px-6 py-12 font-body">
            <h1 class="text-4xl font-heading uppercase italic text-brand-blue mb-10">Votre Commande</h1>

            <div v-if="state.items.length > 0" class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                <div class="lg:col-span-2 space-y-4">
                    <div v-for="item in state.items" :key="item.id" 
                         class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm flex items-center gap-6">
                        <div class="w-24 h-24 bg-slate-50 rounded-2xl flex items-center justify-center shrink-0">
                            <PhPackage :size="40" weight="thin" class="text-slate-300" />
                        </div>
                        
                        <div class="flex-1">
                            <h3 class="font-bold uppercase text-slate-800 text-xl">{{ item.name }}</h3>
                            <div class="flex items-center gap-2 mt-2">
                                <span class="text-brand-blue font-heading text-lg">Prix unitaire : {{ item.price }}€</span>
                                <span class="text-slate-400 font-bold uppercase text-[10px] tracking-widest">
                                    par {{ item.unit === 'unit' ? 'pièce' : item.unit }}
                                </span>
                            </div>
                        </div>

                        <div class="flex items-center bg-slate-100 rounded-2xl p-2">
                            <button @click="updateQuantity(item, item.unit === 'unit' ? -1 : -0.1)" class="p-2 hover:text-brand-blue">
                                <PhMinus :size="16" weight="bold" />
                            </button>
                            
                            <div class="px-4 text-center">
                                <span class="block font-black text-lg leading-none">{{ item.quantity }}</span>
                                <span class="block text-[9px] uppercase font-bold text-slate-400">{{ item.unit }}</span>
                            </div>
                            
                            <button @click="updateQuantity(item, item.unit === 'unit' ? 1 : 0.1)" class="p-2 hover:text-brand-blue">
                                <PhPlus :size="16" weight="bold" />
                            </button>
                        </div>

                        <button @click="removeFromCart(item.id)" class="text-red-400 hover:text-red-600 p-2 transition-colors">
                            <PhTrash :size="24" />
                        </button>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="bg-brand-blue rounded-3xl p-8 text-white shadow-xl">
                        <h2 class="font-heading text-xl text-brand-yellow mb-6 italic border-b border-blue-800 pb-4 uppercase">Total Panier</h2>
                        
                        <div class="space-y-4 mb-8">
                            <div class="flex justify-between text-blue-200">
                                <span>Articles ({{ count() }})</span>
                                <span>{{ total() }}€</span>
                            </div>
                            <div class="flex justify-between text-blue-200">
                                <span>Livraison</span>
                                <span class="text-green-400 font-bold uppercase text-xs">Gratuite</span>
                            </div>
                            <div class="flex justify-between text-2xl font-heading pt-4 border-t border-blue-800">
                                <span>TOTAL TTC</span>
                                <span class="text-brand-yellow">{{ total() }}€</span>
                            </div>
                        </div>

                        <button @click="proceedToCheckout" 
                                class="w-full bg-brand-yellow text-brand-blue font-heading py-5 rounded-2xl flex items-center justify-center gap-3 hover:bg-yellow-400 transition-all shadow-lg active:scale-95 text-lg">
                            <PhCreditCard :size="24" weight="bold" />
                            COMMANDER
                        </button>
                    </div>

                    <p class="text-[10px] text-slate-400 text-center uppercase tracking-[0.2em]">
                        Paiement 100% sécurisé via Stripe & SSL
                    </p>
                </div>
            </div>

            <div v-else class="text-center py-20 bg-white rounded-3xl border border-dashed border-slate-200">
                <PhShoppingCart :size="80" weight="thin" class="mx-auto text-slate-200 mb-6" />
                <p class="text-slate-500 font-heading text-xl uppercase italic mb-8">Votre panier est encore vide</p>
                <Link :href="route('home')" class="inline-flex items-center gap-2 bg-brand-blue text-white px-8 py-4 rounded-xl font-heading hover:bg-blue-800 transition-all">
                    <PhArrowLeft /> RETOUR À LA BOUTIQUE
                </Link>
            </div>
        </div>
    </ShopLayout>
</template>