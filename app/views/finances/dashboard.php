<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="mb-8">
    <h2 class="text-2xl font-bold text-gray-800">Financial Dashboard</h2>
    <p class="text-gray-500">Comprehensive overview of revenue, expenses, and profit.</p>
</div>

<!-- All-Time Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center">
                <i class="fas fa-hand-holding-usd text-xl"></i>
            </div>
            <span class="text-xs font-semibold text-blue-600 bg-blue-50 px-2 py-1 rounded-full">Collected</span>
        </div>
        <h3 class="text-gray-500 text-sm font-medium">Total Revenue</h3>
        <p class="text-2xl font-bold text-gray-800 tracking-tight">$<?php echo number_format($data['all_time']['total_revenue'], 2); ?></p>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-rose-50 text-rose-600 rounded-xl flex items-center justify-center">
                <i class="fas fa-wallet text-xl"></i>
            </div>
            <span class="text-xs font-semibold text-rose-600 bg-rose-50 px-2 py-1 rounded-full">Spent</span>
        </div>
        <h3 class="text-gray-500 text-sm font-medium">Total Expenses</h3>
        <p class="text-2xl font-bold text-gray-800 tracking-tight">$<?php echo number_format($data['all_time']['total_expenses'], 2); ?></p>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center">
                <i class="fas fa-chart-line text-xl"></i>
            </div>
            <span class="text-xs font-semibold text-emerald-600 bg-emerald-50 px-2 py-1 rounded-full">Net</span>
        </div>
        <h3 class="text-gray-500 text-sm font-medium">Net Profit</h3>
        <p class="text-2xl font-bold text-gray-800 tracking-tight">$<?php echo number_format($data['all_time']['net_profit'], 2); ?></p>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-amber-50 text-amber-600 rounded-xl flex items-center justify-center">
                <i class="fas fa-clock text-xl"></i>
            </div>
            <span class="text-xs font-semibold text-amber-600 bg-amber-50 px-2 py-1 rounded-full">Outstanding</span>
        </div>
        <h3 class="text-gray-500 text-sm font-medium">Total Dues</h3>
        <p class="text-2xl font-bold text-gray-800 tracking-tight">$<?php echo number_format($data['all_time']['total_outstanding'], 2); ?></p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
    <!-- Revenue vs Expenses Chart -->
    <div class="lg:col-span-2 bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
        <h4 class="text-lg font-bold text-gray-800 mb-6">Income vs Expense (Last 12 Months)</h4>
        <div class="h-80">
            <canvas id="yearlyChart"></canvas>
        </div>
    </div>

    <!-- Fee Status Breakdown -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
        <h4 class="text-lg font-bold text-gray-800 mb-6">Fee Status (Current Month)</h4>
        <div class="h-64">
            <canvas id="feeStatusChart"></canvas>
        </div>
        <div class="mt-6 space-y-3">
            <div class="flex items-center justify-between text-sm">
                <span class="text-gray-500"><i class="fas fa-circle text-emerald-500 mr-2"></i> Paid</span>
                <span class="font-bold"><?php echo $data['fee_status']['paid']; ?></span>
            </div>
            <div class="flex items-center justify-between text-sm">
                <span class="text-gray-500"><i class="fas fa-circle text-rose-500 mr-2"></i> Pending</span>
                <span class="font-bold"><?php echo $data['fee_status']['pending']; ?></span>
            </div>
            <div class="flex items-center justify-between text-sm">
                <span class="text-gray-500"><i class="fas fa-circle text-amber-500 mr-2"></i> Due</span>
                <span class="font-bold"><?php echo $data['fee_status']['due']; ?></span>
            </div>
        </div>
    </div>
</div>

<!-- Chart Script -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Yearly Chart
    const yearlyCtx = document.getElementById('yearlyChart').getContext('2d');
    const yearlyStats = <?php echo json_safe($data['yearly_stats']); ?>;
    
    new Chart(yearlyCtx, {
        type: 'bar',
        data: {
            labels: yearlyStats.map(s => s.month),
            datasets: [
                {
                    label: 'Revenue',
                    data: yearlyStats.map(s => s.revenue),
                    backgroundColor: '#3b82f6',
                    borderRadius: 6,
                },
                {
                    label: 'Expenses',
                    data: yearlyStats.map(s => s.expenses),
                    backgroundColor: '#e11d48',
                    borderRadius: 6,
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'top', align: 'end' }
            },
            scales: {
                y: { beginAtZero: true, grid: { borderDash: [5, 5] } },
                x: { grid: { display: false } }
            }
        }
    });

    // Fee Status Chart
    const statusCtx = document.getElementById('feeStatusChart').getContext('2d');
    new Chart(statusCtx, {
        type: 'doughnut',
        data: {
            labels: ['Paid', 'Pending', 'Due'],
            datasets: [{
                data: [
                    <?php echo $data['fee_status']['paid']; ?>,
                    <?php echo $data['fee_status']['pending']; ?>,
                    <?php echo $data['fee_status']['due']; ?>
                ],
                backgroundColor: ['#10b981', '#f43f5e', '#f59e0b'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '70%',
            plugins: {
                legend: { display: false }
            }
        }
    });
</script>

<?php require APPROOT . '/views/inc/footer.php'; ?>
