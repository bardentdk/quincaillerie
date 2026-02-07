<script setup>
import ShopLayout from '@/Layouts/ShopLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { PhPackage, PhClock, PhUserGear, PhMapPin, PhArrowRight } from "@phosphor-icons/vue";

defineProps({
    user: Object,
    recentOrders: Array
});
</script>

<template>
    <ShopLayout>
        <Head title="Mon Compte" />
        <div class="max-w-7xl mx-auto py-12 px-6">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-12 font-body">
                
                <aside class="space-y-4">
                    <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100 text-center">
                        <div class="w-20 h-20 bg-brand-blue text-brand-yellow rounded-full flex items-center justify-center mx-auto mb-4 text-3xl font-heading italic">
                            {{ user.name.charAt(0) }}
                        </div>
                        <h3 class="font-bold text-slate-900">{{ user.name }}</h3>
                        <p v-if="user.is_pro" class="text-[10px] bg-brand-yellow text-brand-blue px-3 py-1 rounded-full font-black uppercase mt-2 inline-block italic">Compte Pro</p>
                        <p v-else class="text-[10px] text-slate-400 font-bold uppercase mt-2">Client Particulier</p>
                    </div>

                    <nav class="space-y-2">
                        <Link :href="route('customer.orders.index')" class="flex items-center justify-between p-4 bg-white rounded-2xl hover:bg-brand-blue hover:text-white transition-all group">
                            <span class="font-bold uppercase text-xs">Mes Commandes</span>
                            <PhPackage :size="20" weight="duotone" />
                        </Link>
                        <Link href="#" class="flex items-center justify-between p-4 bg-white rounded-2xl hover:bg-brand-blue hover:text-white transition-all group opacity-50 cursor-not-allowed">
                            <span class="font-bold uppercase text-xs">Adresses de livraison</span>
                            <PhMapPin :size="20" weight="duotone" />
                        </Link>
                    </nav>
                </aside>

                <div class="lg:col-span-3 space-y-8">
                    <div class="bg-brand-blue rounded-3xl p-10 text-white relative overflow-hidden">
                        <h2 class="text-4xl font-heading italic uppercase mb-2">Ravi de vous revoir, <span class="text-brand-yellow">{{ user.name.split(' ')[0] }}</span></h2>
                        <p class="text-blue-200">Prêt pour vos nouveaux travaux ? Retrouvez tous vos outils ici.</p>
                        <PhUserGear :size="120" class="absolute -right-4 -bottom-4 opacity-10 rotate-12" />
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="font-heading italic uppercase text-xl text-slate-800">Derniers achats</h3>
                            <Link :href="route('customer.orders.index')" class="text-brand-blue font-bold uppercase text-xs flex items-center gap-2 hover:underline">Voir tout <PhArrowRight /></Link>
                        </div>

                        <div v-if="recentOrders.length > 0" class="grid grid-cols-1 gap-4">
                            <div v-for="order in recentOrders" :key="order.id" class="bg-white p-6 rounded-2xl border border-slate-100 flex items-center justify-between">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 bg-slate-50 rounded-lg flex items-center justify-center text-slate-400">
                                        <PhClock :size="20" />
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-800">#{{ order.order_number }}</p>
                                        <p class="text-xs text-slate-400 italic">{{ order.created_at }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="font-heading text-lg text-brand-blue">{{ (order.total_amount_cents / 100).toFixed(2) }}€</p>
                                    <span class="text-[9px] font-black uppercase px-2 py-0.5 rounded bg-blue-50 text-blue-500 border border-blue-100">{{ order.status }}</span>
                                </div>
                            </div>
                        </div>
                        <div v-else class="bg-slate-50 border-2 border-dashed border-slate-200 rounded-3xl p-12 text-center text-slate-400">
                            Aucune commande récente.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </ShopLayout>
</template>