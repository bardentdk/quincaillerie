<script setup>
import ShopLayout from '@/Layouts/ShopLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { PhCheckCircle, PhTruck, PhFilePdf, PhHouse } from "@phosphor-icons/vue";
import { onMounted } from 'vue';

onMounted(() => {
    // On vide le panier localement puisque la commande est validée
    localStorage.removeItem('quincaillerie_cart');
});
</script>

<template>
    <ShopLayout>
        <Head title="Commande Confirmée" />
        
        <div class="max-w-3xl mx-auto py-20 px-6 text-center font-body">
            <div class="inline-flex p-6 rounded-full bg-green-100 text-green-600 mb-8">
                <PhCheckCircle :size="80" weight="fill" />
            </div>

            <h1 class="text-5xl font-heading uppercase italic text-brand-blue mb-4">Paiement Accepté !</h1>
            <p class="text-slate-600 text-lg mb-12">
                Votre commande a été transmise à notre équipe logistique. <br>
                Vous recevrez un email dès que votre colis quittera la quincaillerie.
            </p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <Link :href="route('customer.orders.index')" 
                      class="flex items-center justify-center gap-3 bg-brand-blue text-white py-4 rounded-2xl font-heading hover:bg-blue-800 transition-all">
                    <PhTruck :size="24" /> SUIVRE MA LIVRAISON
                </Link>
                
                <Link :href="route('home')" 
                      class="flex items-center justify-center gap-3 bg-slate-100 text-slate-700 py-4 rounded-2xl font-heading hover:bg-slate-200 transition-all">
                    <PhHouse :size="24" /> RETOUR À L'ACCUEIL
                </Link>
            </div>
        </div>
    </ShopLayout>
</template>