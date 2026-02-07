<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head } from '@inertiajs/vue3';
import { 
    Line as LineChart 
} from 'vue-chartjs';
import { 
    Chart as ChartJS, 
    Title, 
    Tooltip, 
    Legend, 
    LineElement, 
    LinearScale, 
    PointElement, 
    CategoryScale,
    Filler
} from 'chart.js';
import { PhTrendUp, PhBank, PhCoins, PhArrowUpRight } from "@phosphor-icons/vue";

// Enregistrement des composants Chart.js
ChartJS.register(
    Title, Tooltip, Legend, LineElement, LinearScale, PointElement, CategoryScale, Filler
);

const props = defineProps({
    chartData: Object
});

// Configuration du style du graphique
const chartOptions = {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
        legend: { display: false },
        tooltip: {
            backgroundColor: '#00429d',
            titleFont: { family: 'Inter', size: 14, weight: 'bold' },
            padding: 12,
            cornerRadius: 10,
            displayColors: false
        }
    },
    scales: {
        y: {
            beginAtZero: true,
            grid: { display: false },
            ticks: { callback: (value) => value + '€' }
        },
        x: {
            grid: { display: false }
        }
    }
};

// Application du dégradé et des couleurs de la marque
const formattedData = {
    labels: props.chartData.labels,
    datasets: [{
        ...props.chartData.datasets[0],
        borderColor: '#ffde00', // Jaune ARCS
        backgroundColor: 'rgba(255, 222, 0, 0.1)', // Dégradé léger
        borderWidth: 4,
        pointBackgroundColor: '#00429d',
        pointBorderColor: '#fff',
        pointHoverRadius: 8,
        fill: true,
        tension: 0.4 // Courbes fluides
    }]
};
</script>

<template>
    <AdminLayout>
        <Head title="Analyse Financière - Admin" />

        <template #header>Performance Commerciale</template>

        <div class="space-y-8 font-body">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="p-3 bg-emerald-50 text-emerald-600 rounded-2xl">
                            <PhTrendUp :size="24" weight="bold" />
                        </div>
                        <span class="text-xs font-black uppercase tracking-widest text-slate-400">Croissance</span>
                    </div>
                    <p class="text-2xl font-heading italic text-slate-900">+12.5% <span class="text-sm font-body not-italic text-slate-400">ce mois</span></p>
                </div>

                <div class="bg-brand-blue p-6 rounded-3xl shadow-xl">
                    <div class="flex items-center gap-4 mb-4 text-white">
                        <div class="p-3 bg-white/10 rounded-2xl text-brand-yellow">
                            <PhBank :size="24" weight="bold" />
                        </div>
                        <span class="text-xs font-black uppercase tracking-widest opacity-60">Trésorerie estimée</span>
                    </div>
                    <p class="text-2xl font-heading italic text-white">Calcul en cours...</p>
                </div>
            </div>

            <div class="bg-white p-8 rounded-3xl shadow-xl border border-slate-100">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-10">
                    <div>
                        <h3 class="text-xl font-heading uppercase italic text-brand-blue flex items-center gap-2">
                            <PhCoins class="text-brand-yellow" /> Évolution du Chiffre d'Affaires
                        </h3>
                        <p class="text-sm text-slate-400">Revenus cumulés sur les 30 derniers jours</p>
                    </div>
                    <div class="flex gap-2">
                        <span class="px-4 py-2 bg-slate-50 rounded-xl text-xs font-bold text-slate-500 border border-slate-100">30 derniers jours</span>
                    </div>
                </div>

                <div class="h-[400px]">
                    <LineChart :data="formattedData" :options="chartOptions" />
                </div>
            </div>
        </div>
    </AdminLayout>
</template>