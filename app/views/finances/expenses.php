<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
    <div>
        <h2 class="text-2xl font-bold text-gray-800">Expenses Tracking</h2>
        <p class="text-gray-500 text-sm">Manage general coaching center expenses</p>
    </div>
    
    <div class="flex gap-2">
        <button onclick="openAddModal()" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-bold shadow-md transition-all shadow-blue-500/20">
            <i class="fas fa-plus mr-1"></i> Add New Expense
        </button>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            <?php foreach($data['expenses'] as $expense) : ?>
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-700"><i class="far fa-calendar-alt text-gray-400 mr-2"></i> <?php echo date('d M, Y', strtotime($expense->expense_date)); ?></div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm font-bold text-gray-900"><?php echo htmlspecialchars($expense->title); ?></div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 bg-gray-100 text-gray-600 rounded-full text-xs font-semibold">
                            <?php echo htmlspecialchars($expense->category); ?>
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm font-extrabold text-gray-800">৳<?php echo number_format($expense->amount, 2); ?></div>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <form action="<?php echo URLROOT; ?>/finance/delete_expense/<?php echo $expense->id; ?>" method="POST" onsubmit="return confirmAction(this, 'Are you sure you want to delete this expense?', event);" class="inline">
                            <button type="submit" class="text-red-500 hover:text-red-700 font-bold text-sm bg-red-50 hover:bg-red-100 p-2 rounded-lg transition-colors">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if(empty($data['expenses'])) : ?>
                <tr>
                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">No expense records found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?php if (isset($data['pagination'])) echo $data['pagination']; ?>

<!-- Add Expense Modal -->
<div id="addExpenseModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm hidden z-[100] flex items-center justify-center p-4 transition-all duration-300">
    <div class="bg-white rounded-2xl w-full max-w-md p-6 shadow-2xl scale-95 origin-center animate-fade-up">
        <h3 class="text-xl font-bold text-gray-800 mb-6 font-display">Add New Expense</h3>
        
        <form action="<?php echo URLROOT; ?>/finance/add_expense" method="POST" class="space-y-5">
            
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Expense Title / Description</label>
                <input type="text" name="title" required class="w-full border-gray-300 px-4 py-3 border rounded-xl focus:ring-2 focus:ring-blue-500 outline-none transition-all placeholder:text-gray-400" placeholder="e.g. Electric Bill for January">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Amount</label>
                    <input type="number" step="1" name="amount" required class="w-full border-gray-300 px-4 py-3 border rounded-xl focus:ring-2 focus:ring-blue-500 outline-none transition-all text-gray-800" placeholder="e.g. 50">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Date</label>
                    <input type="date" name="expense_date" required class="w-full border-gray-300 px-4 py-3 border rounded-xl focus:ring-2 focus:ring-blue-500 outline-none transition-all text-gray-800" value="<?php echo date('Y-m-d'); ?>">
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Category</label>
                <select name="category" class="w-full border-gray-300 px-4 py-3 border rounded-xl focus:ring-2 focus:ring-blue-500 outline-none transition-all bg-white text-gray-700">
                    <option value="Utilities">Utilities</option>
                    <option value="Rent">Rent</option>
                    <option value="Supplies">Supplies</option>
                    <option value="Maintenance">Maintenance</option>
                    <option value="Marketing">Marketing</option>
                    <option value="Other">Other</option>
                </select>
            </div>

            <div class="flex gap-4 pt-6">
                <button type="button" onclick="closeAddModal()" class="flex-1 bg-gray-100 py-3 rounded-xl text-gray-700 font-bold hover:bg-gray-200 transition-colors">Cancel</button>
                <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-xl font-bold shadow-lg shadow-blue-500/30 transition-all">Save Expense</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openAddModal() {
        document.getElementById('addExpenseModal').classList.remove('hidden');
    }
    function closeAddModal() {
        document.getElementById('addExpenseModal').classList.add('hidden');
    }
</script>
<?php require APPROOT . '/views/inc/footer.php'; ?>
