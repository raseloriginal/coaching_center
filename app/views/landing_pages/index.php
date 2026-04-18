<?php require APPROOT . '/views/inc/header.php'; ?>

<!-- Header -->
<header class="flex justify-between items-center mb-10 animate-fade-up">
    <div>
        <h1 class="text-3xl font-bold text-slate-900 tracking-tight">Landing Page Manager</h1>
        <p class="text-slate-500 mt-1">Customize your public website content and appearance.</p>
    </div>
    <div class="flex gap-3">
        <a href="<?php echo URLROOT; ?>" target="_blank" class="flex items-center gap-2 px-4 py-2 bg-white border border-slate-200 text-slate-700 rounded-lg hover:bg-slate-50 transition-all font-medium shadow-sm">
            <i class="fas fa-external-link-alt text-sm"></i>
            <span>Preview Site</span>
        </a>
    </div>
</header>

<?php echo flash('landing_message'); ?>

<!-- Tabs -->
<div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden animate-fade-up" style="animation-delay: 0.1s;">
    <div class="border-b border-slate-200 bg-slate-50/50 px-6">
        <nav class="flex gap-8" id="landing-tabs">
            <button onclick="switchTab('general')" class="tab-btn py-4 px-2 border-b-2 border-transparent text-sm font-semibold text-slate-500 hover:text-slate-700 transition-all focus:outline-none active-tab" data-tab="general">
                General & Hero
            </button>
            <button onclick="switchTab('mentors')" class="tab-btn py-4 px-2 border-b-2 border-transparent text-sm font-semibold text-slate-500 hover:text-slate-700 transition-all focus:outline-none" data-tab="mentors">
                Expert Mentors
            </button>
            <button onclick="switchTab('programs')" class="tab-btn py-4 px-2 border-b-2 border-transparent text-sm font-semibold text-slate-500 hover:text-slate-700 transition-all focus:outline-none" data-tab="programs">
                Academic Programs
            </button>
            <button onclick="switchTab('testimonials')" class="tab-btn py-4 px-2 border-b-2 border-transparent text-sm font-semibold text-slate-500 hover:text-slate-700 transition-all focus:outline-none" data-tab="testimonials">
                Success Stories
            </button>
        </nav>
    </div>

    <div class="p-8">
        <!-- Tab: General -->
        <div id="tab-general" class="tab-content">
            <form action="<?php echo URLROOT; ?>/landingpages/update_settings" method="POST">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
                    <!-- Hero Section -->
                    <div class="space-y-6">
                        <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                            <i class="fas fa-rocket text-blue-500"></i>
                            <span>Hero Section</span>
                        </h3>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Main Title</label>
                            <input type="text" name="hero_title" value="<?php echo $data['settings']['hero_title'] ?? ''; ?>" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Subtitle / Tagline</label>
                            <textarea name="hero_subtitle" rows="3" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all"><?php echo $data['settings']['hero_subtitle'] ?? ''; ?></textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Background Banner URL</label>
                            <input type="text" name="landing_banner" value="<?php echo $data['settings']['landing_banner'] ?? ''; ?>" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all" placeholder="https://unsplash.com/...">
                        </div>
                    </div>

                    <!-- About & Principal -->
                    <div class="space-y-6">
                        <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                            <i class="fas fa-info-circle text-emerald-500"></i>
                            <span>About & Wisdom</span>
                        </h3>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">About Section Title</label>
                            <input type="text" name="about_title" value="<?php echo $data['settings']['about_title'] ?? ''; ?>" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">About Description</label>
                            <textarea name="about_description" rows="3" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all"><?php echo $data['settings']['about_description'] ?? ''; ?></textarea>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Principal Name</label>
                                <input type="text" name="principal_name" value="<?php echo $data['settings']['principal_name'] ?? ''; ?>" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Principal Image URL</label>
                                <input type="text" name="principal_image" value="<?php echo $data['settings']['principal_image'] ?? ''; ?>" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Principal's Quote</label>
                            <textarea name="principal_quote" rows="2" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all"><?php echo $data['settings']['principal_quote'] ?? ''; ?></textarea>
                        </div>
                    </div>
                </div>
                <div class="mt-10 pt-6 border-t border-slate-100 flex justify-end">
                    <button type="submit" class="px-8 py-3 bg-blue-600 text-white rounded-xl font-bold hover:bg-blue-700 shadow-lg shadow-blue-500/30 transition-all flex items-center gap-2">
                        <i class="fas fa-save"></i>
                        <span>Save General Changes</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Tab: Mentors -->
        <div id="tab-mentors" class="tab-content hidden">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-bold text-slate-800">Manage Expert Mentors</h3>
                <button onclick="toggleModal('modal-mentor')" class="px-4 py-2 bg-purple-600 text-white rounded-lg font-bold hover:bg-purple-700 transition-all flex items-center gap-2">
                    <i class="fas fa-plus"></i>
                    <span>Add New Mentor</span>
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                <?php foreach($data['mentors'] as $mentor): ?>
                <div class="bg-white border border-slate-200 rounded-xl overflow-hidden group hover:shadow-md transition-all">
                    <div class="flex gap-4 p-4">
                        <div class="w-20 h-20 rounded-lg overflow-hidden shrink-0 border border-slate-100">
                            <img src="<?php echo $mentor->image; ?>" class="w-full h-full object-cover">
                        </div>
                        <div class="flex-1 min-w-0">
                            <h4 class="text-lg font-bold text-slate-900 truncate"><?php echo $mentor->name; ?></h4>
                            <p class="text-sm text-purple-600 font-bold"><?php echo $mentor->role; ?></p>
                            <p class="text-xs text-slate-500 mt-1 italic truncate"><?php echo $mentor->credentials; ?></p>
                        </div>
                    </div>
                    <div class="px-4 py-3 bg-slate-50 border-t border-slate-100 flex justify-between items-center">
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Order: <?php echo $mentor->sort_order; ?></span>
                        <div class="flex gap-2">
                            <a href="<?php echo URLROOT; ?>/landingpages/mentor_delete/<?php echo $mentor->id; ?>" class="text-slate-400 hover:text-red-500 transition" onclick="return confirm('Remove this mentor?')"><i class="fas fa-trash"></i></a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Tab: Programs -->
        <div id="tab-programs" class="tab-content hidden">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-bold text-slate-800">Academic Programs</h3>
                <button onclick="toggleModal('modal-program')" class="px-4 py-2 bg-emerald-600 text-white rounded-lg font-bold hover:bg-emerald-700 transition-all flex items-center gap-2">
                    <i class="fas fa-plus"></i>
                    <span>Add Program</span>
                </button>
            </div>

            <div class="space-y-4">
                <?php foreach($data['programs'] as $program): ?>
                <div class="bg-white border border-slate-200 rounded-xl p-6 flex gap-6 items-center">
                    <div class="w-32 h-20 rounded-lg overflow-hidden shrink-0 bg-slate-100 border border-slate-100">
                        <img src="<?php echo $program->image; ?>" class="w-full h-full object-cover">
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-1">
                            <h4 class="text-lg font-bold text-slate-900"><?php echo $program->title; ?></h4>
                            <?php if($program->is_trending): ?>
                                <span class="px-2 py-0.5 bg-amber-100 text-amber-700 text-[10px] font-black rounded uppercase">Trending</span>
                            <?php endif; ?>
                        </div>
                        <p class="text-sm text-slate-500 line-clamp-1"><?php echo $program->description; ?></p>
                    </div>
                    <div class="flex gap-3">
                        <a href="<?php echo URLROOT; ?>/landingpages/program_delete/<?php echo $program->id; ?>" class="w-10 h-10 flex items-center justify-center text-slate-400 hover:text-red-500 bg-slate-50 rounded-lg border border-slate-100 transition-all" onclick="return confirm('Delete this program?')">
                            <i class="fas fa-trash"></i>
                        </a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Tab: Testimonials -->
        <div id="tab-testimonials" class="tab-content hidden">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-bold text-slate-800">Success Stories</h3>
                <button onclick="toggleModal('modal-testimonial')" class="px-4 py-2 bg-blue-600 text-white rounded-lg font-bold hover:bg-blue-700 transition-all flex items-center gap-2">
                    <i class="fas fa-plus"></i>
                    <span>Add Success Story</span>
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <?php foreach($data['testimonials'] as $test): ?>
                <div class="bg-white border border-slate-100 shadow-sm rounded-xl p-6 relative group">
                    <p class="text-slate-600 italic mb-6">"<?php echo $test->content; ?>"</p>
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full bg-slate-100 overflow-hidden border border-slate-200">
                            <img src="<?php echo $test->image ?: 'https://i.pravatar.cc/150?u='.$test->id; ?>" class="w-full h-full object-cover">
                        </div>
                        <div>
                            <h5 class="font-bold text-slate-900"><?php echo $test->name; ?></h5>
                            <p class="text-xs text-slate-500 uppercase font-black tracking-widest"><?php echo $test->credentials; ?></p>
                        </div>
                    </div>
                    <a href="<?php echo URLROOT; ?>/landingpages/testimonial_delete/<?php echo $test->id; ?>" class="absolute top-4 right-4 text-slate-300 hover:text-red-500 transition opacity-0 group-hover:opacity-100" onclick="return confirm('Remove story?')">
                        <i class="fas fa-times-circle text-xl"></i>
                    </a>
                </div>
                <?php endforeach; ?>
        </div>
    </div>

<!-- Modal: Add Mentor -->
<div id="modal-mentor" class="fixed inset-0 z-50 hidden overflow-y-auto" style="display: none;">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="toggleModal('modal-mentor')"></div>
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-xl relative overflow-hidden">
            <div class="bg-slate-50 px-8 py-6 border-b border-slate-100">
                <h3 class="text-xl font-bold text-slate-800">Add New Mentor</h3>
            </div>
            <form action="<?php echo URLROOT; ?>/landingpages/mentor_add" method="POST" class="p-8 space-y-5">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-1">Full Name</label>
                        <input type="text" name="name" required class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-lg">
                    </div>
                    <div>
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-1">Role/Subject</label>
                        <input type="text" name="role" required class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-lg">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-1">Credentials (University/Degree)</label>
                    <input type="text" name="credentials" class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-lg">
                </div>
                <div>
                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-1">Image URL</label>
                    <input type="text" name="image" class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-lg">
                </div>
                <div class="grid grid-cols-3 gap-4">
                    <div class="col-span-1">
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-1">Order Index</label>
                        <input type="number" name="sort_order" text="0" class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-lg">
                    </div>
                    <div class="col-span-1">
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-1">Facebook</label>
                        <input type="text" name="social_fb" class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-lg">
                    </div>
                    <div class="col-span-1">
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-1">WhatsApp</label>
                        <input type="text" name="social_wa" class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-lg">
                    </div>
                </div>
                <div class="pt-4 flex justify-end gap-3">
                    <button type="button" onclick="toggleModal('modal-mentor')" class="px-6 py-2 text-slate-600 font-bold">Cancel</button>
                    <button type="submit" class="px-6 py-2 bg-purple-600 text-white rounded-lg font-bold shadow-lg shadow-purple-500/30">Save Mentor</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Similar Modals for Program and Testimonial would go here -->
<!-- Modal: Add Program -->
<div id="modal-program" class="fixed inset-0 z-50 hidden overflow-y-auto" style="display: none;">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="toggleModal('modal-program')"></div>
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-xl relative overflow-hidden">
            <div class="bg-slate-50 px-8 py-6 border-b border-slate-100">
                <h3 class="text-xl font-bold text-slate-800">Add Academic Program</h3>
            </div>
            <form action="<?php echo URLROOT; ?>/landingpages/program_add" method="POST" class="p-8 space-y-5">
                <div>
                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-1">Program Title</label>
                    <input type="text" name="title" required class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-lg">
                </div>
                <div>
                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-1">Short Description</label>
                    <textarea name="description" rows="2" class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-lg"></textarea>
                </div>
                <div>
                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-1">Features (Comma separated)</label>
                    <input type="text" name="features" placeholder="Math, Physics, Weekly Exam" class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-lg">
                </div>
                <div class="grid grid-cols-2 gap-4">
                   <div>
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-1">Image URL</label>
                        <input type="text" name="image" class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-lg">
                    </div>
                    <div>
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-1">Sort Order</label>
                        <input type="number" name="sort_order" value="0" class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-lg">
                    </div>
                </div>
                <div class="flex items-center gap-2 pt-2">
                    <input type="checkbox" name="is_trending" id="chk-trending" class="w-4 h-4 text-emerald-600 rounded border-slate-300">
                    <label for="chk-trending" class="text-sm font-bold text-slate-700">Mark as Trending (Featured)</label>
                </div>
                <div class="pt-4 flex justify-end gap-3">
                    <button type="button" onclick="toggleModal('modal-program')" class="px-6 py-2 text-slate-600 font-bold">Cancel</button>
                    <button type="submit" class="px-6 py-2 bg-emerald-600 text-white rounded-lg font-bold shadow-lg shadow-emerald-500/30">Save Program</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal: Add Testimonial -->
<!-- Modal: Add Testimonial -->
<div id="modal-testimonial" class="fixed inset-0 z-50 hidden overflow-y-auto" style="display: none;">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="toggleModal('modal-testimonial')"></div>
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-xl relative overflow-hidden">
            <div class="bg-slate-50 px-8 py-6 border-b border-slate-100">
                <h3 class="text-xl font-bold text-slate-800">Add Success Story</h3>
            </div>
            <form action="<?php echo URLROOT; ?>/landingpages/testimonial_add" method="POST" class="p-8 space-y-5">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-1">Student Name</label>
                        <input type="text" name="name" required class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-lg">
                    </div>
                    <div>
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-1">Credentials (Batch/Success)</label>
                        <input type="text" name="credentials" placeholder="Batch 2024, BUET" class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-lg">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-1">The Story / Quote</label>
                    <textarea name="content" rows="4" required class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-lg"></textarea>
                </div>
                <div>
                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-1">Image URL</label>
                    <input type="text" name="image" class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-lg">
                </div>
                <div class="pt-4 flex justify-end gap-3">
                    <button type="button" onclick="toggleModal('modal-testimonial')" class="px-6 py-2 text-slate-600 font-bold">Cancel</button>
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg font-bold shadow-lg shadow-blue-500/30">Save Story</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function switchTab(tabId) {
        // Update tab buttons
        document.querySelectorAll('.tab-btn').forEach(btn => {
            if (btn.getAttribute('data-tab') === tabId) {
                btn.classList.add('border-blue-600', 'text-blue-600');
                btn.classList.remove('border-transparent', 'text-slate-500');
            } else {
                btn.classList.remove('border-blue-600', 'text-blue-600');
                btn.classList.add('border-transparent', 'text-slate-500');
            }
        });

        // Update tab contents
        document.querySelectorAll('.tab-content').forEach(content => {
            if (content.id === 'tab-' + tabId) {
                content.classList.remove('hidden');
            } else {
                content.classList.add('hidden');
            }
        });

        // Update URL hash without scroll
        window.history.replaceState(null, null, '?tab=' + tabId);
    }

    function toggleModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal.style.display === 'none' || modal.classList.contains('hidden')) {
            modal.style.display = 'block';
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        } else {
            modal.style.display = 'none';
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
    }

    // Check URL for active tab
    const urlParams = new URLSearchParams(window.location.search);
    const activeTab = urlParams.get('tab');
    if (activeTab) {
        switchTab(activeTab);
    } else {
        switchTab('general');
    }
</script>

<?php require APPROOT . '/views/inc/footer.php'; ?>
