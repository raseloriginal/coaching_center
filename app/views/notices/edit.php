<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="max-w-2xl mx-auto">
    <div class="mb-8">
        <a href="<?php echo URLROOT; ?>/notices" class="text-blue-600 hover:text-blue-700 font-bold flex items-center gap-2 mb-4">
            <i class="fas fa-arrow-left"></i> Back to Notices
        </a>
        <h2 class="text-3xl font-bold text-gray-800"><?php echo isset($data['id']) ? 'Edit' : 'Add'; ?> Notice</h2>
        <p class="text-gray-500">Enter the notice content to display on the landing page ticker.</p>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
        <form action="<?php echo URLROOT; ?>/notices/<?php echo isset($data['id']) ? 'edit/' . $data['id'] : 'add'; ?>" method="post">
            <div class="mb-6">
                <label for="content" class="block text-sm font-bold text-gray-700 mb-2">Notice Content <span class="text-red-500">*</span></label>
                <textarea name="content" id="content" rows="4" class="w-full px-5 py-3 rounded-xl border <?php echo (!empty($data['content_err'])) ? 'border-red-500' : 'border-gray-200'; ?> focus:outline-none focus:ring-2 focus:ring-blue-100 transition" placeholder="Enter notice text..."><?php echo $data['content']; ?></textarea>
                <span class="text-xs text-red-500 mt-1"><?php echo $data['content_err']; ?></span>
            </div>

            <div class="mb-8">
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="is_active" class="sr-only peer" <?php echo ($data['is_active'] == 1) ? 'checked' : ''; ?>>
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                    <span class="ml-3 text-sm font-bold text-gray-700">Display this notice</span>
                </label>
            </div>

            <div class="flex gap-4">
                <button type="submit" class="flex-1 bg-blue-600 text-white py-4 rounded-xl font-black text-lg hover:bg-blue-700 transition shadow-lg">
                    <?php echo isset($data['id']) ? 'Update' : 'Publish'; ?> Notice
                </button>
            </div>
        </form>
    </div>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>
