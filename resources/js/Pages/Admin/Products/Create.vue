<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { useForm, Head } from '@inertiajs/vue3';
import { ref } from 'vue';
import { PhPlus, PhX, PhCheckCircle } from "@phosphor-icons/vue";

const props = defineProps({
    categories: Array
});

// Formulaire principal du produit
const form = useForm({
    name: '',
    category_id: '',
    price: '',
    unit: 'unit', // Par défaut à l'unité
    stock_quantity: '',
    description: '',
    image: null,
});

// Formulaire pour la création rapide de catégorie
const showCategoryModal = ref(false);
const categoryForm = useForm({
    name: '',
});

const submitCategory = () => {
    categoryForm.post(route('admin.categories.storeQuick'), {
        onSuccess: () => {
            showCategoryModal.value = false;
            categoryForm.reset();
        },
    });
};

const submitProduct = () => {
    form.post(route('admin.products.store'));
};
</script>

<template>
    <AdminLayout>
        <Head title="Nouveau Produit - Admin" />
        
        <template #header>Ajouter un article</template>

        <div class="max-w-4xl mx-auto">
            <form @submit.prevent="submitProduct" class="space-y-8 bg-white p-10 rounded-3xl shadow-xl border border-slate-100">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-2">
                        <label class="text-xs font-black uppercase tracking-widest text-slate-400">Nom de l'article</label>
                        <input v-model="form.name" type="text" class="w-full bg-slate-50 border-none rounded-2xl p-4 focus:ring-4 focus:ring-brand-yellow/50">
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-black uppercase tracking-widest text-slate-400">Rayon (Catégorie)</label>
                        <div class="flex gap-2">
                            <select v-model="form.category_id" class="flex-1 bg-slate-50 border-none rounded-2xl p-4 focus:ring-4 focus:ring-brand-yellow/50">
                                <option value="">Choisir un rayon...</option>
                                <option v-for="cat in categories" :key="cat.id" :value="cat.id">{{ cat.name }}</option>
                            </select>
                            <button type="button" @click="showCategoryModal = true" 
                                    class="bg-brand-blue text-brand-yellow p-4 rounded-2xl hover:bg-blue-800 transition-all shadow-lg">
                                <PhPlus weight="bold" />
                            </button>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-black uppercase tracking-widest text-slate-400">Prix de vente (€)</label>
                        <div class="flex gap-2">
                            <input v-model="form.price" type="number" step="0.01" class="flex-1 bg-slate-50 border-none rounded-2xl p-4 focus:ring-4 focus:ring-brand-yellow/50">
                            <select v-model="form.unit" class="w-32 bg-slate-200 border-none rounded-2xl p-4 font-bold text-slate-700">
                                <option value="unit">Pièce</option>
                                <option value="kg">Kilo (kg)</option>
                                <option value="ton">Tonne (t)</option>
                            </select>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-black uppercase tracking-widest text-slate-400">Stock Initial</label>
                        <input v-model="form.stock_quantity" type="number" class="w-full bg-slate-50 border-none rounded-2xl p-4 focus:ring-4 focus:ring-brand-yellow/50">
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-xs font-black uppercase tracking-widest text-slate-400">Description Technique</label>
                    <textarea v-model="form.description" rows="5" class="w-full bg-slate-50 border-none rounded-2xl p-4 focus:ring-4 focus:ring-brand-yellow/50"></textarea>
                </div>

                <div class="space-y-2">
                    <label class="text-xs font-black uppercase tracking-widest text-slate-400">Photo du produit</label>
                    <input type="file" @input="form.image = $event.target.files[0]" class="w-full text-slate-500 file:mr-4 file:py-3 file:px-6 file:rounded-full file:border-0 file:text-sm file:font-heading file:bg-brand-blue file:text-white hover:file:bg-blue-800" />
                </div>

                <button type="submit" class="w-full bg-brand-yellow text-brand-blue font-heading py-5 rounded-2xl text-xl hover:bg-brand-blue hover:text-white transition-all shadow-xl active:scale-95">
                    ENREGISTRER DANS LE CATALOGUE
                </button>
            </form>
        </div>

        <Transition
            enter-active-class="transition duration-300 ease-out" enter-from-class="opacity-0" enter-to-class="opacity-100"
            leave-active-class="transition duration-200 ease-in" leave-from-class="opacity-100" leave-to-class="opacity-0"
        >
            <div v-if="showCategoryModal" class="fixed inset-0 z-[100] flex items-center justify-center p-6 bg-slate-900/80 backdrop-blur-sm">
                <div class="bg-white w-full max-w-md rounded-3xl shadow-2xl overflow-hidden border-4 border-brand-yellow">
                    <div class="p-6 bg-brand-blue text-white flex justify-between items-center">
                        <h3 class="font-heading italic uppercase text-lg">Nouveau Rayon</h3>
                        <button @click="showCategoryModal = false"><PhX :size="24" /></button>
                    </div>
                    <form @submit.prevent="submitCategory" class="p-8 space-y-6">
                        <div class="space-y-2">
                            <label class="text-xs font-black uppercase text-slate-400 tracking-widest">Nom de la catégorie</label>
                            <input v-model="categoryForm.name" type="text" placeholder="Ex: Matériaux, Électricité..." 
                                   class="w-full bg-slate-50 border-none rounded-xl p-4 focus:ring-4 focus:ring-brand-blue/20">
                        </div>
                        <button type="submit" :disabled="categoryForm.processing"
                                class="w-full bg-brand-yellow text-brand-blue font-heading py-4 rounded-xl flex items-center justify-center gap-2 hover:bg-brand-blue hover:text-white transition-all">
                            <PhCheckCircle :size="20" weight="bold" /> CRÉER LE RAYON
                        </button>
                    </form>
                </div>
            </div>
        </Transition>
    </AdminLayout>
</template>