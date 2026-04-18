<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="max-w-lg mx-auto">
    <a href="<?php echo URLROOT; ?>/batches" class="text-gray-500 hover:text-gray-800 flex items-center mb-6 transition-colors">
        <i class="fas fa-chevron-left mr-2"></i> Back to Batches
    </a>

    <div class="bg-white p-8 rounded-2xl shadow-lg border border-gray-100">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Edit Batch Details</h2>
        
        <form action="<?php echo URLROOT; ?>/batches/edit/<?php echo $data['id']; ?>" method="POST" class="space-y-6">
            <div>
                <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Batch Name</label>
                <input type="text" name="name" id="name" class="block w-full px-4 py-3 border <?php echo (!empty($data['name_err'])) ? 'border-red-500' : 'border-gray-300'; ?> rounded-xl focus:ring-2 focus:ring-blue-500 outline-none transition-all" value="<?php echo $data['name']; ?>">
                <span class="text-xs text-red-500 mt-1"><?php echo $data['name_err']; ?></span>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="start_time" class="block text-sm font-semibold text-gray-700 mb-2">Start Time</label>
                    <input type="time" name="start_time" id="start_time" class="block w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none transition-all" value="<?php echo $data['start_time']; ?>">
                </div>
                <div>
                    <label for="end_time" class="block text-sm font-semibold text-gray-700 mb-2">End Time</label>
                    <input type="time" name="end_time" id="end_time" class="block w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none transition-all" value="<?php echo $data['end_time']; ?>">
                </div>
            </div>

            <div>
                <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">Batch Status</label>
                <select name="status" id="status" class="block w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none transition-all">
                    <option value="active" <?php echo ($data['status'] == 'active') ? 'selected' : ''; ?>>Active</option>
                    <option value="finished" <?php echo ($data['status'] == 'finished') ? 'selected' : ''; ?>>Finished</option>
                </select>
            </div>

            <button type="submit" class="w-full bg-slate-900 text-white font-bold py-4 rounded-xl shadow-md transition-all">
                Save Batch Changes
            </button>
        </form>
    </div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>
