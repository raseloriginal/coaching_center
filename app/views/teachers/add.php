<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="max-w-2xl mx-auto">
    <a href="<?php echo URLROOT; ?>/teachers" class="text-gray-500 hover:text-gray-800 flex items-center mb-6 transition-colors">
        <i class="fas fa-chevron-left mr-2"></i> Back to Teachers
    </a>

    <div class="bg-white p-8 rounded-2xl shadow-lg border border-gray-100">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Add New Teacher</h2>
        
        <form action="<?php echo URLROOT; ?>/teachers/add" method="POST" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Full Name</label>
                    <input type="text" name="name" id="name" class="block w-full px-4 py-3 border <?php echo (!empty($data['name_err'])) ? 'border-red-500' : 'border-gray-300'; ?> rounded-xl focus:ring-2 focus:ring-blue-500 outline-none transition-all" value="<?php echo $data['name']; ?>">
                    <span class="text-xs text-red-500"><?php echo $data['name_err']; ?></span>
                </div>
                <div>
                    <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">Phone Number</label>
                    <input type="text" name="phone" id="phone" class="block w-full px-4 py-3 border <?php echo (!empty($data['phone_err'])) ? 'border-red-500' : 'border-gray-300'; ?> rounded-xl focus:ring-2 focus:ring-blue-500 outline-none transition-all" value="<?php echo $data['phone']; ?>">
                    <span class="text-xs text-red-500"><?php echo $data['phone_err']; ?></span>
                </div>
            </div>

            <div>
                <label for="salary" class="block text-sm font-semibold text-gray-700 mb-2">Monthly Salary ($)</label>
                <input type="number" name="salary" id="salary" class="block w-full px-4 py-3 border <?php echo (!empty($data['salary_err'])) ? 'border-red-500' : 'border-gray-300'; ?> rounded-xl focus:ring-2 focus:ring-blue-500 outline-none transition-all" value="<?php echo $data['salary']; ?>">
                <span class="text-xs text-red-500"><?php echo $data['salary_err']; ?></span>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-3">Assign Subjects</label>
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                    <?php foreach($data['all_subjects'] as $subject) : ?>
                        <label class="flex items-center p-3 rounded-lg border border-gray-100 bg-gray-50 hover:bg-blue-50 cursor-pointer transition-colors group">
                            <input type="checkbox" name="subjects[]" value="<?php echo $subject->id; ?>" class="rounded text-blue-500 focus:ring-blue-500 mr-3">
                            <span class="text-sm text-gray-700 group-hover:text-blue-700 font-medium"><?php echo $subject->name; ?></span>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>

            <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-3 rounded-xl shadow-md transition-all">
                Register Teacher
            </button>
        </form>
    </div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>
