<?php
session_start();
$lang_code = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'th';
require_once "languages/{$lang_code}.php";
require_once "db_connect.php";

// GitHub Configuration (Change this when you upload to your repo)
$github_user = "TsanaPhysics";
$github_repo = "rbrupraneet_agri_inno2026";
$github_base = "https://github.com/$github_user/$github_repo/blob/main/notebooks/";
$colab_base = "https://colab.research.google.com/github/$github_user/$github_repo/blob/main/notebooks/";
?>
<!DOCTYPE html>
<html lang="<?php echo $lang_code; ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Climate Data Hacking | Interactive Workshop</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Noto+Sans+Thai:wght@300;400;500;600;700;800&family=Fira+Code:wght@400;500&display=swap" rel="stylesheet">
    
    <!-- CSS -->
    <link rel="stylesheet" href="css/sections.css">
    <!-- Prism.js for Code Highlighting -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/themes/prism-tomorrow.min.css" rel="stylesheet" />
    
    <style>
        :root {
            --code-bg: #1e1e1e;
            --workshop-accent: #f97316;
        }

        .workshop-hero {
            background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('assets/images/activities/climate_hacking.png');
            background-size: cover;
            background-position: center;
            height: 400px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
            margin-top: 80px;
        }

        .session-card {
            background: white;
            border-radius: var(--radius-2xl);
            padding: 2.5rem;
            margin-bottom: 3rem;
            box-shadow: var(--shadow-lg);
            border: 1px solid rgba(0,0,0,0.05);
            transition: all 0.3s ease;
        }

        .session-tag {
            background: var(--workshop-accent);
            color: white;
            padding: 4px 12px;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 600;
            display: inline-block;
            margin-bottom: 1rem;
        }

        .code-container {
            position: relative;
            margin: 1.5rem 0;
            border-radius: var(--radius-lg);
            overflow: hidden;
            background: var(--code-bg);
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }

        .code-header {
            background: #2d2d2d;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: #eee;
            font-size: 0.8rem;
            border-bottom: 1px solid #3d3d3d;
        }

        .code-actions {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .code-btn {
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.1);
            color: #ccc;
            padding: 5px 10px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 0.75rem;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: all 0.2s;
        }

        .code-btn:hover {
            background: rgba(255,255,255,0.1);
            color: white;
            border-color: var(--workshop-accent);
        }

        .btn-colab:hover {
            background: rgba(249, 115, 22, 0.1);
            color: #f97316;
            border-color: #f97316;
        }

        pre[class*="language-"] {
            margin: 0 !important;
            padding: 1.5rem !important;
            font-family: 'Fira Code', monospace !important;
            font-size: 0.9rem !important;
        }

        .interactive-guide {
            display: grid;
            grid-template-columns: 320px 1fr;
            gap: 3rem;
            margin-top: 3rem;
        }

        .guide-nav {
            position: sticky;
            top: 100px;
            height: fit-content;
        }

        .nav-item {
            padding: 1.2rem;
            border-radius: var(--radius-lg);
            margin-bottom: 0.8rem;
            cursor: pointer;
            transition: all 0.3s;
            border-left: 4px solid transparent;
            background: rgba(0,0,0,0.02);
        }

        .nav-item.active {
            background: rgba(249, 115, 22, 0.08);
            color: var(--workshop-accent);
            border-left-color: var(--workshop-accent);
            font-weight: 600;
        }

        @media (max-width: 992px) {
            .interactive-guide { grid-template-columns: 1fr; }
            .guide-nav { display: none; }
        }
    </style>
</head>

<body>
    <?php include 'components/navigation.php'; ?>

    <main>
        <!-- Workshop Hero -->
        <section class="workshop-hero">
            <div class="container">
                <h1 style="font-size: 3.5rem; font-weight: 800; margin-bottom: 1rem;">Climate Data Hacking</h1>
                <p style="font-size: 1.2rem; opacity: 0.9;">Workshop กิจกรรมที่ 1: การวิเคราะห์ข้อมูลสภาพภูมิอากาศด้วย Python สำหรับนักเรียน</p>
                <div style="margin-top: 2rem; display: flex; gap: 15px; justify-content: center; flex-wrap: wrap;">
                    <a href="docs/climate_hacking_full_manual.md" class="btn btn-primary" style="background: var(--workshop-accent); color: white; border: none; box-shadow: 0 10px 20px rgba(249, 115, 22, 0.3); text-shadow: 0 1px 2px rgba(0,0,0,0.2);">📖 Full Manual (คู่มือฉบับเต็ม)</a>
                    <a href="scripts/climate_starter.py" class="btn btn-glass">🐍 Download Starter Script (.py)</a>
                    <a href="data/chanthaburi_climate_sample.csv" class="btn btn-glass">📊 Dataset (.CSV)</a>
                </div>
            </div>
        </section>

        <section class="container" style="padding: 4rem 1rem;">
            <div class="interactive-guide">
                <!-- Side Nav -->
                <aside class="guide-nav">
                    <div class="nav-item active" onclick="scrollToSession('session-1')">Session 1: Python Basics</div>
                    <div class="nav-item" onclick="scrollToSession('session-2')">Session 2: API & TMD Data</div>
                    <div class="nav-item" onclick="scrollToSession('session-3')">Session 3: Data Detective</div>
                    <div class="nav-item" onclick="scrollToSession('session-4')">Session 4: Smart Advisor</div>
                </aside>

                <!-- Content Area -->
                <div class="guide-content">
                    
                    <!-- Session 1 -->
                    <div id="session-1" class="session-card">
                        <span class="session-tag">Session 1 (3 Hours)</span>
                        <h2>ปฐมบทนักโปรแกรมเมอร์เกษตร</h2>
                        <p>เริ่มต้นเรียนรู้พื้นฐาน Python ที่จำเป็นสำหรับการจัดการข้อมูลเกษตร เช่น ตัวแปร (Variables) และการคำนวณพื้นฐาน</p>
                        
                        <div class="theory-panel" style="background: rgba(249, 115, 22, 0.05); border-left: 4px solid var(--workshop-accent); padding: 1.5rem; margin-bottom: 1.5rem; border-radius: var(--radius-md);">
                            <h4 style="color: var(--workshop-accent); margin-bottom: 0.5rem;">📚 ทฤษฎี: ดัชนีความร้อน (Heat Index)</h4>
                            <p style="font-size: 0.9rem; color: var(--text-secondary);">ดัชนีความร้อน คือ อุณหภูมิที่สิ่งมีชีวิตรู้สึกจริงจากการรวมกันของ "อุณหภูมิ" และ "ความชื้น" (Apparent Temperature) ในพื้นที่จันทบุรีที่มีความชื้นสูง ค่า HI จะสูงกว่าอุณหภูมิจริงมาก ซึ่งเป็นปัจจัยวิกฤตที่ทำให้ดอกทุเรียนร่วงได้</p>
                        </div>

                        <div class="code-container">
                            <div class="code-header">
                                <span>📁 session1_basics.ipynb</span>
                                <div class="code-actions">
                                    <a href="<?php echo $github_base; ?>session1_basics.ipynb" target="_blank" class="code-btn">GitHub</a>
                                    <a href="<?php echo $colab_base; ?>session1_basics.ipynb" target="_blank" class="code-btn btn-colab">Open in Colab</a>
                                    <button class="code-btn" onclick="copyCode(this)">Copy</button>
                                </div>
                            </div>
                            <pre><code class="language-python"># โปรแกรมคำนวณดัชนีความร้อน (Heat Index) แบบง่าย
temp = 32.5
humidity = 80

# ตรรกะการวิเคราะห์
heat_index = temp + (0.05 * humidity)

print(f"อุณหภูมิปัจจุบัน: {temp} °C")
print(f"ความรู้สึกจริง: {heat_index:.2f} °C")

if heat_index > 35:
    print("แจ้งเตือน: อากาศร้อนเกินไปสำหรับทุเรียนอ่อน!")</code></pre>
                        </div>

                        <div class="code-walkthrough" style="font-size: 0.85rem; color: var(--text-secondary); margin-top: 1rem;">
                            <h5 style="color: var(--text-primary); margin-bottom: 0.5rem;">🔍 เจาะลึกโค้ด (Code Walkthrough)</h5>
                            <ul style="padding-left: 1.2rem;">
                                <li><code>temp</code> & <code>humidity</code>: การประกาศตัวแปรเพื่อเก็บค่าคงที่จากเซ็นเซอร์</li>
                                <li><code>heat_index</code>: การคำนวณปรับแต่งอุณหภูมิด้วยค่าความชื้น (Mathematical Modeling)</li>
                                <li><code>if heat_index > 35</code>: การใช้ตรรกะตัดสินใจแบบอัตโนมัติ (Automated Decision Making)</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Session 2 -->
                    <div id="session-2" class="session-card">
                        <span class="session-tag">Session 2 (3 Hours)</span>
                        <h2>เชื่อมต่อฟาร์มเข้ากับโลกข้อมูล</h2>
                        <p>เรียนรู้การใช้ Python ดึงข้อมูลพยากรณ์อากาศแบบ Real-time จากกรมอุตุนิยมวิทยา (TMD) ผ่าน API</p>
                        
                        <div class="code-container">
                            <div class="code-header">
                                <span>📁 session2_api.ipynb</span>
                                <div class="code-actions">
                                    <a href="<?php echo $github_base; ?>session2_api.ipynb" target="_blank" class="code-btn">GitHub</a>
                                    <a href="<?php echo $colab_base; ?>session2_api.ipynb" target="_blank" class="code-btn btn-colab">Open in Colab</a>
                                    <button class="code-btn" onclick="copyCode(this)">Copy</button>
                                </div>
                            </div>
                            <pre><code class="language-python">import requests

def get_weather():
    # ตัวอย่างการส่งคำขอไปยัง API กรมอุตุฯ
    url = "https://data.tmd.go.th/api/v1/daily?station_id=48480"
    
    # หมายเหตุ: ในโรงเรียนเราจะใช้ API Key ที่ทีมวิทยากรเตรียมไว้ให้
    print("กำลังดึงข้อมูลจากสถานีจันทบุรี...")
    
    # จำลองข้อมูลที่ได้จาก API
    data = {
        "status": "Rainy",
        "rain_mm": 45.5,
        "wind_speed": 12.0
    }
    return data

weather = get_weather()
print(f"ปริมาณฝนวันนี้: {weather['rain_mm']} mm")</code></pre>
                        </div>
                    </div>

                    <!-- Session 3 -->
                    <div id="session-3" class="session-card">
                        <span class="session-tag">Session 3 (3 Hours)</span>
                        <h2>นักสืบข้อมูล (Data Detective)</h2>
                        <p>ใช้ห้องสมุด Pandas เพื่ออ่านและวิเคราะห์ข้อมูลพยากรณ์อากาศย้อนหลัง 10 ปี เพื่อหาความผิดปกติของฤดูกาล</p>
                        
                        <div class="theory-panel" style="background: rgba(79, 172, 254, 0.05); border-left: 4px solid var(--workshop-accent); padding: 1.5rem; margin-bottom: 1.5rem; border-radius: var(--radius-md);">
                            <h4 style="color: var(--workshop-accent); margin-bottom: 0.5rem;">📚 ทฤษฎี: การวิเคราะห์ความผิดปกติ (Anomaly Detection)</h4>
                            <p style="font-size: 0.9rem; color: var(--text-secondary);">ในการวิเคราะห์ข้อมูลเกษตรแม่นยำ (Precision Agri) เราต้องหาข้อมูลที่ "ผิดปกติ" (Outliers) เช่น ปีที่ฝนตกหนักเกินปกติ หรือช่วงที่อุณหภูมิพุ่งสูงกะทันหัน ซึ่งอาจบ่งบอกถึงความเสี่ยงของศัตรูพืช การใช้ค่าเฉลี่ยเคลื่อนที่ (Moving Average) จะช่วยให้เราเห็นเทรนด์ที่แท้จริงท่ามกลางข้อมูลที่ผันผวน</p>
                        </div>

                        <div class="code-container">
                            <div class="code-header">
                                <span>📁 session3_data.ipynb</span>
                                <div class="code-actions">
                                    <a href="<?php echo $github_base; ?>session3_data.ipynb" target="_blank" class="code-btn">GitHub</a>
                                    <a href="<?php echo $colab_base; ?>session3_data.ipynb" target="_blank" class="code-btn btn-colab">Open in Colab</a>
                                    <button class="code-btn" onclick="copyCode(this)">Copy</button>
                                </div>
                            </div>
                            <pre><code class="language-python">import pandas as pd
import numpy as np

# อ่านข้อมูลและคำนวณค่าเฉลี่ยเคลื่อนที่ (Moving Average)
df = pd.read_csv('chanthaburi_climate_sample.csv')
df['Moving_Avg'] = df['Rainfall_mm'].rolling(window=3).mean()

# ค้นหาช่วงที่ฝนตก "เกินปกติ" (Anomaly)
threshold = df['Rainfall_mm'].mean() + (2 * df['Rainfall_mm'].std())
anomalies = df[df['Rainfall_mm'] > threshold]

print("--- ตรวจพบความผิดปกติของปริมาณฝน ---")
print(anomalies[['Year', 'Month', 'Rainfall_mm']])</code></pre>
                        </div>
                    </div>

                    <!-- Session 4 -->
                    <div id="session-4" class="session-card">
                        <span class="session-tag">Session 4 (3 Hours)</span>
                        <h2>สร้างระบบแจ้งเตือนอัจฉริยะ</h2>
                        <p>โปรเจกต์จบ: เขียนโปรแกรมวิเคราะห์แนวโน้มล่วงหน้าและส่งคำแนะนำให้กับเกษตรกร</p>
                        
                        <div class="theory-panel" style="background: rgba(79, 172, 254, 0.05); border-left: 4px solid var(--workshop-accent); padding: 1.5rem; margin-bottom: 1.5rem; border-radius: var(--radius-md);">
                            <h4 style="color: var(--workshop-accent); margin-bottom: 0.5rem;">📚 ทฤษฎี: ระบบสนับสนุนการตัดสินใจ (Decision Support System)</h4>
                            <p style="font-size: 0.9rem; color: var(--text-secondary);">หัวใจของ "Digital Farmer" คือการเปลี่ยนข้อมูลเป็น "คำสั่งการ" ระบบ DSS จะใช้ตรรกะแบบ Fuzzy หรือ Decision Tree เพื่อพิจารณาทั้งระยะการเจริญเติบโตของพืชและสภาพอากาศพร้อมกัน เพื่อส่งคำแนะนำที่แม่นยำที่สุดผ่าน LINE หรือ Dashboard</p>
                        </div>

                        <div class="code-container">
                            <div class="code-header">
                                <span>📁 session4_advisor.ipynb</span>
                                <div class="code-actions">
                                    <a href="<?php echo $github_base; ?>session4_advisor.ipynb" target="_blank" class="code-btn">GitHub</a>
                                    <a href="<?php echo $colab_base; ?>session4_advisor.ipynb" target="_blank" class="code-btn btn-colab">Open in Colab</a>
                                    <button class="code-btn" onclick="copyCode(this)">Copy</button>
                                </div>
                            </div>
                            <pre><code class="language-python">def farm_advisor(rain_prediction, humidity, crop_stage):
    # ตรรกะแบบผสมผสาน (Hybrid Logic)
    if crop_stage == "flowering":
        if rain_prediction > 50 or humidity > 85:
            return "🚨 ALERT: สภาพอากาศเสี่ยงต่อการเกิดเชื้อราและดอกร่วง! รีบฉีดพ่นสารป้องกัน"
        return "✨ OPTIMAL: สภาพอากาศดีมากสำหรับการผสมเกสร"
    
    elif crop_stage == "fruiting":
        if rain_prediction < 10:
            return "💧 ADVISE: ต้องการน้ำสม่ำเสมอเพื่อการขยายขนาดผล"
        return "✅ STATUS: สภาพอากาศปกติ"

# ทดสอบระบบ Advisor
message = farm_advisor(65, 90, "flowering")
print(f"RBRU-AI Advisor: {message}")</code></pre>
                        </div>
                    </div>

                    <!-- 3D XR Simulator Preview -->
                    <div class="mt-20 p-10 rounded-[2.5rem] bg-gradient-to-br from-slate-900 to-indigo-950 text-white relative overflow-hidden group border border-white/10">
                        <div class="absolute inset-0 opacity-40 mix-blend-overlay">
                            <img src="assets/images/simulators/climate_3d_preview.png" alt="3D Climate Simulator" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-1000">
                        </div>
                        <div class="relative z-10">
                            <div class="flex flex-col md:flex-row items-center gap-8 mb-8">
                                <div class="w-20 h-20 rounded-3xl bg-blue-500/20 backdrop-filter blur-xl flex items-center justify-center text-4xl shadow-inner border border-white/20">👓</div>
                                <div class="text-center md:text-left">
                                    <h3 class="text-3xl font-black mb-2">3D Climate XR Simulator</h3>
                                    <p class="text-blue-300">สัมผัสโมเดลพยากรณ์อากาศในโลกเสมือนจริง</p>
                                </div>
                            </div>
                            <p class="text-slate-300 mb-10 leading-relaxed text-lg max-width: 600px;">
                                ข้อมูลที่คุณวิเคราะห์ด้วย Python จะถูกส่งต่อไปยังระบบจำลอง 3D Twin เพื่อให้นักเรียนสามารถมองเห็นภาพ "ความร้อนสะสม" และ "ทิศทางลม" 
                                ในสวนทุเรียนจำลองได้แบบ 360 องศา ช่วยให้ตัดสินใจวางแผนการเพาะปลูกในโลกจริงได้อย่างแม่นยำยิ่งขึ้น
                            </p>
                            <div class="flex flex-wrap items-center gap-6">
                                <a href="virtual-lab.php?scenario=climate" class="btn btn-primary" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); border: none; padding: 15px 35px; border-radius: 50px;">
                                    <span class="mr-2">🕹️</span> Enter Simulation
                                </a>
                                <div class="flex items-center gap-2 px-4 py-2 rounded-full bg-white/5 border border-white/10 text-[10px] font-black uppercase tracking-widest text-blue-400">
                                    <span class="w-2 h-2 bg-blue-500 rounded-full animate-pulse"></span>
                                    Real-time Data Ready
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </main>

    <?php include 'components/footer.php'; ?>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/prism.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-python.min.js"></script>
    
    <script>
        function copyCode(btn) {
            const pre = btn.parentElement.nextElementSibling;
            const code = pre.textContent;
            navigator.clipboard.writeText(code).then(() => {
                const originalText = btn.textContent;
                btn.textContent = 'Copied!';
                btn.style.borderColor = '#4facfe';
                setTimeout(() => {
                    btn.textContent = originalText;
                    btn.style.borderColor = '#555';
                }, 2000);
            });
        }

        function scrollToSession(id) {
            document.getElementById(id).scrollIntoView({ behavior: 'smooth' });
            
            // Update active nav
            document.querySelectorAll('.nav-item').forEach(item => {
                item.classList.remove('active');
                if(item.textContent.includes(id.replace('session-', '').toUpperCase())) {
                    // This logic is a bit simple, can be improved
                }
            });
        }

        // Simple scroll spy logic
        window.addEventListener('scroll', () => {
            const sessions = ['session-1', 'session-2', 'session-3', 'session-4'];
            let current = '';
            
            sessions.forEach(id => {
                const element = document.getElementById(id);
                const rect = element.getBoundingClientRect();
                if (rect.top <= 150) {
                    current = id;
                }
            });

            document.querySelectorAll('.nav-item').forEach(item => {
                item.classList.remove('active');
                if (item.getAttribute('onclick').includes(current)) {
                    item.classList.add('active');
                }
            });
        });
    </script>
</body>

</html>
