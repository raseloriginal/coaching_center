<!-- Sidebar -->
<aside id="sidebar" class="bg-slate-900 border-r border-slate-800 text-slate-300 w-64 flex-shrink-0 hidden md:flex flex-col transition-all duration-300 shadow-xl">
    <div class="px-6 py-8">
        <div class="flex items-center gap-3 px-2 mb-8 group cursor-pointer">
            <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center text-white shadow-lg shadow-blue-500/30 group-hover:shadow-blue-500/50 transition-all">
                <i class="fas fa-graduation-cap text-lg"></i>
            </div>
            <span class="text-xl font-extrabold text-white tracking-widest">ADMIN</span>
        </div>

        <nav class="space-y-1">
            <p class="px-2 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Main Menu</p>
            
            <a href="<?php echo URLROOT; ?>/pages/dashboard" class="sidebar-item flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-slate-800 transition-colors <?php echo (strpos($_GET['url'] ?? '', 'pages/dashboard') !== false || empty($_GET['url'])) ? 'sidebar-active text-white' : ''; ?>">
                <i class="fas fa-chart-line w-5"></i>
                <span>Dashboard</span>
            </a>

            <a href="<?php echo URLROOT; ?>/batches" class="sidebar-item flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-slate-800 transition-colors <?php echo (strpos($_GET['url'] ?? '', 'batches') !== false) ? 'sidebar-active text-white' : ''; ?>">
                <i class="fas fa-layer-group w-5"></i>
                <span>Batches</span>
            </a>

            <a href="<?php echo URLROOT; ?>/students" class="sidebar-item flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-slate-800 transition-colors <?php echo (strpos($_GET['url'] ?? '', 'students') !== false) ? 'sidebar-active text-white' : ''; ?>">
                <i class="fas fa-user-graduate w-5"></i>
                <span>Students</span>
            </a>

            <a href="<?php echo URLROOT; ?>/teachers" class="sidebar-item flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-slate-800 transition-colors <?php echo (strpos($_GET['url'] ?? '', 'teachers') !== false) ? 'sidebar-active text-white' : ''; ?>">
                <i class="fas fa-chalkboard-teacher w-5"></i>
                <span>Teachers</span>
            </a>

            <a href="<?php echo URLROOT; ?>/subjects" class="sidebar-item flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-slate-800 transition-colors <?php echo (strpos($_GET['url'] ?? '', 'subjects') !== false) ? 'sidebar-active text-white' : ''; ?>">
                <i class="fas fa-book w-5"></i>
                <span>Subjects</span>
            </a>

            <a href="<?php echo URLROOT; ?>/exams" class="sidebar-item flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-slate-800 transition-colors <?php echo (strpos($_GET['url'] ?? '', 'exams') !== false && strpos($_GET['url'] ?? '', 'analytics') === false) ? 'sidebar-active text-white' : ''; ?>">
                <i class="fas fa-poll w-5 text-emerald-400"></i>
                <span class="text-emerald-400 font-semibold tracking-wide">Exams & Results</span>
            </a>

            <a href="<?php echo URLROOT; ?>/exams/analytics" class="sidebar-item flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-slate-800 transition-colors <?php echo (strpos($_GET['url'] ?? '', 'exams/analytics') !== false) ? 'sidebar-active text-white' : ''; ?>">
                <i class="fas fa-chart-bar w-5 text-emerald-400"></i>
                <span class="text-emerald-400 font-semibold tracking-wide">Academic Analytics</span>
            </a>

            <div class="pt-4 pb-2 border-t border-slate-800 mt-4">
                <p class="px-2 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Finance & Tools</p>
            </div>

            <a href="<?php echo URLROOT; ?>/finance/dashboard" class="sidebar-item flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-slate-800 transition-colors <?php echo (strpos($_GET['url'] ?? '', 'finance/dashboard') !== false) ? 'sidebar-active text-white' : ''; ?>">
                <i class="fas fa-tachometer-alt w-5 text-blue-400"></i>
                <span class="text-blue-400 font-semibold tracking-wide">Financial Analytics</span>
            </a>

            <a href="<?php echo URLROOT; ?>/finance/fees" class="sidebar-item flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-slate-800 transition-colors <?php echo (strpos($_GET['url'] ?? '', 'finance/fees') !== false) ? 'sidebar-active text-white' : ''; ?>">
                <i class="fas fa-file-invoice-dollar w-5"></i>
                <span>Student Fees</span>
            </a>

            <a href="<?php echo URLROOT; ?>/finance/payments" class="sidebar-item flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-slate-800 transition-colors <?php echo (strpos($_GET['url'] ?? '', 'finance/payments') !== false) ? 'sidebar-active text-white' : ''; ?>">
                <i class="fas fa-hand-holding-usd w-5"></i>
                <span>Teacher Pays</span>
            </a>

            <a href="<?php echo URLROOT; ?>/finance/expenses" class="sidebar-item flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-slate-800 transition-colors <?php echo (strpos($_GET['url'] ?? '', 'finance/expenses') !== false) ? 'sidebar-active text-white' : ''; ?>">
                <i class="fas fa-wallet w-5"></i>
                <span>Expenses</span>
            </a>

            <a href="<?php echo URLROOT; ?>/attendance/scan" target="_blank" class="sidebar-item flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-slate-800 transition-colors mt-2">
                <i class="fas fa-qrcode w-5 text-sky-400"></i>
                <span class="text-sky-400 font-semibold tracking-wide">QR Scanner</span>
            </a>

            <div class="pt-4 pb-2 border-t border-slate-800 mt-4">
                <p class="px-2 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Web Content</p>
            </div>

            <a href="<?php echo URLROOT; ?>" target="_blank" class="sidebar-item flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-slate-800 transition-colors">
                <i class="fas fa-external-link-alt w-5 text-emerald-400"></i>
                <span class="text-emerald-400 font-semibold tracking-wide">View Website</span>
            </a>

            <a href="<?php echo URLROOT; ?>/notices" class="sidebar-item flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-slate-800 transition-colors <?php echo (strpos($_GET['url'] ?? '', 'notices') !== false) ? 'sidebar-active text-white' : ''; ?>">
                <i class="fas fa-bullhorn w-5 text-amber-400"></i>
                <span class="text-amber-400 font-semibold tracking-wide">Notice Board</span>
            </a>

            <a href="<?php echo URLROOT; ?>/landingpages" class="sidebar-item flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-slate-800 transition-colors <?php echo (strpos($_GET['url'] ?? '', 'landingpages') !== false) ? 'sidebar-active text-white' : ''; ?>">
                <i class="fas fa-magic w-5 text-purple-400"></i>
                <span class="text-purple-400 font-semibold tracking-wide">Landing Manager</span>
            </a>

            <div class="pt-4 pb-2 border-t border-slate-800 mt-4">
                <p class="px-2 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">System</p>
            </div>

            <?php if(isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'super_admin') : ?>
            <a href="<?php echo URLROOT; ?>/users/manage" class="sidebar-item flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-slate-800 transition-colors <?php echo (strpos($_GET['url'] ?? '', 'users/manage') !== false) ? 'sidebar-active text-white' : ''; ?>">
                <i class="fas fa-users-cog w-5 text-indigo-400"></i>
                <span class="text-indigo-400 font-semibold tracking-wide">User Management</span>
            </a>

            <a href="<?php echo URLROOT; ?>/pages/audit_logs" class="sidebar-item flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-slate-800 transition-colors <?php echo (strpos($_GET['url'] ?? '', 'pages/audit_logs') !== false) ? 'sidebar-active text-white' : ''; ?>">
                <i class="fas fa-fingerprint w-5 text-rose-400"></i>
                <span class="text-rose-400 font-semibold tracking-wide">Security Logs</span>
            </a>
            <?php endif; ?>

            <a href="<?php echo URLROOT; ?>/settings" class="sidebar-item flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-slate-800 transition-colors <?php echo (strpos($_GET['url'] ?? '', 'settings') !== false) ? 'sidebar-active text-white' : ''; ?>">
                <i class="fas fa-cog w-5 text-slate-400 group-hover:rotate-90 transition-transform"></i>
                <span>Settings</span>
            </a>
        </nav>
    </div>
</aside>
