                </div> <!-- End of container -->
            </main>

            <footer class="bg-white border-t border-gray-100 py-6 px-6 text-center text-sm font-medium text-gray-400 shadow-inner">
                &copy; <?php echo date('Y'); ?> <span class="text-blue-600 font-bold"><?php echo SITENAME; ?></span>. All rights reserved.
            </footer>
        </div>
    </div>

    <?php if(isLoggedIn()) : ?>
    <!-- Mobile Navigation Components -->
    <div id="bottom-sheet-overlay" class="md:hidden"></div>
    
    <div id="bottom-sheet" class="md:hidden">
        <div class="w-12 h-1.5 bg-gray-300 rounded-full mx-auto my-3"></div>
        <div class="px-6 pb-12">
            <h3 class="text-lg font-bold text-gray-800 mb-6 text-center">Menu</h3>
            <div class="grid grid-cols-3 gap-4">
                <a href="<?php echo URLROOT; ?>/pages/dashboard" class="grid-menu-item">
                    <i class="fas fa-chart-line bg-blue-100 text-blue-600"></i>
                    <span class="text-xs font-semibold text-gray-600">Dashboard</span>
                </a>
                <a href="<?php echo URLROOT; ?>/batches" class="grid-menu-item">
                    <i class="fas fa-layer-group bg-indigo-100 text-indigo-600"></i>
                    <span class="text-xs font-semibold text-gray-600">Batches</span>
                </a>
                <a href="<?php echo URLROOT; ?>/students" class="grid-menu-item">
                    <i class="fas fa-user-graduate bg-emerald-100 text-emerald-600"></i>
                    <span class="text-xs font-semibold text-gray-600">Students</span>
                </a>
                <a href="<?php echo URLROOT; ?>/teachers" class="grid-menu-item">
                    <i class="fas fa-chalkboard-teacher bg-amber-100 text-amber-600"></i>
                    <span class="text-xs font-semibold text-gray-600">Teachers</span>
                </a>
                <a href="<?php echo URLROOT; ?>/subjects" class="grid-menu-item">
                    <i class="fas fa-book bg-purple-100 text-purple-600"></i>
                    <span class="text-xs font-semibold text-gray-600">Subjects</span>
                </a>
                <a href="<?php echo URLROOT; ?>/exams" class="grid-menu-item">
                    <i class="fas fa-poll bg-pink-100 text-pink-600"></i>
                    <span class="text-xs font-semibold text-gray-600">Exams</span>
                </a>
                <a href="<?php echo URLROOT; ?>/finance/fees" class="grid-menu-item">
                    <i class="fas fa-file-invoice-dollar bg-cyan-100 text-cyan-600"></i>
                    <span class="text-xs font-semibold text-gray-600">Fees</span>
                </a>
                <a href="<?php echo URLROOT; ?>/finance/payments" class="grid-menu-item">
                    <i class="fas fa-hand-holding-usd bg-orange-100 text-orange-600"></i>
                    <span class="text-xs font-semibold text-gray-600">Payments</span>
                </a>
                <a href="<?php echo URLROOT; ?>/finance/expenses" class="grid-menu-item">
                    <i class="fas fa-wallet bg-rose-100 text-rose-600"></i>
                    <span class="text-xs font-semibold text-gray-600">Expenses</span>
                </a>
                <a href="<?php echo URLROOT; ?>/attendance/scan" target="_blank" class="grid-menu-item">
                    <i class="fas fa-qrcode bg-sky-100 text-sky-600"></i>
                    <span class="text-xs font-semibold text-gray-600">Scanner</span>
                </a>
            </div>
        </div>
    </div>

    <button id="mobile-fab" class="md:hidden" aria-label="Toggle Menu">
        <i class="fas fa-th-large text-xl"></i>
    </button>
    <?php endif; ?>

    <script>
        // Progress Bar Logic
        const topLoader = document.getElementById('top-loader');
        
        // Complete progress on load
        window.addEventListener('load', () => {
            if(topLoader) {
                topLoader.style.width = '100%';
                setTimeout(() => {
                    topLoader.style.opacity = '0';
                    setTimeout(() => {
                        topLoader.style.width = '0%';
                    }, 300);
                }, 200);
            }
        });

        // Trigger loader on link clicks
        document.querySelectorAll('a').forEach(link => {
            if (link.hostname === window.location.hostname && !link.hash && !link.target) {
                link.addEventListener('click', (e) => {
                    if (topLoader) {
                        topLoader.style.opacity = '1';
                        topLoader.style.width = '40%';
                    }
                });
            }
        });

        // Form Submit Feedback (Trigger Smoothness)
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', (e) => {
                const submitBtn = form.querySelector('button[type="submit"], input[type="submit"]');
                if (submitBtn) {
                    const originalText = submitBtn.innerHTML || submitBtn.value;
                    const isInput = submitBtn.tagName === 'INPUT';
                    
                    // Simple loading state
                    if (isInput) {
                        submitBtn.value = 'Processing...';
                    } else {
                        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Processing...';
                    }
                    submitBtn.classList.add('opacity-75', 'cursor-not-allowed');
                    submitBtn.disabled = true;

                    // Support for hidden field injection if needed (like in confirmAction)
                    setTimeout(() => {
                         if (submitBtn.disabled) submitBtn.disabled = false; // Failsafe
                    }, 10000);
                }

                if (topLoader) {
                    topLoader.style.opacity = '1';
                    topLoader.style.width = '60%';
                }
            });
        });

        // Mobile Sheet Toggle
        const fab = document.getElementById('mobile-fab');
        const sheet = document.getElementById('bottom-sheet');
        const overlay = document.getElementById('bottom-sheet-overlay');

        if(fab && sheet && overlay) {
            const toggleMenu = () => {
                fab.classList.toggle('active');
                sheet.classList.toggle('open');
                overlay.classList.toggle('open');
                
                // Toggle icon
                const icon = fab.querySelector('i');
                if (sheet.classList.contains('open')) {
                    icon.classList.replace('fa-th-large', 'fa-times');
                } else {
                    icon.classList.replace('fa-times', 'fa-th-large');
                }
            };

            fab.addEventListener('click', toggleMenu);
            overlay.addEventListener('click', toggleMenu);
            
            // Close on link click
            sheet.querySelectorAll('a').forEach(link => {
                link.addEventListener('click', () => {
                    if (sheet.classList.contains('open')) toggleMenu();
                });
            });
        }

        // Add class to all main containers for entry animation
        document.querySelectorAll('main > .container').forEach(el => {
            el.classList.add('animate-fade-up');
        });

        // Modal Portal Logic: Move fixed modals to body to escape stacking contexts
        document.addEventListener('DOMContentLoaded', () => {
            // Target all full-screen fixed elements (modals)
            const portals = document.querySelectorAll('.fixed.inset-0');
            portals.forEach(portal => {
                document.body.appendChild(portal);
            });
        });
    </script>
</body>
</html>
