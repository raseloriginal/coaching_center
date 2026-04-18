<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITENAME; ?></title>
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
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Outfit', sans-serif; scroll-behavior: smooth; }
        .glass-nav { background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); }
    </style>
</head>
<body class="bg-gray-50 text-slate-900">
    <!-- Public Navbar -->
    <nav class="fixed top-0 left-0 right-0 z-50 glass-nav border-b border-gray-100">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <a href="<?php echo URLROOT; ?>" class="text-2xl font-bold tracking-tight">
                <span class="text-blue-600">Coaching</span>Manager
            </a>
            
            <div class="hidden md:flex items-center gap-8">
                <a href="#hero" class="text-sm font-medium hover:text-blue-600 transition-colors">Home</a>
                <a href="#features" class="text-sm font-medium hover:text-blue-600 transition-colors">Features</a>
                <a href="#about" class="text-sm font-medium hover:text-blue-600 transition-colors">About Us</a>
                <a href="<?php echo URLROOT; ?>/users/login" class="bg-blue-600 text-white px-6 py-2.5 rounded-full text-sm font-bold hover:bg-blue-700 hover:shadow-blue-600/30 transition-all shadow-lg shadow-blue-500/20">
                    Admin Portal
                </a>
            </div>

            <button class="md:hidden text-2xl">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </nav>
    <div class="h-20"></div>
