<script setup>
import { useForm, Head, Link } from '@inertiajs/vue3';
import { PhLock, PhEnvelope, PhSignIn } from "@phosphor-icons/vue";

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <Head title="Connexion - Quincaillerie Pro" />

    <div class="min-h-screen flex items-center justify-center bg-slate-50 p-6">
        <div class="w-full max-w-md bg-white rounded-2xl shadow-xl overflow-hidden border border-slate-100">
            <div class="bg-brand-blue p-8 text-center">
                <div class="inline-flex p-3 rounded-full bg-brand-yellow mb-4">
                    <PhLock :size="32" weight="duotone" class="text-brand-blue" />
                </div>
                <h1 class="text-3xl font-heading text-white tracking-tight">Espace Client</h1>
                <p class="text-blue-100 font-body mt-2">Accédez à votre compte quincaillerie</p>
            </div>

            <form @submit.prevent="submit" class="p-8 space-y-6">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2 uppercase tracking-wider">Email Professionnel</label>
                    <div class="relative">
                        <PhEnvelope :size="20" class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400" />
                        <input v-model="form.email" type="email" required
                               class="w-full pl-10 pr-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-brand-yellow focus:border-brand-blue outline-none transition-all"
                               placeholder="nom@entreprise.com">
                    </div>
                    <div v-if="form.errors.email" class="text-red-500 text-xs mt-1">{{ form.errors.email }}</div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2 uppercase tracking-wider">Mot de passe</label>
                    <div class="relative">
                        <PhLock :size="20" class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400" />
                        <input v-model="form.password" type="password" required
                               class="w-full pl-10 pr-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-brand-yellow focus:border-brand-blue outline-none transition-all"
                               placeholder="••••••••">
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <label class="flex items-center space-x-2 cursor-pointer">
                        <input type="checkbox" v-model="form.remember" class="rounded border-slate-300 text-brand-blue focus:ring-brand-yellow">
                        <span class="text-sm text-slate-600">Se souvenir de moi</span>
                    </label>
                </div>

                <button type="submit" :disabled="form.processing"
                        class="w-full bg-brand-blue hover:bg-blue-800 text-white font-heading py-4 rounded-xl shadow-lg transition-transform active:scale-[0.98] flex items-center justify-center gap-2 text-lg">
                    <PhSignIn :size="24" weight="bold" />
                    SE CONNECTER
                </button>
            </form>
            
            <div class="p-6 bg-slate-50 border-t border-slate-100 text-center">
                <p class="text-sm text-slate-500 font-body">
                    Pas encore de compte ? 
                    <Link :href="route('register')" class="text-brand-blue font-bold hover:underline">
                        Demander une ouverture de compte
                    </Link>
                </p>
            </div>
        </div>
    </div>
</template>