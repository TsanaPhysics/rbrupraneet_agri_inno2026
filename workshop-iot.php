<?php
session_start();
$lang_code = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'th';
require_once "languages/{$lang_code}.php";
require_once "db_connect.php";

// GitHub Configuration
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
    <title>AI-IoT Prototyping Workshop | Interactive Workshop</title>
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
            --workshop-accent: #3b82f6; /* Blue for IoT/Connectivity */
        }

        .workshop-hero {
            background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('assets/images/activities/iot_smart_sensor.png');
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
            background: rgba(59, 130, 246, 0.08);
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
                <h1 style="font-size: 3.5rem; font-weight: 800; margin-bottom: 1rem;">AI-IoT Prototyping</h1>
                <p style="font-size: 1.2rem; opacity: 0.9;">กิจกรรมที่ 3: การสร้างต้นแบบเซ็นเซอร์อัจฉริยะและการวิเคราะห์ข้อมูลแบบ Edge Computing</p>
                <div style="margin-top: 2rem; display: flex; gap: 15px; justify-content: center; flex-wrap: wrap;">
                    <a href="docs/iot_smart_sensor_manual.md" class="btn btn-primary" style="background: var(--workshop-accent); color: white; border: none; box-shadow: 0 10px 20px rgba(59, 130, 246, 0.3);">📖 Full Manual (คู่มือฉบับเต็ม)</a>
                    <button class="btn btn-glass">📟 Hardware BOM List</button>
                    <a href="https://github.com/TsanaPhysics/rbrupraneet_agri_inno2026/tree/main/notebooks" class="btn btn-glass" target="_blank">🐙 View on GitHub</a>
                </div>
            </div>
        </section>

        <section class="container" style="padding: 4rem 1rem;">
            <div class="interactive-guide">
                <!-- Side Nav -->
                <aside class="guide-nav">
                    <div class="nav-item active" onclick="scrollToSession('session-1')">Session 1: ESP32 Basics</div>
                    <div class="nav-item" onclick="scrollToSession('session-2')">Session 2: Sensor Wiring</div>
                    <div class="nav-item" onclick="scrollToSession('session-3')">Session 3: Cloud & MQTT</div>
                    <div class="nav-item" onclick="scrollToSession('session-4')">Session 4: Edge AI Logic</div>
                </aside>

                <!-- Content Area -->
                <div class="guide-content">
                    
                    <!-- Session 1 -->
                    <div id="session-1" class="session-card">
                        <span class="session-tag">Session 1 (3 Hours)</span>
                        <h2>ฮาร์ดแวร์เพื่อโลกสีเขียว</h2>
                        <p>ทำความรู้จักกับบอร์ด ESP32, พื้นฐานอิเล็กทรอนิกส์ และการเขียนโปรแกรมควบคุม Digital I/O ขั้นต้น</p>
                        
                        <div class="code-container">
                            <div class="code-header">
                                <span>📁 iot_s1.ipynb (MicroPython)</span>
                                <div class="code-actions">
                                    <a href="<?php echo $github_base; ?>iot_s1.ipynb" target="_blank" class="code-btn">GitHub</a>
                                    <a href="<?php echo $colab_base; ?>iot_s1.ipynb" target="_blank" class="code-btn btn-colab">Open in Colab</a>
                                    <button class="code-btn" onclick="copyCode(this)">Copy</button>
                                </div>
                            </div>
                            <pre><code class="language-python">from machine import Pin
import time

led = Pin(2, Pin.OUT)
while True:
    led.value(not led.value())
    time.sleep(1)</code></pre>
                        </div>
                    </div>

                    <!-- Session 2 -->
                    <div id="session-2" class="session-card">
                        <span class="session-tag">Session 2 (3 Hours)</span>
                        <h2>การดึงข้อมูลจากธรรมชาติ</h2>
                        <p>เรียนรู้การเชื่อมต่อเซ็นเซอร์วัดความชื้นในดินและอุณหภูมิ (Analog/Digital Sensors) และการสอบเทียบค่า (Calibration)</p>
                        
                        <div class="code-container">
                            <div class="code-header">
                                <span>📁 iot_s2.ipynb</span>
                                <div class="code-actions">
                                    <a href="<?php echo $github_base; ?>iot_s2.ipynb" target="_blank" class="code-btn">GitHub</a>
                                    <a href="<?php echo $colab_base; ?>iot_s2.ipynb" target="_blank" class="code-btn btn-colab">Open in Colab</a>
                                    <button class="code-btn" onclick="copyCode(this)">Copy</button>
                                </div>
                            </div>
                            <pre><code class="language-python">from machine import ADC, Pin

sensor = ADC(Pin(34))
val = sensor.read()
# แปลงค่า 0-4095 เป็น 0-100%
moisture = 100 - (val / 4095.0 * 100)
print(f"Moisture: {moisture}%")</code></pre>
                        </div>
                    </div>

                    <!-- Session 3 -->
                    <div id="session-3" class="session-card">
                        <span class="session-tag">Session 3 (3 Hours)</span>
                        <h2>ส่งข้อมูลสู่ก้อนเมฆ (Cloud Hosting)</h2>
                        <p>เชื่อมต่อบอร์ดเข้ากับ Wi-Fi และส่งข้อมูลไปยัง Dashboard แบบเรียลไทม์ผ่านโปรโตคอล MQTT</p>
                        
                        <div class="code-container">
                            <div class="code-header">
                                <span>📁 iot_s3.ipynb</span>
                                <div class="code-actions">
                                    <a href="<?php echo $github_base; ?>iot_s3.ipynb" target="_blank" class="code-btn">GitHub</a>
                                    <a href="<?php echo $colab_base; ?>iot_s3.ipynb" target="_blank" class="code-btn btn-colab">Open in Colab</a>
                                    <button class="code-btn" onclick="copyCode(this)">Copy</button>
                                </div>
                            </div>
                            <pre><code class="language-python">import network
from umqtt.simple import MQTTClient

wlan = network.WLAN(network.STA_IF)
wlan.active(True)
wlan.connect('SSID', 'PASS')

client = MQTTClient('esp32_01', 'broker.hivemq.com')
client.connect()
client.publish('rbru/agri/data', 'Hello Cloud!')</code></pre>
                        </div>
                    </div>

                    <!-- Session 4 -->
                    <div id="session-4" class="session-card">
                        <span class="session-tag">Session 4 (3 Hours)</span>
                        <h2>การตัดสินใจที่ชาญฉลาด (Edge AI)</h2>
                        <p>เขียนอัลกอริทึมการตัดสินใจรดน้ำอัตโนมัติ โดยใช้ตรรกะ AI ร่วมกับข้อมูลเซ็นเซอร์หลายตัวพร้อมกัน</p>
                        
                        <div class="code-container">
                            <div class="code-header">
                                <span>📁 iot_s4.ipynb</span>
                                <div class="code-actions">
                                    <a href="<?php echo $github_base; ?>iot_s4.ipynb" target="_blank" class="code-btn">GitHub</a>
                                    <a href="<?php echo $colab_base; ?>iot_s4.ipynb" target="_blank" class="code-btn btn-colab">Open in Colab</a>
                                    <button class="code-btn" onclick="copyCode(this)">Copy</button>
                                </div>
                            </div>
                            <pre><code class="language-python">def auto_pump(moisture, rain_forecast):
    if moisture < 40 and rain_forecast < 30:
        return True # เปิดปั๊ม
    return False # ปิดปั๊ม

print(f"Pump Action: {auto_pump(25, 10)}")</code></pre>
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
                btn.style.borderColor = '#3b82f6';
                setTimeout(() => {
                    btn.textContent = originalText;
                    btn.style.borderColor = '#555';
                }, 2000);
            });
        }

        function scrollToSession(id) {
            const element = document.getElementById(id);
            const offset = 100;
            const bodyRect = document.body.getBoundingClientRect().top;
            const elementRect = element.getBoundingClientRect().top;
            const elementPosition = elementRect - bodyRect;
            const offsetPosition = elementPosition - offset;

            window.scrollTo({ top: offsetPosition, behavior: 'smooth' });
        }

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
