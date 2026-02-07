<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { PhArrowLeft, PhReceipt, PhTruck, PhCheckCircle } from "@phosphor-icons/vue";

const props = defineProps({ order: Object });
</script>

<template>
    <Head :title="'Commande ' + order.order_number" />
    
    <div class="max-w-4xl mx-auto py-12 px-6 font-body">
        <Link :href="route('customer.orders.index')" class="flex items-center gap-2 text-slate-500 hover:text-brand-blue mb-8 font-bold text-sm uppercase">
            <PhArrowLeft /> Retour à mes commandes
        </Link>

        <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-slate-100">
            <div class="bg-brand-blue p-8 text-white flex justify-between items-center">
                <div>
                    <h2 class="font-heading text-2xl">Détails de la commande</h2>
                    <p class="text-blue-200">Réf : {{ order.order_number }}</p>
                </div>
                <a :href="route('orders.invoice', order.id)" 
                   class="bg-brand-yellow text-brand-blue px-6 py-3 rounded-xl font-heading flex items-center gap-2 hover:bg-yellow-400">
                    <PhReceipt :size="20" /> TÉLÉCHARGER LA FACTURE
                </a>
            </div>

            <div class="p-8 border-b border-slate-100 bg-slate-50">
                <div class="flex items-center justify-between max-w-2xl mx-auto relative">
                    <div class="absolute h-1 bg-slate-200 w-full top-1/2 -translate-y-1/2 z-0"></div>
                    
                    <div class="z-10 bg-white p-2 rounded-full border-2 border-brand-blue text-brand-blue">
                        <PhCheckCircle :size="24" weight="fill" />
                    </div>
                    <div :class="order.status === 'shipped' || order.status === 'delivered' ? 'border-brand-blue text-brand-blue' : 'border-slate-200 text-slate-300'" 
                         class="z-10 bg-white p-2 rounded-full border-2">
                        <PhTruck :size="24" weight="fill" />
                    </div>
                    <div :class="order.status === 'delivered' ? 'border-brand-blue text-brand-blue' : 'border-slate-200 text-slate-300'" 
                         class="z-10 bg-white p-2 rounded-full border-2">
                        <PhPackage :size="24" weight="fill" />
                    </div>
                </div>
                <div class="flex justify-between max-w-2xl mx-auto mt-4 text-[10px] font-bold uppercase tracking-widest text-slate-500">
                    <span>Payée</span>
                    <span>En cours d'expédition</span>
                    <span>Livrée</span>
                </div>
            </div>

            <div class="p-8">
                <table class="w-full">
                    <thead>
                        <tr class="text-left text-slate-400 text-xs uppercase border-b border-slate-100">
                            <th class="pb-4">Article</th>
                            <th class="pb-4 text-center">Qté</th>
                            <th class="pb-4 text-right">Prix</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        <tr v-for="item in order.items" :key="item.id">
                            <td class="py-4 font-bold text-slate-700">{{ item.product.name }}</td>
                            <td class="py-4 text-center">{{ item.quantity }}</td>
                            <td class="py-4 text-right font-heading text-brand-blue">{{ (item.price_at_purchase / 100).toFixed(2) }}€</td>
                        </tr>
                    </tbody>
                </table>

                <div class="mt-8 pt-8 border-t border-slate-100 flex justify-end">
                    <div class="text-right">
                        <p class="text-slate-500 uppercase text-xs font-bold">Total TTC</p>
                        <p class="text-4xl font-heading text-brand-blue">{{ (order.total_amount_cents / 100).toFixed(2) }}€</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>