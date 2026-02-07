<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { PhPackage, PhTruck, PhCheckCircle, PhClock, PhEye } from "@phosphor-icons/vue";

defineProps({ orders: Array });

// Fonction pour définir les couleurs des badges selon le statut
const getStatusBadge = (status) => {
    const styles = {
        'pending': 'bg-amber-100 text-amber-700 border-amber-200',
        'paid': 'bg-blue-100 text-blue-700 border-blue-200',
        'shipped': 'bg-indigo-100 text-indigo-700 border-indigo-200',
        'delivered': 'bg-emerald-100 text-emerald-700 border-emerald-200',
    };
    return styles[status] || 'bg-slate-100 text-slate-700';
};

const getStatusIcon = (status) => {
    if (status === 'pending') return PhClock;
    if (status === 'paid') return PhPackage;
    if (status === 'shipped') return PhTruck;
    return PhCheckCircle;
};
</script>

<template>
    <AdminLayout>
        <Head title="Gestion des Commandes - Admin" />
        
        <template #header>Journal des Ventes</template>

        <div class="bg-white rounded-3xl shadow-xl border border-slate-100 overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50 border-b border-slate-100">
                    <tr>
                        <th class="p-6 text-xs font-black uppercase tracking-widest text-slate-400">Commande</th>
                        <th class="p-6 text-xs font-black uppercase tracking-widest text-slate-400">Client</th>
                        <th class="p-6 text-xs font-black uppercase tracking-widest text-slate-400">Date</th>
                        <th class="p-6 text-xs font-black uppercase tracking-widest text-slate-400">Total</th>
                        <th class="p-6 text-xs font-black uppercase tracking-widest text-slate-400">Statut</th>
                        <th class="p-6"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    <tr v-for="order in orders" :key="order.id" class="hover:bg-slate-50/50 transition-colors group">
                        <td class="p-6">
                            <span class="font-heading italic text-brand-blue font-bold">#{{ order.number }}</span>
                        </td>
                        <td class="p-6">
                            <div class="font-bold text-slate-700">{{ order.customer }}</div>
                        </td>
                        <td class="p-6 text-slate-500 text-sm">
                            {{ order.date }}
                        </td>
                        <td class="p-6">
                            <span class="font-heading text-lg text-slate-900">{{ order.total }}</span>
                        </td>
                        <td class="p-6">
                            <div :class="getStatusBadge(order.status)" class="inline-flex items-center gap-2 px-3 py-1 rounded-full border text-[10px] font-black uppercase tracking-tighter">
                                <component :is="getStatusIcon(order.status)" :size="14" weight="bold" />
                                {{ order.status === 'paid' ? 'À Préparer' : order.status }}
                            </div>
                        </td>
                        <td class="p-6 text-right">
                            <Link :href="route('admin.orders.show', order.id)" 
                                  class="inline-flex items-center justify-center w-10 h-10 bg-slate-100 text-slate-400 rounded-xl hover:bg-brand-blue hover:text-white transition-all shadow-sm">
                                <PhEye :size="20" weight="bold" />
                            </Link>
                        </td>
                    </tr>
                </tbody>
            </table>

            <div v-if="orders.length === 0" class="p-20 text-center">
                <PhPackage :size="64" weight="thin" class="mx-auto text-slate-200 mb-4" />
                <p class="text-slate-400 font-heading uppercase italic">Aucune commande enregistrée</p>
            </div>
        </div>
    </AdminLayout>
</template>