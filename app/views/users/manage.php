<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="mb-8 flex justify-between items-center">
    <div>
        <h2 class="text-2xl font-bold text-gray-800">User Management</h2>
        <p class="text-gray-500">Manage administrator accounts and their access roles.</p>
    </div>
    <a href="<?php echo URLROOT; ?>/users/add" class="px-6 py-2 bg-blue-600 text-white rounded-lg font-bold shadow-lg shadow-blue-500/30 hover:shadow-blue-500/50 transition-all flex items-center gap-2">
        <i class="fas fa-plus text-sm"></i> Add New User
    </a>
</div>

<?php flash('user_message'); ?>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="text-xs text-gray-500 uppercase bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="px-6 py-4 font-bold">Name & Email</th>
                    <th class="px-6 py-4 font-bold">Role</th>
                    <th class="px-6 py-4 font-bold">Created</th>
                    <th class="px-6 py-4 font-bold text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                <?php foreach($data['users'] as $user): ?>
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold">
                                <?php echo strtoupper(substr($user->name, 0, 1)); ?>
                            </div>
                            <div>
                                <div class="font-bold text-gray-900"><?php echo $user->name; ?></div>
                                <div class="text-xs text-gray-400"><?php echo $user->email; ?></div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <?php 
                        $role = $user->role ?? 'super_admin';
                        $roleClass = 'bg-gray-100 text-gray-800';
                        if($role == 'super_admin') $roleClass = 'bg-indigo-100 text-indigo-700 font-bold';
                        if($role == 'accountant') $roleClass = 'bg-emerald-100 text-emerald-700';
                        if($role == 'teacher') $roleClass = 'bg-blue-100 text-blue-700';
                        ?>
                        <span class="px-3 py-1 rounded-full text-[10px] uppercase font-bold <?php echo $roleClass; ?>">
                            <?php echo str_replace('_', ' ', (string)($role)); ?>
                        </span>
                    </td>
                    <td class="px-6 py-4 text-gray-500">
                        <?php echo format_date($user->created_at); ?>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex justify-end gap-2">
                            <a href="<?php echo URLROOT; ?>/users/edit/<?php echo $user->id; ?>" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-all" title="Edit User">
                                <i class="fas fa-edit"></i>
                            </a>
                            <?php if($user->id != $_SESSION['user_id']): ?>
                            <form action="<?php echo URLROOT; ?>/users/delete/<?php echo $user->id; ?>" method="POST" onsubmit="return confirmAction(this, 'Delete this user permanently?', event)">
                                <button type="submit" class="p-2 text-rose-600 hover:bg-rose-50 rounded-lg transition-all" title="Delete User">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>
