<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
    <div>
        <h2 class="text-2xl font-bold text-gray-800">Teachers</h2>
        <p class="text-gray-500 text-sm">Manage faculty members and their salaries</p>
    </div>
    <a href="<?php echo URLROOT; ?>/teachers/add" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg font-semibold flex items-center shadow-sm transition-all whitespace-nowrap">
        <i class="fas fa-plus mr-2"></i> Register Teacher
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Teacher</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contact</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Base Salary</th>
                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            <?php foreach($data['teachers'] as $teacher) : ?>
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center font-bold">
                                <?php echo strtoupper(substr($teacher->name, 0, 1)); ?>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-bold text-gray-900"><?php echo $teacher->name; ?></div>
                                <div class="text-xs text-gray-500">Member since <?php echo date('M Y', strtotime($teacher->created_at)); ?></div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                        <i class="fas fa-phone-alt text-gray-300 mr-1"></i> <?php echo $teacher->phone; ?>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-800">
                        ৳<?php echo number_format($teacher->salary, 2); ?>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                        <a href="<?php echo URLROOT; ?>/teachers/edit/<?php echo $teacher->id; ?>" class="text-blue-600 hover:bg-blue-50 p-2 rounded-md transition-all">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="<?php echo URLROOT; ?>/teachers/delete/<?php echo $teacher->id; ?>" method="POST" class="inline" onsubmit="return confirmAction(this, 'Remove this teacher? Current payments will remain.', event);">
                            <button type="submit" class="text-red-600 hover:bg-red-50 p-2 rounded-md transition-all">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if(empty($data['teachers'])) : ?>
                <tr>
                    <td colspan="4" class="px-6 py-10 text-center text-gray-400">
                        <i class="fas fa-chalkboard-teacher text-4xl mb-3 block"></i>
                        No teachers found. Click Register to add one.
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>
