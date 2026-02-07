<script setup>
import { onMounted, ref } from 'vue';
import { Chart, registerables } from 'chart.js';
Chart.register(...registerables);

const props = defineProps({ labels: Array, values: Array });
const chartCanvas = ref(null);

onMounted(() => {
    new Chart(chartCanvas.value, {
        type: 'line',
        data: {
            labels: props.labels,
            datasets: [{
                label: 'Chiffre d\'affaires (€)',
                data: props.values,
                borderColor: '#00429d', // Bleu de marque
                backgroundColor: 'rgba(0, 66, 157, 0.1)',
                fill: true,
                tension: 0.4,
                borderWidth: 3,
                pointBackgroundColor: '#ffde00' // Jaune de marque pour les points
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, grid: { display: false } },
                x: { grid: { display: false } }
            }
        }
    });
});
</script>

<template>
    <div class="h-[300px] w-full">
        <canvas ref="chartCanvas"></canvas>
    </div>
</template>