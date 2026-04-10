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
    <title>Tech Showcase 2026 | Agri-Innovation Exhibition</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Noto+Sans+Thai:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- CSS -->
    <link rel="stylesheet" href="css/sections.css">
    
    <style>
        :root {
            --showcase-accent: #8b5cf6; /* Purple for Innovation/Future */
            --glass-bg: rgba(255, 255, 255, 0.7);
            --glass-border: rgba(255, 255, 255, 0.4);
        }

        .showcase-hero {
            background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('assets/images/activities/tech_showcase_v2.png');
            background-size: cover;
            background-position: center;
            height: 500px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
            margin-top: 80px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 2rem;
            margin-top: -60px;
            padding: 0 1rem;
        }

        .stat-card {
            background: var(--glass-bg);
            backdrop-filter: blur(10px);
            padding: 2rem;
            border-radius: var(--radius-2xl);
            border: 1px solid var(--glass-border);
            text-align: center;
            box-shadow: var(--shadow-xl);
        }

        .timeline-container {
            position: relative;
            max-width: 1000px;
            margin: 4rem auto;
            padding: 0 1rem;
        }

        .timeline-item {
            display: grid;
            grid-template-columns: 120px 1fr;
            gap: 2rem;
            margin-bottom: 2.5rem;
            padding: 1.5rem;
            background: white;
            border-radius: var(--radius-xl);
            box-shadow: var(--shadow-md);
            border-left: 5px solid var(--showcase-accent);
            transition: transform 0.3s;
        }

        .timeline-item:hover {
            transform: scale(1.02);
        }

        .timeline-time {
            font-weight: 800;
            color: var(--showcase-accent);
            font-size: 1.2rem;
        }

        .zone-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2.5rem;
            padding: 4rem 1rem;
        }

        .zone-card {
            background: white;
            border-radius: var(--radius-2xl);
            overflow: hidden;
            box-shadow: var(--shadow-lg);
            border: 1px solid rgba(0,0,0,0.05);
        }

        .zone-content {
            padding: 2rem;
        }

        .zone-tag {
            background: var(--showcase-accent);
            color: white;
            padding: 4px 12px;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 600;
            margin-bottom: 1rem;
            display: inline-block;
        }

        .award-banner {
            background: linear-gradient(135deg, #1e293b, #0f172a);
            color: white;
            padding: 5rem 1rem;
            text-align: center;
            border-radius: var(--radius-4xl);
            margin: 4rem 0;
        }

        .award-card {
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.1);
            padding: 2rem;
            border-radius: var(--radius-2xl);
            transition: all 0.3s;
        }

        .award-card:hover {
            background: rgba(255,255,255,0.1);
            border-color: var(--showcase-accent);
        }

    </style>
</head>

<body>
    <?php include 'components/navigation.php'; ?>

    <main>
        <!-- Showcase Hero -->
        <section class="showcase-hero">
            <div class="container">
                <span class="section-tag" style="background: var(--showcase-accent); color: white;">Grand Finale Event</span>
                <h1 style="font-size: 4rem; font-weight: 800; margin-bottom: 1rem; text-shadow: 0 5px 15px rgba(0,0,0,0.3);">Tech Showcase 2026</h1>
                <p style="font-size: 1.4rem; opacity: 0.9; max-width: 800px; margin: 0 auto;">มหกรรมแสดงผลงานนวัตกรรมดิจิทัลเกษตรและพิธีมอบรางวัลโครงงานยอดเยี่ยม</p>
                <div style="margin-top: 2.5rem;">
                    <button class="btn btn-primary" style="background: var(--showcase-accent);">Register to Attend</button>
                    <button class="btn btn-secondary" style="border-color: white; color: white;">Event Map</button>
                </div>
            </div>
        </section>

        <!-- Dynamic Stats Card -->
        <section class="container stats-grid">
            <div class="stat-card">
                <h3 style="color: var(--showcase-accent);">50+</h3>
                <p>Innovative Projects</p>
            </div>
            <div class="stat-card">
                <h3 style="color: var(--showcase-accent);">20+</h3>
                <p>Partner Schools</p>
            </div>
            <div class="stat-card">
                <h3 style="color: var(--showcase-accent);">500+</h3>
                <p>Visitors Expected</p>
            </div>
            <div class="stat-card">
                <h3 style="color: var(--showcase-accent);">฿100K+</h3>
                <p>Total Prizes</p>
            </div>
        </section>

        <!-- Event Timeline -->
        <section class="container" style="padding: 6rem 1rem;">
            <div class="section-header">
                <span class="section-tag">Agenda</span>
                <h2 class="section-title">ลำดับกิจกรรมวันงาน (5 ก.ย. 2569)</h2>
            </div>

            <div class="timeline-container">
                <div class="timeline-item">
                    <div class="timeline-time">08:30</div>
                    <div>
                        <h4>Registration & Welcome</h4>
                        <p class="small text-muted">ลงทะเบียนเข้าร่วมงานและรับของที่ระลึก ณ หอประชุมใหญ่</p>
                    </div>
                </div>
                <div class="timeline-item">
                    <div class="timeline-time">09:30</div>
                    <div>
                        <h4>Grand Opening</h4>
                        <p class="small text-muted">พิธีเปิดงานโดยอธิการบดี มหาวิทยาลัยราชภัฏรำไพพรรณี</p>
                    </div>
                </div>
                <div class="timeline-item">
                    <div class="timeline-time">10:30</div>
                    <div>
                        <h4>Exhibition Tour & Pitching</h4>
                        <p class="small text-muted">รับชมผลงานนวัตกรรมและการนำเสนอบนเวทีของทีมที่ผ่านเข้ารอบสุดท้าย</p>
                    </div>
                </div>
                <div class="timeline-item">
                    <div class="timeline-time">14:00</div>
                    <div>
                        <h4>Keynote: Future of Smart Agri</h4>
                        <p class="small text-muted">ปาฐกถาพิเศษจากผู้เชี่ยวชาญด้านเทคโนโลยีเกษตรระดับประเทศ</p>
                    </div>
                </div>
                <div class="timeline-item" style="border-left-color: #f59e0b;">
                    <div class="timeline-time" style="color: #f59e0b;">15:30</div>
                    <div>
                        <h4>Awards Ceremony</h4>
                        <p class="small text-muted">ประกาศผลและมอบรางวัลแก่ทีมชนะเลิศในโครงการต่างๆ</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Exhibition Zones -->
        <section class="container-fluid" style="background: #f8fafc; padding: 6rem 1rem;">
            <div class="container">
                <div class="section-header">
                    <span class="section-tag">Zones</span>
                    <h2 class="section-title">โซนการแสดงผลงาน</h2>
                </div>

                <div class="zone-grid">
                    <div class="zone-card">
                        <div class="zone-content">
                            <span class="zone-tag">AI Computing</span>
                            <h3>Climate Hacker Zone</h3>
                            <p>รวบรวมโมเดลพยากรณ์อากาศและการวิเคราะห์ข้อมูล Data Science ของนักเรียนที่ช่วยแก้ปัญหาสวนทุเรียน</p>
                        </div>
                    </div>
                    <div class="zone-card">
                        <div class="zone-content">
                            <span class="zone-tag">Image Processing</span>
                            <h3>Plant Vision Lab</h3>
                            <p>นิทรรศการระบบตรวจจับโรคพืชด้วย CNN และการประยุกต์ใช้โดรนในการสำรวจเกษตรแม่นยำ</p>
                        </div>
                    </div>
                    <div class="zone-card">
                        <div class="zone-content">
                            <span class="zone-tag">Smart Hardware</span>
                            <h3>AI-IoT Prototype Stage</h3>
                            <p>สาธิตระบบรดน้ำอัจฉริยะและเซ็นเซอร์ Node ที่นักเรียนสร้างขึ้นเองจากบอร์ด ESP32</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Award Preview -->
        <section class="container">
            <div class="award-banner">
                <h2 style="font-size: 2.5rem; margin-bottom: 2rem;">Prestige & Recognition</h2>
                <div class="grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 2rem; padding: 0 2rem;">
                    <div class="award-card">
                        <i style="font-size: 3rem; display: block; margin-bottom: 1rem;">🏆</i>
                        <h4>Innovation of the Year</h4>
                        <p class="small opacity-70">สุดยอดนวัตกรรมที่มีผลกระทบต่อภาคการเกษตรสูงสุด</p>
                    </div>
                    <div class="award-card">
                        <i style="font-size: 3rem; display: block; margin-bottom: 1rem;">💡</i>
                        <h4>Best Tech Prototype</h4>
                        <p class="small opacity-70">ผลงานที่มีการออกแบบฮาร์ดแวร์และซอฟต์แวร์ยอดเยี่ยม</p>
                    </div>
                    <div class="award-card">
                        <i style="font-size: 3rem; display: block; margin-bottom: 1rem;">🤝</i>
                        <h4>Community Impact Award</h4>
                        <p class="small opacity-70">นวัตกรรมที่สามารถนำไปใช้งานจริงในชุมชนได้ดีที่สุด</p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php include 'components/footer.php'; ?>

    <script>
        // Simple scroll reveal
        window.addEventListener('scroll', () => {
             // Logic for reveal effects if needed
        });
    </script>
</body>

</html>
