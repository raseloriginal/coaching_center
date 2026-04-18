<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="min-h-[80vh] flex items-center justify-center">
    <div class="max-w-md w-full mx-auto p-4">
        <div class="bg-white p-10 rounded-2xl shadow-2xl shadow-blue-900/5 border border-gray-50">
            <div class="text-center mb-10">
                <div class="w-20 h-20 bg-blue-50 rounded-full flex items-center justify-center text-blue-600 mx-auto mb-6 shadow-inner">
                    <i class="fas fa-lock text-3xl"></i>
                </div>
                <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Admin Login</h2>
                <p class="text-gray-500 text-sm mt-2">Access the coaching management panel</p>
            </div>
    
            <form action="<?php echo URLROOT; ?>/users/login" method="post" class="space-y-6">
                <div>
                <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-gray-400">
                        <i class="fas fa-envelope"></i>
                    </span>
                    <input type="email" name="email" id="email" 
                           class="block w-full pl-11 pr-4 py-3.5 border bg-gray-50/50 hover:bg-white <?php echo (!empty($data['email_err'])) ? 'border-red-500 bg-red-50' : 'border-gray-200'; ?> rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500 transition-all text-gray-800"
                           placeholder="admin@example.com" value="<?php echo $data['email']; ?>">
                </div>
                <span class="text-xs text-red-500 mt-1.5 font-medium inline-block"><?php echo $data['email_err']; ?></span>
            </div>

            <div>
                <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-gray-400">
                        <i class="fas fa-key"></i>
                    </span>
                    <input type="password" name="password" id="password" 
                           class="block w-full pl-11 pr-4 py-3.5 border bg-gray-50/50 hover:bg-white <?php echo (!empty($data['password_err'])) ? 'border-red-500 bg-red-50' : 'border-gray-200'; ?> rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500 transition-all text-gray-800"
                           placeholder="••••••••" value="<?php echo $data['password']; ?>">
                </div>
                <span class="text-xs text-red-500 mt-1.5 font-medium inline-block"><?php echo $data['password_err']; ?></span>
            </div>

            <div>
                <button type="submit" 
                        class="w-full flex justify-center py-4 px-4 border border-transparent rounded-xl shadow-lg shadow-blue-600/20 text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all transform hover:-translate-y-0.5 mt-2">
                    Sign In to Dashboard
                </button>
            </div>
        </form>

        <div class="mt-8 pt-6 border-t border-gray-100 text-center">
            <p class="text-xs text-gray-400 leading-relaxed">
                Authorized Personnel Only. <br>
                Use <strong>admin@example.com</strong> / <strong>admin123</strong>
            </p>
        </div>
    </div>
</div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>
