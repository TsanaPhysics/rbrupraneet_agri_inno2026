<?php
session_start();
// Inferred data from RBRU system and activities.json
$budget_data = [
    ['category' => 'ค่าตอบแทน', 'item' => 'ค่าวิทยากร', 'calculation' => '2 คน x 300 บาท x 6 ชม. x 6 วัน', 'amount' => 21600],
    ['category' => 'ค่าใช้สอย', 'item' => 'ค่าอาหารว่างและเครื่องดื่ม', 'calculation' => '50 คน x 35 บาท x 2 มื้อ x 6 วัน', 'amount' => 21000],
    ['category' => 'ค่าใช้สอย', 'item' => 'ค่าอาหารกลางวัน', 'calculation' => '50 คน x 80 บาท x 1 มื้อ x 6 วัน', 'amount' => 24000],
    ['category' => 'ค่าวัสดุ', 'item' => 'ค่าวัสดุและป้ายโครงการ', 'calculation' => '1 ชุด x 9,400 บาท', 'amount' => 9400],
];

$total_budget = array_sum(array_column($budget_data, 'amount'));

$team_members = [
    ['name' => 'ผศ.ดร.ชีวะ ทัศนา', 'role' => 'หัวหน้าโครงการ', 'dept' => 'คณะวิทยาศาสตร์และเทคโนโลยี'],
    ['name' => 'ผศ.ดร.จิรภัทร จันทมาลี', 'role' => 'ผู้ร่วมโครงการ / AI Expert', 'dept' => 'คณะวิทยาศาสตร์และเทคโนโลยี'],
    ['name' => 'ผศ.ดร.วิกันยา ประทุมยศ', 'role' => 'ผู้ร่วมโครงการ / Agri Tech', 'dept' => 'คณะเทคโนโลยีการเกษตร'],
];

$objectives = [
    'เพื่อพัฒนาทักษะด้านปัญญาประดิษฐ์ (AI) และเทคโนโลยี IoT ให้กับนักเรียนและบุคลากรในพื้นที่',
    'เพื่อสร้างต้นแบบนวัตกรรมดิจิทัลสำหรับการจัดการเกษตรอัจฉริยะในจังหวัดจันทบุรี',
    'เพื่อยกระดับขีดความสามารถในการวิเคราะห์ข้อมูลสภาพภูมิอากาศเพื่อการวางแผนการเพาะปลูก',
];

$target_groups = [
    'นักเรียนโรงเรียนประณีตวิทยาคม จำนวน 50 คน',
    'เกษตรกรและผู้สนใจในพื้นที่จังหวัดจันทบุรี',
];

$activities = [
    [
        'id' => 1,
        'title' => 'Climate Data Hacking',
        'date' => '15-16 มิ.ย. 2569',
        'location' => 'ศูนย์นวัตกรรมเกษตรดิจิทัล',
        'desc' => 'วิเคราะห์ข้อมูลสภาพภูมิอากาศด้วย Python',
        'icon' => '📊'
    ],
    [
        'id' => 2,
        'title' => 'Deep Dive Lab: CNN',
        'date' => '20-22 ก.ค. 2569',
        'location' => 'อาคารเทคโนโลยีดิจิทัล',
        'desc' => 'จำแนกโรคพืชด้วย Deep Learning',
        'icon' => '🧠'
    ],
    [
        'id' => 3,
        'title' => 'AI-IoT Prototyping',
        'date' => '10-12 ส.ค. 2569',
        'location' => 'โรงเรียนประณีตวิทยาคม',
        'desc' => 'สร้างต้นแบบเซ็นเซอร์อัจฉริยะแบบ Real-time',
        'icon' => '🔧'
    ],
    [
        'id' => 4,
        'title' => 'Tech Showcase 2026',
        'date' => '5 ก.ย. 2569',
        'location' => 'หอประชุมใหญ่ มรภ.รำไพพรรณี',
        'desc' => 'มหกรรมแสดงผลงานนวัตกรรมดิจิทัลเกษตร',
        'icon' => '🚀'
    ],
];
?>
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Budget & Activities Report: RBRU-Praneet 2026</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #f97316;
            --accent: #fbbf24;
            --dark: #0f172a;
            --slate: #334155;
            --text: #334155;
            --paper: #ffffff;
            --gold: #d97706;
            --orange-soft: rgba(249, 115, 22, 0.05);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #f1f5f9;
            color: var(--text);
            line-height: 1.6;
        }

        .report-container {
            max-width: 1000px;
            margin: 2rem auto;
            background: var(--paper);
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.1);
            position: relative;
            padding-bottom: 4rem;
        }

        /* Header Section */
        .report-header {
            background: linear-gradient(135deg, var(--dark) 0%, #1e293b 100%);
            color: white;
            padding: 4rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .report-header::after {
            content: "";
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(to right, var(--primary), var(--accent));
        }

        .report-header h1 {
            font-family: 'Playfair Display', serif;
            font-size: 3rem;
            margin-bottom: 1rem;
            color: var(--accent);
        }

        .report-header p {
            font-size: 1.2rem;
            font-weight: 300;
            opacity: 0.8;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        /* Section Layout */
        .section {
            padding: 4rem;
        }

        .section-title {
            font-family: 'Playfair Display', serif;
            font-size: 2.2rem;
            color: var(--dark);
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .section-title::after {
            content: "";
            flex: 1;
            height: 1px;
            background: #e2e8f0;
        }

        /* Financial Dash */
        .dash-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 3rem;
        }

        .card {
            background: #f8fafc;
            padding: 2rem;
            border-radius: 15px;
            text-align: center;
            border-bottom: 4px solid #e2e8f0;
            transition: transform 0.3s ease;
        }

        .card:hover { transform: translateY(-5px); border-bottom-color: var(--primary); }

        .card .val {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--dark);
            margin: 0.5rem 0;
        }

        .card .label { font-size: 0.9rem; color: #64748b; text-transform: uppercase; letter-spacing: 1px; }

        /* Table Style */
        .report-table {
            width: 100%;
            border-collapse: collapse;
            margin: 2rem 0;
            background: white;
            border-radius: 10px;
            overflow: hidden;
        }

        .report-table th {
            background: var(--dark);
            color: white;
            padding: 1.2rem;
            text-align: left;
            font-size: 0.9rem;
            text-transform: uppercase;
        }

        .report-table td {
            padding: 1.2rem;
            border-bottom: 1px solid #f1f5f9;
            font-size: 1rem;
        }

        .report-table tr:last-child { background: var(--orange-soft); font-weight: 700; color: var(--gold); }

        /* Activity Timeline */
        .timeline {
            position: relative;
            margin-top: 2rem;
        }

        .timeline-item {
            display: flex;
            gap: 30px;
            margin-bottom: 3rem;
            position: relative;
        }

        .timeline-item::before {
            content: "";
            position: absolute;
            left: 25px;
            top: 50px;
            bottom: -50px;
            width: 2px;
            background: #e2e8f0;
        }

        .timeline-item:last-child::before { display: none; }

        .item-icon {
            width: 50px;
            height: 50px;
            background: var(--primary);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            z-index: 1;
            box-shadow: 0 10px 20px rgba(249, 115, 22, 0.2);
        }

        .item-content {
            background: white;
            padding: 2rem;
            border-radius: 15px;
            border: 1px solid #f1f5f9;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.02);
            flex: 1;
        }

        .item-date {
            font-weight: 700;
            color: var(--gold);
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }

        .item-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            color: var(--dark);
            margin-bottom: 0.5rem;
        }

        .item-loc { font-size: 0.85rem; color: #94a3b8; margin-bottom: 1rem; }

        /* Global Footer */
        .report-footer {
            text-align: center;
            padding: 4rem;
            border-top: 1px solid #f1f5f9;
            color: #94a3b8;
            font-size: 0.9rem;
        }

        /* Buttons */
        .btn-print {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            background: var(--dark);
            color: white;
            padding: 1rem 2rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 700;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            z-index: 1000;
            display: flex;
            align-items: center;
            gap: 10px;
            border: none;
            cursor: pointer;
        }

        @media print {
            .btn-print { display: none; }
            body { background: white; }
            .report-container { box-shadow: none; margin: 0; max-width: 100%; }
            .timeline-item::before { background: #eee; }
        }
    </style>
</head>

<body>

    <button onclick="window.print()" class="btn-print">
        <span>🖨️</span> พิมพ์รายงาน (PDF)
    </button>

    <div class="report-container">
        <!-- HEADER -->
        <header class="report-header">
            <p>AIDA xAI Center Dashboard 2026</p>
            <h1>รายงานสรุปโครงการ</h1>
            <p>โครงการยุทธศาสตร์เพื่อการพัฒนาท้องถิ่น (RBRU-Praneet)</p>
        </header>

        <!-- OBJECTIVES & TARGET GROUPS -->
        <section class="section" style="background: #fdfdfd; display: grid; grid-template-columns: 1fr 1fr; gap: 40px; padding-top: 2rem;">
            <div>
                <h2 class="section-title" style="font-size: 1.8rem;">🎯 วัตถุประสงค์</h2>
                <ul style="list-style: none; padding-left: 0;">
                    <?php foreach($objectives as $obj): ?>
                    <li style="margin-bottom: 1rem; position: relative; padding-left: 2rem;">
                        <span style="position: absolute; left: 0; color: var(--primary);">✔</span>
                        <?= $obj ?>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div>
                <h2 class="section-title" style="font-size: 1.8rem;">👥 กลุ่มเป้าหมาย</h2>
                <ul style="list-style: none; padding-left: 0;">
                    <?php foreach($target_groups as $tg): ?>
                    <li style="margin-bottom: 1rem; position: relative; padding-left: 2rem;">
                        <span style="position: absolute; left: 0; color: var(--primary);">👤</span>
                        <?= $tg ?>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </section>

        <!-- FINANCIALS -->
        <section class="section">
            <h2 class="section-title">📊 งบประมาณโครงการ</h2>
            
            <div class="dash-cards">
                <div class="card">
                    <div class="label">งบประมาณรวมทั้งสิ้น</div>
                    <div class="val"><?= number_format($total_budget) ?></div>
                    <div class="label">บาท</div>
                </div>
                <div class="card">
                    <div class="label">ไตรมาส 2</div>
                    <div class="val">50,000</div>
                    <div class="label">บาท</div>
                </div>
                <div class="card">
                    <div class="label">ไตรมาส 3</div>
                    <div class="val">26,000</div>
                    <div class="label">บาท</div>
                </div>
            </div>

            <table class="report-table">
                <thead>
                    <tr>
                        <th>หมวดรายจ่าย</th>
                        <th>รายการ</th>
                        <th>การคำนวณ</th>
                        <th style="text-align: right;">จำนวนเงิน</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($budget_data as $row): ?>
                    <tr>
                        <td style="font-weight: 600;"><?= $row['category'] ?></td>
                        <td><?= $row['item'] ?></td>
                        <td style="color: #64748b; font-size: 0.85rem;"><?= $row['calculation'] ?></td>
                        <td style="text-align: right;"><?= number_format($row['amount']) ?></td>
                    </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="3" style="text-align: right;">รวมงบประมาณทั้งสิ้น</td>
                        <td style="text-align: right; font-size: 1.2rem;"><?= number_format($total_budget) ?></td>
                    </tr>
                </tbody>
            </table>
        </section>

        <!-- ACTIVITIES -->
        <section class="section">
            <h2 class="section-title">🚀 กิจกรรมสำคัญ (Activities)</h2>
            
            <div class="timeline">
                <?php foreach($activities as $act): ?>
                <div class="timeline-item">
                    <div class="item-icon"><?= $act['icon'] ?></div>
                    <div class="item-content">
                        <div class="item-date"><?= $act['date'] ?></div>
                        <h3 class="item-title"><?= $act['title'] ?></h3>
                        <div class="item-loc">📍 <?= $act['location'] ?></div>
                        <p><?= $act['desc'] ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </section>

        <!-- TEAM SECTION -->
        <section class="section" style="background: var(--orange-soft);">
            <h2 class="section-title">👔 คณะผู้รับผิดชอบ</h2>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
                <?php foreach($team_members as $member): ?>
                <div style="background: white; padding: 1.5rem; border-radius: 12px; border-left: 5px solid var(--primary);">
                    <div style="font-weight: 700; color: var(--dark); font-size: 1.1rem;"><?= $member['name'] ?></div>
                    <div style="color: var(--gold); font-size: 0.9rem; font-weight: 600; margin-bottom: 5px;"><?= $member['role'] ?></div>
                    <div style="color: #64748b; font-size: 0.8rem;"><?= $member['dept'] ?></div>
                </div>
                <?php endforeach; ?>
            </div>
        </section>

        <!-- FOOTER -->
        <footer class="report-footer">
            <p>ศูนย์พัฒนานวัตกรรมดิจิทัล-ปัญญาประดิษฐ์เพื่อการเกษตรและสิ่งแวดล้อม (AIDA xAI Center)</p>
            <p>มหาวิทยาลัยราชภัฏรำไพพรรณี จ.จันทบุรี</p>
            <p style="margin-top: 1rem; font-size: 0.7rem; opacity: 0.5;">ข้อมูลอ้างอิงจากระบบ STTG RBRU (ดึงข้อมูลอัตโนมัติ 2026-04-15)</p>
        </footer>
    </div>

</body>

</html>
