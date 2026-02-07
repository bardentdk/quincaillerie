<script setup>
import ShopLayout from '@/Layouts/ShopLayout.vue';
import { useForm, Head, Link } from '@inertiajs/vue3';
import { PhUser, PhBriefcase, PhCheckCircle } from "@phosphor-icons/vue";

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    is_pro: false,
    company_name: '',
    phone: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <ShopLayout>
        <Head title="Créer mon compte - Quincaillerie ARCS" />
        <div class="max-w-2xl mx-auto py-16 px-6">
            <div class="bg-white p-10 rounded-3xl shadow-xl border border-slate-100">
                <h1 class="text-4xl font-heading italic uppercase text-brand-blue mb-2">Rejoindre <span class="text-brand-yellow">l'Atelier</span></h1>
                <p class="text-slate-400 mb-8 font-bold uppercase text-xs tracking-widest">Créez votre compte client</p>

                <form @submit.prevent="submit" class="space-y-6">
                    <div class="flex gap-4 p-2 bg-slate-50 rounded-2xl">
                        <button type="button" @click="form.is_pro = false" :class="!form.is_pro ? 'bg-white shadow-sm text-brand-blue' : 'text-slate-400'" class="flex-1 py-3 rounded-xl font-bold uppercase text-xs transition-all">Particulier</button>
                        <button type="button" @click="form.is_pro = true" :class="form.is_pro ? 'bg-brand-blue text-white shadow-lg' : 'text-slate-400'" class="flex-1 py-3 rounded-xl font-bold uppercase text-xs transition-all">Professionnel</button>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase text-slate-400">Nom complet</label>
                            <input v-model="form.name" type="text" class="w-full bg-slate-50 border-none rounded-xl p-4 focus:ring-4 focus:ring-brand-yellow/30" required>
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase text-slate-400">Téléphone</label>
                            <input v-model="form.phone" type="tel" class="w-full bg-slate-50 border-none rounded-xl p-4 focus:ring-4 focus:ring-brand-yellow/30">
                        </div>
                    </div>

                    <div v-if="form.is_pro" class="space-y-2 animate-in fade-in slide-in-from-top-2">
                        <label class="text-[10px] font-black uppercase text-brand-blue">Nom de l'entreprise</label>
                        <input v-model="form.company_name" type="text" class="w-full bg-blue-50 border-2 border-blue-100 rounded-xl p-4 focus:ring-4 focus:ring-brand-blue/20" required>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase text-slate-400">Email professionnel</label>
                        <input v-model="form.email" type="email" class="w-full bg-slate-50 border-none rounded-xl p-4 focus:ring-4 focus:ring-brand-yellow/30" required>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase text-slate-400">Mot de passe</label>
                            <input v-model="form.password" type="password" class="w-full bg-slate-50 border-none rounded-xl p-4 focus:ring-4 focus:ring-brand-yellow/30" required>
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase text-slate-400">Confirmation</label>
                            <input v-model="form.password_confirmation" type="password" class="w-full bg-slate-50 border-none rounded-xl p-4 focus:ring-4 focus:ring-brand-yellow/30" required>
                        </div>
                    </div>

                    <button type="submit" :disabled="form.processing" class="w-full bg-brand-yellow text-brand-blue font-heading py-5 rounded-2xl text-xl hover:bg-brand-blue hover:text-white transition-all shadow-xl active:scale-95 uppercase italic">
                        Créer mon accès
                    </button>
                </form>
            </div>
        </div>
    </ShopLayout>
</template>