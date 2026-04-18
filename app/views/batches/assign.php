<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="max-w-4xl mx-auto">
    <a href="<?php echo URLROOT; ?>/batches" class="text-gray-500 hover:text-gray-800 flex items-center mb-6 transition-colors font-medium">
        <i class="fas fa-chevron-left mr-2"></i> Back to Batches
    </a>

    <div class="bg-white p-8 rounded-2xl shadow-lg border border-gray-100">
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Assign Students to Batch</h2>
            <p class="text-sm text-gray-400 mt-1">Only unassigned students (and those already in this batch) are shown.</p>
            <div class="inline-flex items-center gap-2 mt-3 px-3 py-1.5 bg-blue-50 rounded-lg border border-blue-100">
                <i class="fas fa-layer-group text-blue-500"></i>
                <span class="text-sm font-bold text-blue-800"><?php echo $data['batch']->name; ?></span>
                <span class="text-xs text-blue-600 bg-white px-2 py-0.5 rounded border border-blue-100 ml-1">
                    <?php echo date('h:i A', strtotime($data['batch']->start_time)); ?> – <?php echo date('h:i A', strtotime($data['batch']->end_time)); ?>
                </span>
            </div>
        </div>

        <form action="<?php echo URLROOT; ?>/batches/assign/<?php echo $data['batch']->id; ?>" method="POST" class="space-y-5">

            <!-- Filter Bar -->
            <div class="flex flex-col sm:flex-row gap-3">
                <div class="relative flex-1">
                    <input type="text" id="student_search" placeholder="Search by name or phone..."
                           class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-400 outline-none transition-all text-sm">
                    <i class="fas fa-search absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                </div>
                <select id="filter_status" class="px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-400 outline-none text-sm text-gray-600 bg-white">
                    <option value="all">All Students</option>
                    <option value="assigned">Already in this batch</option>
                    <option value="unassigned">Not yet assigned</option>
                </select>
            </div>

            <!-- Student Count Banner -->
            <div class="flex items-center justify-between text-sm text-gray-500 px-1">
                <span id="visible_count">
                    Showing <strong class="text-gray-700" id="shown_num"><?php echo count($data['students']); ?></strong> students
                </span>
                <button type="button" id="select_all_btn"
                        class="text-blue-500 hover:text-blue-700 font-semibold transition-colors text-xs">
                    Select All Visible
                </button>
            </div>

            <!-- Student List -->
            <div class="max-h-[420px] overflow-y-auto pr-1 custom-scrollbar">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3" id="student_list">
                    <?php if (empty($data['students'])) : ?>
                        <div class="col-span-2 py-12 text-center text-gray-400">
                            <i class="fas fa-user-slash text-3xl mb-3 block"></i>
                            <p class="font-medium">No students available to assign.</p>
                            <p class="text-xs mt-1">All students are already assigned to other batches.</p>
                        </div>
                    <?php else : ?>
                        <?php foreach($data['students'] as $student) :
                            $isAssigned = in_array($student->id, $data['assignedIds']);
                        ?>
                            <label class="student-item flex items-center p-4 rounded-xl border <?php echo $isAssigned ? 'border-blue-200 bg-blue-50' : 'border-gray-100 bg-gray-50'; ?> hover:bg-white hover:border-blue-200 hover:shadow-md cursor-pointer transition-all group"
                                   data-name="<?php echo strtolower($student->name); ?>"
                                   data-phone="<?php echo strtolower($student->phone); ?>"
                                   data-state="<?php echo $isAssigned ? 'assigned' : 'unassigned'; ?>">
                                <input type="checkbox"
                                       name="students[]"
                                       value="<?php echo $student->id; ?>"
                                       <?php echo $isAssigned ? 'checked' : ''; ?>
                                       class="student-checkbox rounded text-blue-500 focus:ring-blue-500 mr-4 h-5 w-5 flex-shrink-0">
                                <div class="min-w-0 flex-1">
                                    <div class="text-sm font-bold text-gray-900 truncate">
                                        <?php echo $student->name; ?>
                                        <?php if ($isAssigned) : ?>
                                            <span class="ml-2 text-xs font-medium text-blue-600 bg-blue-100 px-1.5 py-0.5 rounded">In batch</span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="text-xs text-gray-500 mt-0.5">
                                        <i class="fas fa-phone-alt mr-1 text-gray-400"></i><?php echo $student->phone; ?>
                                    </div>
                                </div>
                            </label>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

            <div class="flex items-center justify-between pt-5 border-t border-gray-100">
                <p class="text-sm text-gray-400">
                    <i class="fas fa-info-circle mr-1 text-blue-400"></i>
                    Unchecking a student will remove them from this batch.
                </p>
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-3 px-8 rounded-xl shadow-lg transition-all flex items-center gap-2">
                    <i class="fas fa-save"></i> Save Assignments
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    const searchInput  = document.getElementById('student_search');
    const filterSelect = document.getElementById('filter_status');
    const selectAllBtn = document.getElementById('select_all_btn');
    const shownNum     = document.getElementById('shown_num');

    function filterStudents() {
        const term   = searchInput.value.toLowerCase().trim();
        const status = filterSelect.value;
        const items  = document.querySelectorAll('.student-item');
        let visible  = 0;

        items.forEach(item => {
            const name    = item.dataset.name  || '';
            const phone   = item.dataset.phone || '';
            const state   = item.dataset.state;

            const matchSearch = !term || name.includes(term) || phone.includes(term);
            const matchStatus = status === 'all' || state === status;

            if (matchSearch && matchStatus) {
                item.style.display = 'flex';
                visible++;
            } else {
                item.style.display = 'none';
            }
        });

        shownNum.textContent = visible;
    }

    searchInput.addEventListener('input', filterStudents);
    filterSelect.addEventListener('change', filterStudents);

    selectAllBtn.addEventListener('click', () => {
        const visibleItems = [...document.querySelectorAll('.student-item')].filter(i => i.style.display !== 'none');
        const allChecked = visibleItems.every(i => i.querySelector('.student-checkbox').checked);
        visibleItems.forEach(i => i.querySelector('.student-checkbox').checked = !allChecked);
        selectAllBtn.textContent = allChecked ? 'Select All Visible' : 'Deselect All Visible';
    });
</script>
<?php require APPROOT . '/views/inc/footer.php'; ?>
