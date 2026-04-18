<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
    <div class="flex items-center gap-4">
        <a href="<?php echo URLROOT; ?>/exams/marks/<?php echo $data['exam']->id; ?>" class="w-10 h-10 flex items-center justify-center rounded-full bg-white border border-gray-200 text-gray-400 hover:text-blue-600 transition-all">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <div class="flex items-center gap-2">
                <h2 class="text-2xl font-bold text-gray-800"><?php echo $data['exam']->title; ?></h2>
                <span class="px-3 py-1 bg-blue-600 text-white text-xs font-bold rounded-full"><?php echo $data['examSubject']->subject_name; ?></span>
            </div>
            <p class="text-gray-500 text-sm">
                Total Marks: <?php echo $data['examSubject']->total_marks; ?> &bull;
                <?php echo $data['exam']->batch_name ?: 'Global Exam'; ?>
            </p>
        </div>
    </div>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <form action="<?php echo URLROOT; ?>/exams/save_marks" method="POST">
        <input type="hidden" name="exam_id" value="<?php echo $data['exam']->id; ?>">
        <input type="hidden" name="exam_subject_id" value="<?php echo $data['examSubject']->id; ?>">
        <input type="hidden" name="subject_name" value="<?php echo $data['examSubject']->subject_name; ?>">
        
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/3">Student</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/4">Marks Obtained</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Remarks</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php foreach($data['students'] as $student) : ?>
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-8 h-8 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-xs uppercase">
                                    <?php echo substr($student->name, 0, 1); ?>
                                </div>
                                <div class="ml-3">
                                    <div class="text-sm font-semibold text-gray-900"><?php echo $student->name; ?></div>
                                    <div class="text-xs text-gray-500"><?php echo $student->phone; ?></div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="relative w-32">
                                <input type="number" 
                                       step="0.01" 
                                       max="<?php echo $data['examSubject']->total_marks; ?>" 
                                       name="marks[<?php echo $student->id; ?>]" 
                                       value="<?php echo isset($data['marks'][$student->id]) ? $data['marks'][$student->id]->marks_obtained : ''; ?>"
                                       class="w-full pl-3 pr-8 py-2 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:bg-white outline-none transition-all font-bold text-gray-800"
                                       placeholder="0.00">
                                <span class="absolute right-3 top-1/2 -translate-y-1/2 text-[10px] font-bold text-gray-400">/<?php echo $data['examSubject']->total_marks; ?></span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <input type="text" 
                                   name="remarks[<?php echo $student->id; ?>]"
                                   value="<?php echo isset($data['marks'][$student->id]) ? $data['marks'][$student->id]->remarks : ''; ?>"
                                   class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:bg-white outline-none transition-all text-sm text-gray-600"
                                   placeholder="e.g. Excellent, Needs Improvement">
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if(empty($data['students'])) : ?>
                    <tr>
                        <td colspan="3" class="px-6 py-12 text-center text-gray-400">
                            No students found.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- Submit Section -->
        <div class="p-6 bg-gray-50 border-t border-gray-100 flex justify-end">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-xl font-bold shadow-lg shadow-blue-500/30 transition-all flex items-center gap-2">
                <i class="fas fa-save"></i> Save <?php echo $data['examSubject']->subject_name; ?> Results
            </button>
        </div>
    </form>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>
