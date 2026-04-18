<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="mb-8 flex justify-between items-center">
    <div>
        <h2 class="text-3xl font-bold text-gray-800">Notice Board</h2>
        <p class="text-gray-500">Manage the scrolling notices on the landing page.</p>
    </div>
    <a href="<?php echo URLROOT; ?>/notices/add" class="bg-blue-600 text-white px-6 py-2 rounded-xl font-bold hover:bg-blue-700 transition flex items-center gap-2">
        <i class="fas fa-plus"></i> Add Notice
    </a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <table class="w-full text-left">
        <thead class="bg-gray-50 border-b border-gray-100">
            <tr>
                <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest text-center w-16">ID</th>
                <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest">Notice Content</th>
                <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest text-center w-32">Status</th>
                <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest text-center w-32">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            <?php foreach($data['notices'] as $notice) : ?>
                <tr class="hover:bg-blue-50/30 transition-colors">
                    <td class="px-6 py-4 text-center font-mono text-gray-400">#<?php echo $notice->id; ?></td>
                    <td class="px-6 py-4">
                        <div class="text-sm font-medium text-gray-800"><?php echo $notice->content; ?></div>
                        <div class="text-xs text-gray-400 mt-1">Created at: <?php echo date('M d, Y h:i A', strtotime($notice->created_at)); ?></div>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <?php if($notice->is_active) : ?>
                            <span class="px-3 py-1 bg-emerald-100 text-emerald-700 rounded-full text-xs font-bold">Active</span>
                        <?php else : ?>
                            <span class="px-3 py-1 bg-gray-100 text-gray-500 rounded-full text-xs font-bold">Inactive</span>
                        <?php endif; ?>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex justify-center gap-2">
                            <a href="<?php echo URLROOT; ?>/notices/edit/<?php echo $notice->id; ?>" class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center hover:bg-blue-600 hover:text-white transition-all shadow-sm" title="Edit">
                                <i class="fas fa-edit text-xs"></i>
                            </a>
                            <form action="<?php echo URLROOT; ?>/notices/delete/<?php echo $notice->id; ?>" method="post" onsubmit="return confirmAction(this, 'Permanently delete this notice?', event)">
                                <button type="submit" class="w-8 h-8 rounded-lg bg-rose-50 text-rose-600 flex items-center justify-center hover:bg-rose-600 hover:text-white transition-all shadow-sm">
                                    <i class="fas fa-trash-alt text-xs"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if(empty($data['notices'])) : ?>
                <tr>
                    <td colspan="4" class="px-6 py-12 text-center text-gray-400">
                        <i class="fas fa-info-circle text-4xl mb-4 opacity-20"></i>
                        <p>No notices found. Add your first notice to show on the landing page.</p>
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>
