import os
import json
import urllib.request
import urllib.error
import re
import sys

OLLAMA_API_URL = "http://localhost:11434/api/generate"
MODEL_NAME = "gemma4:latest"
BASE_DIR = "/Applications/XAMPP/xamppfiles/htdocs/rbrupraneet_agri_inno2026/aiiot2026"
OUTPUT_MERGED_FILE = "/Applications/XAMPP/xamppfiles/htdocs/rbrupraneet_agri_inno2026/aiiot2026/training_manual_expanded.md"

# System instructions to guarantee academic rigor, SI units, and Thai/English transliteration on first use
SYSTEM_INSTRUCTION = """
You are an Elite Thai Professor in Agricultural Physics, Precision Irrigation Engineering, and Internet of Things (รศ.ดร. ด้านฟิสิกส์การเกษตร วิศวกรรมชลประทานแม่นยำ และไอโอที).
Write in highly engaging, educational, and professional THAI language suitable for Junior High School students (มัธยมศึกษาตอนต้น) who are learning STEM and agricultural technology.
Maintain high academic rigor (Associate Professor standard) but explain concepts with step-by-step clarity, simple analogies, and detailed practical steps.
Ensure all scientific words have their English terms in parentheses on their first occurrence in this file, e.g., อินเทอร์เน็ตของสรรพสิ่ง (Internet of Things หรือ IoT), อนุกรมวิธานของบลูม (Bloom's Taxonomy).
Use standard SI units with a space between numbers and units (e.g., 3.3 V, 220 V, 10 m, 2.4 GHz, 5 s, 9600 bps, 1883 Port).
Ensure all mathematical models and equations are written using standard LaTeX math formatting ($...$ for inline and $$...$$ for block).
Provide production-grade code listings (C++ for Arduino, JavaScript for Node-RED) with extensive Thai comments explaining each line and the physics/logic behind it.
All relay code must be Active Low with high-voltage safety practices (such as HIGH initialization).
"""

sections = [
    {
        "filepath": "modules/00_front_matter/preface.md",
        "title": "คำนำ บทนำ และตารางวิเคราะห์การสอนสหวิทยาการฉบับยกระดับ (Preface & Advanced Pedagogical Matrix)",
        "instruction": """
        - เขียนชื่อคู่มือปฏิบัติการอย่างชัดเจน: "คู่มือปฏิบัติการวิศวกรรมระบบน้ำอัตโนมัติและไอโอทีเกษตรอัจฉริยะ 2568"
        - เขียนบทนำ/คำนำที่เป็นทางการ (Preface): เชื่อมโยงปัญหาจริงของการเปลี่ยนผ่านสภาพภูมิอากาศ (Climate Change), ความแห้งแล้ง, และการขาดแคลนน้ำในดินเหนียวชุดจันทบุรี/ตราด (Chanthaburi/Trat Clay) กับความต้องการระบบชลประทานอัจฉริยะแบบแม่นยำ (Precision Irrigation) ภายใต้แนวคิดเศรษฐกิจ BCG (Bio-Circular-Green Economy)
        - พัฒนาโครงสร้างแผนการสอนเชิงบูรณาการและวิเคราะห์ตามระดับการเรียนรู้ของบลูม (Bloom's Taxonomy) ในลักษณะตารางเมทริกซ์ 6 ระดับ (ความรู้, ความเข้าใจ, การประยุกต์ใช้, การวิเคราะห์, การประเมินค่า, และการสร้างสรรค์นวัตกรรม) เชื่อมโยงหัวข้อและกิจกรรมการอบรมทั้ง 8 แล็บ (Lab 1 ถึง Lab 8) อย่างเป็นระบบ ชัดเจน และครบถ้วนสมบูรณ์!
        - อธิบายวัตถุประสงค์เชิงพฤติกรรมและการเตรียมความพร้อมของเยาวชนเพื่อสร้างสรรค์เทคโนโลยีในพื้นที่จริง
        """
    },
    {
        "filepath": "modules/01_soil_hydraulics/1_1_vwc_calculation.md",
        "title": "1.1 การคำนวณเปอร์เซ็นต์ความชื้นดินเชิงปริมาตร (Volumetric Water Content: VWC)",
        "instruction": """
        - อธิบายความแตกต่างและความหมายทางฟิสิกส์ของ เปอร์เซ็นต์ความชื้นดินเชิงปริมาตร (Volumetric Water Content หรือ VWC) และความจุความชื้นที่เป็นประโยชน์ต่อพืช (Available Water Capacity หรือ AWC)
        - แสดงสูตรการคำนวณและอธิบายตัวแปรอย่างละเอียด:
          $$VWC (\%) = \\theta = \\frac{V_w}{V_t} \\times 100\%$$
          และ
          $$AWC = FC - PWP$$
        - อธิบายคุณลักษณะทางฟิสิกส์ของดิน 3 สถานะที่สำคัญในดินเหนียวชุดจันทบุรี/ตราด:
          1. จุดอิ่มตัวด้วยน้ำ (Saturation Point)
          2. ความจุความชื้นสูงสุดของดินหลังน้ำลด (Field Capacity หรือ FC)
          3. จุดเหี่ยวเฉาถาวร (Permanent Wilting Point หรือ PWP)
        - แสดงการนำทฤษฎีไปใช้งานจริงในการบริหารจัดการน้ำสำหรับต้นทุเรียน (Durian) โดยการรักษาระดับความชื้นดินในเขตรากให้อยู่ในช่วงร้อยละ 60 % ถึง 80 % ของ AWC เพื่อหลีกเลี่ยงสภาวะตึงเครียดจากน้ำ (Water Stress)
        - อธิบายหลักฟิสิกส์ของเซ็นเซอร์วัดดินแบบ FDR/TDR ในการวัดค่าคงที่ไดอิเล็กทริก (Dielectric Constant) ของดิน
        """
    },
    {
        "filepath": "modules/01_soil_hydraulics/1_2_etc_fao56.md",
        "title": "1.2 สมการการคายระเหยน้ำอ้างอิงและการประเมินความต้องการน้ำของทุเรียน (Crop Evapotranspiration: ETc)",
        "instruction": """
        - แสดงสมการการคายระเหยน้ำอ้างอิงมาตรฐาน FAO-56 Penman-Monteith แบบเต็มรูปแบบ:
          $$ET_0 = \\frac{0.408 \\Delta (R_n - G) + \\gamma \\frac{900}{T + 273} u_2 (e_s - e_a)}{\\Delta + \\gamma (1 + 0.34 u_2)}$$
          อธิบายความหมายและหน่วยของทุกตัวแปรอย่างละเอียดเชิงวิชาการ (เช่น $R_n$, $G$, $T$, $u_2$, $e_s - e_a$, $\\Delta$, $\\gamma$)
        - อธิบายทฤษฎีความต้องการน้ำของพืชรายวัน ($ET_c$):
          $$ET_c = K_c \\times ET_0$$
        - แสดงค่าสัมประสิทธิ์พืช (Crop Coefficient หรือ $K_c$) ของทุเรียนในแต่ละช่วงการเจริญเติบโต (Phenological Stages) ได้แก่:
          1. ระยะดึงใบอ่อนและเตรียมต้น
          2. ระยะกักโศก (งดน้ำชักนำการเปิดตาดอก)
          3. ระยะดึงน้ำหลังตาดอกบาน/ติดผลอ่อน
          4. ระยะขยายขนาดผลโตเร็ว
        - แสดงสูตรคำนวณปริมาตรน้ำที่ต้องให้จริงต่อวันต่อต้น ($V_{water}$):
          $$V_{water} (\\text{L/day}) = \\frac{ET_c \\times A_{canopy} \\times 1,000}{\\eta_{irrigation}}$$
          โดยระบุประสิทธิภาพระบบชลประทาน (Irrigation Efficiency หรือ $\\eta_{irrigation}$) ของหัวจ่ายมินิสปริงเกลอร์ (Mini-sprinkler)
        - จัดทำตัวอย่างการประคำนวณแบบสเต็ปบายสเต็ปเพื่อให้เยาวชนสามารถนำไปฝึกคิดตามได้ง่าย
        """
    },
    {
        "filepath": "modules/01_soil_hydraulics/1_3_hazen_williams.md",
        "title": "1.3 ชลศาสตร์ระบบท่อและการสูญเสียพลังงานเนื่องจากความเสียดทาน (Friction Head Loss)",
        "instruction": """
        - อธิบายหลักการไหลของน้ำในระบบท่อ ความเร็วการไหล และความดันในการชลประทานเกษตร
        - แสดงสมการคำนวณการสูญเสียพลังงานในระบบท่อเนื่องจากความเสียดทานโดยใช้ สมการเฮเซน-วิลเลียมส์ (Hazen-Williams Equation):
          $$h_f = 10.67 \\times L \\times Q^{1.852} \\times C^{-1.852} \\times D^{-4.87}$$
          ระบุนิยาม ตัวแปร และหน่วยวัดเชิงลึกทั้งหมด ($h_f$, $L$, $Q$, $C$, $D$)
        - สอนวิธีแปลงค่าสูญเสียความดัน $h_f$ เป็นหน่วยบาร์ (bar) หรือกิโลปาสกาล (kPa):
          $$P_{loss} (\\text{bar}) = \\frac{h_f}{10.2}$$
        - อธิบายความสำคัญของการหาค่าการสูญเสียในระบบท่อหลัก (Main Line) และท่อย่อย (Lateral Line) เพื่อคำนวณแรงม้าของปั๊มน้ำให้พอดีกับความต่างระดับของแปลง (Static Head) และแรงดันใช้งานหัวสปริงเกลอร์
        - แสดงตัวอย่างการคำนวณอย่างละเอียด: ท่อพีวีซี (PVC) ขนาดระบุ 2 นิ้ว (เส้นผ่านศูนย์กลางภายใน $D = 0.053 \\text{ m}$), ความยาว $L = 100 \\text{ m}$, อัตราการไหล $Q = 10 \\text{ m}^3\\text{/h}$ (แสดงการแปลงหน่วยเป็น $\\text{m}^3\\text{/s}$ ก่อนนำไปคำนวณ)
        """
    },
    {
        "filepath": "modules/02_iot_labs/lab1_arduino_ide.md",
        "title": "Lab 1: การติดตั้ง Arduino IDE และ CH340 Driver",
        "instruction": """
        - พัฒนาเนื้อหาคู่มือปฏิบัติการ Lab 1 อย่างละเอียดเป็นมิตรกับเยาวชนมัธยมต้น
        - อธิบายหน้าที่ของ คอมไพเลอร์ (Compiler), บอร์ดพัฒนาไมโครคอนโทรลเลอร์ (Microcontroller Board) ESP32, และชิปแปลงระดับสัญญาณอนุกรม (USB-to-Serial Converter) CH340 
        - เขียนและออกแบบผังการไหลของสัญญาณวิทยุและข้อมูลโดยใช้แผนภูมิ Mermaid:
          `PC -- USB Data --> CH340 USB-to-Serial Converter -- UART TX/RX --> ESP32 Main MCU`
        - อธิบายขั้นตอนอย่างเป็นระเบียบในการดาวน์โหลด ติดตั้ง Arduino IDE และ CH340 Driver พร้อมวิธีการตรวจเช็ก COM Port บนระบบปฏิบัติการ Windows และ macOS
        - แสดงสเก็ตช์โค้ด Blink (ไฟกะพริบ) ภาษา C++ ที่มีความสมบูรณ์ เขียนขึ้นให้ชัดเจน และใส่คำอธิบายภาษาไทยในทุกๆ บรรทัดของโค้ด (Line-by-line annotation) อธิบายหน้าที่ของ `pinMode()`, `digitalWrite()`, และ `delay()`
        - จัดทำแบบฝึกหัดท้ายบทปฏิบัติการ 1 (Lab 1 Exercises) ประกอบด้วย:
          1. คำถามทวนความเข้าใจ (Review Questions) เรื่อง CH340 และวิธีแก้ปัญหา "Port not found"
          2. กิจกรรมท้าทาย (Coding Challenge) ให้เขียนโค้ดไฟกะพริบถี่เป็นจังหวะไฟสัญญาณเตือนภัยฉุกเฉินสวนทุเรียน (เปิด 200 ms และปิด 200 ms)
          3. แบบฝึกหัดเติมคำในช่องว่างพร้อมเฉลยในตัว
        """
    },
    {
        "filepath": "modules/02_iot_labs/lab2_gpio_relay.md",
        "title": "Lab 2: การสั่งงานวงจรไฟฟ้าและอุปกรณ์ขับเคลื่อนทางกายภาพภายนอก (GPIO & Relay Control)",
        "instruction": """
        - พัฒนาเนื้อหาคู่มือปฏิบัติการ Lab 2 สำหรับควบคุมปั๊มน้ำหรือโซลินอยด์วาล์วผ่านพอร์ตสัญญาณอินพุตและเอาต์พุตเอนกประสงค์ (General Purpose Input/Output หรือ GPIO) ของบอร์ด ESP32
        - อธิบายเหตุผลทางวิทยาศาสตร์ว่าทำไมขาพอร์ต GPIO ที่จ่ายระดับแรงดัน $3.3 \\text{ V}$ และกระแสต่ำ ($12 - 40 \\text{ mA}$) จึงต้องควบคุมโหลดกำลังไฟฟ้าบ้านสูง ($220 \\text{ V}$) ผ่าน รีเลย์ (Relay)
        - อธิบายหลักการทำงานเชิงฟิสิกส์ของรีเลย์แบบแม่เหล็กไฟฟ้าและการป้องกันวงจรเสียหายด้วยการแยกทางไฟฟ้าด้วยแสง (Optocoupler Isolation) เพื่อสกัดกั้นไฟกระชากกลับ (Back Electromotive Force)
        - อธิบายกลไกลอจิกแบบ Active Low (ทำงานเมื่อสั่งสัญญาณ LOW) และมาตรการความปลอดภัยเชิงปฏิบัติ โดยการควบคุมให้สั่งจ่ายสัญญาณ `HIGH` เป็นค่าเริ่มต้นในการปิดการทำงานปั๊มน้ำ
        - วาดแผนผังการเชื่อมโยงระบบควบคุม (Mermaid Flow Diagram) และระบุขาร่วม (VCC-5V, GND, GPIO 12 -> IN)
        - แสดงสเก็ตช์โค้ด C++ สำหรับ ESP32 ที่ทำงานเปิดรีเลย์ 3 วินาที และปิดรีเลย์ 3 วินาที สลับกันพร้อมเปิด Serial Terminal เพื่อรายงานค่าออกหน้าจอคอมพิวเตอร์อย่างเป็นเชิงเส้นตรงและมีระเบียบ ใส่คอมเมนต์ภาษาไทยประกอบละเอียดทุกบรรทัด
        - จัดทำแบบฝึกหัดท้ายปฏิบัติการ 2 (Lab 2 Exercises) พร้อมเฉลยในตัว
        """
    },
    {
        "filepath": "modules/02_iot_labs/lab3_wifi_connectivity.md",
        "title": "Lab 3: การจัดการชิปวิทยุ Wi-Fi และสถาปัตยกรรมโครงข่ายไร้สายแบบ Non-blocking",
        "instruction": """
        - พัฒนาเนื้อหาคู่มือปฏิบัติการ Lab 3 อธิบายการเชื่อมต่อเครือข่ายอินเทอร์เน็ตไร้สายบนบอร์ด ESP32 ผ่านความถี่คลื่นวิทยุ $2.4 \\text{ GHz}$ ตามมาตรฐาน IEEE 802.11 b/g/n
        - อธิบายความแตกต่างของโหมดการทำงาน: สถานีปลายทาง (Station Mode หรือ STA) และจุดกระจายสัญญาณเครือข่าย (Access Point หรือ AP) รวมถึงพารามิเตอร์การเชื่อมต่อ (SSID, Password, IP Address, RSSI)
        - อธิบายความสำคัญของการเขียนคำสั่งและโค้ดเชื่อมต่อแบบไร้การปิดกั้นสถานะ (Non-blocking Connect) และระบบป้องกันสัญญาณหลุดกึ่งอัตโนมัติ (Auto-reconnection Loop) ในภาคสนาม
        - แสดงสเก็ตช์โค้ด C++ ที่ใช้ไลบรารี `<WiFi.h>` เพื่อสั่งเชื่อมโยง ไวไฟ พิมพ์จุดแสดงความคืบหน้า รายงาน IP address และอ่านค่าระดับความแรงสัญญาณวิทยุที่เครื่องวัดได้ (Received Signal Strength Indicator หรือ RSSI) ในหน่วยเดซิเบลมิลลิวัตต์ (dBm) มาแสดงผลบนหน้าจอ Serial Monitor อย่างสม่ำเสมอ ใส่คอมเมนต์ภาษาไทยอธิบายทุกบรรทัด
        - จัดทำแบบฝึกหัดท้ายปฏิบัติการ 3 (Lab 3 Exercises) พร้อมเฉลยในตัว
        """
    },
    {
        "filepath": "modules/02_iot_labs/lab4_mqtt_telemetry.md",
        "title": "Lab 4: การจัดส่งข้อมูลระยะไกลด้วยโปรโตคอลระบบส่งข้อมูลน้ำหนักเบา (MQTT IoT Protocol)",
        "instruction": """
        - อธิบายสถาปัตยกรรมของโปรโตคอลขนส่งข้อมูลน้ำหนักเบา เอ็มคิวทีที (Message Queuing Telemetry Transport หรือ MQTT) ซึ่งใช้หลักการเผยแพร่และสมัครรับข้อมูล (Publish/Subscribe) 
        - อธิบายบทบาทและหน้าที่ของเครื่องลูกข่าย (Client), ผู้เผยแพร่ (Publisher), เครื่องบริการตัวกลาง (Broker), และผู้สมัครรับสารข้อมูล (Subscriber) พร้อมลอจิกการจัดแยกประเภทหัวข้อการส่งแบบลำดับชั้นย่อย (Topic Level Separator) ด้วยเครื่องหมาย `/`
        - แสดงและวาดโครงสร้างการลำเลียงข้อมูลแบบ Pub/Sub ไปยังแดชบอร์ดและ Doctor AI App ด้วย Mermaid Diagram
        - แสดงสเก็ตช์โค้ด C++ ที่มีความเสถียรและทนทานสูง (Robust Code) บนบอร์ด ESP32 โดยใช้ไลบรารี `<PubSubClient.h>` และ `<WiFi.h>` สั่งเชื่อมต่อไปยังโฮสต์คลาวด์สาธารณะฟรี (เช่น broker.hivemq.com พอร์ต 1883) ส่งข้อมูลความชื้นดินจำลอง 52.4 % VWC ไปยังหัวข้อพับลิชทุกๆ 10 วินาที และมีฟังก์ชันคอลแบ็ก (Callback Function) ในการคอยรอสมัครรับสารหัวข้อคำสั่งควบคุม (Subscribe Topic) เพื่อนำข้อมูล String "1" ไปสั่งเปิดรีเลย์ หรือ "0" เพื่อสั่งปิดรีเลย์ (GPIO 12 แบบ Active Low)
        - ใส่ตรรกะระบบกู้คืนสัญญาณเชื่อมต่อโบรกเกอร์ (Automatic MQTT Reconnect loop) และตั้งชื่อ Client ID แบบสุ่มป้องกันสัญญาณชนกัน
        - จัดทำแบบฝึกหัดท้ายปฏิบัติการ 4 (Lab 4 Exercises) พร้อมเฉลย
        """
    },
    {
        "filepath": "modules/02_iot_labs/lab5_nodered_dashboard.md",
        "title": "Lab 5: การพัฒนาแผงควบคุมกราฟิกจำลองการทำงานด้วยเครื่องมือ Node-RED",
        "instruction": """
        - พัฒนาคู่มือปฏิบัติการ Lab 5 ในการสร้าง แผงควบคุม (Dashboard) วิชวลและแผนภาพลอจิกควบคุมโดยใช้ Node-RED 
        - อธิบายกลไกพื้นฐานของ Node-RED ที่ทำงานขับเคลื่อนบนระบบเหตุการณ์ (Event-Driven) และเทคโนโลยีรันไทม์ Node.js ดำเนินการส่งข้อมูลระหว่างบล็อกด้วยวิชวลพารามิเตอร์ออบเจ็กต์ข่าวสาร (Message Object Payload หรือ `msg.payload`)
        - วาดโครงสร้าง Flowchart การเชื่อมต่อโหนด MQTT in, Button On, Button Off, และ MQTT out ใน Node-RED ด้วยแผนภูมิ Mermaid อย่างชัดเจน
        - อธิบายขั้นตอนสเต็ปบายสเต็ปในการเชื่อมต่อบล็อกในหน้าจอ Visual Flow Editor (localhost:1880) เพื่อ:
          1. รับค่าความชื้นดินจาก `mqtt in` (หัวข้อ `trat/school/durian/moisture`) มาวาดเป็น Chart กราฟเส้นแสดงผลแบบเรียลไทม์
          2. สร้าง Button On / Button Off สลักหน้าชื่อปุ่มให้ส่งค่า Payload เป็นสายอักขระตัวหนังสือ "1" และ "0" สตรีมส่งออกไปยังโหนด `mqtt out` (หัวข้อ `trat/school/durian/control`)
        - แสดงส่วนเขียนคำสั่งแบบจำลองฟังก์ชัน (Function Node) ในภาษาจาวาสคริปต์ (JavaScript) เพื่อแปลงค่าข้อมูลพยากรณ์ความชื้นและจัดแต่งการแสดงผลให้เป็นภาษาไทยที่งดงามก่อนส่งต่อออกหน้าจอ
        - จัดทำแบบฝึกหัดท้ายปฏิบัติการ 5 (Lab 5 Exercises) พร้อมเฉลย
        """
    },
    {
        "filepath": "modules/03_industrial_labs/lab6_modbus_poll.md",
        "title": "Lab 6: การโปรแกรม Modbus Poll และศึกษาแผนที่สมุดรีจิสเตอร์อุตสาหกรรม",
        "instruction": """
        - พัฒนาเนื้อหาคู่มือปฏิบัติการ Lab 6 อธิบายประวัติและความสำคัญของโปรโตคอลมอดบัส (Modbus Protocol Standard) และสายอนุกรมมาตรฐานอุตสาหกรรม RS-485
        - อธิบายกลไกการส่งสัญญาณผลต่างศักย์คู่สาย (Differential Signaling) ของสาย A และ B ที่ช่วยหักล้างสัญญาณรบกวนร่วม (Common-mode Noise) ได้สมบูรณ์แบบ ส่งผลให้สาย RS-485 ทนต่อสัญญาณกวนจากเครื่องจักรปั๊มแรงสูงในแปลงทุเรียนและเดินสายได้ไกลถึง 1,200 เมตร
        - อธิบายชนิดกล่องข้อมูลหรือหน่วยความจำในอุปกรณ์มอดบัส: Coil, Discrete Input, Input Register, และ Holding Register 
        - แสดงโครงสร้างเฟรมสัญญาณข้อมูลไบนารีขนาด 8 บิต (Modbus RTU Frame Layout):
          `[Slave ID] -> [Function Code] -> [Start Register Address] -> [Register Quantity] -> [CRC Checksum]`
          พร้อมอธิบายหน้าต่างฟังก์ชันพื้นฐานที่ประยุกต์ใช้เช่น Function Code 03 (Read Holding Registers) และ Function Code 06 (Write Single Register)
        - อธิบายกระบวนการใช้โปรแกรมคอมพิวเตอร์ Modbus Poll (Master Simulator) ในการทดสอบและสแกนตั้งค่าขาสมุดบัญชีของ Slave ID 1 เพื่อดูค่าดิน
        - จัดทำแบบฝึกหัดท้ายปฏิบัติการ 6 (Lab 6 Exercises) พร้อมเฉลย
        """
    },
    {
        "filepath": "modules/03_industrial_labs/lab7_modbus_rtu_coding.md",
        "title": "Lab 7: การเขียนโปรแกรมสื่อสารด้วยโพรโตคอล Modbus RTU ผ่านพอร์ต RS-485",
        "instruction": """
        - พัฒนาคู่มือปฏิบัติการ Lab 7 ในการเขียนโค้ดอ่านตัวตรวจวัดค่าดินอุตสาหกรรมจริง (NPK/VWC Modbus Sensor) ผ่านบอร์ด ESP32 ร่วมกับตัวแปลงระดับสัญญาณ (TTL-to-RS485 Transceiver Module)
        - แสดงสถาปัตยกรรมเชื่อมต่อฮาร์ดแวร์อนุกรม UART2 (RX2-GPIO 16, TX2-GPIO 17) และวงจรประสานคู่สาย Differential Pair A/B ด้วยแผนผังกล่องข้อความ
        - แสดงสเก็ตช์โค้ด C++ ที่เสถียรและทรงพลังในการประกาศอาร์เรย์ของเฟรมคำสั่งดิบ (Raw Hex Frame Request Array) ขนาด 8 ไบต์เพื่อส่งคำขออ่านความชื้นดิน:
          `const byte ReadSoilMoistureRequestFrame[] = {0x01, 0x03, 0x00, 0x00, 0x00, 0x01, 0x84, 0x0A};`
          และมีระบบเขียนข้อมูลลงพอร์ต `Serial2.write()`, ดีเลย์เพื่อตรวจคอยข้อมูลตอบกลับ 150 มิลลิวินาที, ตรวจสแกนแพ็กเกจที่สะท้อนกลับมาว่าครบ 7 ไบต์ตามมาตรฐานหรือไม่ และฟลัชล้างสัญญาณ (Serial flush) ในพอร์ตรับข้อมูลทันทีเมื่อเกิดข้อผิดพลาด
        - แสดงกลไกการแกะกล่องไบต์ข้อมูลระดับล่างสุด (Bitwise operations parsing) ดึงข้อมูลไบต์ที่ 3 (บิตซ้าย/High byte) และไบต์ที่ 4 (บิตขวา/Low byte) มารวมสัญญาณเข้าด้วยกันด้วยการขยับเลื่อนบิต 8 ตำแหน่ง:
          `int rawSoilMoistureData = (responseFrame[3] << 8) | responseFrame[4];`
          จากนั้นทำการหารค่าทศนิยมด้วย 10.0 เพื่อให้ได้เปอร์เซ็นต์ความชื้นดินจริงตรงตามสเปกอุตสาหกรรม
        - จัดทำแบบฝึกหัดท้ายปฏิบัติการ 7 (Lab 7 Exercises) และเฉลย
        """
    },
    {
        "filepath": "modules/03_industrial_labs/lab8_cadesimu_pump.md",
        "title": "Lab 8: การเขียนผังและออกแบบแบบจำลองตู้จ่ายไฟปั๊มสูบน้ำ 3 เฟสด้วยโปรแกรม CADe_SIMU V4",
        "instruction": """
        - พัฒนาคู่มือปฏิบัติการ Lab 8 ในการจำลองและออกแบบวงจรควบคุมกำลังไฟมอเตอร์ขนาดใหญ่ 3 เฟสที่ใช้ในสถานีชลประทานในแปลงทุเรียนหมอนทองขนาดใหญ่
        - อธิบายหน้าที่และฟิสิกส์ของมอเตอร์ไฟฟ้าแบบเหนี่ยวนำกระแสสลับ 3 เฟส (Three-phase Induction Motor), สวิตช์จ่ายกำลังขนาดใหญ่ แมกเนติกคอนแทกเตอร์ (Magnetic Contactor), ตัวสแกนวัดความร้อนตัดกระแสไฟเกินพิกัด เทอร์มอลโอเวอร์โหลดรีเลย์ (Thermal Overload Relay), และสวิตช์ปุ่มกดปิดฉุกเฉินระดับปลอดภัยสูง (Emergency Push Button Normally Closed NC)
        - วาดโครงสร้างไหลเวียนกระแสไฟฟ้า (Power and Control loops) ด้วยแผนภูมิ Mermaid
        - อธิบายการลากสายประกอบระบบควบคุมในโปรแกรม CADe_SIMU V4 อย่างเป็นระเบียบทีละขั้น:
          1. วงจรกำลังหลัก (Power Circuit): แหล่งจ่าย 3 เฟส L1-L2-L3 วิ่งผ่านเซอร์กิตเบรกเกอร์ (MCB 3-Pole) วิ่งลัดเข้าขั้วหลักแมกเนติก (KM1) ผ่านรีเลย์ความร้อนสะสม (F1) และเชื่อมตรงไปยังขั้วมอเตอร์ U1-V1-W1
          2. วงจรควบคุมลอจิกสวิตช์ (Control Circuit): ดึงไฟเฟส L1 ผ่านหน้าสัมผัสตัดกระแสปกติปิด NC (พอร์ต 95-96) ของโอเวอร์โหลดรีเลย์ F1, เชื่อมปุ่มสีแดง Emergency NC, เชื่อมปุ่มสีเขียว Start NO ขนานข้ามไปควบคุมขดลวดโซลินอยด์แมกเนติก KM1 (พอร์ต A1-A2) และปล่อยสาย Neutral
        - วิเคราะห์ทฤษฎีกลไกการประคองกระแสค้างเลี้ยงตัวเอง (Self-Holding หรือ Self-Latching Logic) โดยการเดินท่อสายนำหน้าสัมผัสช่วย KM1 ปกติเปิด NO (พอร์ต 13-14) มาขนานครอบปุ่มสีเขียว เพื่อรักษาแรงจ่ายไฟฟ้าอย่างต่อเนื่องเมื่อผู้เรียนละมือออกจากสปริงปุ่มสตาร์ท
        - จัดทำแบบฝึกหัดท้ายปฏิบัติการ 8 (Lab 8 Exercises) และเฉลย
        """
    },
    {
        "filepath": "modules/04_appendices/appendix_a_exercises.md",
        "title": "ภาคผนวก ก: แบบประเมินผลและการประลองเชิงทักษะวิชาการนวัตกรเกษตรดิจิทัล",
        "instruction": """
        - รวบรวมแนวแบบทดสอบและกิจกรรมประเมินผลเชิงบูรณาการสะเต็ม (STEM Integration Exam) ทั้งหมดของ 8 บทปฏิบัติการ
        - จัดโครงสร้างข้อทดสอบออกเป็น:
          1. ข้อสอบปรนัย (Multiple-choice) แบบเลือกตอบที่มีคำถามกระตุ้นกระบวนการคิดวิเคราะห์เชิงลึก (บทละ 3 ข้อ รวม 24 ข้อพร้อมเฉลยอธิบายทฤษฎียืนยัน)
          2. ปัญหาวิเคราะห์อัตนัยเชิงสร้างสรรค์ (Open-ended Challenge Tasks) ในการนำแบบจำลอง VWC หรือ Hazen-Williams ไปคำนวณแก้โจทย์ชลประทานจริงในแปลงเกษตรของสวนทุเรียนตราด
          3. แบบฝึกหัดถอดรหัสบิต Modbus และวิเคราะห์ตรรกะระบบ Active Low Fail-safe
        - หลีกเลี่ยงโจทย์ความจำเป็นอย่างยิ่ง มุ่งเน้นการประยุกต์และประเมินทักษะแก้ปัญหา
        """
    },
    {
        "filepath": "modules/04_appendices/appendix_b_glossary.md",
        "title": "ภาคผนวก ข: อภิธานศัพท์เทคโนโลยีและฟิสิกส์เกษตรอัจฉริยะ (Bilingual Glossary)",
        "instruction": """
        - จัดสร้าง อภิธานศัพท์เทคนิคและวิศวกรรมสองภาษา (Bilingual Technical Glossary) ที่อธิบายความหมายอย่างละเอียด น่าเชื่อถือ ตามแนววิชาการชั้นสูง
        - บรรจุรายคำศัพท์เฉพาะทางในระดับความลึกที่สมบูรณ์ไม่ต่ำกว่า 30 คำ (เช่น Volumetric Water Content, Reference Evapotranspiration, Friction Head Loss, Optocoupler, Active Low, Modbus RTU, RS-485, Ingress Protection, Self-Holding, Differential Signaling, Vapor Pressure Deficit, Field Capacity, Permanent Wilting Point, Thermal Overload Relay, Magnetic Contactor, Analog-to-Digital Converter, In-text Citation, Feedback Control Loop, etc.)
        - เรียงตามลำดับความสำคัญหรืออักษรภาษาอังกฤษ มีรูปแบบภาษาไทยควบคู่ภาษาอังกฤษดั้งเดิม และนิยามความสอดรับกับการเกษตรดิจิทัลแม่นยำ
        """
    },
    {
        "filepath": "modules/04_appendices/appendix_c_references.md",
        "title": "ภาคผนวก ค: เอกสารอ้างอิงเชิงวิชาการมาตรฐานสากล (Academic References)",
        "instruction": """
        - จัดทำคลังบรรณานุกรมเชิงลึกที่มีความน่าเชื่อถือสูง ปราศจากค่า Placeholder หรือ URL เดดลิงก์
        - ใส่รายการอ้างอิงและงานวิจัยที่ทันสมัยไม่ต่ำกว่า 6 รายการที่อัปเดต โดยผสมผสานตามสัดส่วนการอ้างอิงแบบมาตรฐานสากล APA 7th edition (สำหรับพฤกษศาสตร์ ชีววิทยา และวิทยาศาสตร์สิ่งแวดล้อมดิน) และ IEEE Style (สำหรับวิศวกรรมไฟฟ้า สมองกลฝังตัว และอินเทอร์เน็ตของสรรพสิ่ง)
        - รายการอ้างอิงควรครอบคลุม:
          1. แบบจำลองดุลน้ำในดินเหนียวจันทบุรี/ตราด (Richards & Van Genuchten)
          2. อุตุนิยมวิทยาการคำนวณ Penman-Monteith (FAO-56 standard)
          3. การสื่อสารอุตสาหกรรมผ่าน RS-485 Modbus RTU
          4. ระบบแยกวงจรไฟฟ้าด้วยออปโตคัปเปลอร์และความปลอดภัยระบบปั๊มกำลังไฟฟ้า
          5. หลักสูตรชลประทานอัจฉริยะระดับนานาชาติ
        """
    }
]

def clean_model_thinking(text):
    """Clean typical deepseek/gemma thinking processes if any exist in the response"""
    cleaned = re.sub(r'<think>.*?</think>', '', text, flags=re.DOTALL)
    cleaned = re.sub(r'Thinking\.\.\..*?done thinking\.', '', cleaned, flags=re.DOTALL)
    cleaned = re.sub(r'\[Thinking\.\.\.\].*?\[done thinking\]', '', cleaned, flags=re.DOTALL)
    return cleaned.strip()

def verify_si_spacing(text):
    """Ensure SI units have a single space between numbers and units (e.g. '5V' to '5 V')"""
    pattern = r'(\d+)\s*(V|Hz|m|s|bar|kPa|L/day|dBm|inch|bps|VWC|FC|PWP|AWC)\b'
    return re.sub(pattern, r'\1 \2', text)

def validate_content(filepath, text):
    """Validate that the generated chapter is complete and robust"""
    if not text:
        return False, "Empty content"
    if len(text) < 7000:
        return False, f"Content too short ({len(text)} chars, expected >= 7000)"
    if text.count("```") % 2 != 0:
        return False, "Unclosed code block (odd number of triple backticks)"
    if text.count("$") % 2 != 0:
        return False, "Unclosed math block or inline math (odd number of dollar signs)"
    
    stripped_text = text.strip()
    if re.search(r'#+\s+[^\n]+$', stripped_text):
        return False, "Incomplete ending: ends with a heading line"
    
    last_100 = stripped_text[-100:]
    if last_100.endswith("...") or last_100.endswith("etc."):
        return False, "Ends with ellipsis (incomplete)"
        
    bad_endings = ["และ", "หรือ", "เพราะ", "เพราะว่า", "จากนั้น", "แล้ว", "กับ", "ที่", "ซึ่ง", "อัน", "เช่น"]
    for be in bad_endings:
        if last_100.endswith(be):
            return False, f"Ends with incomplete Thai conjunction '{be}'"
            
    return True, "Valid"

def generate_section(filepath, title, instruction):
    """Calls local Ollama API to generate detailed academic content for one specific section"""
    target_abs_path = os.path.join(BASE_DIR, filepath)
    
    # Self-healing skip check: skip if the file exists and is already valid
    if os.path.exists(target_abs_path):
        with open(target_abs_path, "r", encoding="utf-8") as f:
            existing_content = f.read()
        is_valid, reason = validate_content(filepath, existing_content)
        if is_valid:
            print(f"  [SKIP] '{filepath}' already exists and is valid ({len(existing_content)} chars).")
            return
        else:
            print(f"  [INVALID] '{filepath}' exists but is invalid: {reason}. Regenerating...")

    prompt = f"""
    {SYSTEM_INSTRUCTION}
    
    หัวข้อการเรียนรู้ทางวิชาการและคู่มือการอบรม: {title}
    คำแนะนำของหัวข้อและกรอบเนื้อหาปฏิบัติการที่ต้องเขียนอธิบายขยายความเชิงทฤษฎีและปฏิบัติการอย่างลึกซึ้ง:
    {instruction}
    
    จงเขียนเนื้อหาอธิบายอย่างละเอียด มีระดับความยาวและระดับวิชาการสูงสุด ไม่เขียนสรุปย่อหรือละเว้นส่วนสำคัญ เขียนทฤษฎี สมการ LaTeX ฟอนต์สัญลักษณ์ SI และตัวอย่างซอร์สโค้ดสมบูรณ์ (ถ้าคำแนะนำร้องขอ) แบบประณีต สละสลวย และถูกต้องตามหลักการวิชาการ:
    """
    
    payload = {
        "model": MODEL_NAME,
        "prompt": prompt,
        "stream": False,
        "options": {
            "temperature": 0.2,
            "num_predict": 16384,
            "num_ctx": 32768
        }
    }
    
    max_retries = 3
    for attempt in range(1, max_retries + 1):
        print(f"  [PROCESS] Generating '{filepath}' (Attempt {attempt}/{max_retries}) ... Please wait ...")
        
        data = json.dumps(payload).encode("utf-8")
        req = urllib.request.Request(OLLAMA_API_URL, data=data, headers={"Content-Type": "application/json"})
        
        try:
            with urllib.request.urlopen(req, timeout=900) as response:
                res_body = response.read().decode("utf-8")
                result = json.loads(res_body)
                raw_text = result.get("response", "")
                cleaned_text = clean_model_thinking(raw_text)
                
                # Post-processing: verify SI spacing in generated text
                formatted_text = verify_si_spacing(cleaned_text)
                
                full_content = f"## {title}\n\n{formatted_text}\n"
                
                # Validate content
                is_valid, reason = validate_content(filepath, full_content)
                if is_valid:
                    # Write content to specific file in modular structure
                    os.makedirs(os.path.dirname(target_abs_path), exist_ok=True)
                    with open(target_abs_path, "w", encoding="utf-8") as f:
                        f.write(full_content)
                    print(f"  [SUCCESS] Written {len(full_content)} characters to '{filepath}'")
                    return
                else:
                    print(f"  [WARNING] Attempt {attempt} failed validation: {reason}")
                    
        except urllib.error.URLError as e:
            print(f"  [ERROR] Network error during generation of '{filepath}' (Attempt {attempt}): {e}")
        except Exception as e:
            print(f"  [ERROR] Unexpected error during generation of '{filepath}' (Attempt {attempt}): {e}")
            
        # If it failed validation, we can adjust the prompt slightly on retry to ask for completeness
        if attempt < max_retries:
            print("  [RETRY] Retrying generation with explicit instruction for completeness...")
            payload["prompt"] = prompt + "\n\n⚠️ สำคัญมาก: โปรดเขียนให้เสร็จสมบูรณ์จนจบเนื้อหา ห้ามตัดจบกลางคัน หรือตัดโค้ดกลางคันเด็ดขาด!"
            
    print(f"  [FATAL] Failed to generate valid complete content for '{filepath}' after {max_retries} attempts.")
    sys.exit(1)

def merge_markdown_files():
    """Combines all modular files in order and saves the consolidated master file"""
    print(f"\n[PROCESS] Starting Consolidation of all modules into a single master file...")
    
    merged_data = []
    
    # Master title header matching academic handbook standards
    merged_data.append("# คู่มือปฏิบัติการวิศวกรรมระบบน้ำอัตโนมัติและไอโอทีเกษตรอัจฉริยะ 2568\n")
    merged_data.append("## หลักสูตรการปฏิบัติการเทคโนโลยีชลศาสตร์ เกษตรแม่นยำ และระบบควบคุมระบบอัตโนมัติในสวนทุเรียน\n")
    merged_data.append("### สำหรับระดับเยาวชนและนวัตกรระดับมัธยมศึกษาตอนต้น\n")
    merged_data.append("#### โครงการความร่วมมือทางวิชาการและงานวิจัยเชิงพื้นที่ ศูนย์พัฒนานวัตกรรมเกษตรดิจิทัล รำไพพรรณี (รศ. Standard 2026)\n")
    merged_data.append("\n---\n\n")
    
    # Add Table of Contents to the merged document
    merged_data.append("## สารบัญโมดูลการเรียนรู้ (Table of Contents)\n\n")
    merged_data.append("*   [**บทนำและตารางวิเคราะห์การสอนสหวิทยาการ (Preface)**](modules/00_front_matter/preface.md)\n")
    merged_data.append("*   [**หมวดที่ 1: วิศวกรรมชลศาสตร์ปฐพีวิทยาและการคำนวณ (Soil Physics & Hydraulics)**](modules/01_soil_hydraulics/1_1_vwc_calculation.md)\n")
    merged_data.append("    *   [1.1 การคำนวณเปอร์เซ็นต์ความชื้นดินเชิงปริมาตร (VWC)](modules/01_soil_hydraulics/1_1_vwc_calculation.md)\n")
    merged_data.append("    *   [1.2 สมการการคายระเหยน้ำอ้างอิงและความต้องการน้ำทุเรียน (ETc)](modules/01_soil_hydraulics/1_2_etc_fao56.md)\n")
    merged_data.append("    *   [1.3 ชลศาสตร์ระบบท่อและการสูญเสียพลังงานเนื่องจากความเสียดทาน](modules/01_soil_hydraulics/1_3_hazen_williams.md)\n")
    merged_data.append("*   [**หมวดที่ 2: ปฏิบัติการเซ็นเซอร์และระบบฝังตัวไอโอที (IoT Labs)**](modules/02_iot_labs/lab1_arduino_ide.md)\n")
    merged_data.append("    *   [Lab 1: การจัดเตรียมสภาพแวดล้อมการพัฒนาและติดตั้งซอฟต์แวร์ (Arduino IDE & CH340 Driver)](modules/02_iot_labs/lab1_arduino_ide.md)\n")
    merged_data.append("    *   [Lab 2: การสั่งงานวงจรไฟฟ้าและอุปกรณ์ขับเคลื่อนทางกายภาพภายนอก (GPIO & Relay Control)](modules/02_iot_labs/lab2_gpio_relay.md)\n")
    merged_data.append("    *   [Lab 3: การเชื่อมต่อโครงข่ายสื่อสารไร้สาย (Wi-Fi Connectivity)](modules/02_iot_labs/lab3_wifi_connectivity.md)\n")
    merged_data.append("    *   [Lab 4: การจัดส่งข้อมูลระยะไกลด้วยโปรโตคอลระบบส่งข้อมูลน้ำหนักเบา (MQTT IoT Protocol)](modules/02_iot_labs/lab4_mqtt_telemetry.md)\n")
    merged_data.append("    *   [Lab 5: การพัฒนาแผงควบคุมกราฟิกจำลองการทำงานด้วยเครื่องมือ Node-RED](modules/02_iot_labs/lab5_nodered_dashboard.md)\n")
    merged_data.append("*   [**หมวดที่ 3: ปฏิบัติการระบบควบคุมกำลังและการสื่อสารอุตสาหกรรม (Industrial Labs)**](modules/03_industrial_labs/lab6_modbus_poll.md)\n")
    merged_data.append("    *   [Lab 6: การโปรแกรม Modbus Poll และศึกษาแผนที่สมุดรีจิสเตอร์อุตสาหกรรม](modules/03_industrial_labs/lab6_modbus_poll.md)\n")
    merged_data.append("    *   [Lab 7: การเขียนโปรแกรมสื่อสารด้วยโพรโตคอล Modbus RTU ผ่านพอร์ต RS-485](modules/03_industrial_labs/lab7_modbus_rtu_coding.md)\n")
    merged_data.append("    *   [Lab 8: การเขียนผังและออกแบบแบบจำลองตู้จ่ายไฟมอเตอร์ 3 เฟสด้วย CADe_SIMU V4](modules/03_industrial_labs/lab8_cadesimu_pump.md)\n")
    merged_data.append("*   [**หมวดที่ 4: ภาคผนวกการประเมินและคลังอ้างอิง (Appendices & References)**](modules/04_appendices/appendix_a_exercises.md)\n")
    merged_data.append("    *   [ภาคผนวก ก: แบบประเมินผลและการประลองเชิงทักษะวิชาการนวัตกร](modules/04_appendices/appendix_a_exercises.md)\n")
    merged_data.append("    *   [ภาคผนวก ข: อภิธานศัพท์เทคโนโลยีและฟิสิกส์เกษตรอัจฉริยะ (Bilingual Glossary)](modules/04_appendices/appendix_b_glossary.md)\n")
    merged_data.append("    *   [ภาคผนวก ค: เอกสารอ้างอิงเชิงวิชาการมาตรฐานสากล (References)](modules/04_appendices/appendix_c_references.md)\n")
    merged_data.append("\n---\n\n")
    
    for sec in sections:
        filepath = sec["filepath"]
        abs_path = os.path.join(BASE_DIR, filepath)
        if not os.path.exists(abs_path):
            print(f"  [WARNING] File not found: '{filepath}'. Skipping merger.")
            continue
            
        with open(abs_path, "r", encoding="utf-8") as f:
            content = f.read()
            
        # Ensure correct level 1 title styling in the consolidated file
        content = re.sub(r'^## ', '# ', content)
        merged_data.append(content)
        merged_data.append("\n\n---\n\n")
        
    with open(OUTPUT_MERGED_FILE, "w", encoding="utf-8") as f:
        f.writelines(merged_data)
        
    print(f"  [SUCCESS] All modules merged into single master manual: '{OUTPUT_MERGED_FILE}'")

def main():
    print(f"=== เริ่มต้นการแยกและขยายคู่มืออบรมระบบน้ำอัตโนมัติเป็นเล่มโมดูลาร์ (gemma4) ===")
    os.makedirs(BASE_DIR, exist_ok=True)
    
    # Process and generate each chapter one by one
    for index, sec in enumerate(sections, 1):
        print(f"\n[{index}/{len(sections)}] ประมวลผลย่อย: {sec['filepath']}")
        generate_section(sec["filepath"], sec["title"], sec["instruction"])
        
    # Merge all individual files into the final master handbook
    merge_markdown_files()
    print(f"\n=== เสร็จสมบูรณ์ทุกกระบวนการย่อยของคู่มืออบรมเรียบร้อยแล้ว! ===")

if __name__ == "__main__":
    main()
