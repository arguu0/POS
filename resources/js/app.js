import Chart from 'chart.js/auto';

function loadSalesChart() {
    const canvas = document.getElementById('salesChart');

    let list = [];
    const values = document.querySelectorAll('.values');
    values.forEach(value => {
        list.push(parseInt(value.dataset.val));
    })

    if (canvas) {
        new Chart(canvas, {
            type: 'line',
            pointRadius: 0,
            pointHoverRadius: 5,
            data: {
                labels: ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'],
                datasets: [{
                    label: 'Sales',
                    data: list,
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
                        stepSize: 10000
                    }
                }
                }
            }
        });
    }
}

document.addEventListener('DOMContentLoaded', loadSalesChart);

document.addEventListener('livewire:navigated', loadSalesChart);