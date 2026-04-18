<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="max-w-3xl mx-auto">
    <div class="flex items-center gap-4 mb-8">
        <a href="<?php echo URLROOT; ?>/exams" class="w-10 h-10 flex items-center justify-center rounded-full bg-white border border-gray-200 text-gray-400 hover:text-blue-600 hover:border-blue-200 transition-all">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h2 class="text-2xl font-bold text-gray-800">Schedule New Exam</h2>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
        <form action="<?php echo URLROOT; ?>/exams/add" method="POST" class="space-y-6">
            
            <div class="space-y-2">
                <label class="block text-sm font-semibold text-gray-700">Exam Title</label>
                <input type="text" name="title" required value="<?php echo $data['title']; ?>" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:bg-white outline-none transition-all <?php echo (!empty($data['title_err'])) ? 'border-red-500' : ''; ?>" placeholder="e.g. Monthly Test - April">
                <?php if(!empty($data['title_err'])) : ?>
                    <p class="text-red-500 text-xs mt-1"><?php echo $data['title_err']; ?></p>
                <?php endif; ?>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">Exam Date</label>
                    <input type="date" name="exam_date" required value="<?php echo $data['exam_date']; ?>" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:bg-white outline-none transition-all">
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">Batch (Optional)</label>
                    <select name="batch_id" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:bg-white outline-none transition-all">
                        <option value="">Global Exam (All Students)</option>
                        <?php foreach($data['batches'] as $batch) : ?>
                            <option value="<?php echo $batch->id; ?>" <?php echo ($data['batch_id'] == $batch->id) ? 'selected' : ''; ?>><?php echo $batch->name; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="space-y-4">
                <div class="flex justify-between items-center">
                    <label class="block text-sm font-semibold text-gray-700">Subjects & Marks</label>
                    <button type="button" onclick="addSubjectRow()" class="text-blue-600 hover:text-blue-700 text-sm font-bold flex items-center">
                        <i class="fas fa-plus-circle mr-1"></i> Add Subject
                    </button>
                </div>
                
                <div id="subjects-container" class="space-y-3">
                    <div class="subject-row grid grid-cols-1 md:grid-cols-5 gap-3 items-end bg-gray-50 p-4 rounded-xl border border-gray-100">
                        <div class="md:col-span-3 space-y-1">
                            <label class="text-[10px] uppercase font-bold text-gray-500 tracking-wider">Subject</label>
                            <select name="subject_ids[]" required class="w-full px-4 py-2 bg-white border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none transition-all">
                                <option value="">Select Subject</option>
                                <?php foreach($data['all_subjects'] as $subject) : ?>
                                    <option value="<?php echo $subject->id; ?>"><?php echo $subject->name; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="md:col-span-1 space-y-1">
                            <label class="text-[10px] uppercase font-bold text-gray-500 tracking-wider">Total Marks</label>
                            <input type="number" name="total_marks[]" required value="100" class="w-full px-4 py-2 bg-white border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none transition-all">
                        </div>
                        <div class="md:col-span-1 flex justify-end">
                            <button type="button" onclick="removeSubjectRow(this)" class="text-gray-300 hover:text-red-500 transition-colors p-2">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <?php if(!empty($data['subject_err'])) : ?>
                    <p class="text-red-500 text-xs mt-1"><?php echo $data['subject_err']; ?></p>
                <?php endif; ?>
            </div>

            <div class="pt-6 border-t border-gray-100 flex gap-4">
                <a href="<?php echo URLROOT; ?>/exams" class="flex-1 px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl font-bold text-center transition-all">Cancel</a>
                <button type="submit" class="flex-1 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-bold shadow-lg shadow-blue-500/30 transition-all">Create Exam</button>
            </div>
        </form>
    </div>
</div>

<script>
function addSubjectRow() {
    const container = document.getElementById('subjects-container');
    const firstRow = container.querySelector('.subject-row');
    const newRow = firstRow.cloneNode(true);
    
    // Clear values
    newRow.querySelector('select').value = '';
    newRow.querySelector('input[type="number"]').value = '100';
    
    container.appendChild(newRow);
}

function removeSubjectRow(btn) {
    const container = document.getElementById('subjects-container');
    const rows = container.querySelectorAll('.subject-row');
    if (rows.length > 1) {
        btn.closest('.subject-row').remove();
    } else {
        alert('At least one subject is required');
    }
}
</script>

<?php require APPROOT . '/views/inc/footer.php'; ?>
