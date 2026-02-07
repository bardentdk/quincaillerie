<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import { PhPackage, PhTruck, PhCheckCircle, PhArrowLeft, PhUser, PhMapPin } from "@phosphor-icons/vue";

const props = defineProps({ order: Object });

const updateStatus = (newStatus) => {
    router.put(route('admin.orders.status', props.order.id), { status: newStatus });
};
</script>

<template>
    <AdminLayout>
        <Head :title="'Commande ' + order.order_number" />
        
        <template #header>
            <div class="flex items-center gap-4">
                <button @click="window.history.back()" class="p-2 hover:bg-slate-100 rounded-xl transition-colors">
                    <PhArrowLeft :size="20" />
                </button>
                Préparation Commande #{{ order.order_number }}
            </div>
        </template>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 font-body">
            
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100">
                    <h3 class="font-heading text-xl mb-8 uppercase italic text-brand-blue border-b pb-4">Articles à préparer</h3>
                    
                    <div class="space-y-6">
                        <div v-for="item in order.items" :key="item.id" class="flex items-center justify-between group">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-slate-50 rounded-xl flex items-center justify-center font-black text-brand-blue border border-slate-100">
                                    {{ item.quantity }}
                                </div>
                                <div>
                                    <p class="font-bold uppercase text-slate-800">{{ item.product.name }}</p>
                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">
                                        Unité : {{ item.product.unit === 'unit' ? 'Pièce' : item.product.unit }}
                                    </p>
                                </div>
                            </div>
                            <div class="text-right font-heading text-lg text-slate-400 group-hover:text-brand-blue transition-colors">
                                {{ (item.price_at_purchase_cents / 100).toFixed(2) }}€
                            </div>
                        </div>
                    </div>

                    <div class="mt-10 pt-6 border-t-4 border-double border-slate-100 flex justify-between items-center">
                        <span class="font-heading uppercase text-slate-400">Total payé</span>
                        <span class="text-3xl font-heading text-brand-blue italic">{{ (order.total_amount_cents / 100).toFixed(2) }}€</span>
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div class="bg-brand-blue p-8 rounded-3xl text-white shadow-xl relative overflow-hidden">
                    <div class="relative z-10">
                        <h3 class="font-heading text-brand-yellow uppercase italic mb-6">Logistique</h3>
                        
                        <div class="space-y-3">
                            <button @click="updateStatus('shipped')" 
                                    :disabled="order.status !== 'paid'"
                                    :class="order.status !== 'paid' ? 'opacity-30 cursor-not-allowed' : 'hover:bg-blue-800 hover:scale-105'"
                                    class="w-full flex items-center justify-between p-5 rounded-2xl border-2 border-blue-400 transition-all font-bold uppercase text-sm">
                                <span>1. Expédier</span>
                                <PhTruck :size="24" weight="fill" />
                            </button>

                            <button @click="updateStatus('delivered')" 
                                    :disabled="order.status !== 'shipped'"
                                    :class="order.status === 'delivered' ? 'bg-green-500 border-none' : (order.status !== 'shipped' ? 'opacity-30 cursor-not-allowed' : 'hover:bg-blue-800')"
                                    class="w-full flex items-center justify-between p-5 rounded-2xl border-2 border-blue-400 transition-all font-bold uppercase text-sm">
                                <span>2. Marquer Livré</span>
                                <PhCheckCircle :size="24" weight="fill" />
                            </button>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100">
                    <div class="space-y-6">
                        <div class="flex items-start gap-4">
                            <PhUser :size="20" class="text-brand-blue mt-1" />
                            <div>
                                <p class="text-[10px] font-black uppercase text-slate-400">Client</p>
                                <p class="font-bold">{{ order.user.name }}</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <PhMapPin :size="20" class="text-brand-blue mt-1" />
                            <div>
                                <p class="text-[10px] font-black uppercase text-slate-400">Livraison</p>
                                <p class="text-sm font-medium leading-relaxed">{{ order.delivery_address }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>