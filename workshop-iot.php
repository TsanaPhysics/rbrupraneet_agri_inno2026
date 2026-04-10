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
                    <a href="docs/iot_smart_sensor_manual.md" class="btn btn-primary" style="background: var(--workshop-accent); color: white; border: none; box-shadow: 0 10px 20px rgba(59, 130, 246, 0.3); text-shadow: 0 1px 2px rgba(0,0,0,0.2);">📖 Full Manual (คู่มือฉบับเต็ม)</a>
                    <a href="scripts/iot_sensor_hub.py" class="btn btn-glass">🐍 Download MicroPython Script (.py)</a>
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
                    
                        <div class="theory-panel" style="background: rgba(59, 130, 246, 0.05); border-left: 4px solid var(--workshop-accent); padding: 1.5rem; margin-bottom: 1.5rem; border-radius: var(--radius-md);">
                            <h4 style="color: var(--workshop-accent); margin-bottom: 0.5rem;">📚 ทฤษฎี: โลกของสัญญาณดิจิทัล (Digital I/O)</h4>
                            <p style="font-size: 0.9rem; color: var(--text-secondary);">ในการทำเกษตรอัจฉริยะ บอร์ด ESP32 ทำหน้าที่เป็น "สมอง" ที่สั่งการผ่านสัญญาณไฟฟ้า 0 หรือ 1 (Low/High) การควบคุมขา Pin ให้เป็น 1 จะทำให้กระแสไหลไปเปิดอุปกรณ์ เช่น ปั๊มน้ำ หรือวาล์วไฟฟ้า นี่คือจุดเริ่มต้นของการสร้างระบบอัตโนมัติ</p>
                        </div>

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

                        <div class="code-walkthrough" style="font-size: 0.85rem; color: var(--text-secondary); margin-top: 1rem;">
                            <h5 style="color: var(--text-primary); margin-bottom: 0.5rem;">🔍 เจาะลึกโค้ด (Code Walkthrough)</h5>
                            <ul style="padding-left: 1.2rem;">
                                <li><code>from machine import Pin</code>: การเรียกใช้คลังคำสั่งเพื่อจัดการฮาร์ดแวร์โดยตรง</li>
                                <li><code>Pin(2, Pin.OUT)</code>: ตั้งค่าขาหมายเลข 2 ของ ESP32 ให้ทำหน้าที่เป็น "ขาออก" (Output)</li>
                                <li><code>led.value(not led.value())</code>: ตรรกะการสลับสถานะไฟฟ้า (Toggle) เพื่อสร้างไฟกระพริบ</li>
                            </ul>
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

                        <div class="theory-panel" style="background: rgba(59, 130, 246, 0.05); border-left: 4px solid var(--workshop-accent); padding: 1.5rem; margin-bottom: 1.5rem; border-radius: var(--radius-md);">
                            <h4 style="color: var(--workshop-accent); margin-bottom: 0.5rem;">📚 ทฤษฎี: ความปลอดภัยของข้อมูล IoT (MQTT Security)</h4>
                            <p style="font-size: 0.9rem; color: var(--text-secondary);">ในระบบอุตสาหกรรมการเกษตร ข้อมูลเซ็นเซอร์คือความลับทางการค้า เราต้องป้องกันการดักฟังด้วยการใช้ TLS/SSL และการทำ Data Hashing ก่อนส่งขึ้น Cloud เพื่อให้มั่นใจว่าคำสั่งรดน้ำมาจาก "สมองกล" ของเราจริงๆ ไม่ใช่การโจมตีจากภายนอก</p>
                        </div>

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
import hashlib
from umqtt.simple import MQTTClient

# ฟังก์ชันเข้ารหัสข้อมูลก่อนส่ง (Hashing)
def secure_payload(data):
    return hashlib.sha256(data.encode()).hexdigest()

client = MQTTClient('esp32_rbru', 'broker.hivemq.com', port=1883)
client.connect()
payload = secure_payload("Moisture: 45%")
client.publish('rbru/secure/orchard', payload)
print("🔐 Encrypted data sent to Cloud")</code></pre>
                        </div>
                    </div>

                    <!-- Session 4 -->
                    <div id="session-4" class="session-card">
                        <span class="session-tag">Session 4 (3 Hours)</span>
                        <h2>การประหยัดพลังงานและการตัดสินใจ (Deep Sleep & Logic)</h2>
                        <p>เรียนรู้การใช้โหมดประหยัดพลังงานขั้นสูง (Deep Sleep) เพื่อการใช้งานในพื้นที่ที่ไม่มีไฟฟ้า และการเขียนตรรกะตัดสินใจที่ซับซ้อนแม่นยำขึ้น</p>
                        
                        <div class="theory-panel" style="background: rgba(59, 130, 246, 0.05); border-left: 4px solid var(--workshop-accent); padding: 1.5rem; margin-bottom: 1.5rem; border-radius: var(--radius-md);">
                            <h4 style="color: var(--workshop-accent); margin-bottom: 0.5rem;">📚 ทฤษฎี: การประหยัดพลังงานระดับอุตสาหกรรม (Deep Sleep)</h4>
                            <p style="font-size: 0.9rem; color: var(--text-secondary);">เซ็นเซอร์ในสวนทุเรียนมักทำงานด้วยแบตเตอรี่หรือโซลาร์เซลล์ การประหยัดพลังงานจึงสำคัญที่สุด เราจะใช้โหมด Deep Sleep เพื่อปิดการทำงานของ CPU เกือบทั้งหมด และตื่นขึ้นมาส่งข้อมูลเพียงเสี้ยววินาที เพื่อให้แบตเตอรี่ใช้งานได้นานหลายเดือน</p>
                        </div>

                        <div class="code-container">
                            <div class="code-header">
                                <span>📁 iot_s4.ipynb</span>
                                <div class="code-actions">
                                    <a href="<?php echo $github_base; ?>iot_s4.ipynb" target="_blank" class="code-btn">GitHub</a>
                                    <a href="<?php echo $colab_base; ?>iot_s4.ipynb" target="_blank" class="code-btn btn-colab">Open in Colab</a>
                                    <button class="code-btn" onclick="copyCode(this)">Copy</button>
                                </div>
                            </div>
                            <pre><code class="language-python">import machine
import time

# อ่านค่าและส่งข้อมูล
read_and_send()

print("💤 Entering Deep Sleep for 1 hour...")
# สั่งให้ ESP32 หลับลึกเป็นเวลา 1 ชั่วโมง (3600000ms)
machine.deepsleep(3600000)</code></pre>
                        </div>
                    </div>

                    <!-- 3D Digital Twin Simulator Preview -->
                    <div class="mt-20 p-10 rounded-[2.5rem] bg-gradient-to-br from-slate-900 to-blue-950 text-white relative overflow-hidden group border border-blue-500/20">
                        <div class="absolute inset-0 opacity-40 mix-blend-overlay">
                            <img src="assets/images/simulators/iot_3d_preview.png" alt="3D Digital Twin Simulator" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-1000">
                        </div>
                        <div class="relative z-10">
                            <div class="flex flex-col md:flex-row items-center gap-8 mb-8">
                                <div class="w-20 h-20 rounded-3xl bg-blue-500/20 backdrop-filter blur-xl flex items-center justify-center text-4xl shadow-inner border border-white/20">🖥️</div>
                                <div class="text-center md:text-left">
                                    <h3 class="text-3xl font-black mb-2">3D Digital Twin Command Hub</h3>
                                    <p class="text-blue-300">ควบคุมสวนทุเรียนจากปลายนิ้วผ่านโลกคู่ขนานดิจิทัล</p>
                                </div>
                            </div>
                            <p class="text-slate-300 mb-10 leading-relaxed text-lg max-width: 600px;">
                                เชื่อมต่อข้อมูลจากเซ็นเซอร์ ESP32 จริงของคุณเข้ากับโมเดล Digital Twin แบบ 3 มิติ 
                                เมื่อคุณสั่งรดน้ำในโลกเสมือน ระบบจะส่งคำสั่งผ่าน MQTT กลับมายังฮาร์ดแวร์จริงในสวน พร้อมแสดงผลลัพธ์ผ่านเส้นสตรีมข้อมูลที่สวยงาม
                            </p>
                            <div class="flex flex-wrap items-center gap-6">
                                <a href="virtual-lab.php?scenario=iot" class="btn btn-primary" style="background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); border: none; padding: 15px 35px; border-radius: 50px;">
                                    <span class="mr-2">🔌</span> Connect Hardware
                                </a>
                                <div class="flex items-center gap-2 px-4 py-2 rounded-full bg-white/5 border border-white/10 text-[10px] font-black uppercase tracking-widest text-blue-400">
                                    <span class="w-2 h-2 bg-blue-500 rounded-full animate-pulse"></span>
                                    MQTT Stream Active
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
