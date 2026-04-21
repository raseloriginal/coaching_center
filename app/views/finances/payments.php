<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
    <div>
        <h2 class="text-2xl font-bold text-gray-800">Teacher Payments</h2>
        <p class="text-gray-500 text-sm">Monthly salary tracking and status management</p>
    </div>
    
    <div class="flex items-center gap-4 flex-wrap">
        <form action="<?php echo URLROOT; ?>/finance/payments" method="GET" class="flex gap-2">
            <input type="month" name="month" value="<?php echo $data['current_month']; ?>" class="border border-gray-300 rounded-lg px-3 py-1 text-sm focus:ring-blue-500 focus:border-blue-500" onchange="this.form.submit()">
            <input type="hidden" name="status" value="<?php echo $data['current_status']; ?>">
        </form>

        <div class="flex gap-2">
            <button onclick="filterPayments('')" id="btnFilterAll" class="filter-btn px-3 py-1 rounded-lg text-sm font-semibold <?php echo empty($_GET['status']) ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-700'; ?>">All</button>
            <button onclick="filterPayments('pending')" id="btnFilterPending" class="filter-btn px-3 py-1 rounded-lg text-sm font-semibold <?php echo ($data['current_status'] == 'pending') ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-700'; ?>">Pending</button>
            <button onclick="filterPayments('paid')" id="btnFilterPaid" class="filter-btn px-3 py-1 rounded-lg text-sm font-semibold <?php echo ($data['current_status'] == 'paid') ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-700'; ?>">Paid</button>
            <button onclick="filterPayments('due')" id="btnFilterDue" class="filter-btn px-3 py-1 rounded-lg text-sm font-semibold <?php echo ($data['current_status'] == 'due') ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-700'; ?>">Due</button>
        </div>
    </div>
</div>

<?php if(empty($data['payments']) && empty($data['current_status'])) : ?>
    <div class="bg-blue-50 p-6 rounded-xl border border-blue-100 mb-6 text-center animate-fade-up">
        <i class="fas fa-magic text-blue-400 text-4xl mb-3 block"></i>
        <h3 class="text-lg font-bold text-blue-900 mb-1">No Payments Found for <?php echo date('F Y', strtotime($data['current_month'] . '-01')); ?></h3>
        <p class="text-blue-700 text-sm mb-4">It looks like teacher payments for this month haven't been generated yet.</p>
        <form action="<?php echo URLROOT; ?>/finance/generate_monthly_payments" method="POST">
            <input type="hidden" name="month" value="<?php echo $data['current_month']; ?>">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg shadow hover:shadow-lg transition-all transform hover:-translate-y-0.5">
                Generate All Teacher Payments
            </button>
        </form>
    </div>
<?php endif; ?>

<form id="bulkForm" action="<?php echo URLROOT; ?>/finance/bulk_update_payments" method="POST">
    <input type="hidden" name="current_month" value="<?php echo $data['current_month']; ?>">
    
    <div id="bulkActions" class="fixed top-20 left-1/2 transform -translate-x-1/2 bg-gray-900 shadow-2xl rounded-full px-6 py-3 flex items-center gap-6 hidden z-[100] animate-fade-down border border-gray-800">
        <span class="text-sm font-bold text-white"><span id="selectedCount" class="bg-blue-600 text-white px-2 py-0.5 rounded-md mr-1">0</span> items selected</span>
        <div class="flex items-center gap-2">
            <select name="bulk_status" class="text-sm border-gray-700 bg-gray-800 text-white rounded-lg focus:ring-blue-500 py-2" required>
                <option value="">Change Status To...</option>
                <option value="paid">Paid</option>
                <option value="pending">Pending</option>
                <option value="due">Due</option>
            </select>
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg text-sm font-bold hover:bg-blue-500 transition shadow-lg">Apply</button>
        </div>
    </div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-8">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 w-12"><input type="checkbox" id="selectAllPayments" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"></th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Teacher & Month</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
            </tr>
        </thead>
        <tbody id="paymentsTableBody" class="bg-white divide-y divide-gray-200">
            <?php foreach($data['payments'] as $payment) : ?>
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4"><input type="checkbox" name="payment_ids[]" value="<?php echo $payment->id; ?>" class="row-checkbox rounded border-gray-300 text-blue-600 focus:ring-blue-500" onclick="updatePaymentBulkActions()"></td>
                    <td class="px-6 py-4">
                        <div class="text-sm font-bold text-gray-900"><?php echo $payment->teacher_name; ?></div>
                        <div class="text-xs text-gray-500"><i class="far fa-calendar-alt mr-1"></i> <?php echo date('F Y', strtotime($payment->month . '-01')); ?></div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm font-semibold text-gray-800">৳<?php echo $payment->amount; ?></div>
                        <?php if($payment->due_amount > 0) : ?>
                            <div class="text-xs text-rose-500 text-right">Due: ৳<?php echo $payment->due_amount; ?></div>
                        <?php endif; ?>
                    </td>
                    <td class="px-6 py-4">
                        <?php 
                        $statusClass = 'bg-gray-100 text-gray-800';
                        if($payment->status == 'paid') $statusClass = 'bg-emerald-100 text-emerald-800';
                        if($payment->status == 'due') $statusClass = 'bg-blue-100 text-blue-800';
                        if($payment->status == 'pending') $statusClass = 'bg-rose-100 text-rose-800';
                        ?>
                        <span class="px-3 py-1 rounded-full text-xs font-bold <?php echo $statusClass; ?>">
                            <?php echo ucfirst($payment->status); ?>
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <button onclick="openModal('<?php echo $payment->id; ?>', '<?php echo $payment->status; ?>', '<?php echo $payment->due_amount; ?>', '<?php echo $payment->teacher_name; ?>')" class="text-blue-600 hover:text-blue-900 font-bold text-sm">Update</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</form>

<!-- Modal -->
<div id="paymentModal" class="fixed inset-0 bg-black/50 hidden z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl w-full max-w-md p-6 shadow-2xl">
        <h3 class="text-xl font-bold text-gray-800 mb-2">Update teacher Payment</h3>
        <p id="modalTeacherName" class="text-gray-500 text-sm mb-6"></p>
        
        <form action="<?php echo URLROOT; ?>/finance/update_payment" method="POST" class="space-y-4">
            <input type="hidden" name="id" id="modalPaymentId">
            <input type="hidden" name="current_month" value="<?php echo $data['current_month']; ?>">
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="status" id="modalStatus" class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    <option value="pending">Pending</option>
                    <option value="paid">Paid</option>
                    <option value="due">Due / Partial</option>
                </select>
            </div>

            <div id="dueAmountContainer" class="hidden">
                <label class="block text-sm font-medium text-gray-700 mb-1">Due Amount</label>
                <input type="number" step="1" name="due_amount" id="modalDue" class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" value="0">
            </div>

            <div class="flex gap-4 pt-4">
                <button type="button" onclick="closeModal()" class="flex-1 bg-gray-100 py-2 rounded-lg font-bold">Cancel</button>
                <button type="submit" class="flex-1 bg-blue-500 text-white py-2 rounded-lg font-bold">Save Changes</button>
            </div>
        </form>
    </div>
</div>

<script>
    function filterPayments(status) {
        // Update buttons style
        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.classList.remove('bg-blue-500', 'text-white');
            btn.classList.add('bg-gray-200', 'text-gray-700');
        });
        
        let activeBtnId = 'btnFilterAll';
        if(status === 'pending') activeBtnId = 'btnFilterPending';
        if(status === 'paid') activeBtnId = 'btnFilterPaid';
        if(status === 'due') activeBtnId = 'btnFilterDue';
        
        let activeBtn = document.getElementById(activeBtnId);
        activeBtn.classList.remove('bg-gray-200', 'text-gray-700');
        activeBtn.classList.add('bg-blue-500', 'text-white');

        // Fetch data
        document.getElementById('paymentsTableBody').innerHTML = '<tr><td colspan="4" class="px-6 py-4 text-center text-gray-500">Loading...</td></tr>';
        
        let month = '<?php echo $data['current_month']; ?>';
        fetch('<?php echo URLROOT; ?>/finance/filter_payments?status=' + status + '&month=' + month)
            .then(response => response.text())
            .then(data => {
                document.getElementById('paymentsTableBody').innerHTML = data;
                updatePaymentBulkActions(); // reset UI
                document.getElementById('selectAllPayments').checked = false;
            });
    }

    const selectAllBtn = document.getElementById('selectAllPayments');
    if (selectAllBtn) {
        selectAllBtn.addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.row-checkbox');
            checkboxes.forEach(cb => cb.checked = this.checked);
            updatePaymentBulkActions();
        });
    }

    function updatePaymentBulkActions() {
        const checkboxes = document.querySelectorAll('.row-checkbox:checked');
        const bulkDiv = document.getElementById('bulkActions');
        const countSpan = document.getElementById('selectedCount');
        
        if (checkboxes.length > 0) {
            bulkDiv.classList.remove('hidden');
            countSpan.textContent = checkboxes.length;
        } else {
            bulkDiv.classList.add('hidden');
        }
    }

    function openModal(id, status, due, name) {
        document.getElementById('modalPaymentId').value = id;
        document.getElementById('modalStatus').value = status;
        document.getElementById('modalDue').value = due;
        document.getElementById('modalTeacherName').innerText = "Updating record for: " + name;

        var dueContainer = document.getElementById('dueAmountContainer');
        if (status === 'due') {
            dueContainer.classList.remove('hidden');
        } else {
            dueContainer.classList.add('hidden');
        }

        document.getElementById('paymentModal').classList.remove('hidden');
    }

    document.getElementById('modalStatus').addEventListener('change', function() {
        var dueContainer = document.getElementById('dueAmountContainer');
        if (this.value === 'due') {
            dueContainer.classList.remove('hidden');
        } else {
            dueContainer.classList.add('hidden');
            document.getElementById('modalDue').value = 0;
        }
    });

    function closeModal() {
        document.getElementById('paymentModal').classList.add('hidden');
    }
</script>
<?php require APPROOT . '/views/inc/footer.php'; ?>
