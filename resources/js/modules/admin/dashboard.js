import Chart from 'chart.js/auto';

document.addEventListener('DOMContentLoaded', () => {
    const data = window.dashboardData;

    // Sales Chart
    const salesCtx = document.getElementById('salesChart').getContext('2d');

    // Process data for sales chart
    const months = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
    const salesLabels = months;
    const salesData = new Array(12).fill(0);
    const ordersData = new Array(12).fill(0);

    data.ordenesPorMes.forEach(item => {
        salesData[item.month - 1] = item.total;
        ordersData[item.month - 1] = item.count;
    });

    new Chart(salesCtx, {
        type: 'line',
        data: {
            labels: salesLabels,
            datasets: [
                {
                    label: 'Ingresos (Bs)',
                    data: salesData,
                    borderColor: 'rgba(60, 141, 188, 0.8)',
                    backgroundColor: 'rgba(60, 141, 188, 0.2)',
                    fill: true,
                    yAxisID: 'y',
                },
                {
                    label: 'Cantidad de Órdenes',
                    data: ordersData,
                    borderColor: 'rgba(210, 214, 222, 1)',
                    backgroundColor: 'rgba(210, 214, 222, 1)',
                    fill: false,
                    type: 'bar',
                    yAxisID: 'y1',
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                mode: 'index',
                intersect: false,
            },
            scales: {
                y: {
                    type: 'linear',
                    display: true,
                    position: 'left',
                    title: {
                        display: true,
                        text: 'Ingresos (Bs)'
                    }
                },
                y1: {
                    type: 'linear',
                    display: true,
                    position: 'right',
                    grid: {
                        drawOnChartArea: false,
                    },
                    title: {
                        display: true,
                        text: 'Cantidad'
                    }
                },
            }
        }
    });

    // Order Status Chart
    const statusCtx = document.getElementById('orderStatusChart').getContext('2d');

    const statusLabels = data.ordenesPorEstado.map(item => item.status.charAt(0).toUpperCase() + item.status.slice(1));
    const statusCounts = data.ordenesPorEstado.map(item => item.count);

    // Define colors based on status if possible, else random or predefined palette
    const statusColors = {
        'pending': '#ffc107', // warning
        'completed': '#28a745', // success
        'cancelled': '#dc3545', // danger
        'processing': '#17a2b8', // info
    };

    const backgroundColors = data.ordenesPorEstado.map(item => statusColors[item.status] || '#6c757d');

    new Chart(statusCtx, {
        type: 'doughnut',
        data: {
            labels: statusLabels,
            datasets: [{
                data: statusCounts,
                backgroundColor: backgroundColors,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                }
            }
        }
    });
});
