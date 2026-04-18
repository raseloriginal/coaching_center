<?php require APPROOT . '/views/inc/header.php'; ?>
<div class=" mx-auto">
    <a href="<?php echo URLROOT; ?>/students" class="text-gray-500 hover:text-gray-800 flex items-center mb-6 transition-colors">
        <i class="fas fa-chevron-left mr-2"></i> Back to Student Directory
    </a>

    <div class="bg-white p-8 rounded-2xl shadow-lg border border-gray-100">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 font-display">New Student Registration</h2>
        
        <form action="<?php echo URLROOT; ?>/students/add" method="POST" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          
        <div>
                <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Student Full Name</label>
                <input type="text" name="name" id="name" class="block w-full px-4 py-3 border <?php echo (!empty($data['name_err'])) ? 'border-red-500' : 'border-gray-300'; ?> rounded-xl focus:ring-2 focus:ring-blue-500 outline-none transition-all placeholder:text-gray-400" placeholder="e.g. John Doe" value="<?php echo $data['name']; ?>">
                <span class="text-xs text-red-500"><?php echo $data['name_err']; ?></span>
            </div>

            <div>
                <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">Contact Phone</label>
                <input type="text" name="phone" id="phone" class="block w-full px-4 py-3 border <?php echo (!empty($data['phone_err'])) ? 'border-red-500' : 'border-gray-300'; ?> rounded-xl focus:ring-2 focus:ring-blue-500 outline-none transition-all placeholder:text-gray-400" placeholder="e.g. 01700000000" value="<?php echo $data['phone']; ?>">
                <span class="text-xs text-red-500"><?php echo $data['phone_err']; ?></span>
            </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="father_name" class="block text-sm font-semibold text-gray-700 mb-2">Father's Name</label>
                    <input type="text" name="father_name" id="father_name" class="block w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none transition-all placeholder:text-gray-400" placeholder="e.g. Michael Doe" value="<?php echo $data['father_name'] ?? ''; ?>">
                </div>

                <div>
                    <label for="roll_number" class="block text-sm font-semibold text-gray-700 mb-2">Roll Number</label>
                    <input type="text" name="roll_number" id="roll_number" class="block w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none transition-all placeholder:text-gray-400" placeholder="e.g. 101" value="<?php echo $data['roll_number'] ?? ''; ?>">
                </div>

                <div>
                    <label for="fees_amount" class="block text-sm font-semibold text-gray-700 mb-2">Fees Amount</label>
                    <input type="number" step="1" name="fees_amount" id="fees_amount" class="block w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none transition-all placeholder:text-gray-400" placeholder="e.g. 1500" value="<?php echo $data['fees_amount'] ?? ''; ?>">
                </div>

                <div>
                    <label for="joining_date" class="block text-sm font-semibold text-gray-700 mb-2">Joining Date</label>
                    <input type="date" name="joining_date" id="joining_date" class="block w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none transition-all text-gray-700" value="<?php echo $data['joining_date'] ?? ''; ?>">
                </div>

                <div>
                    <label for="date_to_pay" class="block text-sm font-semibold text-gray-700 mb-2">Date to Pay</label>
                    <input type="date" name="date_to_pay" id="date_to_pay" class="block w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none transition-all text-gray-700" value="<?php echo $data['date_to_pay'] ?? ''; ?>">
                </div>    <div class="bg-blue-50 p-4 rounded-xl flex gap-3 items-start">
                <i class="fas fa-info-circle text-blue-500 mt-1"></i>
                <p class="text-xs text-blue-700 leading-relaxed font-medium">
                    A unique QR code will be automatically generated upon registration. This QR code will be used for daily attendance tracking.
                </p>
            </div>
            </div>

        

            <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-4 rounded-xl shadow-lg shadow-blue-500/20 transition-all transform hover:-translate-y-0.5 active:scale-[0.98]">
                Complete Registration
            </button>
        </form>
    </div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>
