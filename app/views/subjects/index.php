<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="flex justify-between items-center mb-6">
    <div>
        <h2 class="text-2xl font-bold text-gray-800">Subjects</h2>
        <p class="text-gray-500 text-sm">Manage courses and subjects offered</p>
    </div>
    <a href="<?php echo URLROOT; ?>/subjects/add" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg font-semibold flex items-center shadow-sm transition-all">
        <i class="fas fa-plus mr-2"></i> Add Subject
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subject Name</th>
                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            <?php foreach($data['subjects'] as $subject) : ?>
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo $subject->id; ?></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-800"><?php echo $subject->name; ?></td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                        <a href="<?php echo URLROOT; ?>/subjects/edit/<?php echo $subject->id; ?>" class="text-blue-600 hover:text-blue-900 bg-blue-50 p-2 rounded-md transition-all">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="<?php echo URLROOT; ?>/subjects/delete/<?php echo $subject->id; ?>" method="POST" class="inline" onsubmit="return confirmAction(this, 'Are you sure you want to delete this subject?', event);">
                            <button type="submit" class="text-red-600 hover:text-red-900 bg-red-50 p-2 rounded-md transition-all">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if(empty($data['subjects'])) : ?>
                <tr>
                    <td colspan="3" class="px-6 py-10 text-center text-gray-400">
                        <i class="fas fa-book-open text-4xl mb-3 block"></i>
                        No subjects found. Start by adding one.
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>
