<template>
    <AdminLayout>
        <template #header>Gestion des Comptes</template>
        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
            <table class="w-full text-left">
                <thead class="bg-slate-50 border-b">
                    <tr class="text-[10px] font-black uppercase text-slate-400 tracking-widest">
                        <th class="p-6">Client</th>
                        <th class="p-6">Type</th>
                        <th class="p-6">Entreprise</th>
                        <th class="p-6">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    <tr v-for="user in users" :key="user.id" class="hover:bg-slate-50 transition-colors">
                        <td class="p-6">
                            <p class="font-bold text-slate-800">{{ user.name }}</p>
                            <p class="text-xs text-slate-400">{{ user.email }}</p>
                        </td>
                        <td class="p-6">
                            <span :class="user.is_pro ? 'bg-brand-yellow text-brand-blue' : 'bg-slate-100 text-slate-500'" 
                                  class="px-3 py-1 rounded-full text-[10px] font-black uppercase">
                                {{ user.is_pro ? 'PRO' : 'Particulier' }}
                            </span>
                        </td>
                        <td class="p-6 text-sm italic">{{ user.company_name || '-' }}</td>
                        <td class="p-6">
                            <button @click="togglePro(user)" class="text-brand-blue font-bold text-xs uppercase hover:underline">
                                {{ user.is_pro ? 'Passer Particulier' : 'Passer PRO' }}
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { router } from '@inertiajs/vue3';
defineProps({ users: Array });

const togglePro = (user) => {
    router.put(route('admin.users.update', user.id), { is_pro: !user.is_pro });
};
</script>