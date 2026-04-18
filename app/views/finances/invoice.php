<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice - <?php echo $data['fee']->student_name; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        @media print {
            .no-print { display: none; }
            body { background: white; padding: 0; }
            .invoice-box { box-shadow: none; border: none; margin: 0; width: 100%; }
        }
    </style>
</head>
<body class="bg-gray-50 py-12 px-4">

    <div class="max-w-3xl mx-auto no-print mb-8 flex justify-between items-center">
        <a href="<?php echo URLROOT; ?>/finance/fees" class="text-sm font-bold text-blue-600 flex items-center gap-2">
            <i class="fas fa-arrow-left"></i> Back to Fees
        </a>
        <button onclick="window.print()" class="px-6 py-2 bg-blue-600 text-white rounded-lg font-bold shadow-lg shadow-blue-500/30">
            <i class="fas fa-print mr-2"></i> Print Invoice
        </button>
    </div>

    <div class="max-w-3xl mx-auto bg-white p-10 rounded-2xl shadow-xl border border-gray-100 invoice-box">
        <!-- Header -->
        <div class="flex justify-between items-start mb-12">
            <div>
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-12 h-12 bg-blue-600 rounded-xl flex items-center justify-center text-white text-2xl">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-black text-gray-900 uppercase tracking-tighter"><?php echo get_setting('site_title', SITENAME); ?></h1>
                        <p class="text-xs text-gray-500 font-bold uppercase tracking-widest">Official Fee Receipt</p>
                    </div>
                </div>
                <div class="text-sm text-gray-500 space-y-1">
                    <p>H-123, Sector 7, Uttara, Dhaka</p>
                    <p>Phone: +880 1234 567890</p>
                    <p>Email: contact@coaching.com</p>
                </div>
            </div>
            <div class="text-right">
                <h2 class="text-4xl font-black text-gray-200 uppercase mb-2">Invoice</h2>
                <p class="text-sm font-bold text-gray-700">No: #INV-<?php echo str_pad($data['fee']->id, 6, '0', STR_PAD_LEFT); ?></p>
                <p class="text-sm text-gray-500">Date: <?php echo date('d M, Y'); ?></p>
            </div>
        </div>

        <hr class="border-gray-100 mb-10">

        <!-- Bill To -->
        <div class="grid grid-cols-2 gap-12 mb-12">
            <div>
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Student Details</h3>
                <div class="text-gray-900">
                    <p class="font-bold text-lg"><?php echo $data['fee']->student_name; ?></p>
                    <p class="text-sm">Roll No: <?php echo $data['fee']->roll_number ?: 'N/A'; ?></p>
                    <p class="text-sm">Father: <?php echo $data['fee']->father_name ?: 'N/A'; ?></p>
                    <p class="text-sm">Phone: <?php echo $data['fee']->student_phone ?: 'N/A'; ?></p>
                </div>
            </div>
            <div class="text-right">
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Payment Info</h3>
                <div class="text-gray-900">
                    <p class="text-sm">Month: <span class="font-bold text-blue-600 uppercase"><?php echo date('F Y', strtotime($data['fee']->month_year . '-01')); ?></span></p>
                    <?php 
                        $statusClass = 'text-emerald-600';
                        if($data['fee']->status == 'pending') $statusClass = 'text-amber-600';
                        if($data['fee']->status == 'due') $statusClass = 'text-rose-600';
                    ?>
                    <p class="text-sm">Status: <span class="font-bold uppercase <?php echo $statusClass; ?>"><?php echo $data['fee']->status; ?></span></p>
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="mb-12">
            <table class="w-full text-left">
                <thead>
                    <tr class="border-b-2 border-gray-900">
                        <th class="py-4 text-sm font-black uppercase text-gray-900">Description</th>
                        <th class="py-4 text-right text-sm font-black uppercase text-gray-900">Rate</th>
                        <th class="py-4 text-right text-sm font-black uppercase text-gray-900">Qty</th>
                        <th class="py-4 text-right text-sm font-black uppercase text-gray-900">Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <tr>
                        <td class="py-6">
                            <p class="font-bold text-gray-900">Monthly Tuition Fee</p>
                            <p class="text-xs text-gray-500 italic">For the month of <?php echo date('F Y', strtotime($data['fee']->month_year . '-01')); ?></p>
                        </td>
                        <td class="py-6 text-right text-gray-900">৳<?php echo number_format($data['fee']->amount, 2); ?></td>
                        <td class="py-6 text-right text-gray-900">1</td>
                        <td class="py-6 text-right font-bold text-gray-900">৳<?php echo number_format($data['fee']->amount, 2); ?></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Summary -->
        <div class="flex justify-end mb-12">
            <div class="w-64 space-y-3">
                <div class="flex justify-between text-sm text-gray-500">
                    <span>Subtotal</span>
                    <span>৳<?php echo number_format($data['fee']->amount, 2); ?></span>
                </div>
                <div class="flex justify-between text-sm text-gray-500">
                    <span>Discount</span>
                    <span>-৳0.00</span>
                </div>
                <div class="flex justify-between text-lg font-black border-t-2 border-gray-900 pt-3">
                    <span>Total Amount</span>
                    <span class="text-blue-600">৳<?php echo number_format($data['fee']->amount, 2); ?></span>
                </div>
                <?php if($data['fee']->status == 'due'): ?>
                <div class="flex justify-between text-sm font-bold text-rose-600 pt-1">
                    <span>Due Balance</span>
                    <span>৳<?php echo number_format($data['fee']->due_amount, 2); ?></span>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Footer -->
        <div class="mt-20 pt-10 border-t border-dashed border-gray-200">
            <div class="flex justify-between items-end">
                <div class="max-w-xs">
                    <h4 class="text-sm font-bold text-gray-900 mb-2">Terms & Conditions</h4>
                    <p class="text-[10px] text-gray-400 leading-relaxed">
                        This receipt is computer generated and requires no physical signature. 
                        Fees once paid are non-refundable. Please keep this receipt for future reference.
                    </p>
                </div>
                <div class="text-center">
                    <div class="w-32 h-px bg-gray-900 mb-2 mx-auto"></div>
                    <p class="text-xs font-bold text-gray-900">Authorized Signature</p>
                </div>
            </div>
        </div>

        <div class="mt-12 text-center text-[10px] font-bold text-gray-300 uppercase tracking-[0.3em]">
            Thank you for being part of our excellence
        </div>
    </div>

</body>
</html>
