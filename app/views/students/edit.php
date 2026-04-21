<?php require APPROOT . '/views/inc/header.php'; ?>
<div class=" mx-auto">
    <a href="<?php echo URLROOT; ?>/students" class="text-gray-500 hover:text-gray-800 flex items-center mb-6 transition-colors">
        <i class="fas fa-chevron-left mr-2"></i> Back to Student Directory
    </a>

    <div class="bg-white p-8 rounded-2xl shadow-lg border border-gray-100">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Edit Student Information</h2>
        
        <form action="<?php echo URLROOT; ?>/students/edit/<?php echo $data['id']; ?>" method="POST" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                 <div>
                <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Student Full Name</label>
                <input type="text" name="name" id="name" class="block w-full px-4 py-3 border <?php echo (!empty($data['name_err'])) ? 'border-red-500' : 'border-gray-300'; ?> rounded-xl focus:ring-2 focus:ring-blue-500 outline-none transition-all" value="<?php echo $data['name']; ?>">
                <span class="text-xs text-red-500"><?php echo $data['name_err']; ?></span>
            </div>

            <div>
                <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">Contact Phone</label>
                <input type="text" name="phone" id="phone" class="block w-full px-4 py-3 border <?php echo (!empty($data['phone_err'])) ? 'border-red-500' : 'border-gray-300'; ?> rounded-xl focus:ring-2 focus:ring-blue-500 outline-none transition-all" value="<?php echo $data['phone']; ?>">
                <span class="text-xs text-red-500"><?php echo $data['phone_err']; ?></span>
            </div>

              </div>
       
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="father_name" class="block text-sm font-semibold text-gray-700 mb-2">Father's Name</label>
                    <input type="text" name="father_name" id="father_name" class="block w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none transition-all" value="<?php echo $data['father_name'] ?? ''; ?>">
                </div>

                <div>
                    <label for="roll_number" class="block text-sm font-semibold text-gray-700 mb-2">Roll Number</label>
                    <input type="text" name="roll_number" id="roll_number" class="block w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none transition-all" value="<?php echo $data['roll_number'] ?? ''; ?>">
                </div>

                <div>
                    <label for="fees_amount" class="block text-sm font-semibold text-gray-700 mb-2">Fees Amount</label>
                    <input type="number" step="1" name="fees_amount" id="fees_amount" class="block w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none transition-all" value="<?php echo $data['fees_amount'] ?? ''; ?>">
                </div>

                <div>
                    <label for="joining_date" class="block text-sm font-semibold text-gray-700 mb-2">Joining Date</label>
                    <input type="date" name="joining_date" id="joining_date" class="block w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none transition-all text-gray-700" value="<?php echo $data['joining_date'] ?? ''; ?>">
                </div>


                 <div>
                <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">Account Status</label>
                <select name="status" id="status" class="block w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none transition-all">
                    <option value="active" <?php echo ($data['status'] == 'active') ? 'selected' : ''; ?>>Active</option>
                    <option value="completed" <?php echo ($data['status'] == 'completed') ? 'selected' : ''; ?>>Completed</option>
                    <option value="cancelled" <?php echo ($data['status'] == 'cancelled') ? 'selected' : ''; ?>>Cancelled</option>
                </select>
            </div>
            </div>

          

            <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-4 rounded-xl shadow-md transition-all">
                Update Student Record
            </button>
        </form>
    </div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>
