<?php
session_start();
$lang_code = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'th';
require_once "languages/{$lang_code}.php";
require_once "db_connect.php";
?>
<!DOCTYPE html>
<html lang="<?php echo $lang_code; ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activity Plan 2026 | RBRU-Praneet Digital Agri-Innovation Center</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Noto+Sans+Thai:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/sections.css">
    <style>
        .plan-hero {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.05) 0%, rgba(118, 75, 162, 0.05) 100%);
            padding: 120px 0 60px;
            text-align: center;
        }

        .timeline-container {
            position: relative;
            max-width: 1000px;
            margin: 50px auto;
            padding: 20px;
        }

        .timeline-line {
            position: absolute;
            left: 50%;
            top: 0;
            bottom: 0;
            width: 4px;
            background: var(--primary-gradient);
            transform: translateX(-50%);
            border-radius: 2px;
            opacity: 0.2;
        }

        .timeline-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            margin-bottom: 50px;
            position: relative;
        }

        .timeline-item:nth-child(even) {
            flex-direction: row-reverse;
        }

        .timeline-content {
            width: 45%;
            padding: 25px;
            background: white;
            border-radius: var(--radius-xl);
            box-shadow: var(--shadow-lg);
            border: 1px solid rgba(0, 0, 0, 0.05);
            transition: all 0.4s ease;
        }

        .timeline-content:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-xl);
        }

        .timeline-dot {
            position: absolute;
            left: 50%;
            width: 25px;
            height: 25px;
            background: var(--primary-gradient);
            border-radius: 50%;
            transform: translateX(-50%);
            z-index: 1;
            border: 4px solid white;
            box-shadow: var(--shadow-md);
        }

        .timeline-date {
            width: 45%;
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--primary-color);
            text-align: right;
        }

        .timeline-item:nth-child(even) .timeline-date {
            text-align: left;
        }

        .calendar-section {
            background: var(--bg-secondary);
            padding: 80px 0;
        }

        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
            margin-top: 40px;
        }

        .calendar-month {
            background: white;
            padding: 20px;
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-md);
        }

        .month-name {
            font-weight: 800;
            color: var(--text-primary);
            margin-bottom: 15px;
            border-bottom: 2px solid var(--primary-color);
            padding-bottom: 8px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .event-item {
            font-size: 0.9rem;
            margin-bottom: 10px;
            display: flex;
            gap: 10px;
            align-items: flex-start;
        }

        .event-day {
            background: var(--primary-gradient);
            color: white;
            padding: 2px 8px;
            border-radius: 4px;
            font-weight: 600;
            min-width: 40px;
            text-align: center;
        }

        @media (max-width: 768px) {
            .timeline-line { left: 20px; }
            .timeline-dot { left: 20px; }
            .timeline-item { flex-direction: column !important; align-items: flex-start; padding-left: 50px; }
            .timeline-content { width: 100%; }
            .timeline-date { width: 100%; text-align: left !important; margin-bottom: 10px; font-size: 1.2rem; }
        }
    </style>
</head>

<body>
    <?php include 'components/navigation.php'; ?>

    <main>
        <!-- Page Hero -->
        <section class="plan-hero">
            <div class="container">
                <span class="section-tag" style="background: var(--primary-gradient); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Strategic Roadmap 2026</span>
                <h1 class="section-title">แผนการดำเนินงานจัดกิจกรรม</h1>
                <p class="section-description" style="max-width: 800px; margin: 0 auto;">
                    ตารางเวลาและรายละเอียดขั้นตอนการพัฒนาศักยภาพเยาวชนและเกษตรกร <br>ผ่าน 4 เวิร์กช็อปหลักภายใต้โครงการ RBRU-Praneet Agri-Inno
                </p>
            </div>
        </section>

        <!-- Interactive Timeline -->
        <section class="timeline-section">
            <div class="container">
                <div class="timeline-container">
                    <div class="timeline-line"></div>

                    <!-- Phase 1 -->
                    <div class="timeline-item">
                        <div class="timeline-date">มกราคม 2569</div>
                        <div class="timeline-dot"></div>
                        <div class="timeline-content">
                            <h3 style="color: var(--text-primary); margin-bottom: 10px;">Phase 1: Project Kickoff</h3>
                            <p style="color: var(--text-secondary); font-size: 0.95rem;">เตรียมความพร้อมด้านบุคลากร จัดซื้ออุปกรณ์ IoT สำนักพัฒนานวัตกรรมฯ และประสานงานโรงเรียนเครือข่าย</p>
                        </div>
                    </div>

                    <!-- Phase 2 -->
                    <div class="timeline-item">
                        <div class="timeline-date">กุมภาพันธ์ 2569</div>
                        <div class="timeline-dot"></div>
                        <div class="timeline-content">
                            <h3 style="color: var(--text-primary); margin-bottom: 10px;">Phase 2: Climate Data Hacking</h3>
                            <p style="color: var(--text-secondary); font-size: 0.95rem;">อบรมการใช้ Python เพื่อวิเคราะห์ข้อมูลสภาพภูมิอากาศย้อนหลัง 10 ปี เพื่อประเมินความเสี่ยงต่อพืชผล (Durian Climate Action)</p>
                            <div style="margin-top: 10px; font-weight: 600; color: var(--primary-color);">Workshop 1: Feb 15-17</div>
                        </div>
                    </div>

                    <!-- Phase 3 -->
                    <div class="timeline-item">
                        <div class="timeline-date">มีนาคม 2569</div>
                        <div class="timeline-dot"></div>
                        <div class="timeline-content">
                            <h3 style="color: var(--text-primary); margin-bottom: 10px;">Phase 3: Deep Dive Lab CNN</h3>
                            <p style="color: var(--text-secondary); font-size: 0.95rem;">สอนการสร้างโมเดลปัญญาประดิษฐ์เพื่อจำแนกโรคทุเรียนผ่านรูปถ่ายใบและลำต้น (Computer Vision Workshop)</p>
                            <div style="margin-top: 10px; font-weight: 600; color: var(--primary-color);">Workshop 2: Mar 20-22</div>
                        </div>
                    </div>

                    <!-- Phase 4 -->
                    <div class="timeline-item">
                        <div class="timeline-date">พฤษภาคม 2569</div>
                        <div class="timeline-dot"></div>
                        <div class="timeline-content">
                            <h3 style="color: var(--text-primary); margin-bottom: 10px;">Phase 4: AI-IoT Prototyping</h3>
                            <p style="color: var(--text-secondary); font-size: 0.95rem;">ประดิษฐ์ต้นแบบเซ็นเซอร์วัดความชื้นในดินและปุ๋ย พร้อมเชื่อมต่อ Dashboard สั่งการด้วย AI</p>
                            <div style="margin-top: 10px; font-weight: 600; color: var(--primary-color);">Workshop 3: May 15-17</div>
                        </div>
                    </div>

                    <!-- Phase 5 -->
                    <div class="timeline-item">
                        <div class="timeline-date">มิถุนายน 2569</div>
                        <div class="timeline-dot"></div>
                        <div class="timeline-content">
                            <h3 style="color: var(--text-primary); margin-bottom: 10px;">Phase 5: Tech Showcase</h3>
                            <p style="color: var(--text-secondary); font-size: 0.95rem;">มหกรรมแสดงผลงานนวัตกรรมดิจิทัลเกษตร และการประเมินผลสัมฤทธิ์ของเครือข่ายนวัตกรระดับชุมชน</p>
                            <div style="margin-top: 10px; font-weight: 600; color: var(--primary-color);">Final Expo: Jun 20</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Calendar Suggestion -->
        <section class="calendar-section">
            <div class="container">
                <div class="section-header">
                    <h2 class="section-title">ปฏิทินปฏิบัติงาน 2569</h2>
                    <p>ตารางสรุปแผนงานรายเดือนเพื่อการติดตามผล</p>
                </div>

                <div class="calendar-grid">
                    <div class="calendar-month">
                        <div class="month-name">มกราคม <span>Preparation</span></div>
                        <div class="event-item"><span class="event-day">W1</span> ประชุมทีมวิจัย</div>
                        <div class="event-item"><span class="event-day">W3</span> สั่งซื้อเซ็นเซอร์ IoT</div>
                    </div>
                    <div class="calendar-month">
                        <div class="month-name" style="border-color: #f5576c;">กุมภาพันธ์ <span>WS #1</span></div>
                        <div class="event-item"><span class="event-day">15</span> Climate Data Day 1</div>
                        <div class="event-item"><span class="event-day">17</span> Data visualization</div>
                    </div>
                    <div class="calendar-month">
                        <div class="month-name" style="border-color: #f5576c;">มีนาคม <span>WS #2</span></div>
                        <div class="event-item"><span class="event-day">20</span> AI Vision Intro</div>
                        <div class="event-item"><span class="event-day">22</span> CNN Model Training</div>
                    </div>
                    <div class="calendar-month">
                        <div class="month-name">เมษายน <span>Refining</span></div>
                        <div class="event-item"><span class="event-day">W2</span> ออนไลน์เทรนนิ่ง</div>
                        <div class="event-item"><span class="event-day">W4</span> เตรียมแปลงทดสอบ</div>
                    </div>
                    <div class="calendar-month">
                        <div class="month-name" style="border-color: #f5576c;">พฤษภาคม <span>WS #3</span></div>
                        <div class="event-item"><span class="event-day">15</span> IoT Hardwiring</div>
                        <div class="event-item"><span class="event-day">17</span> Field Installation</div>
                    </div>
                    <div class="calendar-month">
                        <div class="month-name" style="border-color: #00f2fe;">มิถุนายน <span>Showcase</span></div>
                        <div class="event-item"><span class="event-day">10</span> Prototype Finish</div>
                        <div class="event-item"><span class="event-day">20</span> Tech Showcase Night</div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php include 'components/footer.php'; ?>

    <script src="js/main.js"></script>
</body>

</html>
