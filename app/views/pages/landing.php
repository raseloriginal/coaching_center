<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $data['settings']['site_title'] ?? 'Coaching Center'; ?> - Welcome</title>
    <!-- Tailwind CSS with custom configuration -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'bd-green': '#006a4e',
                        'bd-red': '#f42a41',
                    },
                    borderRadius: {
                        'custom': '3px',
                    },
                    animation: {
                        'marquee': 'marquee 25s linear infinite',
                    },
                    keyframes: {
                        marquee: {
                            '0%': { transform: 'translateX(0)' },
                            '100%': { transform: 'translateX(-100%)' },
                        }
                    }
                }
            }
        }
    </script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .rounded-3xl, .rounded-2xl, .rounded-xl, .rounded-lg, .rounded-md, .rounded { 
            border-radius: 3px !important; 
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-900">

    <!-- Top Bar -->
    <div class="bg-bd-green text-white py-2 hidden md:block">
        <div class="container mx-auto px-4 flex justify-between items-center text-sm">
            <div class="flex items-center space-x-6">
                <span><i class="fas fa-phone mr-2"></i> <?php echo $data['settings']['site_phone'] ?? '+880 1234 567890'; ?></span>
                <span><i class="fas fa-envelope mr-2"></i> <?php echo $data['settings']['site_email'] ?? 'info@coachingcenter.com'; ?></span>
            </div>
            <div class="flex items-center space-x-4">
                <a href="#" class="hover:text-gray-300"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="hover:text-gray-300"><i class="fab fa-twitter"></i></a>
                <a href="#" class="hover:text-gray-300"><i class="fab fa-youtube"></i></a>
                <a href="#" class="hover:text-gray-300"><i class="fab fa-instagram"></i></a>
            </div>
        </div>
    </div>

    <!-- Sticky Navbar -->
    <nav class="bg-white sticky top-0 z-50 shadow-sm landing-nav">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <div class="flex items-center">
                <a href="<?php echo URLROOT; ?>" class="text-2xl font-extrabold text-[#006a4e] flex items-center">
                    <i class="fas fa-graduation-cap mr-2 text-[#f42a41]"></i>
                    <span><?php echo $data['settings']['site_title'] ?? 'COACHING'; ?></span>
                </a>
            </div>
            
            <div class="hidden lg:flex items-center space-x-8 font-semibold text-gray-700">
                <a href="#" class="hover:text-bd-green transition">Home</a>
                <a href="#about" class="hover:text-bd-green transition">About Us</a>
                <a href="#mentors" class="hover:text-bd-green transition">Mentors</a>
                <a href="#courses" class="hover:text-bd-green transition">Courses</a>
                <a href="#success" class="hover:text-bd-green transition">Success Story</a>
                <a href="#contact" class="hover:text-bd-green transition">Contact</a>
            </div>

            <div class="flex items-center space-x-6">
                <!-- Social Connect -->
                <a href="https://wa.me/<?php echo preg_replace('/[^0-9]/', '', $data['settings']['site_phone'] ?? '8801234567890'); ?>" target="_blank" class="text-[#25D366] text-xl hover:scale-110 transition shrink-0"><i class="fab fa-whatsapp"></i></a>
                <a href="#" class="text-[#1877F2] text-xl hover:scale-110 transition shrink-0"><i class="fab fa-facebook-messenger"></i></a>
                <a href="tel:<?php echo $data['settings']['site_phone'] ?? '+8801234567890'; ?>" class="hidden sm:flex items-center space-x-2 text-[#006a4e] font-bold border-l-2 border-gray-200 pl-4">
                    <i class="fas fa-phone-alt animate-pulse text-sm"></i>
                    <span>Call Now</span>
                </a>
            </div>
        </div>
    </nav>

    <!-- Notice Ticker -->
    <?php if(!empty($data['notices'])) : ?>
    <div class="bg-[#f42a41] text-white py-2.5 overflow-hidden flex items-center">
        <div class="container mx-auto flex items-center relative">
            <span class="bg-white text-[#f42a41] px-4 py-1 font-bold text-sm mr-4 z-10 shrink-0 rounded-[3px]">LATEST NOTICE</span>
            <div class="flex-1 overflow-hidden">
                <div class="whitespace-nowrap animate-marquee flex">
                    <?php foreach($data['notices'] as $notice) : ?>
                        <span class="mx-12 font-medium">*** <?php echo $notice->content; ?> ***</span>
                    <?php endforeach; ?>
                    <!-- Duplicate for seamless scroll -->
                    <?php foreach($data['notices'] as $notice) : ?>
                        <span class="mx-12 font-medium">*** <?php echo $notice->content; ?> ***</span>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Hero Section -->
    <section class="relative h-[650px] flex items-center overflow-hidden bg-cover bg-center" style="background-image: url('<?php echo $data['settings']['landing_banner'] ?? 'https://images.unsplash.com/photo-1523050853063-bd8012fec042?auto=format&fit=crop&w=1920&q=80'; ?>');">
        <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/50 to-transparent"></div>
        <div class="container mx-auto px-4 relative z-10 text-white">
            <div class="max-w-2xl">
                <h4 class="text-[#f42a41] font-bold text-xl mb-4 bg-white/20 inline-block px-4 py-1 backdrop-blur-sm rounded-[3px]">WELCOME TO <?php echo strtoupper($data['settings']['site_title'] ?? 'OUR CENTER'); ?></h4>
                <h1 class="text-5xl md:text-7xl font-black mb-6 leading-[1.1]">
                    <?php echo $data['settings']['hero_title'] ?? 'Build Your Career with Proper Guidance'; ?>
                </h1>
                <p class="text-xl text-gray-200 mb-10 leading-relaxed font-light">
                    <?php echo $data['settings']['hero_subtitle'] ?? 'We are one of the most reliable coaching centers in Bangladesh, providing top-notch education for years.'; ?>
                </p>
                <div class="flex flex-wrap gap-4">
                    <a href="https://wa.me/<?php echo preg_replace('/[^0-9]/', '', $data['settings']['site_phone'] ?? '8801234567890'); ?>" target="_blank" class="bg-[#25D366] text-white px-10 py-4 rounded-[3px] font-black text-lg hover:-translate-y-1 transition shadow-xl shadow-green-500/30 flex items-center">
                        <i class="fab fa-whatsapp mr-3 text-2xl"></i> WhatsApp Us
                    </a>
                    <a href="#contact" class="bg-white/10 hover:bg-white/20 backdrop-blur-md text-white border border-white/30 px-10 py-4 rounded-[3px] text-lg font-bold transition flex items-center">
                        <i class="fas fa-envelope mr-3 opacity-70"></i> Send Message
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <div class="container mx-auto px-4 -mt-16 relative z-20">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-8">
            <div class="bg-white p-8 rounded-[3px] shadow-xl text-center border-b-4 border-[#006a4e] hover:-translate-y-2 transition-transform duration-300">
                <div class="text-[#006a4e] text-4xl mb-2"><i class="fas fa-user-graduate"></i></div>
                <div class="text-3xl font-black text-gray-800"><?php echo $data['stats']['active_students'] ?? '500'; ?>+</div>
                <div class="text-gray-500 font-semibold uppercase text-xs tracking-wider">Active Students</div>
            </div>
            <div class="bg-white p-8 rounded-[3px] shadow-xl text-center border-b-4 border-blue-600 hover:-translate-y-2 transition-transform duration-300">
                <div class="text-blue-600 text-4xl mb-2"><i class="fas fa-chalkboard-teacher"></i></div>
                <div class="text-3xl font-black text-gray-800"><?php echo $data['stats']['total_teachers'] ?? '40'; ?>+</div>
                <div class="text-gray-500 font-semibold uppercase text-xs tracking-wider">Expert Teachers</div>
            </div>
            <div class="bg-white p-8 rounded-[3px] shadow-xl text-center border-b-4 border-[#f42a41] hover:-translate-y-2 transition-transform duration-300">
                <div class="text-[#f42a41] text-4xl mb-2"><i class="fas fa-award"></i></div>
                <div class="text-3xl font-black text-gray-800">98%</div>
                <div class="text-gray-500 font-semibold uppercase text-xs tracking-wider">Success Rate</div>
            </div>
            <div class="bg-white p-8 rounded-[3px] shadow-xl text-center border-b-4 border-emerald-600 hover:-translate-y-2 transition-transform duration-300">
                <div class="text-emerald-600 text-4xl mb-2"><i class="fas fa-book-open"></i></div>
                <div class="text-3xl font-black text-gray-800"><?php echo $data['stats']['total_courses'] ?? '15'; ?>+</div>
                <div class="text-gray-500 font-semibold uppercase text-xs tracking-wider">Special Courses</div>
            </div>
        </div>
    </div>

    <!-- About Section -->
    <section id="about" class="py-24 bg-white">
        <div class="container mx-auto px-4">
            <div class="flex flex-col lg:flex-row items-center gap-16">
                <div class="lg:w-1/2 relative">
                    <div class="absolute -top-4 -left-4 w-24 h-24 bg-[#f42a41] rounded-full opacity-10"></div>
                    <img src="https://conceptum3g.com/wp-content/uploads/2023/06/Chillox-photo.jpg" alt="About Us" class="rounded-[3px] shadow-2xl relative z-10 w-full object-cover h-[450px]">
                    <div class="absolute -bottom-8 -right-8 bg-[#006a4e] p-8 rounded-[3px] text-white shadow-xl z-20 hidden md:block border-l-4 border-[#f42a41]">
                        <div class="text-4xl font-black"><?php echo $data['settings']['years_excellence'] ?? '10+'; ?></div>
                        <div class="text-sm uppercase font-bold tracking-widest opacity-80">Years of Excellence</div>
                    </div>
                </div>
                <div class="lg:w-1/2">
                    <h2 class="text-bd-red font-bold text-lg mb-2 uppercase">Why Choose Us</h2>
                    <h3 class="text-4xl font-black text-gray-900 mb-6 leading-tight">
                        <?php echo $data['settings']['about_title'] ?? 'The Most Trusted Education Partner in the Region'; ?>
                    </h3>
                    <p class="text-gray-600 text-lg mb-8 leading-relaxed">
                        <?php echo $data['settings']['about_description'] ?? 'We provide comprehensive coaching for students from class 6 to 12. Our special focus areas include Science, Mathematics, and English. We believe that every student has the potential to shine if given the right guidance.'; ?>
                    </p>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div class="flex items-start space-x-4">
                            <div class="w-10 h-10 rounded-lg bg-emerald-100 flex items-center justify-center text-emerald-600 shrink-0 mt-1">
                                <i class="fas fa-check"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-800">Expert Mentors</h4>
                                <p class="text-sm text-gray-500">Teachers from top universities.</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-4">
                            <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center text-blue-600 shrink-0 mt-1">
                                <i class="fas fa-microscope"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-800">Modern Lab</h4>
                                <p class="text-sm text-gray-500">Practical learning experience.</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-4">
                            <div class="w-10 h-10 rounded-lg bg-orange-100 flex items-center justify-center text-orange-600 shrink-0 mt-1">
                                <i class="fas fa-file-alt"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-800">Weekly Exams</h4>
                                <p class="text-sm text-gray-500">Regular performance tracking.</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-4">
                            <div class="w-10 h-10 rounded-lg bg-purple-100 flex items-center justify-center text-purple-600 shrink-0 mt-1">
                                <i class="fas fa-mobile-alt"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-800">Parental Monitoring</h4>
                                <p class="text-sm text-gray-500">SMS updates on attendance.</p>
                            </div>
                        </div>
                    </div>

                    <div class="p-6 bg-gray-50 rounded-xl principal-quote mb-8">
                        <p class="text-gray-700 italic mb-4">"<?php echo $data['settings']['principal_quote'] ?? 'Our mission is to empower the next generation of leaders in Bangladesh through quality education.'; ?>"</p>
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 rounded-full overflow-hidden bg-gray-200">
                                <img src="<?php echo $data['settings']['principal_image'] ?? 'https://i.pravatar.cc/150?u=principal'; ?>" alt="Principal">
                            </div>
                            <div>
                                <h5 class="font-bold text-gray-900"><?php echo $data['settings']['principal_name'] ?? 'Principal Name'; ?></h5>
                                <p class="text-xs text-gray-500 uppercase">Principal & Founder</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Mentors Section -->
    <section id="mentors" class="py-24 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center max-w-2xl mx-auto mb-16">
                <h2 class="text-[#f42a41] font-bold text-lg mb-2 uppercase tracking-widest">Our Mentors</h2>
                <h3 class="text-4xl font-black text-gray-900 leading-tight">Expert Guidance from Professional Educators</h3>
                <p class="text-gray-500 mt-4 text-lg">We believe that a great teacher can change a student's life. Our mentors are selected from the top universities of Bangladesh.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-12">
                <?php if(!empty($data['mentors'])) : ?>
                    <?php foreach($data['mentors'] as $mentor) : ?>
                    <!-- Mentor -->
                    <div class="group">
                        <div class="relative overflow-hidden mb-6 rounded-[3px] aspect-[4/5] shadow-lg">
                            <img src="<?php echo $mentor->image; ?>" alt="<?php echo $mentor->name; ?>" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-[#006a4e]/80 to-transparent flex items-end p-6 translate-y-full group-hover:translate-y-0 transition-transform">
                                <div class="flex space-x-4 text-white text-lg">
                                    <?php if(!empty($mentor->social_fb)) : ?>
                                        <a href="<?php echo $mentor->social_fb; ?>"><i class="fab fa-facebook-messenger"></i></a>
                                    <?php endif; ?>
                                    <?php if(!empty($mentor->social_wa)) : ?>
                                        <a href="https://wa.me/<?php echo preg_replace('/[^0-9]/', '', $mentor->social_wa); ?>"><i class="fab fa-whatsapp"></i></a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <h4 class="text-xl font-bold text-gray-900 mb-1"><?php echo $mentor->name; ?></h4>
                        <p class="text-[#f42a41] font-bold text-sm mb-2 uppercase"><?php echo $mentor->role; ?></p>
                        <p class="text-gray-500 text-sm italic"><?php echo $mentor->credentials; ?></p>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="courses" class="py-24 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center max-w-2xl mx-auto mb-16">
                <h2 class="text-[#f42a41] font-bold text-lg mb-2 uppercase tracking-widest">Our Programs</h2>
                <h3 class="text-4xl font-black text-gray-900">Education Customized for You</h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <?php if(!empty($data['programs'])) : ?>
                    <?php foreach($data['programs'] as $program) : ?>
                    <!-- Program -->
                    <div class="bg-white rounded-[3px] overflow-hidden shadow-sm border-t-4 border-[#006a4e] hover:shadow-md transition-shadow <?php echo $program->is_trending ? 'scale-105 z-10 shadow-lg' : ''; ?>">
                        <div class="h-48 overflow-hidden relative">
                            <?php if($program->is_trending): ?>
                                <div class="absolute top-4 right-4 bg-bd-red text-white py-1 px-4 rounded-full text-xs font-bold pulse">TRENDING</div>
                            <?php endif; ?>
                            <img src="<?php echo $program->image; ?>" alt="<?php echo $program->title; ?>" class="w-full h-full object-cover">
                        </div>
                        <div class="p-8">
                            <h4 class="text-2xl font-bold text-gray-900 mb-4"><?php echo $program->title; ?></h4>
                            <p class="text-gray-600 mb-6"><?php echo $program->description; ?></p>
                            <ul class="space-y-3 mb-8 text-gray-600 font-medium">
                                <?php 
                                    $features = explode(',', $program->features);
                                    foreach($features as $feature) : 
                                ?>
                                    <li><i class="fas fa-check text-[#006a4e] mr-2"></i> <?php echo trim($feature); ?></li>
                                <?php endforeach; ?>
                            </ul>
                            <a href="https://wa.me/<?php echo preg_replace('/[^0-9]/', '', $data['settings']['site_phone'] ?? '8801234567890'); ?>?text=I'm%20interested%20in%20<?php echo urlencode($program->title); ?>" target="_blank" class="<?php echo $program->is_trending ? 'bg-[#006a4e] text-white text-center block py-3 rounded-[3px] font-bold hover:bg-emerald-700 transition shadow-lg' : 'text-[#006a4e] font-bold flex items-center group'; ?>">
                                <?php if($program->is_trending): ?>
                                    <i class="fab fa-whatsapp mr-2"></i> Inquire Now
                                <?php else: ?>
                                    Inquire via WhatsApp <i class="fab fa-whatsapp ml-2 text-lg group-hover:scale-110 transition"></i>
                                <?php endif; ?>
                            </a>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Admission Info Section -->
    <section class="py-20 bg-[#006a4e] text-white relative overflow-hidden">
        <div class="absolute top-0 right-0 w-96 h-96 bg-white opacity-5 rounded-full -mr-48 -mt-48"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-white opacity-5 rounded-full -ml-32 -mb-32"></div>
        <div class="container mx-auto px-4 relative z-10 flex flex-col items-center text-center">
            <h2 class="text-3xl md:text-4xl font-black mb-6">Have Questions? Talk to Our Experts Directly</h2>
            <p class="text-xl opacity-90 mb-10 max-w-3xl">We are here to help you choose the right path for your academic success. Connect with us via any of these channels.</p>
            <div class="flex flex-wrap justify-center gap-6">
                <a href="https://wa.me/<?php echo preg_replace('/[^0-9]/', '', $data['settings']['site_phone'] ?? '8801234567890'); ?>" target="_blank" class="bg-[#25D366] text-white px-10 py-4 rounded-[3px] font-black text-lg hover:-translate-y-1 transition shadow-2xl flex items-center">
                    <i class="fab fa-whatsapp mr-3 text-2xl"></i> WHATSAPP
                </a>
                <a href="tel:<?php echo $data['settings']['site_phone'] ?? '+8801234567890'; ?>" class="bg-white text-[#006a4e] px-10 py-4 rounded-[3px] font-black text-lg hover:-translate-y-1 transition shadow-2xl flex items-center">
                    <i class="fas fa-phone-alt mr-3"></i> CALL NOW
                </a>
                <a href="#" class="bg-[#1877F2] text-white px-10 py-4 rounded-[3px] font-black text-lg hover:-translate-y-1 transition shadow-2xl flex items-center">
                    <i class="fab fa-facebook-messenger mr-3 text-2xl"></i> MESSENGER
                </a>
            </div>
        </div>
    </section>

    <!-- Success Story Section -->
    <section id="success" class="py-24 bg-gray-50 overflow-hidden">
        <div class="container mx-auto px-4">
            <div class="flex flex-col lg:flex-row items-center gap-16">
                <div class="lg:w-1/2">
                    <h2 class="text-[#f42a41] font-bold text-lg mb-2 uppercase tracking-widest">Success Story</h2>
                    <h3 class="text-4xl font-black text-gray-900 mb-6 leading-tight">Changing Lives Since 2014</h3>
                    <p class="text-gray-600 text-lg mb-8 leading-relaxed">Over the past decade, we have helped more than 5,000 students achieve their dreams. Our alumni are now studying in top medical colleges, engineering universities, and renowned institutions across Bangladesh.</p>
                    
                    <div class="space-y-6">
                        <?php if(!empty($data['testimonials'])) : ?>
                            <?php foreach($data['testimonials'] as $test) : ?>
                            <!-- Testimonial -->
                            <div class="bg-white p-6 rounded-[3px] shadow-sm border-l-4 border-[#006a4e]">
                                <p class="text-gray-600 italic mb-4">"<?php echo $test->content; ?>"</p>
                                <div class="flex items-center space-x-4">
                                    <div class="w-10 h-10 rounded-full bg-gray-200 overflow-hidden">
                                        <img src="<?php echo $test->image ?: 'https://i.pravatar.cc/150?u='.$test->id; ?>" class="w-full h-full object-cover">
                                    </div>
                                    <div>
                                        <h5 class="font-bold text-gray-900"><?php echo $test->name; ?></h5>
                                        <p class="text-xs text-gray-500 uppercase"><?php echo $test->credentials; ?></p>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="lg:w-1/2 relative">
                    <div class="grid grid-cols-2 gap-4">
                        <img src="https://images.unsplash.com/photo-1523240795612-9a054b0db644?auto=format&fit=crop&w=600&q=80" alt="Happy Students" class="rounded-[3px] shadow-lg mt-8">
                        <img src="https://images.unsplash.com/photo-1529333166437-7750a6dd5a70?auto=format&fit=crop&w=600&q=80" alt="Success" class="rounded-[3px] shadow-lg">
                    </div>
                    <div class="absolute -bottom-6 -left-6 bg-[#f42a41] text-white p-6 rounded-[3px] shadow-2xl hidden md:block">
                        <div class="text-3xl font-black"><?php echo $data['settings']['gpa5_holders'] ?? '500+'; ?></div>
                        <div class="text-xs uppercase font-bold tracking-widest">GPA 5.00 Holders</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-24 bg-white">
        <div class="container mx-auto px-4">
            <div class="flex flex-col lg:flex-row gap-16">
                <div class="lg:w-1/2">
                    <h2 class="text-[#f42a41] font-bold text-lg mb-2 uppercase">Contact Us</h2>
                    <h3 class="text-4xl font-black text-gray-900 mb-8">Get in Touch Today</h3>
                    
                    <div class="space-y-8 mb-12">
                        <div class="flex items-start space-x-6">
                            <div class="w-14 h-14 bg-gray-50 rounded-[3px] flex items-center justify-center text-[#006a4e] shrink-0 text-xl shadow-inner">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-800 text-lg">Our Location</h4>
                                <p class="text-gray-500 line-clamp-2"><?php echo $data['settings']['site_address'] ?? '123 Coaching Street, Dhanmondi, Dhaka, Bangladesh'; ?></p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-6">
                            <div class="w-14 h-14 bg-gray-50 rounded-[3px] flex items-center justify-center text-[#006a4e] shrink-0 text-xl shadow-inner">
                                <i class="fas fa-phone-alt"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-800 text-lg">Phone Number</h4>
                                <p class="text-gray-500"><?php echo $data['settings']['site_phone'] ?? '+880 1234 567890'; ?></p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-6">
                            <div class="w-14 h-14 bg-gray-50 rounded-[3px] flex items-center justify-center text-[#006a4e] shrink-0 text-xl shadow-inner">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-800 text-lg">Email Address</h4>
                                <p class="text-gray-500"><?php echo $data['settings']['site_email'] ?? 'info@coachingcenter.com'; ?></p>
                            </div>
                        </div>
                    </div>

                    <!-- Map (Placeholder) -->
                    <div class="rounded-2xl overflow-hidden h-[300px] border-4 border-gray-50 bg-gray-100 flex items-center justify-center text-gray-400">
                         <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m14!1m8!1m3!1d14608.2729518163!2d90.377!3d23.75!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755b8b087021c81%3A0x8fa563bbdd5904c2!2sDhanmondi%2C%20Dhaka!5e0!3m2!1sen!2sbd!4v1680000000000!5m2!1sen!2sbd" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                    </div>
                </div>

                <div class="lg:w-1/2">
                    <div class="bg-gray-50 p-10 rounded-[3px] shadow-sm border border-gray-100">
                        <h4 class="text-2xl font-bold text-gray-800 mb-2">Send Message</h4>
                        <p class="text-gray-500 mb-8">Fill out the form below and we'll get back to you shortly.</p>
                        
                        <form action="#" class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Full Name</label>
                                    <input type="text" placeholder=" Rahim Ahmed" class="w-full px-5 py-3 rounded-[3px] border border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#006a4e]/20 transition">
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Phone Number</label>
                                    <input type="tel" placeholder=" 01712xxxxxx" class="w-full px-5 py-3 rounded-[3px] border border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#006a4e]/20 transition">
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Class/Program</label>
                                <select class="w-full px-5 py-3 rounded-[3px] border border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#006a4e]/20 transition">
                                    <option>Select Section</option>
                                    <option>Junior Section (6-8)</option>
                                    <option>SSC Preparation (9-10)</option>
                                    <option>HSC Preparation (11-12)</option>
                                    <option>Admission Test</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Your Message</label>
                                <textarea rows="4" placeholder="How can we help you?" class="w-full px-5 py-3 rounded-[3px] border border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#006a4e]/20 transition"></textarea>
                            </div>
                            <button type="submit" class="w-full bg-[#f42a41] text-white py-4 rounded-[3px] font-black text-lg hover:bg-red-700 transition shadow-xl">SEND MESSAGE <i class="fas fa-paper-plane ml-2"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-[#004d39] text-[#e2e8f0] pt-20 pb-10">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-16">
                <!-- Brand -->
                <div class="lg:col-span-1">
                    <a href="#" class="text-3xl font-black text-white flex items-center mb-6">
                        <i class="fas fa-graduation-cap mr-2 text-[#f42a41]"></i>
                        <span><?php echo $data['settings']['site_title'] ?? 'COACHING'; ?></span>
                    </a>
                    <p class="text-gray-400 leading-relaxed mb-6">
                        The leading coaching center in the country providing high-quality education for over a decade.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="w-10 h-10 rounded-full bg-white/5 flex items-center justify-center hover:bg-[#f42a41] transition"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="w-10 h-10 rounded-full bg-white/5 flex items-center justify-center hover:bg-[#f42a41] transition"><i class="fab fa-youtube"></i></a>
                        <a href="#" class="w-10 h-10 rounded-full bg-white/5 flex items-center justify-center hover:bg-[#f42a41] transition"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>

                <!-- Fast Links -->
                <div>
                    <h4 class="text-xl font-bold text-white mb-8 border-b border-white/10 pb-2 inline-block">Support</h4>
                    <ul class="space-y-4 text-gray-400">
                        <li><a href="#contact" class="hover:text-[#f42a41] transition">Contact Support</a></li>
                        <li><a href="#" class="hover:text-[#f42a41] transition">WhatsApp Inquiry</a></li>
                        <li><a href="#" class="hover:text-[#f42a41] transition">Student Results</a></li>
                        <li><a href="#" class="hover:text-[#f42a41] transition">Our Location</a></li>
                    </ul>
                </div>

                <!-- Academic -->
                <div>
                    <h4 class="text-xl font-bold text-white mb-8 border-b border-white/10 pb-2 inline-block">Academic</h4>
                    <ul class="space-y-4 text-gray-400">
                        <li><a href="#" class="hover:text-[#f42a41] transition">Science Group</a></li>
                        <li><a href="#" class="hover:text-[#f42a41] transition">Commerce Group</a></li>
                        <li><a href="#" class="hover:text-[#f42a41] transition">Arts Group</a></li>
                        <li><a href="#" class="hover:text-[#f42a41] transition">English Medium</a></li>
                    </ul>
                </div>

                <!-- Newsletter -->
                <div>
                    <h4 class="text-xl font-bold text-white mb-8 border-b border-white/10 pb-2 inline-block">Newsletter</h4>
                    <p class="text-gray-400 mb-6 text-sm">Subscribe to get latest updates and news.</p>
                    <form action="#" class="flex">
                        <input type="email" placeholder="Email" class="bg-white/5 border border-white/10 px-4 py-2 rounded-l-lg w-full focus:outline-none focus:border-[#f42a41] text-white">
                        <button class="bg-[#f42a41] px-4 py-2 rounded-r-lg hover:bg-red-700 transition"><i class="fas fa-paper-plane"></i></button>
                    </form>
                </div>
            </div>

            <div class="border-t border-white/10 pt-10 text-center text-sm text-gray-500">
                <p>&copy; <?php echo date('Y'); ?> <?php echo $data['settings']['site_title'] ?? 'Coaching Center'; ?>. All rights reserved. Developed with <i class="fas fa-heart text-[#f42a41] mx-1"></i> in Bangladesh.</p>
            </div>
        </div>
    </footer>

    <script>
        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    </script>

</body>
</html>
