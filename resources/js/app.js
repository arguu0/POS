import Chart from 'chart.js/auto';

function loadSalesChart() {
    const canvas = document.getElementById('salesChart');

    if (canvas) {
        new Chart(canvas, {
            type: 'line',
            pointRadius: 0,
            pointHoverRadius: 5,
            data: {
                labels: ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'],
                datasets: [{
                    label: 'Sales',
                    data: [100,500,1000,500,300,2000,1500],
                    borderColor: '#4ade80',
                    backgroundColor: 'rgba(74,222,128,.2)',
                    fill: true,
                    tension: 0.3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        }
                    },
                    y: {
                    beginAtZero: true,
                    grid: {
                            color: '#3f3f46'
                        },
                    ticks: {
                        stepSize: 300
                    }
                }
                }
            }
        });
    }
}

document.addEventListener('DOMContentLoaded', loadSalesChart);

document.addEventListener('livewire:navigated', loadSalesChart);