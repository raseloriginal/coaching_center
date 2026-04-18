<!DOCTYPE html>
<html lang="en" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance History - Portal</title>
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
                            <h1 class="text-white font-black text-xl tracking-tight hidden sm:block">ATTENDANCE LOGS</h1>
                        </a>
                    </div>
                </div>
            </div>
        </nav>

        <header class="bg-white shadow-sm border-b border-slate-200">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <h2 class="text-2xl font-extrabold text-slate-800 tracking-tight italic uppercase">My Attendance History</h2>
            </div>
        </header>

        <main class="max-w-4xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-[2.5rem] shadow-2xl shadow-slate-200/50 border border-slate-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="text-xs text-slate-400 font-black uppercase tracking-widest bg-slate-50 border-b border-slate-100">
                            <tr>
                                <th class="px-8 py-5">Date</th>
                                <th class="px-8 py-5">Time</th>
                                <th class="px-8 py-5">Batch</th>
                                <th class="px-8 py-5 text-right">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            <?php if(!empty($data['attendance'])): ?>
                                <?php foreach($data['attendance'] as $log): ?>
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="px-8 py-6 font-bold text-slate-800">
                                        <?php echo format_date($log->date); ?>
                                    </td>
                                    <td class="px-8 py-6 text-slate-500 font-medium">
                                        <?php echo date('h:i A', strtotime($log->time)); ?>
                                    </td>
                                    <td class="px-8 py-6 text-slate-600 font-bold">
                                        <?php echo $log->batch_name; ?>
                                    </td>
                                    <td class="px-8 py-6 text-right">
                                        <span class="px-3 py-1 bg-emerald-100 text-emerald-700 rounded-full text-[10px] font-black uppercase tracking-widest">
                                            Present
                                        </span>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="px-8 py-20 text-center text-slate-400">
                                        <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                                            <i class="fas fa-calendar-times text-2xl"></i>
                                        </div>
                                        <p class="font-medium italic">No attendance records found.</p>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

</body>
</html>
