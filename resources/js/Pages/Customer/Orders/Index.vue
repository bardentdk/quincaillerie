<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { PhFileText, PhPackage, PhCaretRight } from "@phosphor-icons/vue";

defineProps({ orders: Object });

const getStatusStyle = (status) => {
    const styles = {
        'paid': 'bg-green-100 text-green-700',
        'shipped': 'bg-blue-100 text-blue-700',
        'delivered': 'bg-slate-100 text-slate-700',
        'pending': 'bg-yellow-100 text-yellow-700'
    };
    return styles[status] || 'bg-gray-100';
};
</script>

<template>
    <Head title="Mes Commandes" />
    <div class="max-w-5xl mx-auto py-12 px-6">
        <h1 class="font-heading text-3xl text-brand-blue mb-8 uppercase italic">Mon Historique d'Achats</h1>

        <div class="space-y-4">
            <div v-for="order in orders.data" :key="order.id" 
                 class="bg-white border border-slate-200 rounded-2xl p-6 flex flex-wrap items-center justify-between hover:shadow-md transition-shadow">
                
                <div class="flex items-center gap-6">
                    <div class="p-4 bg-slate-50 rounded-xl text-slate-400">
                        <PhPackage :size="32" />
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-tighter">Commande n°</p>
                        <p class="font-heading text-lg text-slate-800">{{ order.order_number }}</p>
                    </div>
                </div>

                <div class="text-center">
                    <p class="text-xs font-bold text-slate-400 uppercase">Date</p>
                    <p class="font-bold text-slate-700">{{ new Date(order.created_at).toLocaleDateString() }}</p>
                </div>

                <div>
                    <span :class="getStatusStyle(order.status)" class="px-4 py-1 rounded-full text-xs font-bold uppercase">
                        {{ order.status }}
                    </span>
                </div>

                <div class="flex items-center gap-4">
                    <div class="text-right">
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Total</p>
                        <p class="text-xl font-heading text-brand-blue">{{ (order.total_amount_cents / 100).toFixed(2) }} €</p>
                    </div>
                    <Link :href="route('customer.orders.show', order.id)" 
                          class="p-3 bg-brand-yellow text-brand-blue rounded-xl hover:bg-yellow-400 transition-colors">
                        <PhCaretRight :size="20" weight="bold" />
                    </Link>
                </div>
            </div>
        </div>
    </div>
</template>