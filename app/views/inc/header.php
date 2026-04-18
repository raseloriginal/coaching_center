<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo get_setting('site_title', SITENAME); ?></title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            200: '#bfdbfe',
                            300: '#93c5fd',
                            400: '#60a5fa',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            800: '#1e40af',
                            900: '#1e3a8a',
                        }
                    }
                }
            }
        }
    </script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .sidebar-active { background-color: rgba(255, 255, 255, 0.1); border-left: 4px solid #3b82f6; } /* Blue active border */
    </style>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        :root {
            --primary-blue: #3b82f6;
            --primary-glass: rgba(255, 255, 255, 0.7);
            --radius-sharp: 3px;
        }

        /* Global 3px Radius Patch for Admin */
        .rounded-3xl, .rounded-2xl, .rounded-xl, .rounded-lg, .rounded-md, .rounded, .rounded-2xl, .btn-smooth, .glass-card, .grid-menu-item, input, select, textarea, button { 
            border-radius: var(--radius-sharp) !important; 
        }

        html { scroll-behavior: smooth; }
        
        body { 
            font-family: 'Inter', sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /* Top Progress Bar */
        #top-loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 0%;
            height: 3px;
            background: linear-gradient(to right, #3b82f6, #60a5fa, #93c5fd);
            z-index: 10000;
            transition: width 0.3s ease-out, opacity 0.3s ease-in-out;
            box-shadow: 0 0 10px rgba(59, 130, 246, 0.5);
        }

        /* Entry Animations */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(15px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate-fade-up {
            animation: fadeUp 0.5s cubic-bezier(0.4, 0, 0.2, 1) forwards;
        }

        /* Smooth Triggers */
        .btn-smooth {
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .btn-smooth:active {
            transform: scale(0.96);
        }

        /* Glassmorphism Classes */
        .glass-card {
            background: var(--primary-glass);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        /* Sidebar Item Hover */
        .sidebar-item {
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }
        .sidebar-item i {
            transition: transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        .sidebar-item:hover i {
            transform: scale(1.2) rotate(-10deg);
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

        .sidebar-active { background-color: rgba(255, 255, 255, 0.1); border-left: 4px solid #3b82f6; }

        /* Mobile Navigation Styles (Only for mobile to avoid ID specificity issues on desktop) */
        @media (max-width: 767px) {
            #mobile-fab {
                position: fixed;
                bottom: 2rem;
                right: 2rem;
                width: 3.5rem;
                height: 3.5rem;
                border-radius: 9999px;
                background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
                color: white;
                display: flex;
                align-items: center;
                justify-content: center;
                box-shadow: 0 10px 25px -5px rgba(37, 99, 235, 0.5);
                cursor: pointer;
                z-index: 1000;
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            }
            #mobile-fab:active { transform: scale(0.9); }
            #mobile-fab.active { transform: rotate(135deg); background: #ef4444; box-shadow: 0 10px 25px -5px rgba(239, 68, 68, 0.5); }

            #bottom-sheet {
                position: fixed;
                bottom: 0;
                left: 0;
                right: 0;
                background: white;
                border-top-left-radius: 1.5rem;
                border-top-right-radius: 1.5rem;
                z-index: 999;
                transform: translateY(100%);
                transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
                box-shadow: 0 -10px 25px -5px rgba(0, 0, 0, 0.1);
            }
            #bottom-sheet.open { transform: translateY(0); }
            
            #bottom-sheet-overlay {
                position: fixed;
                inset: 0;
                background: rgba(15, 23, 42, 0.4);
                backdrop-filter: blur(4px);
                z-index: 998;
                opacity: 0;
                pointer-events: none;
                transition: opacity 0.3s ease;
            }
            #bottom-sheet-overlay.open { opacity: 1; pointer-events: auto; }
        }

        /* Grid Icons */
        .grid-menu-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.5rem;
            padding: 1rem;
            border-radius: 1rem;
            transition: all 0.2s ease;
        }
        .grid-menu-item:active { background: #f1f5f9; transform: scale(0.95); }
        .grid-menu-item i {
            width: 3rem;
            height: 3rem;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 1rem;
            font-size: 1.25rem;
        }
    </style>

    <script>
        // Global loading bar logic
        window.addEventListener('beforeunload', () => {
            document.getElementById('top-loader').style.width = '70%';
            document.getElementById('top-loader').style.opacity = '1';
        });

        function confirmAction(element, message, event) {
            if (event) event.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
                text: message,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Yes, proceed!'
            }).then((result) => {
                if (result.isConfirmed) {
                    if (element.tagName === 'FORM') {
                        element.submit();
                    } else {
                        // If it's a button, find parent form
                        let form = element.closest('form');
                        if (form) {
                            if (element.name) {
                                let hidden = document.createElement('input');
                                hidden.type = 'hidden';
                                hidden.name = element.name;
                                hidden.value = element.value;
                                form.appendChild(hidden);
                            }
                            form.submit();
                        } else if (element.href) {
                            window.location.href = element.href;
                        }
                    }
                }
            });
            return false;
        }
    </script>
</head>
<body class="bg-gray-50 text-gray-800">
    <div id="top-loader"></div>
    <div class="min-h-screen flex flex-col md:flex-row">
        <?php if(isLoggedIn()) : ?>
            <?php require APPROOT . '/views/inc/sidebar.php'; ?>
        <?php endif; ?>

        <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
            <!-- Top Navigation -->
            <header class="bg-white border-b border-gray-200">
                <div class="px-4 py-4 flex justify-between items-center">
                    <div class="flex items-center gap-4">
                        <?php if(isLoggedIn()) : ?>
                            <!-- <button id="mobile-menu-button" class="md:hidden text-gray-600">
                                <i class="fas fa-bars text-xl"></i>
                            </button> -->
                        <?php endif; ?>
                        <h1 class="text-xl font-bold text-gray-800 tracking-tight">
                            <?php 
                            $site_title = get_setting('site_title', SITENAME);
                            $words = explode(' ', $site_title, 2);
                            if(count($words) > 1): ?>
                                <span class="text-blue-600"><?php echo $words[0]; ?></span> <?php echo $words[1]; ?>
                            <?php else: ?>
                                <span class="text-blue-600"><?php echo $site_title; ?></span>
                            <?php endif; ?>
                        </h1>
                    </div>
                    <?php if(isLoggedIn()) : ?>
                    <div class="flex items-center gap-4">
                        <span class="hidden sm:inline-block text-sm text-gray-500">Welcome, <strong><?php echo $_SESSION['user_name']; ?></strong></span>
                        <a href="<?php echo URLROOT; ?>/users/logout" class="text-sm font-medium text-red-600 hover:text-red-700">
                            <i class="fas fa-sign-out-alt mr-1"></i> Logout
                        </a>
                    </div>
                    <?php endif; ?>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-6">
                <div class="container mx-auto">
                    <?php flash(); ?>
