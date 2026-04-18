<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="max-w-2xl mx-auto">
    <div class="flex items-center gap-4 mb-8">
        <a href="<?php echo URLROOT; ?>/exams" class="w-10 h-10 flex items-center justify-center rounded-full bg-white border border-gray-200 text-gray-400 hover:text-blue-600 hover:border-blue-200 transition-all">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h2 class="text-2xl font-bold text-gray-800"><?php echo $data['exam']->title; ?></h2>
            <p class="text-gray-500 text-sm">Select a subject to record student marks</p>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-4">
        <?php foreach($data['subjects'] as $subject) : ?>
            <a href="<?php echo URLROOT; ?>/exams/marks/<?php echo $data['exam']->id; ?>/<?php echo $subject->id; ?>" 
               class="group bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between hover:shadow-md hover:border-blue-200 transition-all">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center group-hover:bg-blue-600 group-hover:text-white transition-all">
                        <i class="fas fa-book text-xl"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-800 text-lg"><?php echo $subject->subject_name; ?></h3>
                        <p class="text-gray-500 text-sm">Total Marks: <?php echo $subject->total_marks; ?></p>
                    </div>
                </div>
                <div class="text-gray-300 group-hover:text-blue-600 transition-all">
                    <i class="fas fa-chevron-right text-xl"></i>
                </div>
            </a>
        <?php endforeach; ?>

        <?php if(empty($data['subjects'])) : ?>
            <div class="bg-amber-50 border border-amber-200 p-6 rounded-2xl text-center">
                <p class="text-amber-800 font-medium">No subjects assigned to this exam yet.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>
