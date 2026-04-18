<!DOCTYPE html>
<html lang="en" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="h-full">

    <div class="min-h-full">
        <!-- Navigation -->
        <nav class="bg-blue-700 shadow-lg">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-20">
                    <div class="flex items-center gap-4">
                        <div class="flex-shrink-0 bg-white p-2 rounded-xl text-blue-700">
                            <i class="fas fa-graduation-cap text-2xl"></i>
                        </div>
                        <div class="hidden md:block">
                            <h1 class="text-white font-black text-xl tracking-tight"><?php echo get_setting('site_title', SITENAME); ?> PORTAL</h1>
                        </div>
                    </div>
                    <div class="flex items-center gap-6">
                        <div class="text-right hidden sm:block">
                            <p class="text-white font-bold text-sm"><?php echo $_SESSION['student_name']; ?></p>
                            <p class="text-blue-200 text-xs">Roll: <?php echo $_SESSION['student_roll']; ?></p>
                        </div>
                        <a href="<?php echo URLROOT; ?>/portals/logout" class="bg-blue-600 hover:bg-blue-500 text-white px-4 py-2 rounded-lg text-sm font-bold transition-all flex items-center gap-2">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </a>
                    </div>
                </div>
            </div>
        </nav>

        <header class="bg-white shadow-sm border-b border-slate-200">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
                <h2 class="text-2xl font-extrabold text-slate-800 tracking-tight italic uppercase">My Dashboard</h2>
                <div class="flex gap-2">
                    <span class="bg-emerald-100 text-emerald-700 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-widest">Active Student</span>
                </div>
            </div>
        </header>

        <main class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
            <!-- Stats -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-10">
                <div class="bg-white p-8 rounded-[2rem] shadow-xl shadow-slate-200/50 border border-slate-100">
                    <div class="flex items-center gap-5">
                        <div class="w-14 h-14 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center text-2xl">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div>
                            <p class="text-xs font-black text-slate-400 uppercase tracking-widest mb-1">Last Result</p>
                            <h3 class="text-2xl font-black text-slate-800">
                                <?php echo !empty($data['results']) ? $data['results'][0]->percentage . '%' : 'N/A'; ?>
                            </h3>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-8 rounded-[2rem] shadow-xl shadow-slate-200/50 border border-slate-100">
                    <div class="flex items-center gap-5">
                        <div class="w-14 h-14 bg-amber-50 text-amber-600 rounded-2xl flex items-center justify-center text-2xl">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <div>
                            <p class="text-xs font-black text-slate-400 uppercase tracking-widest mb-1">Attendance</p>
                            <h3 class="text-2xl font-black text-slate-800">92%</h3>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-8 rounded-[2rem] shadow-xl shadow-slate-200/50 border border-slate-100">
                    <div class="flex items-center gap-5">
                        <div class="w-14 h-14 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center text-2xl">
                            <i class="fas fa-wallet"></i>
                        </div>
                        <div>
                            <p class="text-xs font-black text-slate-400 uppercase tracking-widest mb-1">Account Status</p>
                            <h3 class="text-2xl font-black text-slate-800 text-emerald-600 italic uppercase">Clear</h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
                <!-- Recent Results -->
                <div class="bg-white rounded-[2.5rem] shadow-2xl shadow-slate-200/50 border border-slate-100 overflow-hidden">
                    <div class="p-8 border-b border-slate-50 flex justify-between items-center bg-slate-50/50">
                        <h3 class="text-xl font-black text-slate-800 uppercase tracking-tighter italic">Academic Performance</h3>
                        <a href="<?php echo URLROOT; ?>/portals/results" class="text-blue-600 font-bold text-sm hover:underline">View All</a>
                    </div>
                    <div class="p-4">
                        <div class="space-y-4">
                            <?php if(!empty($data['results'])): ?>
                                <?php foreach($data['results'] as $res): ?>
                                <div class="flex items-center justify-between p-5 bg-slate-50 rounded-2xl border border-slate-100 hover:border-blue-200 transition-all group">
                                    <div>
                                        <p class="font-black text-slate-800 group-hover:text-blue-700 transition-colors"><?php echo $res->title; ?></p>
                                        <p class="text-xs font-medium text-slate-400"><?php echo format_date($res->exam_date); ?></p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-lg font-black text-slate-800"><?php echo $res->total_marks; ?>/<?php echo $res->max_marks; ?></p>
                                        <span class="text-[10px] font-black uppercase px-2 py-0.5 bg-blue-100 text-blue-700 rounded-full tracking-wider"><?php echo $res->percentage; ?>%</span>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="text-center py-10">
                                    <p class="text-slate-400 font-medium italic">No exam results found.</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Recent Fees -->
                <div class="bg-white rounded-[2.5rem] shadow-2xl shadow-slate-200/50 border border-slate-100 overflow-hidden">
                    <div class="p-8 border-b border-slate-50 flex justify-between items-center bg-slate-50/50">
                        <h3 class="text-xl font-black text-slate-800 uppercase tracking-tighter italic">Recent Fees</h3>
                    </div>
                    <div class="p-4">
                        <div class="space-y-4">
                            <?php if(!empty($data['fees'])): ?>
                                <?php foreach(array_slice($data['fees'], 0, 5) as $fee): ?>
                                <div class="flex items-center justify-between p-5 bg-slate-50 rounded-2xl border border-slate-100">
                                    <div>
                                        <p class="font-black text-slate-800"><?php echo date('F Y', strtotime($fee->month . '-01')); ?></p>
                                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Tuition Fee</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-lg font-black text-slate-800">৳<?php echo number_format($fee->amount, 2); ?></p>
                                        <?php 
                                            $sClass = 'bg-rose-100 text-rose-700';
                                            if($fee->status == 'paid') $sClass = 'bg-emerald-100 text-emerald-700';
                                            if($fee->status == 'due') $sClass = 'bg-amber-100 text-amber-700';
                                        ?>
                                        <span class="text-[10px] font-black uppercase px-2 py-0.5 <?php echo $sClass; ?> rounded-full tracking-wider"><?php echo $fee->status; ?></span>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="text-center py-10">
                                    <p class="text-slate-400 font-medium italic">No fee records found.</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

</body>
</html>
