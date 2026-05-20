<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Poster - Saen Tung</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Chakra+Petch:wght@400;600;700&family=Noto+Sans+Thai:wght@300;400;600;800&family=Playfair+Display:wght@700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/speech-control.css">
    <style>
        :root {
            --primary: #f97316; /* Orange */
            --secondary: #1e293b; /* Slate */
            --accent-green: #10b981;
            --accent-blue: #3b82f6;
            --light: #f8fafc;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            background: #e2e8f0;
            font-family: 'Noto Sans Thai', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        /* A4 Size Paper */
        .poster-container {
            width: 210mm;
            height: 297mm;
            background: white;
            position: relative;
            box-shadow: 0 20px 50px rgba(0,0,0,0.15);
            overflow: hidden;
            background-image: 
                radial-gradient(circle at 100% 0%, rgba(249, 115, 22, 0.05) 0%, transparent 40%),
                radial-gradient(circle at 0% 100%, rgba(59, 130, 246, 0.05) 0%, transparent 40%);
        }

        /* Top Graphic Header */
        .header-graphic {
            background: linear-gradient(135deg, #0f172a 0%, var(--secondary) 100%);
            color: white;
            padding: 40px 30px;
            position: relative;
            clip-path: polygon(0 0, 100% 0, 100% 85%, 0 100%);
        }

        .rbru-logo {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            font-weight: 900;
            color: var(--primary);
            line-height: 1;
            margin-bottom: 20px;
        }

        .subtitle {
            font-family: 'Chakra Petch', sans-serif;
            color: #ccc;
            font-size: 1rem;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        .main-title {
            font-size: 2.8rem;
            font-weight: 800;
            margin-top: 10px;
            line-height: 1.2;
            color: white;
            text-shadow: 0 4px 10px rgba(0,0,0,0.5);
        }

        /* School Targeting */
        .school-badge {
            background: var(--accent-blue);
            color: white;
            display: inline-block;
            padding: 10px 25px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 1.4rem;
            margin-top: 25px;
            box-shadow: 0 10px 20px rgba(59, 130, 246, 0.3);
            border: 2px solid white;
            transform: rotate(-2deg);
        }

        /* Content Area */
        .content-body {
            padding: 20px 40px;
        }

        .intro-text {
            font-size: 1.2rem;
            color: #475569;
            line-height: 1.6;
            margin-bottom: 30px;
            text-align: justify;
        }

        /* The 3 Pillars */
        .pillars-container {
            display: grid;
            grid-template-columns: 1fr;
            gap: 20px;
        }

        .pillar-card {
            background: var(--light);
            border-left: 5px solid var(--primary);
            padding: 20px;
            border-radius: 0 15px 15px 0;
            display: flex;
            gap: 20px;
            align-items: center;
        }

        .pillar-card.cnn { border-left-color: var(--accent-green); }
        .pillar-card.iot { border-left-color: var(--accent-blue); }

        .pillar-icon {
            font-size: 3rem;
            min-width: 60px;
            text-align: center;
        }

        .pillar-info h3 {
            font-size: 1.4rem;
            color: var(--secondary);
            margin-bottom: 5px;
        }

        .pillar-info p {
            font-size: 1rem;
            color: #64748b;
            line-height: 1.4;
        }

        /* Call To Action */
        .cta-section {
            position: absolute;
            bottom: 40px;
            left: 40px;
            right: 40px;
            text-align: center;
            background: rgba(59, 130, 246, 0.1);
            border: 2px dashed var(--accent-blue);
            padding: 20px;
            border-radius: 15px;
        }

        .qr-placeholder {
            width: 100px;
            height: 100px;
            background: white;
            margin: 0 auto 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid #ccc;
            font-weight: bold;
            color: #ccc;
            border-radius: 10px;
        }

        .footer-text {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--secondary);
        }

        /* Print Settings */
        @media print {
            body { background: none; }
            .poster-container { box-shadow: none; width: 100%; height: 100%; page-break-after: avoid; }
            @page { size: A4; margin: 0; }
        }
    </style>
</head>
<body>

<div class="poster-container">
    
    <div class="header-graphic">
        <div class="rbru-logo">RBRU-Praneet<br><span style="font-size: 1.2rem; color: white; display: block; margin-top: 5px; font-family: 'Noto Sans Thai'; font-weight: 400;">ศูนย์พัฒนานวัตกรรมดิจิทัล-ปัญญาประดิษฐ์เพื่อการเกษตรและสิ่งแวดล้อม</span></div>
        <div class="subtitle">Future Innovator Hub 2026</div>
        <h1 class="main-title">เปิดรับสมัครยุววิศวกร<br>เทคโนโลยีการเกษตร</h1>
        <div class="school-badge">📍 โรงเรียนชุมชนวัดแสนตุ้ง</div>
    </div>

    <div class="content-body">
        <p class="intro-text">
            ศูนย์ AIDA xAI Center ขอเชิญชวนนักเรียนเครือข่ายพื้นที่ เข้าร่วมโครงการอบรมเชิงปฏิบัติการ <strong>"Agri-Tech Masterclass 2026"</strong> เพื่อยกระดับทักษะแห่งอนาคต พลิกโฉมการเกษตรไทยด้วยปัญญาประดิษฐ์ (AI) และเทคโนโลยี Edge Computing
        </p>

        <div class="pillars-container">
            <!-- Pillar 1 -->
            <div class="pillar-card">
                <div class="pillar-icon">🌦️</div>
                <div class="pillar-info">
                    <h3 style="color: var(--primary);">Data & Climate Hacking</h3>
                    <p>เรียนรู้ทักษะ Data Science วิเคราะห์ชุดข้อมูลสถิติสภาพภูมิอากาศ เพื่อทำนายผลผลิตและจัดการความเสี่ยงภาคการเกษตรด้วยภาษา Python</p>
                </div>
            </div>

            <!-- Pillar 2 -->
            <div class="pillar-card cnn">
                <div class="pillar-icon">🍃</div>
                <div class="pillar-info">
                    <h3 style="color: var(--accent-green);">Computer Vision AI (CNN)</h3>
                    <p>สร้างโครงข่ายประสาทเทียมให้คอมพิวเตอร์ ทำระบบตาทิพย์ตรวจจับโรคพืชและประเมินสุขภาพสวนทุเรียนจากภาพถ่ายระดับพิกเซล</p>
                </div>
            </div>

            <!-- Pillar 3 -->
            <div class="pillar-card iot">
                <div class="pillar-icon">🤖</div>
                <div class="pillar-info">
                    <h3 style="color: var(--accent-blue);">AI-IoT Edge Prototyping</h3>
                    <p>เจาะลึกฮาร์ดแวร์ไมโครคอนโทรลเลอร์ (ESP32) สั่งรดน้ำอัจฉริยะผ่านเซ็นเซอร์ และเชื่อมต่อโปรโตคอลความเร็วสูง</p>
                </div>
            </div>
        </div>
    </div>

    <div class="cta-section">
        <div style="display: flex; align-items: center; justify-content: center; gap: 30px;">
            <div class="qr-placeholder" style="flex-shrink: 0;">
                [ สแกน QR ]<br>เพื่อลงทะเบียน
            </div>
            <div style="text-align: left;">
                <p class="footer-text">✨ ด่วน! รับจำนวนจำกัดสำหรับนักเรียนชุมชนวัดแสนตุ้ง</p>
                <p style="color: var(--accent-blue); font-weight: bold; font-size: 1.2rem; margin-top: 5px;">ฟรีตลอดหลักสูตร พร้อมใบประกาศนียบัตร</p>
                <p style="font-size: 0.9rem; color: #64748b; margin-top: 5px;">สอบถามเพิ่มเติม: AIDA xAI Center — Center for AI Innovation & Development in Agriculture and Environment</p>
            </div>
        </div>
    </div>

</div>

    <script src="js/speech-control.js"></script>
</body>
</html>
