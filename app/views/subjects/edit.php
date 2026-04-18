<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="max-w-lg mx-auto">
    <a href="<?php echo URLROOT; ?>/subjects" class="text-gray-500 hover:text-gray-800 flex items-center mb-6 transition-colors font-medium">
        <i class="fas fa-chevron-left mr-2"></i> Back to Subjects
    </a>

    <div class="bg-white p-8 rounded-2xl shadow-lg border border-gray-100">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Edit Subject</h2>
        
        <form action="<?php echo URLROOT; ?>/subjects/edit/<?php echo $data['id']; ?>" method="POST" class="space-y-6">
            <div>
                <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Subject Name</label>
                <input type="text" name="name" id="name" 
                       class="block w-full px-4 py-3 border <?php echo (!empty($data['name_err'])) ? 'border-red-500' : 'border-gray-300'; ?> rounded-xl focus:ring-2 focus:ring-blue-500 outline-none transition-all"
                       value="<?php echo $data['name']; ?>">
                <span class="text-xs text-red-500 mt-1"><?php echo $data['name_err']; ?></span>
            </div>

            <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-3 rounded-xl shadow-md transition-all">
                Update Subject
            </button>
        </form>
    </div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>
