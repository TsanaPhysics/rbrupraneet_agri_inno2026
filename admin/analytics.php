<?php
require_once "auth_check.php";
$assessmentsFile = '../storage/database/assessments.json';
$registrationsFile = '../storage/database/activities.json'; // We'll use this for cross-ref or activities.json

$assessments = [];
if (file_exists($assessmentsFile)) {
    $assessments = json_decode(file_get_contents($assessmentsFile), true) ?: [];
}

// Calculate Stats
$scoreMap = [];
$totalEI = 0;
$eiCount = 0;
$maxScore = 5;

foreach ($assessments as $entry) {
    if ($entry['course_code'] !== 'CNN') continue;
    $sid = $entry['student_id'];
    if (!isset($scoreMap[$sid])) $scoreMap[$sid] = ['pre' => null, 'post' => null];
    
    if ($entry['activity_type'] === 'pre_test') $scoreMap[$sid]['pre'] = $entry['score'];
    if ($entry['activity_type'] === 'post_test') $scoreMap[$sid]['post'] = $entry['score'];
}

function calculateEI($pre, $post, $max) {
    if ($pre >= $max) return ($post >= $pre) ? 100 : 0;
    return round((($post - $pre) / ($max - $pre)) * 100, 1);
}

foreach ($scoreMap as $sId => $scores) {
    if ($scores['pre'] !== null && $scores['post'] !== null) {
        $totalEI += calculateEI($scores['pre'], $scores['post'], $maxScore);
        $eiCount++;
    }
}
$avgEI = $eiCount > 0 ? round($totalEI / $eiCount, 1) : 0;
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assessment Intelligence | Admin Hub</title>
    <link rel="stylesheet" href="../css/main.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;900&display=swap" rel="stylesheet">
    <style>
        body { background: #020617; color: white; font-family: 'Outfit', sans-serif; }
        .glass-card {
            background: rgba(30, 41, 59, 0.4);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,0.05);
            border-radius: 32px;
            padding: 30px;
        }
        .stat-val { font-size: 3rem; font-weight: 900; line-height: 1; }
        .growth-up { color: #10b981; }
        .growth-neutral { color: #94a3b8; }
        table { width: 100%; border-collapse: separate; border-spacing: 0 10px; }
        th { text-align: left; padding: 15px 20px; color: #64748b; font-size: 0.7rem; text-transform: uppercase; letter-spacing: 1px; }
        td { padding: 20px; background: rgba(255,255,255,0.02); }
        tr td:first-child { border-radius: 16px 0 0 16px; }
        tr td:last-child { border-radius: 0 16px 16px 0; }
    </style>
</head>
<body class="p-8">
    <div class="container mx-auto">
        <div class="flex justify-between items-end mb-12">
            <div>
                <span class="text-orange-500 font-bold text-xs tracking-widest uppercase">Live Monitoring</span>
                <h1 class="text-5xl font-black mt-2">Assessment <span class="bg-clip-text text-transparent bg-gradient-to-r from-orange-400 to-amber-200">Intelligence</span></h1>
            </div>
            <div class="glass-card flex gap-8">
                <div>
                    <div class="text-[10px] text-slate-500 uppercase tracking-tighter">Cohort Avg EI</div>
                    <div class="text-3xl font-black text-emerald-400"><?php echo $avgEI; ?>%</div>
                </div>
                <div>
                    <div class="text-[10px] text-slate-500 uppercase tracking-tighter">Total Students</div>
                    <div class="text-3xl font-black"><?php echo count($scoreMap); ?></div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
            <div class="glass-card">
                <h3 class="text-xl font-bold mb-6">Learning Growth Summary</h3>
                <div class="space-y-6">
                    <div class="flex justify-between text-sm">
                        <span class="text-slate-400">Knowledge Efficiency Index (EI)</span>
                        <span class="text-emerald-400 font-bold"><?php echo $avgEI; ?>%</span>
                    </div>
                    <div class="h-3 w-full bg-white/5 rounded-full overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-emerald-600 to-teal-400" style="width: <?php echo $avgEI; ?>%"></div>
                    </div>
                    <p class="text-xs text-slate-500">The Efficiency Index measures the actual gain relative to the potential gain based on pre-test scores.</p>
                </div>
            </div>
            
            <div class="glass-card flex items-center justify-center text-center">
                <div>
                    <div class="text-6xl mb-4">🏆</div>
                    <div class="text-xs text-slate-500 uppercase tracking-widest mb-1">Status</div>
                    <div class="text-3xl font-black"><?php echo ($avgEI > 50) ? 'EXCEPTIONAL' : 'VIBRANT'; ?></div>
                </div>
            </div>
        </div>

        <!-- Detailed Table -->
        <div class="glass-card">
            <h3 class="text-xl font-bold mb-8">Individual Performance Tracking</h3>
            <div class="overflow-x-auto">
                <table>
                    <thead>
                        <tr>
                            <th>Student ID</th>
                            <th class="text-center">Pre-test</th>
                            <th class="text-center">Post-test</th>
                            <th class="text-center">EI Growth</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($scoreMap as $sid => $m): 
                            $ei = 0;
                            if($m['pre'] !== null && $m['post'] !== null) $ei = calculateEI($m['pre'], $m['post'], $maxScore);
                        ?>
                        <tr>
                            <td class="font-bold"><?php echo $sid; ?></td>
                            <td class="text-center text-slate-400"><?php echo $m['pre'] ?? '-'; ?></td>
                            <td class="text-center text-emerald-400 font-bold"><?php echo $m['post'] ?? '-'; ?></td>
                            <td class="text-center">
                                <span class="px-4 py-1 rounded-full bg-emerald-500/10 text-emerald-400 font-black">
                                    +<?php echo $ei; ?>%
                                </span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-20 text-center">
            <a href="index.php" class="text-slate-500 hover:text-white transition-colors text-sm">&laquo; Back to Admin Hub</a>
        </div>
    </div>
</body>
</html>
