<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="mb-8">
    <h2 class="text-2xl font-bold text-gray-800">Academic Analytics</h2>
    <p class="text-gray-500">Track batch performance trends and student leaderboards.</p>
</div>

<!-- Selection Filter -->
<div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 mb-8">
    <form action="<?php echo URLROOT; ?>/exams/analytics" method="GET" class="flex flex-wrap items-end gap-4">
        <div class="flex-1 min-w-[200px]">
            <label class="block text-sm font-medium text-gray-700 mb-1">Select Batch</label>
            <select name="url" onchange="window.location.href='<?php echo URLROOT; ?>/exams/analytics/' + this.value" class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5">
                <option value="">Choose a batch...</option>
                <?php foreach($data['batches'] as $batch): ?>
                    <option value="<?php echo $batch->id; ?>" <?php echo ($data['selected_batch_id'] == $batch->id) ? 'selected' : ''; ?>>
                        <?php echo $batch->name; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <?php if($data['selected_batch_id']): ?>
        <div class="flex-1 min-w-[200px]">
            <label class="block text-sm font-medium text-gray-700 mb-1">Select Exam</label>
            <select name="exam" onchange="this.form.submit()" class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5">
                <?php foreach($data['exams'] as $exam): ?>
                    <option value="<?php echo $exam->id; ?>" <?php echo ($data['selected_exam_id'] == $exam->id) ? 'selected' : ''; ?>>
                        <?php echo $exam->title; ?> (<?php echo format_date($exam->exam_date); ?>)
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <?php endif; ?>
    </form>
</div>

<?php if($data['selected_batch_id']): ?>
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
    <!-- Performance Trend -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
        <h4 class="text-lg font-bold text-gray-800 mb-6">Batch Performance Trend</h4>
        <div class="h-80">
            <canvas id="trendChart"></canvas>
        </div>
    </div>

    <!-- Leaderboard -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
        <h4 class="text-lg font-bold text-gray-800 mb-6">Exam Leaderboard</h4>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-xs text-gray-500 uppercase bg-gray-50">
                    <tr>
                        <th class="px-4 py-3">Rank</th>
                        <th class="px-4 py-3">Student</th>
                        <th class="px-4 py-3">Marks</th>
                        <th class="px-4 py-3">Percent</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php if(!empty($data['leaderboard'])): ?>
                        <?php foreach($data['leaderboard'] as $index => $row): ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-4">
                                <?php if($index == 0): ?>
                                    <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-amber-100 text-amber-600 font-bold"><i class="fas fa-crown text-xs"></i></span>
                                <?php elseif($index == 1): ?>
                                    <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-gray-100 text-gray-600 font-bold">2</span>
                                <?php elseif($index == 2): ?>
                                    <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-orange-100 text-orange-600 font-bold">3</span>
                                <?php else: ?>
                                    <span class="text-gray-500 ml-2"><?php echo $index + 1; ?></span>
                                <?php endif; ?>
                            </td>
                            <td class="px-4 py-4">
                                <div class="font-bold text-gray-900"><?php echo $row->name; ?></div>
                                <div class="text-xs text-gray-500">Roll: <?php echo $row->roll_number; ?></div>
                            </td>
                            <td class="px-4 py-4 font-semibold"><?php echo $row->total_marks; ?> / <?php echo $row->max_marks; ?></td>
                            <td class="px-4 py-4">
                                <span class="bg-blue-100 text-blue-800 text-xs font-bold px-2.5 py-0.5 rounded-full">
                                    <?php echo $row->percentage; ?>%
                                </span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="4" class="px-4 py-8 text-center text-gray-500">No marks recorded yet.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Trend Chart
    const trendCtx = document.getElementById('trendChart').getContext('2d');
    const trendData = <?php echo json_safe($data['trend']); ?>;
    
    new Chart(trendCtx, {
        type: 'line',
        data: {
            labels: trendData.map(d => d.title),
            datasets: [{
                label: 'Batch Average %',
                data: trendData.map(d => d.avg_percent),
                borderColor: '#3b82f6',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                tension: 0.4,
                fill: true,
                pointRadius: 6,
                pointBackgroundColor: '#fff',
                pointBorderColor: '#3b82f6',
                pointBorderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: { 
                    beginAtZero: true, 
                    max: 100,
                    grid: { borderDash: [5, 5] },
                    ticks: { callback: value => value + '%' }
                },
                x: { grid: { display: false } }
            }
        }
    });
</script>
<?php else: ?>
<div class="text-center py-20 bg-white rounded-2xl shadow-sm border border-gray-100">
    <div class="w-16 h-16 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center mx-auto mb-4">
        <i class="fas fa-chart-area text-2xl"></i>
    </div>
    <h3 class="text-xl font-bold text-gray-800">No Batch Selected</h3>
    <p class="text-gray-500">Please select a batch from the dropdown above to view performance analytics.</p>
</div>
<?php endif; ?>

<?php require APPROOT . '/views/inc/footer.php'; ?>
