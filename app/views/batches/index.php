<?php require APPROOT . '/views/inc/header.php'; ?>
<form action="<?php echo URLROOT; ?>/batches/bulk_action" method="POST">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Batch Management</h2>
            <p class="text-gray-500 text-sm">Organize students into time slots</p>
        </div>
        <div class="flex gap-2">
            <button type="submit" name="action" value="finish" class="bg-slate-800 hover:bg-slate-900 text-white px-4 py-2 rounded-lg font-semibold flex items-center shadow-sm transition-all text-sm" onclick="return confirmAction(this, 'Mark selected batches as finished? This will also update student statuses.', event)">
                <i class="fas fa-check-double mr-2"></i> Bulk Finish
            </button>
            <a href="<?php echo URLROOT; ?>/batches/add" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg font-semibold flex items-center shadow-sm transition-all text-sm">
                <i class="fas fa-plus mr-2"></i> New Batch
            </a>
        </div>
    </div>

    <?php flash('batch_message'); ?>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left">
                        <input type="checkbox" id="select-all" class="rounded text-blue-500 focus:ring-blue-500">
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Batch Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Schedule</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Students</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php if (empty($data['batches'])) : ?>
                    <tr>
                        <td colspan="6" class="px-6 py-10 text-center text-gray-400">
                            <i class="fas fa-layer-group text-3xl mb-2 block"></i>
                            No batches found. <a href="<?php echo URLROOT; ?>/batches/add" class="text-blue-500 hover:underline">Create one</a>.
                        </td>
                    </tr>
                <?php else : ?>
                    <?php foreach($data['batches'] as $batch) : ?>
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4">
                                <input type="checkbox" name="batch_ids[]" value="<?php echo $batch->id; ?>" class="batch-checkbox rounded text-blue-500 focus:ring-blue-500">
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-bold text-gray-800"><?php echo $batch->name; ?></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                <i class="far fa-clock mr-1 text-blue-500"></i>
                                <?php echo date('h:i A', strtotime($batch->start_time)); ?> - <?php echo date('h:i A', strtotime($batch->end_time)); ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-700">
                                    <i class="fas fa-users text-indigo-400 text-xs"></i>
                                    <?php echo $batch->student_count; ?> student<?php echo $batch->student_count != 1 ? 's' : ''; ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full <?php echo $batch->status == 'active' ? 'bg-emerald-100 text-emerald-800' : 'bg-gray-100 text-gray-800'; ?>">
                                    <?php echo ucfirst($batch->status); ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-1">
                                <!-- View Students Button -->
                                <a href="<?php echo URLROOT; ?>/batches/view_batch/<?php echo $batch->id; ?>" 
                                   class="inline-flex items-center gap-1 text-indigo-600 hover:bg-indigo-50 px-2 py-1.5 rounded-md transition-all text-xs font-semibold" 
                                   title="View Students">
                                    <i class="fas fa-eye"></i> View
                                </a>
                                <!-- Assign Students Button -->
                                <a href="<?php echo URLROOT; ?>/batches/assign/<?php echo $batch->id; ?>" 
                                   class="inline-flex items-center gap-1 text-blue-600 hover:bg-blue-50 px-2 py-1.5 rounded-md transition-all text-xs font-semibold" 
                                   title="Assign Students">
                                    <i class="fas fa-user-plus"></i> Assign
                                </a>
                                <!-- Edit Button -->
                                <a href="<?php echo URLROOT; ?>/batches/edit/<?php echo $batch->id; ?>" 
                                   class="inline-flex items-center gap-1 text-gray-600 hover:bg-gray-100 px-2 py-1.5 rounded-md transition-all text-xs font-semibold">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</form>

<script>
    document.getElementById('select-all').addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('.batch-checkbox');
        checkboxes.forEach(cb => cb.checked = this.checked);
    });
</script>
<?php require APPROOT . '/views/inc/footer.php'; ?>
