<script setup>
import ShopLayout from '@/Layouts/ShopLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { PhFilePdf, PhTruck, PhCheckCircle, PhClock } from "@phosphor-icons/vue";

defineProps({ orders: Array });

const statusLabel = (s) => ({
    'pending': 'Attente paiement',
    'paid': 'En préparation',
    'shipped': 'En livraison',
    'delivered': 'Livré'
}[s]);
</script>

<template>
    <ShopLayout>
        <Head title="Mes Commandes" />
        <div class="max-w-5xl mx-auto py-12 px-6">
            <h1 class="text-4xl font-heading italic uppercase text-brand-blue mb-10 text-center md:text-left">
                Mon Historique <span class="text-brand-yellow">Chantiers</span>
            </h1>

            <div v-if="orders.length > 0" class="space-y-4">
                <div v-for="order in orders" :key="order.id" 
                     class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm hover:shadow-md transition-shadow flex flex-wrap items-center justify-between gap-6">
                    
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-slate-50 rounded-2xl flex items-center justify-center text-brand-blue">
                            <component :is="order.status === 'delivered' ? PhCheckCircle : PhClock" :size="24" />
                        </div>
                        <div>
                            <p class="font-black text-brand-blue">#{{ order.order_number }}</p>
                            <p class="text-xs text-slate-400 font-bold uppercase">{{ order.date }}</p>
                        </div>
                    </div>

                    <div class="px-4 py-2 rounded-full border text-[10px] font-black uppercase tracking-widest"
                         :class="order.status === 'paid' ? 'bg-blue-50 text-blue-600 border-blue-100' : 'bg-slate-50 text-slate-500 border-slate-100'">
                        {{ statusLabel(order.status) }}
                    </div>

                    <div class="text-xl font-heading text-slate-900">{{ order.total }}€</div>

                    <div class="flex gap-2">
                        <Link :href="route('orders.download', order.id)" class="p-3 bg-slate-100 text-slate-500 rounded-xl hover:bg-brand-blue hover:text-white transition-all">
                            <PhFilePdf :size="20" />
                        </Link>
                    </div>
                </div>
            </div>

            <div v-else class="text-center py-20 bg-white rounded-3xl border-2 border-dashed border-slate-100">
                <p class="text-slate-400 font-heading text-xl uppercase italic">Aucune commande passée</p>
            </div>
        </div>
    </ShopLayout>
</template>