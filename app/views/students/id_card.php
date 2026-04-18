<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student ID Cards</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @media print {
            body { background: white; }
            .no-print { display: none; }
            .id-card { break-inside: avoid; margin-bottom: 20px; }
        }
        .id-card {
            width: 3.375in;
            height: 2.125in;
            background: white;
            border-radius: 12px;
            overflow: hidden;
            position: relative;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            border: 1px solid #e2e8f0;
            display: inline-block;
            margin: 10px;
            vertical-align: top;
            font-family: 'Inter', sans-serif;
        }
        .card-header {
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
            height: 45%;
            padding: 10px;
            color: white;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .center-logo {
            width: 40px;
            height: 40px;
            background: white;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #1e3a8a;
        }
        .card-body {
            padding: 10px;
            display: flex;
            gap: 12px;
        }
        .photo-placeholder {
            width: 60px;
            height: 70px;
            background: #f1f5f9;
            border-radius: 6px;
            border: 1px dashed #cbd5e1;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #94a3b8;
            font-size: 20px;
        }
        .qr-area {
            position: absolute;
            bottom: 10px;
            right: 10px;
            width: 50px;
            height: 50px;
        }
        .qr-area img {
            width: 100%;
            height: 100%;
        }
    </style>
</head>
<body class="bg-gray-100 p-8">

    <div class="no-print mb-8 flex justify-between items-center bg-white p-4 rounded-xl shadow-sm">
        <div>
            <h1 class="text-xl font-bold text-gray-800">Print ID Cards</h1>
            <p class="text-xs text-gray-500">Ready to print student identification cards.</p>
        </div>
        <div class="flex gap-3">
            <button onclick="window.history.back()" class="px-4 py-2 text-sm font-medium text-gray-600 hover:bg-gray-50 rounded-lg border border-gray-200">
                <i class="fas fa-arrow-left mr-2"></i> Back
            </button>
            <button onclick="window.print()" class="px-6 py-2 bg-blue-600 text-white rounded-lg font-bold shadow-lg shadow-blue-500/30 hover:shadow-blue-500/50 transition-all">
                <i class="fas fa-print mr-2"></i> Print Now
            </button>
        </div>
    </div>

    <div class="flex flex-wrap justify-center">
        <?php foreach($data['students'] as $student): ?>
        <div class="id-card">
            <div class="card-header">
                <div class="center-logo">
                    <i class="fas fa-graduation-cap text-lg"></i>
                </div>
                <div>
                    <div class="text-[10px] font-bold uppercase tracking-widest opacity-80">Coaching Center</div>
                    <div class="text-sm font-extrabold truncate w-48"><?php echo get_setting('site_title', SITENAME); ?></div>
                </div>
            </div>
            <div class="card-body">
                <div class="photo-placeholder">
                    <i class="fas fa-user"></i>
                </div>
                <div class="flex-1">
                    <div class="text-[10px] text-gray-400 font-bold uppercase">Student Name</div>
                    <div class="text-sm font-bold text-gray-800 mb-1"><?php echo $student->name; ?></div>
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <div class="text-[8px] text-gray-400 font-bold uppercase">ID Number</div>
                            <div class="text-[10px] font-bold text-gray-700"><?php echo $student->roll_number ?: 'N/A'; ?></div>
                        </div>
                        <div>
                            <div class="text-[8px] text-gray-400 font-bold uppercase">Joined</div>
                            <div class="text-[10px] font-bold text-gray-700"><?php echo format_date($student->joining_date ?: $student->created_at); ?></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="qr-area">
                <!-- Using a public QR generator for preview, real implementation should use local QR storage if available -->
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=<?php echo $student->qr_code; ?>" alt="QR">
            </div>
            <div class="absolute bottom-2 left-3 text-[7px] font-bold text-gray-400">
                VALID UNTIL: <?php echo date('Y') + 1; ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

</body>
</html>
