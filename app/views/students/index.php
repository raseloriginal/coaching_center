<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
    <div>
        <h2 class="text-2xl font-bold text-gray-800">Student Directory</h2>
        <p class="text-gray-500 text-sm">Manage student registrations and status</p>
    </div>
    <a href="<?php echo URLROOT; ?>/students/add" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg font-semibold flex items-center shadow-sm transition-all whitespace-nowrap">
        <i class="fas fa-plus mr-2"></i> Register Student
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phone</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">QR Code</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            <?php foreach($data['students'] as $student) : ?>
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center font-bold">
                                <?php echo strtoupper(substr($student->name, 0, 1)); ?>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-bold text-gray-900"><?php echo $student->name; ?></div>
                                <div class="text-xs text-gray-500">ID: <?php echo $student->id; ?></div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                        <i class="fas fa-phone-alt text-gray-400 mr-1 text-xs"></i> <?php echo $student->phone; ?>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-blue-600 font-semibold bg-blue-50 px-2 py-1 rounded inline-block mt-3">
                        <?php echo $student->qr_code; ?>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <?php 
                        $badgeClass = 'bg-gray-100 text-gray-800';
                        if($student->status == 'active') $badgeClass = 'bg-emerald-100 text-emerald-800';
                        if($student->status == 'completed') $badgeClass = 'bg-blue-100 text-blue-800';
                        if($student->status == 'cancelled') $badgeClass = 'bg-rose-100 text-rose-800';
                        ?>
                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full <?php echo $badgeClass; ?>">
                            <?php echo ucfirst($student->status); ?>
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                        <a href="<?php echo URLROOT; ?>/students/view_qr/<?php echo $student->id; ?>" class="text-purple-600 hover:bg-purple-50 p-2 rounded-md transition-all" title="View QR Code">
                            <i class="fas fa-qrcode"></i>
                        </a>
                        <a href="<?php echo URLROOT; ?>/students/edit/<?php echo $student->id; ?>" class="text-blue-600 hover:bg-blue-50 p-2 rounded-md transition-all">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="<?php echo URLROOT; ?>/students/delete/<?php echo $student->id; ?>" method="POST" class="inline" onsubmit="return confirmAction(this, 'Delete this student record?', event);">
                            <button type="submit" class="text-red-600 hover:bg-red-50 p-2 rounded-md transition-all">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if(empty($data['students'])) : ?>
                <tr>
                    <td colspan="5" class="px-6 py-10 text-center text-gray-400">
                        <i class="fas fa-user-slash text-4xl mb-3 block"></i>
                        No students registered yet.
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?php if (isset($data['pagination'])) echo $data['pagination']; ?>
<?php require APPROOT . '/views/inc/footer.php'; ?>
