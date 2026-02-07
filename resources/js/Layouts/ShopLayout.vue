<script setup>
import { ref, computed, onMounted } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
import { PhShoppingCart, PhUser, PhPackage, PhX, PhTrash, PhCreditCard, PhArrowRight } from "@phosphor-icons/vue";
import { useCart } from '@/Composables/useCart';

const { state, count, total, removeFromCart, loadCart } = useCart();
const isCartOpen = ref(false); // État du panier flottant

const page = usePage();
const user = computed(() => page.props.auth?.user);
const flash = computed(() => page.props.flash?.message);

onMounted(() => loadCart());
</script>

<template>
    <div class="min-h-screen bg-slate-50 font-body relative overflow-x-hidden">
        
        <Transition
            enter-active-class="transition-opacity duration-300"
            enter-from-class="opacity-0"
            enter-to-class="opacity-100"
            leave-active-class="transition-opacity duration-300"
            leave-from-class="opacity-100"
            leave-to-class="opacity-0"
        >
            <div v-if="isCartOpen" @click="isCartOpen = false" class="fixed inset-0 bg-slate-900/60 z-[60] backdrop-blur-sm"></div>
        </Transition>

        <Transition
            enter-active-class="transform transition duration-500 cubic-bezier(0.4, 0, 0.2, 1)"
            enter-from-class="translate-x-full"
            enter-to-class="translate-x-0"
            leave-active-class="transform transition duration-500 cubic-bezier(0.4, 0, 0.2, 1)"
            leave-from-class="translate-x-0"
            leave-to-class="translate-x-full"
        >
            <aside v-if="isCartOpen" class="fixed right-0 top-0 h-full w-full max-w-md bg-white z-[70] shadow-2xl flex flex-col">
                <div class="p-6 border-b border-slate-100 flex items-center justify-between bg-brand-blue text-white">
                    <h2 class="font-heading italic uppercase text-xl flex items-center gap-2">
                        <PhShoppingCart weight="fill" class="text-brand-yellow" />
                        Mon Panier <span class="text-sm font-body not-italic opacity-60">({{ count() }})</span>
                    </h2>
                    <button @click="isCartOpen = false" class="p-2 hover:bg-white/10 rounded-full transition-colors">
                        <PhX :size="24" weight="bold" />
                    </button>
                </div>

                <div class="flex-1 overflow-y-auto p-6 space-y-4">
                    <div v-if="state.items.length === 0" class="h-full flex flex-col items-center justify-center text-slate-400 opacity-60">
                        <PhPackage :size="64" weight="thin" class="mb-4" />
                        <p class="font-heading uppercase italic">Le panier est vide</p>
                    </div>

                    <div v-for="item in state.items" :key="item.id" class="flex gap-4 p-3 border border-slate-50 rounded-2xl hover:bg-slate-50 transition-colors">
                        <div class="w-16 h-16 bg-slate-100 rounded-lg flex items-center justify-center shrink-0">
                            <PhPackage :size="24" class="text-slate-300" />
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-bold uppercase text-slate-800 line-clamp-1">{{ item.name }}</p>
                            
                            <div class="flex items-center gap-1 mt-1">
                                <span class="text-xs bg-slate-100 px-2 py-0.5 rounded font-bold text-slate-600">
                                    {{ item.quantity }} {{ item.unit === 'unit' ? 'pce(s)' : item.unit }}
                                </span>
                                <span class="text-[10px] text-slate-400">@ {{ item.price }}€</span>
                            </div>

                            <p class="text-brand-blue font-heading font-bold mt-1">
                                {{ (item.price * item.quantity).toFixed(2) }}€
                            </p>
                        </div>
                        <button @click="removeFromCart(item.id)" class="text-slate-300 hover:text-red-500 transition-colors">
                            <PhTrash :size="18" />
                        </button>
                    </div>
                </div>

                <div v-if="state.items.length > 0" class="p-6 border-t border-slate-100 bg-slate-50">
                    <div class="flex justify-between items-center mb-6">
                        <span class="text-slate-500 font-bold uppercase text-xs tracking-widest">Sous-total</span>
                        <span class="text-2xl font-heading text-brand-blue">{{ total() }}€</span>
                    </div>
                    
                    <div class="space-y-3">
                        <Link :href="route('cart.index')" class="w-full bg-slate-200 text-slate-700 font-heading py-4 rounded-xl flex items-center justify-center gap-2 hover:bg-slate-300 transition-all uppercase text-sm">
                            Voir le panier complet
                        </Link>
                        <button @click="isCartOpen = false; $inertia.post(route('checkout.store'), { items: state.items })" 
                                class="w-full bg-brand-yellow text-brand-blue font-heading py-4 rounded-xl flex items-center justify-center gap-2 hover:bg-brand-blue hover:text-white transition-all shadow-lg shadow-brand-yellow/20 uppercase text-sm">
                            <PhCreditCard :size="20" weight="bold" /> Commander
                        </button>
                    </div>
                </div>
            </aside>
        </Transition>

        <nav class="bg-brand-blue text-white sticky top-0 z-50 shadow-lg border-b-4 border-brand-yellow">
            <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
                <Link :href="route('home')" class="flex items-center gap-3 group">
                    <div class="w-10 h-10 bg-brand-yellow rounded-xl flex items-center justify-center group-hover:rotate-12 transition-transform">
                        <PhPackage :size="24" weight="fill" class="text-brand-blue" />
                    </div>
                    <span class="font-heading text-2xl tracking-tighter italic uppercase">
                        Quinc<span class="text-brand-yellow">Pro</span>
                    </span>
                </Link>

                <div class="flex items-center gap-6">
                    <button @click="isCartOpen = true" class="relative p-2 bg-blue-800 rounded-full hover:bg-brand-yellow hover:text-brand-blue transition-all group">
                        <PhShoppingCart :size="24" weight="duotone" class="group-hover:scale-110 transition-transform" />
                        <span v-if="count() > 0" class="absolute -top-1 -right-1 bg-brand-yellow text-brand-blue text-[10px] font-bold w-5 h-5 rounded-full flex items-center justify-center border-2 border-brand-blue">
                            {{ count() }}
                        </span>
                    </button>
                    
                    <Link v-if="!user" :href="route('login')" class="hover:text-brand-yellow transition-colors"><PhUser :size="24" /></Link>
                    <Link v-else :href="route('dashboard')" class="text-xs font-bold uppercase border-b-2 border-brand-yellow">{{ user.name }}</Link>
                </div>
            </div>
        </nav>

        <slot />
    </div>
</template>