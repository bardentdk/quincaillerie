<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head } from '@inertiajs/vue3';
import { PhTrendUp, PhShoppingCart, PhWarningOctagon, PhPackage, PhEye } from "@phosphor-icons/vue";

defineProps({ metrics: Object, revenueChart: Array, recentOrders: Array });
</script>

<template>
    <AdminLayout>
        <Head title="Tableau de Bord Financier" />
        <template #header>Rapport d'activité Quincaillerie</template>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-blue-50 text-brand-blue rounded-xl"><PhTrendUp :size="24" weight="duotone" /></div>
                    <span class="text-xs font-bold text-green-500 bg-green-50 px-2 py-1 rounded-lg">+12.5%</span>
                </div>
                <p class="text-slate-500 text-xs font-bold uppercase tracking-widest">CA du mois</p>
                <p class="text-3xl font-heading text-slate-900">{{ metrics.total_revenue }} €</p>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-yellow-50 text-brand-yellow rounded-xl"><PhShoppingCart :size="24" weight="duotone" /></div>
                </div>
                <p class="text-slate-500 text-xs font-bold uppercase tracking-widest">Commandes</p>
                <p class="text-3xl font-heading text-slate-900">{{ metrics.orders_count }}</p>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
                <div class="flex items-center justify-between mb-4 text-red-600">
                    <div class="p-3 bg-red-50 rounded-xl"><PhWarningOctagon :size="24" weight="duotone" /></div>
                </div>
                <p class="text-slate-500 text-xs font-bold uppercase tracking-widest">Alerte Stock</p>
                <p class="text-3xl font-heading text-red-600">{{ metrics.low_stock_count }}</p>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
                <div class="flex items-center justify-between mb-4 text-brand-blue">
                    <div class="p-3 bg-blue-50 rounded-xl"><PhPackage :size="24" weight="duotone" /></div>
                </div>
                <p class="text-slate-500 text-xs font-bold uppercase tracking-widest">À livrer</p>
                <p class="text-3xl font-heading text-brand-blue">{{ metrics.pending_deliveries }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="p-6 border-b border-slate-100 flex justify-between items-center">
                    <h3 class="font-heading text-lg">Dernières Commandes</h3>
                    <button class="text-brand-blue text-sm font-bold hover:underline italic">Voir tout</button>
                </div>
                <table class="w-full text-left">
                    <thead class="bg-slate-50 text-slate-500 text-[10px] uppercase tracking-tighter">
                        <tr>
                            <th class="p-4">Client</th>
                            <th class="p-4">Date</th>
                            <th class="p-4">Montant</th>
                            <th class="p-4">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        <tr v-for="order in recentOrders" :key="order.id" class="hover:bg-slate-50">
                            <td class="p-4 font-bold text-slate-700">{{ order.user.name }}</td>
                            <td class="p-4 text-sm text-slate-500">{{ new Date(order.created_at).toLocaleDateString() }}</td>
                            <td class="p-4 font-bold text-brand-blue">{{ (order.total_amount_cents / 100).toFixed(2) }}€</td>
                            <td class="p-4">
                                <button class="p-2 bg-slate-100 rounded-lg hover:bg-brand-yellow transition-colors">
                                    <PhEye :size="18" />
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="bg-brand-blue rounded-3xl p-8 text-white">
                <h3 class="font-heading text-xl text-brand-yellow mb-6 italic underline">Notes Logistique</h3>
                <ul class="space-y-4 text-sm font-body">
                    <li class="flex gap-3">
                        <span class="w-2 h-2 mt-1.5 rounded-full bg-brand-yellow shrink-0"></span>
                        Vérifier arrivage visserie inox lundi matin.
                    </li>
                    <li class="flex gap-3">
                        <span class="w-2 h-2 mt-1.5 rounded-full bg-brand-yellow shrink-0"></span>
                        Appeler transporteur pour livraison palette #882.
                    </li>
                </ul>
            </div>
        </div>
    </AdminLayout>
</template>