<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4 animate-fade-up">
    <div>
        <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">System Settings</h2>
        <p class="text-slate-500 mt-1">Configure your coaching center and authentication details.</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 animate-fade-up" style="animation-delay: 0.1s;">
    <!-- Navigation Tabs -->
    <div class="lg:col-span-1">
        <div class="bg-white/70 backdrop-blur-xl border border-white/20 rounded-2xl shadow-xl p-4 sticky top-6">
            <nav class="space-y-2" id="settings-tabs">
                <button onclick="switchTab('general')" id="tab-general" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 bg-blue-600 text-white shadow-lg shadow-blue-500/30">
                    <i class="fas fa-cog w-5 text-center"></i>
                    <span class="font-semibold">General Settings</span>
                </button>
                <button onclick="switchTab('auth')" id="tab-auth" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 text-slate-600 hover:bg-slate-100">
                    <i class="fas fa-shield-alt w-5 text-center"></i>
                    <span class="font-semibold">Auth & SMTP</span>
                </button>
                <button onclick="switchTab('appearance')" id="tab-appearance" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 text-slate-600 hover:bg-slate-100">
                    <i class="fas fa-palette w-5 text-center"></i>
                    <span class="font-semibold">Appearance</span>
                </button>
                <button onclick="switchTab('landing')" id="tab-landing" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 text-slate-600 hover:bg-slate-100">
                    <i class="fas fa-home w-5 text-center"></i>
                    <span class="font-semibold">Landing Page</span>
                </button>
            </nav>
            
            <div class="mt-8 p-4 bg-blue-50 rounded-xl border border-blue-100">
                <div class="flex gap-3">
                    <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-info-circle"></i>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-blue-900">Need Help?</h4>
                        <p class="text-xs text-blue-700 mt-1 leading-relaxed">These settings affect the entire system globally.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Content -->
    <div class="lg:col-span-2">
        <form action="<?php echo URLROOT; ?>/settings/update" method="POST" class="space-y-8">
            <!-- General Settings Section -->
            <div id="section-general" class="settings-section transition-all duration-300">
                <div class="bg-white/70 backdrop-blur-xl border border-white/20 rounded-3xl shadow-2xl overflow-hidden">
                    <div class="px-8 py-6 border-b border-slate-100 bg-gradient-to-r from-blue-50 to-transparent">
                        <h3 class="text-xl font-bold text-slate-900 flex items-center gap-2">
                            <i class="fas fa-building text-blue-500"></i>
                            Center Information
                        </h3>
                    </div>
                    <div class="p-8 space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-slate-700 ml-1">Coaching Center Name</label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-blue-500 transition-colors">
                                        <i class="fas fa-university"></i>
                                    </div>
                                    <input type="text" name="site_title" value="<?php echo $data['settings']['site_title'] ?? ''; ?>" 
                                        class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all"
                                        placeholder="Enter coaching name">
                                </div>
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-slate-700 ml-1">Official Email</label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-blue-500 transition-colors">
                                        <i class="fas fa-envelope"></i>
                                    </div>
                                    <input type="email" name="site_email" value="<?php echo $data['settings']['site_email'] ?? ''; ?>" 
                                        class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all"
                                        placeholder="contact@coaching.com">
                                </div>
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-slate-700 ml-1">Contact Phone</label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-blue-500 transition-colors">
                                        <i class="fas fa-phone"></i>
                                    </div>
                                    <input type="text" name="site_phone" value="<?php echo $data['settings']['site_phone'] ?? ''; ?>" 
                                        class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all"
                                        placeholder="+1234567890">
                                </div>
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-slate-700 ml-1">Office Address</label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-blue-500 transition-colors">
                                        <i class="fas fa-map-marker-alt"></i>
                                    </div>
                                    <input type="text" name="site_address" value="<?php echo $data['settings']['site_address'] ?? ''; ?>" 
                                        class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all"
                                        placeholder="Full address">
                                </div>
                            </div>
                        </div>
                        
                        <!-- Portal & Invoice Settings -->
                        <div class="mt-10 pt-8 border-t border-slate-100 grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="space-y-4">
                                <label class="text-sm font-black text-slate-800 uppercase tracking-widest flex items-center gap-2">
                                    <i class="fas fa-door-open text-blue-500"></i>
                                    Student Portal Access
                                </label>
                                <label class="relative inline-flex items-center cursor-pointer group">
                                    <input type="checkbox" name="portal_enabled" value="1" class="sr-only peer" <?php echo ($data['settings']['portal_enabled'] ?? '1') == '1' ? 'checked' : ''; ?>>
                                    <div class="w-14 h-7 bg-slate-200 peer-focus:outline-none ring-0 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-blue-600"></div>
                                    <span class="ml-3 text-sm font-bold text-slate-600 group-hover:text-blue-600 transition-colors">Enable Student/Parent Portal</span>
                                </label>
                                <p class="text-xs text-slate-400 leading-relaxed italic">When disabled, students will not be able to log in to view results or fees.</p>
                            </div>

                            <div class="space-y-4">
                                <label class="text-sm font-black text-slate-800 uppercase tracking-widest flex items-center gap-2">
                                    <i class="fas fa-file-invoice-dollar text-blue-500"></i>
                                    Invoice Footer Note
                                </label>
                                <textarea name="invoice_footer" rows="2" 
                                    class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all font-medium text-slate-600"
                                    placeholder="e.g. Fees once paid are non-refundable."><?php echo $data['settings']['invoice_footer'] ?? ''; ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Auth & SMTP Section (Hidden by default) -->
            <div id="section-auth" class="settings-section hidden transition-all duration-300">
                <div class="bg-white/70 backdrop-blur-xl border border-white/20 rounded-3xl shadow-2xl overflow-hidden">
                    <div class="px-8 py-6 border-b border-slate-100 bg-gradient-to-r from-amber-50 to-transparent">
                        <h3 class="text-xl font-bold text-slate-900 flex items-center gap-2">
                            <i class="fas fa-server text-amber-500"></i>
                            SMTP Server Configuration
                        </h3>
                    </div>
                    <div class="p-8 space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-slate-700 ml-1">SMTP Host</label>
                                <input type="text" name="smtp_host" value="<?php echo $data['settings']['smtp_host'] ?? ''; ?>" 
                                    class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-4 focus:ring-amber-500/10 focus:border-amber-500 outline-none transition-all">
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-slate-700 ml-1">SMTP Port</label>
                                <input type="text" name="smtp_port" value="<?php echo $data['settings']['smtp_port'] ?? '587'; ?>" 
                                    class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-4 focus:ring-amber-500/10 focus:border-amber-500 outline-none transition-all">
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-slate-700 ml-1">SMTP Username</label>
                                <input type="text" name="smtp_user" value="<?php echo $data['settings']['smtp_user'] ?? ''; ?>" 
                                    class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-4 focus:ring-amber-500/10 focus:border-amber-500 outline-none transition-all">
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-slate-700 ml-1">SMTP Password</label>
                                <input type="password" name="smtp_pass" value="<?php echo $data['settings']['smtp_pass'] ?? ''; ?>" 
                                    class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-4 focus:ring-amber-500/10 focus:border-amber-500 outline-none transition-all">
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-slate-700 ml-1">Encryption</label>
                                <select name="smtp_encryption" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-4 focus:ring-amber-500/10 focus:border-amber-500 outline-none transition-all">
                                    <option value="tls" <?php echo ($data['settings']['smtp_encryption'] ?? '') == 'tls' ? 'selected' : ''; ?>>TLS</option>
                                    <option value="ssl" <?php echo ($data['settings']['smtp_encryption'] ?? '') == 'ssl' ? 'selected' : ''; ?>>SSL</option>
                                    <option value="none" <?php echo ($data['settings']['smtp_encryption'] ?? '') == 'none' ? 'selected' : ''; ?>>None</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Appearance Section (Placeholders for now) -->
            <div id="section-appearance" class="settings-section hidden transition-all duration-300">
                <div class="bg-white/70 backdrop-blur-xl border border-white/20 rounded-3xl shadow-2xl overflow-hidden">
                    <div class="px-8 py-6 border-b border-slate-100 bg-gradient-to-r from-purple-50 to-transparent">
                        <h3 class="text-xl font-bold text-slate-900 flex items-center gap-2">
                            <i class="fas fa-palette text-purple-500"></i>
                            Visual Identity
                        </h3>
                    </div>
                    <div class="p-8">
                        <div class="p-12 border-2 border-dashed border-slate-200 rounded-2xl flex flex-col items-center justify-center text-slate-400">
                            <i class="fas fa-images text-5xl mb-4"></i>
                            <p class="font-medium">Logo and theme customization coming soon</p>
                            <p class="text-sm mt-2">Currently using system default blue theme</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Landing Page Section -->
            <div id="section-landing" class="settings-section hidden transition-all duration-300">
                <div class="bg-white/70 backdrop-blur-xl border border-white/20 rounded-3xl shadow-2xl overflow-hidden">
                    <div class="px-8 py-6 border-b border-slate-100 bg-gradient-to-r from-emerald-50 to-transparent">
                        <h3 class="text-xl font-bold text-slate-900 flex items-center gap-2">
                            <i class="fas fa-home text-emerald-500"></i>
                            Public Landing Page Content
                        </h3>
                    </div>
                    <div class="p-8 space-y-6">
                        <div class="space-y-2">
                            <label class="text-sm font-semibold text-slate-700 ml-1">Landing Banner URL</label>
                            <input type="text" name="landing_banner" value="<?php echo $data['settings']['landing_banner'] ?? ''; ?>" 
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none transition-all"
                                placeholder="https://example.com/banner.jpg">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-slate-700 ml-1">Hero Title</label>
                                <input type="text" name="hero_title" value="<?php echo $data['settings']['hero_title'] ?? ''; ?>" 
                                    class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none transition-all">
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-slate-700 ml-1">Hero Subtitle</label>
                                <input type="text" name="hero_subtitle" value="<?php echo $data['settings']['hero_subtitle'] ?? ''; ?>" 
                                    class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none transition-all">
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-slate-700 ml-1">About Us Title</label>
                                <input type="text" name="about_title" value="<?php echo $data['settings']['about_title'] ?? ''; ?>" 
                                    class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none transition-all">
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-slate-700 ml-1">Admission Info Text</label>
                                <input type="text" name="admission_info" value="<?php echo $data['settings']['admission_info'] ?? ''; ?>" 
                                    class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none transition-all">
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="text-sm font-semibold text-slate-700 ml-1">About Us Description</label>
                            <textarea name="about_description" rows="4" 
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none transition-all"
                                placeholder="Describe your coaching center..."><?php echo $data['settings']['about_description'] ?? ''; ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex items-center justify-end gap-4 bg-white/50 backdrop-blur-sm p-6 rounded-3xl border border-white/20 shadow-lg">
                <button type="reset" class="px-6 py-3 text-slate-600 font-semibold hover:text-slate-900 transition-colors">
                    Reset Changes
                </button>
                <button type="submit" class="px-10 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold rounded-xl shadow-xl shadow-blue-500/30 hover:shadow-blue-500/50 hover:scale-[1.02] active:scale-[0.98] transition-all">
                    Save System Settings
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function switchTab(tab) {
    // Hide all sections
    document.querySelectorAll('.settings-section').forEach(section => {
        section.classList.add('hidden');
    });
    
    // Deactivate all buttons
    document.querySelectorAll('#settings-tabs button').forEach(button => {
        button.className = 'w-full flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 text-slate-600 hover:bg-slate-100';
    });
    
    // Show selected section
    const activeSection = document.getElementById('section-' + tab);
    activeSection.classList.remove('hidden');
    activeSection.classList.add('animate-fade-up');
    
    // Activate selected button
    let color = 'blue';
    if(tab === 'auth') color = 'amber';
    if(tab === 'appearance') color = 'purple';
    if(tab === 'landing') color = 'emerald';
    
    const activeBtn = document.getElementById('tab-' + tab);
    activeBtn.className = `w-full flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 bg-${color}-600 text-white shadow-lg shadow-${color}-500/30`;
}
</script>

<?php require APPROOT . '/views/inc/footer.php'; ?>
