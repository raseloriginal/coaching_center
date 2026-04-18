<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="max-w-4xl mx-auto">
    <a href="<?php echo URLROOT; ?>/batches" class="text-gray-500 hover:text-gray-800 flex items-center mb-6 transition-colors font-medium">
        <i class="fas fa-chevron-left mr-2"></i> Back to Batches
    </a>

    <?php flash('batch_message'); ?>

    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-indigo-600 to-blue-500 px-8 py-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <div class="flex items-center gap-2 mb-1">
                        <i class="fas fa-layer-group text-white/70 text-sm"></i>
                        <span class="text-white/70 text-xs font-medium uppercase tracking-wider">Batch Details</span>
                    </div>
                    <h2 class="text-2xl font-bold text-white"><?php echo htmlspecialchars($data['batch']->name); ?></h2>
                    <p class="text-blue-100 text-sm mt-1">
                        <i class="far fa-clock mr-1"></i>
                        <?php echo date('h:i A', strtotime($data['batch']->start_time)); ?> –
                        <?php echo date('h:i A', strtotime($data['batch']->end_time)); ?>
                        &nbsp;·&nbsp;
                        <span class="<?php echo $data['batch']->status == 'active' ? 'text-emerald-200' : 'text-gray-200'; ?>">
                            <?php echo ucfirst($data['batch']->status); ?>
                        </span>
                    </p>
                </div>
                <div class="flex items-center gap-3">
                    <div class="bg-white/20 backdrop-blur rounded-xl px-5 py-3 text-center">
                        <div class="text-3xl font-extrabold text-white"><?php echo count($data['students']); ?></div>
                        <div class="text-xs text-blue-100 mt-0.5">Student<?php echo count($data['students']) != 1 ? 's' : ''; ?></div>
                    </div>
                    <a href="<?php echo URLROOT; ?>/batches/assign/<?php echo $data['batch']->id; ?>"
                       class="bg-white text-blue-600 hover:bg-blue-50 font-bold px-4 py-2.5 rounded-xl text-sm flex items-center gap-2 transition-all shadow">
                        <i class="fas fa-user-plus"></i> Assign Students
                    </a>
                </div>
            </div>
        </div>

        <!-- Student List -->
        <div class="p-6">
            <!-- Search -->
            <div class="relative mb-5">
                <input type="text" id="view_search" placeholder="Search students by name or phone..."
                       class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-400 outline-none transition-all text-sm">
                <i class="fas fa-search absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
            </div>

            <?php if (empty($data['students'])) : ?>
                <div class="py-16 text-center text-gray-400">
                    <i class="fas fa-users text-5xl mb-4 block text-gray-200"></i>
                    <p class="font-semibold text-gray-500 text-lg">No students in this batch yet.</p>
                    <p class="text-sm mt-1 mb-5">Assign students to get started.</p>
                    <a href="<?php echo URLROOT; ?>/batches/assign/<?php echo $data['batch']->id; ?>"
                       class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2.5 rounded-xl font-bold text-sm transition-all inline-flex items-center gap-2">
                        <i class="fas fa-user-plus"></i> Assign Students Now
                    </a>
                </div>
            <?php else : ?>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3" id="view_student_list">
                    <?php foreach($data['students'] as $student) : ?>
                        <div class="view-student-item flex items-center justify-between p-4 rounded-xl border border-gray-100 bg-gray-50 hover:bg-white hover:border-blue-100 hover:shadow transition-all group"
                             data-name="<?php echo strtolower($student->name); ?>"
                             data-phone="<?php echo strtolower($student->phone); ?>">
                            <div class="flex items-center gap-3 min-w-0">
                                <div class="w-9 h-9 rounded-full bg-gradient-to-br from-blue-400 to-indigo-500 flex items-center justify-center text-white font-bold text-sm flex-shrink-0">
                                    <?php echo strtoupper(mb_substr($student->name, 0, 1)); ?>
                                </div>
                                <div class="min-w-0">
                                    <div class="text-sm font-bold text-gray-800 truncate"><?php echo htmlspecialchars($student->name); ?></div>
                                    <div class="text-xs text-gray-500 mt-0.5">
                                        <i class="fas fa-phone-alt mr-1 text-gray-400"></i><?php echo htmlspecialchars($student->phone); ?>
                                    </div>
                                    <?php if (!empty($student->roll_number)) : ?>
                                        <div class="text-xs text-indigo-500 mt-0.5">
                                            <i class="fas fa-id-badge mr-1"></i>Roll: <?php echo htmlspecialchars($student->roll_number); ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Remove Button -->
                            <form action="<?php echo URLROOT; ?>/batches/remove_student/<?php echo $data['batch']->id; ?>/<?php echo $student->id; ?>" method="POST"
                                  onsubmit="return confirm('Remove <?php echo addslashes($student->name); ?> from this batch?')">
                                <button type="submit"
                                        class="ml-3 flex-shrink-0 text-red-400 hover:text-red-600 hover:bg-red-50 p-2 rounded-lg transition-all opacity-0 group-hover:opacity-100"
                                        title="Remove from batch">
                                    <i class="fas fa-user-minus text-sm"></i>
                                </button>
                            </form>
                        </div>
                    <?php endforeach; ?>
                </div>

                <p class="text-xs text-gray-400 mt-5 flex items-center gap-1.5">
                    <i class="fas fa-info-circle text-blue-400"></i>
                    Hover over a student card and click the <i class="fas fa-user-minus mx-0.5 text-red-400"></i> button to remove them from this batch.
                </p>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
    const viewSearch = document.getElementById('view_search');
    if (viewSearch) {
        viewSearch.addEventListener('input', function () {
            const term  = this.value.toLowerCase().trim();
            document.querySelectorAll('.view-student-item').forEach(item => {
                const name  = item.dataset.name  || '';
                const phone = item.dataset.phone || '';
                item.style.display = (!term || name.includes(term) || phone.includes(term)) ? 'flex' : 'none';
            });
        });
    }
</script>
<?php require APPROOT . '/views/inc/footer.php'; ?>
