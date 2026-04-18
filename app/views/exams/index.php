<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
    <div>
        <h2 class="text-2xl font-bold text-gray-800">Exam Management</h2>
        <p class="text-gray-500 text-sm">Schedule exams and record student results</p>
    </div>
    <a href="<?php echo URLROOT; ?>/exams/add" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-semibold flex items-center shadow-lg transition-all">
        <i class="fas fa-plus mr-2"></i> Schedule New Exam
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Exam Details</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Batch</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subjects</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            <?php foreach($data['exams'] as $exam) : ?>
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-bold text-gray-900"><?php echo $exam->title; ?></div>
                        <div class="text-xs text-gray-500">ID: #EX-<?php echo $exam->id; ?></div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-600"><?php echo $exam->batch_name ?: 'Global Exam'; ?></div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs font-bold rounded-md">
                            <i class="fas fa-book mr-1"></i> <?php echo $exam->subject_count; ?> Subjects
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                        <i class="far fa-calendar-alt mr-1"></i> <?php echo date('d M, Y', strtotime($exam->exam_date)); ?>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                        <a href="<?php echo URLROOT; ?>/exams/marks/<?php echo $exam->id; ?>" class="bg-emerald-50 text-emerald-600 hover:bg-emerald-100 px-3 py-1 rounded-md transition-all text-xs font-bold ring-1 ring-emerald-200">
                            <i class="fas fa-edit mr-1"></i> Record Marks
                        </a>
                        <form action="<?php echo URLROOT; ?>/exams/delete/<?php echo $exam->id; ?>" method="POST" class="inline" onsubmit="return confirmAction(this, 'Delete this exam and all associated marks?', event);">
                            <button type="submit" class="text-red-600 hover:bg-red-50 p-2 rounded-md transition-all">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if(empty($data['exams'])) : ?>
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-gray-400">
                        <i class="fas fa-poll text-4xl mb-4 block opacity-20"></i>
                        No exams scheduled yet.
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>
