<?php require APPROOT . '/views/inc/header.php'; ?>
<!-- Include Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-end gap-4">
    <div>
        <h2 class="text-3xl font-bold text-gray-800">Financial Analytics Dashboard</h2>
        <p class="text-gray-500">Real-time overview of your coaching center for <?php echo date('F Y'); ?>.</p>
    </div>
</div>

<!-- Key Performance Indicators (KPIs) -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    
    <!-- Total Active Students -->
    <div class="bg-white p-6 rounded-2xl shadow-sm hover:shadow-md hover:-translate-y-1 transition-all border border-gray-100 flex items-center gap-4 animate-fade-up" style="animation-delay: 0.1s;">
        <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center text-blue-600 text-xl shadow-inner">
            <i class="fas fa-users"></i>
        </div>
        <div>
            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Active Students</p>
            <h3 class="text-2xl font-black text-gray-800"><?php echo $data['active_students']; ?></h3>
        </div>
    </div>

    <!-- Monthly Revenue -->
    <div class="bg-white p-6 rounded-2xl shadow-sm hover:shadow-md hover:-translate-y-1 transition-all border border-gray-100 flex items-center gap-4 border-l-4 border-l-emerald-500 animate-fade-up" style="animation-delay: 0.2s;">
        <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center text-emerald-600 text-xl shadow-inner">
            <i class="fas fa-wallet"></i>
        </div>
        <div>
            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Monthly Revenue</p>
            <h3 class="text-2xl font-black text-gray-800">$<?php echo number_format($data['financial_stats']['revenue_collected'], 2); ?></h3>
        </div>
    </div>

    <!-- Monthly Expenses -->
    <div class="bg-white p-6 rounded-2xl shadow-sm hover:shadow-md hover:-translate-y-1 transition-all border border-gray-100 flex items-center gap-4 border-l-4 border-l-rose-500 animate-fade-up" style="animation-delay: 0.3s;">
        <div class="w-12 h-12 bg-rose-100 rounded-xl flex items-center justify-center text-rose-600 text-xl shadow-inner">
            <i class="fas fa-file-invoice-dollar"></i>
        </div>
        <div>
            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Monthly Expenses</p>
            <h3 class="text-2xl font-black text-gray-800">$<?php echo number_format($data['financial_stats']['expenses_paid'], 2); ?></h3>
        </div>
    </div>

    <!-- Outstanding Dues -->
    <div class="bg-white p-6 rounded-2xl shadow-sm hover:shadow-md hover:-translate-y-1 transition-all border border-gray-100 flex items-center gap-4 border-l-4 border-l-amber-500 animate-fade-up" style="animation-delay: 0.4s;">
        <div class="w-12 h-12 bg-amber-100 rounded-xl flex items-center justify-center text-amber-600 text-xl shadow-inner">
            <i class="fas fa-clock"></i>
        </div>
        <div>
            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Total Outstanding</p>
            <h3 class="text-2xl font-black text-amber-600">$<?php echo number_format($data['all_time']['total_outstanding'], 2); ?></h3>
        </div>
    </div>
</div>

<!-- Charts Section -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
    
    <!-- Cash Flow Bar Chart -->
    <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 p-6 animate-fade-up" style="animation-delay: 0.5s;">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-lg font-bold text-gray-800">Cash Flow (<?php echo date('M Y'); ?>)</h3>
            <span class="px-3 py-1 bg-gray-100 rounded-full text-xs font-bold text-gray-600">Monthly Snapshot</span>
        </div>
        <div class="relative h-72 w-full">
            <canvas id="cashFlowChart"></canvas>
        </div>
    </div>

    <!-- Fee Collection Status Donut Chart -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 animate-fade-up" style="animation-delay: 0.6s;">
        <h3 class="text-lg font-bold text-gray-800 mb-6 text-center">Fee Collection Status</h3>
        <div class="relative h-64 w-full flex justify-center">
            <canvas id="feeStatusChart"></canvas>
        </div>
        <div class="mt-6 grid grid-cols-3 gap-2 text-center text-sm">
            <div>
                <p class="text-xs text-gray-500 font-bold uppercase">Paid</p>
                <p class="text-lg font-black text-emerald-500"><?php echo $data['financial_stats']['fee_status_counts']['paid']; ?></p>
            </div>
            <div>
                <p class="text-xs text-gray-500 font-bold uppercase">Due</p>
                <p class="text-lg font-black text-blue-500"><?php echo $data['financial_stats']['fee_status_counts']['due']; ?></p>
            </div>
            <div>
                <p class="text-xs text-gray-500 font-bold uppercase">Pending</p>
                <p class="text-lg font-black text-rose-500"><?php echo $data['financial_stats']['fee_status_counts']['pending']; ?></p>
            </div>
        </div>
    </div>

</div>

<!-- Quick Actions -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-8 animate-fade-up" style="animation-delay: 0.7s;">
    <h3 class="text-lg font-bold text-gray-800 mb-4">Quick Workflows</h3>
    <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
        <a href="<?php echo URLROOT; ?>/students/add" class="btn-smooth flex flex-col items-center justify-center p-4 rounded-xl border border-gray-100 bg-gray-50 hover:bg-blue-50 hover:border-blue-200 transition-all group">
            <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-sm mb-2 group-hover:scale-110 transition-transform">
                <i class="fas fa-user-plus text-blue-500"></i>
            </div>
            <span class="text-xs font-bold text-gray-600 group-hover:text-blue-700">Add Student</span>
        </a>
        <a href="<?php echo URLROOT; ?>/batches/add" class="btn-smooth flex flex-col items-center justify-center p-4 rounded-xl border border-gray-100 bg-gray-50 hover:bg-sky-50 hover:border-sky-200 transition-all group">
            <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-sm mb-2 group-hover:scale-110 transition-transform">
                <i class="fas fa-layer-group text-sky-500"></i>
            </div>
            <span class="text-xs font-bold text-gray-600 group-hover:text-sky-700">New Batch</span>
        </a>
        <a href="<?php echo URLROOT; ?>/finance/expenses" class="btn-smooth flex flex-col items-center justify-center p-4 rounded-xl border border-gray-100 bg-gray-50 hover:bg-purple-50 hover:border-purple-200 transition-all group">
            <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-sm mb-2 group-hover:scale-110 transition-transform">
                <i class="fas fa-receipt text-purple-500"></i>
            </div>
            <span class="text-xs font-bold text-gray-600 group-hover:text-purple-700">Log Expense</span>
        </a>
        <a href="<?php echo URLROOT; ?>/finance/fees" class="btn-smooth flex flex-col items-center justify-center p-4 rounded-xl border border-gray-100 bg-gray-50 hover:bg-emerald-50 hover:border-emerald-200 transition-all group">
            <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-sm mb-2 group-hover:scale-110 transition-transform">
                <i class="fas fa-hand-holding-usd text-emerald-500"></i>
            </div>
            <span class="text-xs font-bold text-gray-600 group-hover:text-emerald-700">Collect Fees</span>
        </a>
        <a href="<?php echo URLROOT; ?>/attendance/scan" target="_blank" class="btn-smooth flex flex-col items-center justify-center p-4 rounded-xl border border-gray-100 bg-gray-50 hover:bg-zinc-100 hover:border-zinc-300 transition-all group">
            <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-sm mb-2 group-hover:scale-110 transition-transform text-xl">
                <i class="fas fa-qrcode text-zinc-700"></i>
            </div>
            <span class="text-xs font-bold text-gray-600 group-hover:text-zinc-800">QR Scanner</span>
        </a>
    </div>
</div>

<script>
    // Set custom font for Chart.js
    Chart.defaults.font.family = "'Inter', sans-serif";
    Chart.defaults.color = '#64748b'; // slate-500

    // 1. Cash Flow Bar Chart
    <?php 
        $profit = ($data['financial_stats']['revenue_collected'] ?? 0) - ($data['financial_stats']['expenses_paid'] ?? 0);
        $isProfit = $profit >= 0;
    ?>
    const ctxFlow = document.getElementById('cashFlowChart').getContext('2d');
    new Chart(ctxFlow, {
        type: 'bar',
        data: {
            labels: ['Revenue', 'Expenses', 'Net Profit'],
            datasets: [{
                label: 'Amount (BDT)',
                data: [
                    <?php echo $data['financial_stats']['revenue_collected']; ?>,
                    <?php echo $data['financial_stats']['expenses_paid']; ?>,
                    <?php echo $profit; ?>
                ],
                backgroundColor: [
                    'rgba(16, 185, 129, 0.8)', // emerald-500
                    'rgba(244, 63, 94, 0.8)',  // rose-500
                    '<?php echo $isProfit ? "rgba(59, 130, 246, 0.8)" : "rgba(244, 63, 94, 0.8)"; ?>' // blue-500 or rose
                ],
                borderRadius: 8,
                barPercentage: 0.6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: 'rgba(15, 23, 42, 0.9)',
                    padding: 12,
                    titleFont: { size: 14, weight: 'bold' },
                    bodyFont: { size: 14 },
                    callbacks: {
                        label: function(context) {
                            return '৳' + context.parsed.y.toLocaleString();
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: '#f1f5f9', drawBorder: false }
                },
                x: {
                    grid: { display: false, drawBorder: false }
                }
            }
        }
    });

    // 2. Fee Collection Status Doughnut Chart
    const ctxStatus = document.getElementById('feeStatusChart').getContext('2d');
    new Chart(ctxStatus, {
        type: 'doughnut',
        data: {
            labels: ['Paid', 'Due/Partial', 'Pending'],
            datasets: [{
                data: [
                    <?php echo $data['financial_stats']['fee_status_counts']['paid']; ?>,
                    <?php echo $data['financial_stats']['fee_status_counts']['due']; ?>,
                    <?php echo $data['financial_stats']['fee_status_counts']['pending']; ?>
                ],
                backgroundColor: [
                    '#10b981', // emerald
                    '#3b82f6', // blue
                    '#f43f5e'  // rose
                ],
                borderWidth: 0,
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '75%',
            plugins: {
                legend: { display: false }
            }
        }
    });
</script>

<?php require APPROOT . '/views/inc/footer.php'; ?>
