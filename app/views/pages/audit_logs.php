<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="mb-8">
    <h2 class="text-2xl font-bold text-gray-800">System Audit Logs</h2>
    <p class="text-gray-500">Track all administrative actions and security events.</p>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="text-xs text-gray-500 uppercase bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="px-6 py-4 font-bold">Timestamp</th>
                    <th class="px-6 py-4 font-bold">User</th>
                    <th class="px-6 py-4 font-bold">Action</th>
                    <th class="px-6 py-4 font-bold">Details</th>
                    <th class="px-6 py-4 font-bold">IP Address</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                <?php if(!empty($data['logs'])): ?>
                    <?php foreach($data['logs'] as $log): ?>
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 text-gray-500 font-medium">
                            <?php echo format_date($log->created_at, 'M j, Y H:i'); ?>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-[10px] font-bold text-slate-600">
                                    <?php echo strtoupper(substr($log->user_name, 0, 1)); ?>
                                </div>
                                <span class="font-bold text-gray-900"><?php echo $log->user_name; ?></span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <?php 
                                $actionClass = 'bg-slate-100 text-slate-700';
                                if(strpos($log->action, 'DELETE') !== false) $actionClass = 'bg-rose-100 text-rose-700';
                                if(strpos($log->action, 'ADD') !== false) $actionClass = 'bg-emerald-100 text-emerald-700';
                                if(strpos($log->action, 'UPDATE') !== false) $actionClass = 'bg-blue-100 text-blue-700';
                                if(strpos($log->action, 'LOGIN') !== false) $actionClass = 'bg-indigo-100 text-indigo-700';
                            ?>
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider <?php echo $actionClass; ?>">
                                <?php echo str_replace('_', ' ', $log->action); ?>
                            </span>
                        </td>
                        <td class="px-6 py-4 text-gray-600">
                            <?php echo $log->details; ?>
                        </td>
                        <td class="px-6 py-4 text-gray-400 font-mono text-xs">
                            <?php echo $log->ip_address; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-gray-400 italic">
                            No logs found.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>
