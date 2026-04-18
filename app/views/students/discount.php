<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="max-w-4xl mx-auto">
    <div class="mb-8">
        <a href="<?php echo URLROOT; ?>/students" class="text-sm font-semibold text-blue-600 hover:text-blue-700 flex items-center gap-2 mb-4">
            <i class="fas fa-arrow-left"></i> Back to Students
        </a>
        <h2 class="text-3xl font-bold text-gray-800">Student Discounts</h2>
        <p class="text-gray-500">Manage special discounts and fee waivers for <strong><?php echo $data['student']->name; ?></strong>.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- New Discount Form -->
        <div class="lg:col-span-1">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <h3 class="text-lg font-bold text-gray-800 mb-6">Apply Discount</h3>
                <form action="<?php echo URLROOT; ?>/students/discount/<?php echo $data['student']->id; ?>" method="POST">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Discount Type</label>
                            <select name="discount_type" class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 focus:ring-2 focus:ring-blue-500 focus:bg-white outline-none transition-all">
                                <option value="percentage">Percentage (%)</option>
                                <option value="fixed">Fixed Amount (৳)</option>
                                <option value="full_waiver">Full Waiver</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Amount</label>
                            <input type="number" name="amount" step="0.01" class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 focus:ring-2 focus:ring-blue-500 focus:bg-white outline-none transition-all" placeholder="Enter value">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Reason</label>
                            <textarea name="reason" rows="3" class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 focus:ring-2 focus:ring-blue-500 focus:bg-white outline-none transition-all" placeholder="e.g. Merit-based scholarship"></textarea>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Expiry Date (Optional)</label>
                            <input type="date" name="expires_at" class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 focus:ring-2 focus:ring-blue-500 focus:bg-white outline-none transition-all">
                        </div>

                        <button type="submit" class="w-full bg-emerald-600 text-white py-3 rounded-xl font-bold shadow-lg shadow-emerald-500/30 hover:shadow-emerald-500/50 hover:-translate-y-1 transition-all">
                            Apply Discount
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Existing Discounts List -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100">
                    <h3 class="text-lg font-bold text-gray-800">Active Discounts</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="text-xs text-gray-500 uppercase bg-gray-50">
                            <tr>
                                <th class="px-6 py-4">Benefit</th>
                                <th class="px-6 py-4">Reason</th>
                                <th class="px-6 py-4">Valid Until</th>
                                <th class="px-6 py-4 text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <?php if(!empty($data['discounts'])): ?>
                                <?php foreach($data['discounts'] as $discount): ?>
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 font-bold text-emerald-600">
                                        <?php if($discount->discount_type == 'percentage'): ?>
                                            <?php echo $discount->amount; ?>% Off
                                        <?php elseif($discount->discount_type == 'fixed'): ?>
                                            -৳<?php echo number_format($discount->amount, 2); ?>
                                        <?php else: ?>
                                            Full Waiver
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-6 py-4 text-gray-600">
                                        <?php echo $discount->reason; ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <?php echo $discount->expires_at ? format_date($discount->expires_at) : '<span class="text-gray-400 italic">No expiry</span>'; ?>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <button class="text-rose-600 hover:bg-rose-50 p-2 rounded-lg transition-all">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center text-gray-400">
                                        <i class="fas fa-tags text-4xl mb-4 opacity-20 block"></i>
                                        No discounts applied to this student yet.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require APPROOT . '/views/inc/header.php'; ?>
