let categoryChartRef = null;
let publicPrivateChartRef = null;
let allPrompts = [];

async function initAnalyticsPage() {
    const response = await API.analytics.get();
    if (response.success) {
        allPrompts = response.data; // Keep compatibility if needed, but we should use response.data.counts etc.
        renderAnalytics(response.data);
    } else {
        showToast("Failed to load analytics data.", "error");
    }
}

function renderAnalytics(data) {
    const { counts, categories, user } = data;

    document.getElementById("statTotal").innerText = counts.total;
    document.getElementById("statPublic").innerText = counts.public;
    document.getElementById("statPrivate").innerText = counts.private;
    document.getElementById("statTopCategory").innerText = categories.length > 0 ? categories[0].category_name : "None";

    if (typeof Chart === 'undefined') return;

    const isLight = document.documentElement.getAttribute("data-theme") === "light";
    const textColor = isLight ? '#0f172a' : '#f8fafc';
    const gridColor = isLight ? 'rgba(0,0,0,0.1)' : 'rgba(255,255,255,0.05)';

    Chart.defaults.color = textColor;
    Chart.defaults.font.family = "'Inter', sans-serif";

    if (categoryChartRef) categoryChartRef.destroy();
    if (publicPrivateChartRef) publicPrivateChartRef.destroy();

    // 1. Pie Chart for Visibility
    publicPrivateChartRef = new Chart(document.getElementById('publicPrivateChart'), {
        type: 'doughnut',
        data: {
            labels: ['Public', 'Private'],
            datasets: [{
                data: [counts.public, counts.private],
                backgroundColor: ['#10b981', '#3b82f6'], 
                borderWidth: 2,
                borderColor: isLight ? '#ffffff' : '#1e293b',
                hoverOffset: 15
            }]
        },
        options: { 
            responsive: true,
            maintainAspectRatio: true,
            cutout: '70%',
            plugins: {
                legend: { position: 'bottom', labels: { padding: 20, usePointStyle: true } }
            }
        }
    });

    const catLabels = categories.map(c => c.category_name);
    const catData = categories.map(c => c.count);

    // 2. Bar Chart for Categories
    categoryChartRef = new Chart(document.getElementById('categoryChart'), {
        type: 'bar',
        data: {
            labels: catLabels,
            datasets: [{ 
                label: 'Prompts', 
                data: catData, 
                backgroundColor: 'rgba(59, 130, 246, 0.8)',
                hoverBackgroundColor: '#3b82f6',
                borderRadius: 10,
                barThickness: 30
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: { 
                    beginAtZero: true, 
                    grid: { color: gridColor, drawBorder: false }, 
                    ticks: { stepSize: 1, padding: 10 } 
                },
                x: { 
                    grid: { display: false },
                    ticks: { padding: 10 }
                }
            },
            plugins: { 
                legend: { display: false },
                tooltip: {
                    backgroundColor: isLight ? '#ffffff' : '#0f172a',
                    titleColor: isLight ? '#0f172a' : '#ffffff',
                    bodyColor: isLight ? '#64748b' : '#94a3b8',
                    borderColor: 'rgba(59, 130, 246, 0.3)',
                    borderWidth: 1,
                    padding: 12,
                    displayColors: false
                }
            }
        }
    });
}

window.addEventListener('themeChanged', () => {
    initAnalyticsPage(); // Re-fetch or re-render
});

