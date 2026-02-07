<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { PhPlus, PhPencilSimple, PhTrash, PhCube } from "@phosphor-icons/vue";

defineProps({ products: Object });
</script>

<template>
    <AdminLayout>
        <Head title="Gestion Catalogue" />
        <template #header>Catalogue de la Quincaillerie</template>

        <div class="mb-6 flex justify-end">
            <Link :href="route('admin.products.create')" 
                  class="bg-brand-blue text-white px-6 py-3 rounded-xl font-heading flex items-center gap-2 hover:bg-blue-800 transition-all shadow-lg">
                <PhPlus :size="20" weight="bold" />
                AJOUTER UN PRODUIT
            </Link>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200">
                        <th class="p-4 font-heading text-slate-500 uppercase text-sm">Produit</th>
                        <th class="p-4 font-heading text-slate-500 uppercase text-sm">Catégorie</th>
                        <th class="p-4 font-heading text-slate-500 uppercase text-sm">Prix</th>
                        <th class="p-4 font-heading text-slate-500 uppercase text-sm">Stock</th>
                        <th class="p-4 font-heading text-slate-500 uppercase text-sm text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <tr v-for="product in products.data" :key="product.id" class="hover:bg-slate-50 transition-colors">
                        <td class="p-4">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 bg-slate-100 rounded-lg flex items-center justify-center text-slate-400">
                                    <PhCube :size="24" />
                                </div>
                                <div>
                                    <p class="font-bold text-slate-800">{{ product.name }}</p>
                                    <p class="text-xs text-slate-500 font-mono">{{ product.sku }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="p-4 text-sm text-slate-600">{{ product.category.name }}</td>
                        <td class="p-4 font-bold text-brand-blue">{{ (product.price_cents / 100).toFixed(2) }}€</td>
                        <td class="p-4">
                            <span :class="product.stock_quantity < 10 ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700'" 
                                  class="px-3 py-1 rounded-full text-xs font-bold">
                                {{ product.stock_quantity }} en stock
                            </span>
                        </td>
                        <td class="p-4 text-right">
                            <div class="flex justify-end gap-2">
                                <button class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                                    <PhPencilSimple :size="20" />
                                </button>
                                <button class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                                    <PhTrash :size="20" />
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </AdminLayout>
</template>