<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $data['title']; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://unpkg.com/html5-qrcode"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .glass { background: rgba(30, 41, 59, 0.7); backdrop-filter: blur(12px); border: 1px solid rgba(255, 255, 255, 0.1); }
        #reader { border: none !important; }
        #reader__dashboard_section_csr button { 
            background: #3b82f6 !important; color: white !important; border: none !important; padding: 8px 16px !important; border-radius: 8px !important; font-weight: bold !important;
        }
        .log-enter { animation: slideIn 0.3s ease-out forwards; }
        @keyframes slideIn { from { opacity: 0; transform: translateX(20px); } to { opacity: 1; transform: translateX(0); } }
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #334155; border-radius: 10px; }
    </style>
</head>
<body class="bg-[#0f172a] text-slate-200 min-h-screen">
    <div class="container mx-auto px-4 py-8 lg:py-12">
        <!-- Header -->
        <header class="flex justify-between items-center mb-10">
            <div>
                <h1 class="text-3xl font-extrabold text-white tracking-tight flex items-center gap-3">
                    <span class="bg-blue-600 p-2 rounded-xl h-10 w-10 flex items-center justify-center">
                        <i class="fas fa-qrcode text-sm"></i>
                    </span>
                    Attendance Pulse
                </h1>
                <p class="text-slate-400 mt-1 text-sm">Real-time QR Scanning Dashboard</p>
            </div>
            <div class="hidden md:block">
                <div class="glass px-4 py-2 rounded-full text-xs font-semibold flex items-center gap-2">
                    <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                    System Online
                </div>
            </div>
        </header>

        <div class="grid lg:grid-cols-12 gap-8">
            <!-- Left Side: Scanner & Last Scanned -->
            <div class="lg:col-span-7 space-y-8">
                <!-- Scanner Section -->
                <div class="glass rounded-[2.5rem] p-2 shadow-2xl overflow-hidden relative border-blue-500/30 border-2">
                    <div id="reader" class="w-full h-full rounded-[2.2rem] overflow-hidden"></div>
                    <div class="absolute top-4 left-4 right-4 bottom-4 pointer-events-none border-2 border-white/5 rounded-[2rem]"></div>
                </div>

                <!-- Last Scanned Student Card -->
                <div id="status-card" class="glass rounded-3xl p-8 transition-all duration-300 opacity-0 transform translate-y-4">
                    <div class="flex items-start gap-6">
                        <div id="status-icon" class="w-16 h-16 rounded-2xl flex items-center justify-center text-3xl">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="flex-1">
                            <div id="status-badge" class="inline-block px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider mb-2">
                                Ready for scan
                            </div>
                            <h2 id="student-name" class="text-2xl font-bold text-white mb-1">Waiting...</h2>
                            <p id="student-meta" class="text-slate-400 text-sm">Position QR code to begin</p>
                        </div>
                    </div>
                    <div id="time-stamp" class="mt-6 pt-6 border-t border-slate-700/50 flex justify-between text-xs font-medium text-slate-500">
                        <span>SCAN FEEDBACK AREA</span>
                        <span id="scan-time"></span>
                    </div>
                </div>
            </div>

            <!-- Right Side: Recent Activity Feed -->
            <div class="lg:col-span-5">
                <div class="glass rounded-[2rem] h-[600px] flex flex-col shadow-xl">
                    <div class="p-6 border-b border-white/5 flex justify-between items-center">
                        <h3 class="font-bold flex items-center gap-2">
                            <i class="fas fa-history text-blue-500"></i>
                            Recent Activity
                        </h3>
                        <span class="text-xs text-slate-500 bg-white/5 px-2 py-1 rounded-md">Today's Logs</span>
                    </div>
                    
                    <div id="logs-container" class="flex-1 overflow-y-auto p-6 space-y-4">
                        <?php foreach($data['recentLogs'] as $log): ?>
                        <div class="flex items-center gap-4 p-4 rounded-2xl bg-white/5 border border-white/5 hover:bg-white/[0.08] transition-all group">
                            <div class="w-10 h-10 rounded-xl bg-blue-500/10 text-blue-500 flex items-center justify-center font-bold">
                                <?php echo strtoupper(substr($log->student_name, 0, 1)); ?>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="text-sm font-bold text-white truncate"><?php echo $log->student_name; ?></h4>
                                <p class="text-[10px] text-slate-400 font-medium"><?php echo $log->batch_name; ?> • Roll: <?php echo $log->roll_number; ?></p>
                            </div>
                            <div class="text-right">
                                <span class="text-[10px] font-bold text-slate-500 block"><?php echo date('h:i A', strtotime($log->time)); ?></span>
                                <span class="text-[9px] px-1.5 py-0.5 bg-emerald-500/20 text-emerald-500 rounded font-bold uppercase">Present</span>
                            </div>
                        </div>
                        <?php endforeach; ?>
                        
                        <?php if(empty($data['recentLogs'])): ?>
                        <div id="no-logs" class="h-full flex flex-col items-center justify-center text-slate-500 gap-3 grayscale opacity-50">
                            <i class="fas fa-inbox text-4xl"></i>
                            <p class="text-sm font-medium">No scans recorded yet</p>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Audio Feedback -->
    <audio id="beep-success" src="https://assets.mixkit.co/active_storage/sfx/2568/2568-preview.mp3"></audio>
    <audio id="beep-error" src="https://assets.mixkit.co/active_storage/sfx/2571/2571-preview.mp3"></audio>

    <script>
        const html5QrCode = new Html5Qrcode("reader");
        
        // Larger, more responsive capture area (qrbox)
        const qrboxFunction = function(viewfinderWidth, viewfinderHeight) {
            let minEdgeSize = Math.min(viewfinderWidth, viewfinderHeight);
            let qrboxSize = Math.floor(minEdgeSize * 0.8); // 80% of space
            return {
                width: qrboxSize,
                height: qrboxSize
            };
        }

        const config = { 
            fps: 20, 
            qrbox: qrboxFunction,
            aspectRatio: 1.0 // Force square for dashboard feel
        };
        let isProcessing = false;

        function playSound(type) {
            const sound = document.getElementById(type === 'success' ? 'beep-success' : 'beep-error');
            if(sound) {
                sound.currentTime = 0;
                sound.play().catch(e => console.log('Audio play blocked'));
            }
        }

        function onScanSuccess(decodedText, decodedResult) {
            if(isProcessing) return;
            isProcessing = true;

            const formData = new FormData();
            formData.append('qr_code', decodedText);

            fetch('<?php echo URLROOT; ?>/attendance/mark', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                updateUI(data);
                setTimeout(() => { isProcessing = false; }, 2000); // Wait 2s before next scan
            })
            .catch(error => {
                updateUI({ status: 'error', message: 'Network Connection Error' });
                setTimeout(() => { isProcessing = false; }, 2000);
            });
        }

        function updateUI(data) {
            const card = document.getElementById('status-card');
            const icon = document.getElementById('status-icon');
            const badge = document.getElementById('status-badge');
            const name = document.getElementById('student-name');
            const meta = document.getElementById('student-meta');
            const time = document.getElementById('scan-time');

            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';

            if (data.status === 'success' || data.status === 'info') {
                playSound('success');
                const student = data.student;
                
                // Update Card
                badge.innerText = data.status === 'success' ? 'Attendance Recorded' : 'Already Recorded';
                badge.className = `inline-block px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider mb-2 ${data.status === 'success' ? 'bg-emerald-500/20 text-emerald-500' : 'bg-blue-500/20 text-blue-500'}`;
                icon.className = `w-16 h-16 rounded-2xl flex items-center justify-center text-3xl ${data.status === 'success' ? 'bg-emerald-500/20 text-emerald-500' : 'bg-blue-500/20 text-blue-500'}`;
                icon.innerHTML = `<i class="fas ${data.status === 'success' ? 'fa-check-circle' : 'fa-info-circle'}"></i>`;
                name.innerText = student.name;
                meta.innerText = `${student.batch} • Roll: ${student.roll}`;
                time.innerText = `${student.date} | ${student.time}`;

                if (data.status === 'success') {
                    addLogToFeed(student);
                }
            } else {
                playSound('error');
                badge.innerText = 'Error';
                badge.className = 'inline-block px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider mb-2 bg-rose-500/20 text-rose-500';
                icon.className = 'w-16 h-16 rounded-2xl flex items-center justify-center text-3xl bg-rose-500/20 text-rose-500';
                icon.innerHTML = '<i class="fas fa-times-circle"></i>';
                name.innerText = 'Scan Failed';
                meta.innerText = data.message;
                time.innerText = '';
            }
        }

        function addLogToFeed(student) {
            const container = document.getElementById('logs-container');
            const noLogs = document.getElementById('no-logs');
            if(noLogs) noLogs.remove();

            const logHtml = `
                <div class="flex items-center gap-4 p-4 rounded-2xl bg-white/5 border border-white/5 hover:bg-white/[0.08] transition-all group log-enter">
                    <div class="w-10 h-10 rounded-xl bg-blue-500/10 text-blue-500 flex items-center justify-center font-bold">
                        ${student.name.charAt(0).toUpperCase()}
                    </div>
                    <div class="flex-1 min-w-0">
                        <h4 class="text-sm font-bold text-white truncate">${student.name}</h4>
                        <p class="text-[10px] text-slate-400 font-medium">${student.batch} • Roll: ${student.roll}</p>
                    </div>
                    <div class="text-right">
                        <span class="text-[10px] font-bold text-slate-500 block">${student.time}</span>
                        <span class="text-[9px] px-1.5 py-0.5 bg-emerald-500/20 text-emerald-500 rounded font-bold uppercase">Present</span>
                    </div>
                </div>
            `;
            container.insertAdjacentHTML('afterbegin', logHtml);
        }

        // Start scanning automatically
        html5QrCode.start({ facingMode: "environment" }, config, onScanSuccess);
    </script>
</body>
</html>
