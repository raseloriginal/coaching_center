<!DOCTYPE html>
<html lang="en" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exam Results - Portal</title>
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
                        <a href="<?php echo URLROOT; ?>/portals/dashboard" class="flex items-center gap-4">
                            <div class="flex-shrink-0 bg-white p-2 rounded-xl text-blue-700">
                                <i class="fas fa-arrow-left text-lg"></i>
                            </div>
                            <h1 class="text-white font-black text-xl tracking-tight hidden sm:block">ACADEMIC RESULTS</h1>
                        </a>
                    </div>
                    <div class="flex items-center gap-6">
                        <a href="<?php echo URLROOT; ?>/portals/logout" class="bg-blue-600 hover:bg-blue-500 text-white px-4 py-2 rounded-lg text-sm font-bold transition-all">
                            Logout
                        </a>
                    </div>
                </div>
            </div>
        </nav>

        <header class="bg-white shadow-sm border-b border-slate-200">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <h2 class="text-2xl font-extrabold text-slate-800 tracking-tight italic uppercase">My Academic History</h2>
            </div>
        </header>

        <main class="max-w-4xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
            <div class="space-y-6">
                <?php if(!empty($data['results'])): ?>
                    <?php foreach($data['results'] as $res): ?>
                    <div class="bg-white p-6 sm:p-8 rounded-[2rem] shadow-xl shadow-slate-200/50 border border-slate-100 flex flex-col sm:flex-row justify-between items-center gap-6">
                        <div class="flex items-center gap-5 w-full sm:w-auto">
                            <div class="w-16 h-16 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center text-2xl font-black">
                                <?php echo date('d', strtotime($res->exam_date)); ?>
                                <span class="text-[10px] uppercase block"><?php echo date('M', strtotime($res->exam_date)); ?></span>
                            </div>
                            <div>
                                <h3 class="text-lg font-black text-slate-800"><?php echo $res->title; ?></h3>
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-1">Batch Marks</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-8 w-full sm:w-auto justify-between sm:justify-end">
                            <div class="text-center">
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Obtained</p>
                                <p class="text-xl font-black text-slate-800"><?php echo $res->total_marks; ?> <span class="text-slate-300 font-medium">/ <?php echo $res->max_marks; ?></span></p>
                            </div>
                            <div class="text-right">
                                <div class="inline-flex items-center justify-center p-4 bg-emerald-50 rounded-2xl border border-emerald-100">
                                    <span class="text-2xl font-black text-emerald-600"><?php echo $res->percentage; ?>%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="bg-white py-20 rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-slate-100 text-center">
                        <div class="w-20 h-20 bg-slate-50 text-slate-300 rounded-full flex items-center justify-center mx-auto mb-6 text-3xl">
                            <i class="fas fa-poll-h"></i>
                        </div>
                        <h3 class="text-xl font-black text-slate-800 uppercase tracking-tighter">No Results Found</h3>
                        <p class="text-slate-400 font-medium">Your exam results will appear here once published.</p>
                    </div>
                <?php endif; ?>
            </div>
        </main>
    </div>

</body>
</html>
