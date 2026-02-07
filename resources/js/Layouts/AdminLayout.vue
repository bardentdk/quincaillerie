<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { PhLayout, PhPackage, PhUsers, PhShoppingCart, PhChartLineUp, PhSignOut, PhGear, PhBank } from "@phosphor-icons/vue";

const page = usePage();
</script>

<template>
    <div class="flex min-h-screen bg-slate-100 font-body overflow-x-hidden">
        
        <aside class="w-64 bg-brand-blue text-white flex flex-col fixed h-full z-20">
            <div class="p-6 bg-blue-900 flex items-center gap-3">
                <div class="w-8 h-8 bg-brand-yellow rounded-lg flex items-center justify-center">
                    <PhPackage :size="20" weight="fill" class="text-brand-blue" />
                </div>
                <span class="font-heading text-xl tracking-tighter italic">QUINC<span class="text-brand-yellow">PRO</span></span>
            </div>

            <nav class="flex-1 p-4 space-y-2 mt-4">
                <Link :href="route('dashboard')" :class="{'bg-blue-800 text-brand-yellow': $page.component === 'Admin/Dashboard'}" class="flex items-center gap-3 p-3 rounded-xl hover:bg-blue-800 transition-colors">
                    <PhChartLineUp :size="22" weight="duotone" />
                    <span class="font-semibold uppercase text-sm tracking-wide">Tableau de bord</span>
                </Link>

                <Link :href="route('admin.products.index')" :class="{'bg-blue-800 text-brand-yellow': $page.url.startsWith('/admin/products')}" class="flex items-center gap-3 p-3 rounded-xl hover:bg-blue-800 transition-colors">
                    <PhPackage :size="22" weight="duotone" />
                    <span class="font-semibold uppercase text-sm tracking-wide">Catalogue</span>
                </Link>
                
                <Link :href="route('admin.financials')" :class="route().current('admin.financials') ? 'bg-blue-800 text-brand-yellow' : 'text-white hover:bg-white/10'" class="flex items-center gap-3 p-3 rounded-xl hover:bg-blue-800 transition-colors">
                    <PhBank :size="22" weight="duotone" />
                    <span class="font-semibold uppercase text-sm tracking-wide">Analyse financière</span>
                </Link>

                <Link :href="route('admin.orders.index')" :class="{'bg-blue-800 text-brand-yellow': $page.url.startsWith('/admin/orders')}" class="flex items-center gap-3 p-3 rounded-xl hover:bg-blue-800 transition-colors">
                    <PhShoppingCart :size="22" weight="duotone" />
                    <span class="font-semibold uppercase text-sm tracking-wide">Commandes</span>
                </Link>
            </nav>

            <div class="p-4 border-t border-blue-800">
                <Link :href="route('logout')" method="post" as="button" class="flex items-center gap-3 p-3 w-full text-left text-blue-300 hover:text-white transition-colors">
                    <PhSignOut :size="22" />
                    <span class="font-semibold uppercase text-sm tracking-wide">Déconnexion</span>
                </Link>
            </div>
        </aside>

        <main class="flex-1 ml-64 min-w-0">
            <header class="bg-white h-20 border-b border-slate-200 flex items-center justify-between px-8 sticky top-0 z-10">
                <h2 class="font-heading text-2xl text-slate-800">
                    <slot name="header" />
                </h2>
                <div class="flex items-center gap-4">
                    <div class="text-right">
                        <p class="text-sm font-bold text-slate-700">{{ $page.props.auth.user.name }}</p>
                        <p class="text-xs text-slate-500 uppercase">Administrateur</p>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-slate-200 border-2 border-brand-yellow"></div>
                </div>
            </header>

            <div class="p-8 overflow-hidden">
                <slot />
            </div>
        </main>
    </div>
</template>