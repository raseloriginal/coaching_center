<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="max-w-2xl mx-auto">
    <div class="mb-8">
        <a href="<?php echo URLROOT; ?>/users/manage" class="text-sm font-semibold text-blue-600 hover:text-blue-700 flex items-center gap-2 mb-4">
            <i class="fas fa-arrow-left"></i> Back to Users
        </a>
        <h2 class="text-3xl font-bold text-gray-800">Edit User</h2>
        <p class="text-gray-500">Update account details and access permissions for <strong><?php echo $data['name']; ?></strong>.</p>
    </div>

    <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
        <form action="<?php echo URLROOT; ?>/users/edit/<?php echo $data['id']; ?>" method="POST">
            <div class="space-y-6">
                <!-- Name -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Full Name</label>
                    <input type="text" name="name" value="<?php echo $data['name']; ?>" 
                           class="w-full px-4 py-3 rounded-xl border <?php echo (!empty($data['name_err'])) ? 'border-rose-500 bg-rose-50' : 'border-gray-200 bg-gray-50'; ?> focus:ring-2 focus:ring-blue-500 focus:bg-white outline-none transition-all" 
                           placeholder="John Doe">
                    <?php if(!empty($data['name_err'])): ?>
                        <p class="mt-1 text-xs font-bold text-rose-500"><?php echo $data['name_err']; ?></p>
                    <?php endif; ?>
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Email Address</label>
                    <input type="email" name="email" value="<?php echo $data['email']; ?>" 
                           class="w-full px-4 py-3 rounded-xl border <?php echo (!empty($data['email_err'])) ? 'border-rose-500 bg-rose-50' : 'border-gray-200 bg-gray-50'; ?> focus:ring-2 focus:ring-blue-500 focus:bg-white outline-none transition-all" 
                           placeholder="john@example.com">
                    <?php if(!empty($data['email_err'])): ?>
                        <p class="mt-1 text-xs font-bold text-rose-500"><?php echo $data['email_err']; ?></p>
                    <?php endif; ?>
                </div>

                <!-- Password -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">New Password <span class="text-xs font-normal text-gray-400 ml-1">(Leave blank to keep current)</span></label>
                    <input type="password" name="password" 
                           class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 focus:ring-2 focus:ring-blue-500 focus:bg-white outline-none transition-all" 
                           placeholder="••••••••">
                </div>

                <!-- Role -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Access Role</label>
                    <div class="grid grid-cols-2 gap-4">
                        <label class="relative flex items-center p-4 border rounded-xl cursor-pointer hover:bg-gray-50 transition-all <?php echo ($data['role'] == 'super_admin') ? 'border-blue-500 bg-blue-50' : 'border-gray-200'; ?>">
                            <input type="radio" name="role" value="super_admin" <?php echo ($data['role'] == 'super_admin') ? 'checked' : ''; ?> class="w-4 h-4 text-blue-600 border-gray-300">
                            <div class="ml-3">
                                <span class="block text-sm font-bold text-gray-900">Super Admin</span>
                                <span class="block text-[10px] text-gray-500">Full Access</span>
                            </div>
                        </label>
                        <label class="relative flex items-center p-4 border rounded-xl cursor-pointer hover:bg-gray-50 transition-all <?php echo ($data['role'] == 'accountant') ? 'border-blue-500 bg-blue-50' : 'border-gray-200'; ?>">
                            <input type="radio" name="role" value="accountant" <?php echo ($data['role'] == 'accountant') ? 'checked' : ''; ?> class="w-4 h-4 text-blue-600 border-gray-300">
                            <div class="ml-3">
                                <span class="block text-sm font-bold text-gray-900">Accountant</span>
                                <span class="block text-[10px] text-gray-500">Finance only</span>
                            </div>
                        </label>
                        <label class="relative flex items-center p-4 border rounded-xl cursor-pointer hover:bg-gray-50 transition-all <?php echo ($data['role'] == 'teacher') ? 'border-blue-500 bg-blue-50' : 'border-gray-200'; ?>">
                            <input type="radio" name="role" value="teacher" <?php echo ($data['role'] == 'teacher') ? 'checked' : ''; ?> class="w-4 h-4 text-blue-600 border-gray-300">
                            <div class="ml-3">
                                <span class="block text-sm font-bold text-gray-900">Teacher</span>
                                <span class="block text-[10px] text-gray-500">Academics only</span>
                            </div>
                        </label>
                        <label class="relative flex items-center p-4 border rounded-xl cursor-pointer hover:bg-gray-50 transition-all <?php echo ($data['role'] == 'frontdesk') ? 'border-blue-500 bg-blue-50' : 'border-gray-200'; ?>">
                            <input type="radio" name="role" value="frontdesk" <?php echo ($data['role'] == 'frontdesk') ? 'checked' : ''; ?> class="w-4 h-4 text-blue-600 border-gray-300">
                            <div class="ml-3">
                                <span class="block text-sm font-bold text-gray-900">Front Desk</span>
                                <span class="block text-[10px] text-gray-500">Attendance/Admissions</span>
                            </div>
                        </label>
                    </div>
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full bg-blue-600 text-white py-4 rounded-xl font-bold text-lg shadow-lg shadow-blue-500/30 hover:shadow-blue-500/50 hover:-translate-y-1 transition-all">
                        Update Account
                    </button>
                    <p class="mt-4 text-center">
                        <a href="<?php echo URLROOT; ?>/users/manage" class="text-sm font-bold text-gray-400 hover:text-gray-600 transition-colors">Cancel and go back</a>
                    </p>
                </div>
            </div>
        </form>
    </div>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>
