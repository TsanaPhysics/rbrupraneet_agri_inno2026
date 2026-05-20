import urllib.request
import urllib.error
import json
import os
import sys

# Define base configuration
OLLAMA_API_URL = "http://localhost:11434/api/generate"
MODEL_NAME = "gemma4:latest"
OUTPUT_FILE = "/Applications/XAMPP/xamppfiles/htdocs/rbrupraneet_agri_inno2026/docs/agri_innovation_handbook_3days.md"

print(f"Initializing Academic Handbook Generation using Ollama model: {MODEL_NAME}")

# Base prompt instructions derived from science-academic-writer skill
BASE_ACADEMIC_PROMPT = """
คุณคือผู้เชี่ยวชาญด้านปัญญาประดิษฐ์ เกษตรดิจิทัล และฟิสิกส์ประยุกต์ ที่เขียนงานตามมาตรฐานทางวิชาการระดับ "รองศาสตราจารย์ (รศ.)" 
จงใช้องค์ความรู้ระดับสูงเขียนบทความวิชาการภาษาไทยที่สละสลวย ถูกต้องตามอักขรวิธี มีการใช้ศัพท์วิทยาศาสตร์ที่เป็นมาตรฐานพร้อมศัพท์ภาษาอังกฤษในวงเล็บ 
ใช้หน่วยวัด SI เสมอ (มีช่องว่างระหว่างตัวเลขกับหน่วย เช่น 5 V, 10 kg) 
ใช้สมการคณิตศาสตร์ฟอร์แมต LaTeX ทั้งแบบ inline ($...$) และ block ($$...$$) 
เนื้อหาต้องเป็นประโยชน์เชิงการสอน มีทักษะการเรียนรู้เชิงปฏิบัติ (PBL) และสอดรับกับกำหนดการอบรมเชิงปฏิบัติการ 3 วันของ "ศูนย์พัฒนานวัตกรรมเกษตรดิจิทัลรำไพพรรณี-ประณีตวิทยาคม" 

หัวข้อกำหนดการอ้างอิง:
- วันที่ 1: การเขียน Python ดึงข้อมูลสภาพอากาศ TMD Open Data API วิเคราะห์ภัยแล้งด้วย Pandas และสร้าง Dashboard
- วันที่ 2: หลักการ Computer Vision, โครงข่ายประสาทเทียม CNN บน Google Colab, ถ่ายภาพ Dataset และพัฒนาแอป MIT App Inventor/Kodular
- วันที่ 3: บอร์ด ESP32, การติดตั้ง Arduino IDE และไดรเวอร์ CH340, การเขียนโปรแกรม C++ อ่านค่าดิน (Soil Moisture) และแสง (LDR), ระบบเปิดปิดปั๊มน้ำด้วย Relay อัตโนมัติ, กิจกรรม Capstone สามประสาน และการติดตั้งจริงในสวนทุเรียน IP65 แบบยั่งยืน (พลังงานโซลาร์เซลล์)
"""

def generate_section(section_title, section_instruction):
    prompt = f"{BASE_ACADEMIC_PROMPT}\n\nหัวข้อที่จะให้เขียน: {section_title}\nคำแนะนำในการเจาะลึกเฉพาะหัวข้อ:\n{section_instruction}\n\nจงเขียนเนื้อหาทางวิชาการอย่างสมบูรณ์แบบ ละเอียด ลึกซึ้ง ไม่เขียนแบบย่อหรือมี placeholder และแสดงโค้ด/สมการอย่างเป็นระเบียบ:"
    
    payload = {
        "model": MODEL_NAME,
        "prompt": prompt,
        "stream": False,
        "options": {
            "temperature": 0.3,
            "num_predict": 4096
        }
    }
    
    data = json.dumps(payload).encode("utf-8")
    req = urllib.request.Request(OLLAMA_API_URL, data=data, headers={"Content-Type": "application/json"})
    
    try:
        print(f"Generating: {section_title} ... Please wait ...")
        # Increase timeout to 600s because local LLM generation of long sections can take time
        with urllib.request.urlopen(req, timeout=600) as response:
            res_body = response.read().decode("utf-8")
            result = json.loads(res_body)
            return result.get("response", "")
    except urllib.error.URLError as e:
        print(f"URLError raised during generation: {e}")
        return f"\n\n## Error generating {section_title}: {e}\n"
    except Exception as e:
        print(f"Exception raised during generation: {e}")
        return f"\n\n## Exception generating {section_title}: {e}\n"

# Sections definition with specific guidelines
sections = [
    {
        "title": "หน้าปก บทนำ และวัตถุประสงค์เชิงเป้าหมายการเรียนรู้ (Bloom's Taxonomy)",
        "instruction": """
        - เขียนชื่อคู่มือ: "คู่มือนวัตกรเกษตรดิจิทัลรุ่นเยาว์: การบูรณาการปัญญาประดิษฐ์และอินเทอร์เน็ตของสรรพสิ่งในแปลงเกษตรแม่นยำ"
        - คำนำที่เป็นทางการ (Preface) เชื่อมโยงบริบทความเปราะบางทางสภาพอากาศ (Climate Change/Global Warming) ในพื้นที่จังหวัดตราดและจันทบุรี กับความสำคัญของการทำเกษตรกรรมแม่นยำ (Precision Agriculture) และ BCG Model
        - กำหนดวัตถุประสงค์การเรียนรู้ตามอนุกรมวิธานของบลูม (Bloom's Taxonomy) ในด้านความรู้ ความเข้าใจ การประยุกต์ใช้ การวิเคราะห์ และการสังเคราะห์นวัตกรรม
        """
    },
    {
        "title": "บทที่ 1: การวิเคราะห์สถิติภูมิอากาศและความเสี่ยงภัยแล้งด้วย Python (Day 1)",
        "instruction": """
        - 1.1 ความสำคัญเชิงกายภาพและอุตุนิยมวิทยาต่อการเติบโตของทุเรียน (เช่น ความชื้นและผลกระทบของฝนทิ้งช่วง)
        - 1.2 ปฐมบท Python Sandbox สำหรับนักเรียน: อธิบายตัวแปร (Variables), ประเภทข้อมูล, และตรรกะแบบมีเงื่อนไข (if-else logic)
        - 1.3 การดึงข้อมูลสภาพอากาศแบบ API จากคลังข้อมูล TMD Open Data API กรมอุตุนิยมวิทยา อธิบายโครงสร้าง JSON และคำสั่งดึงข้อมูลด้วยไลบรารี urllib หรือ requests
        - 1.4 การวิเคราะห์ข้อมูลอนุกรมเวลา (Time Series Analysis) ด้วย Pandas และ Seaborn: อธิบายการเปลี่ยนข้อมูลเป็นกราฟเส้นแสดงแนวโน้มฝนและอุณหภูมิสะสม
        - 1.5 การพัฒนา Drought Risk Dashboard ด้วยโค้ดจำลองระบบช่วยตัดสินใจเชิงเลข (Decision Support System: DSS)
        - แสดงตัวอย่างโค้ด Python ที่สะอาด มีคอมเมนต์ประกอบการเรียนรู้
        """
    },
    {
        "title": "บทที่ 2: คอมพิวเตอร์วิทัศน์และโมเดลการเรียนรู้เชิงลึกเพื่อการวินิจฉัยสภาพแปลงปลูก (Day 2)",
        "instruction": """
        - 2.1 หลักการของคอมพิวเตอร์วิทัศน์ (Computer Vision) และโครงข่ายประสาทเทียมแบบคอนโวลูชัน (Convolutional Neural Networks: CNN)
        - 2.2 ปฏิบัติการสะสมชุดภาพถ่ายพืชอัจฉริยะ (Data Collection) และเทคนิคการเพิ่มขยายข้อมูลภาพ (Data Augmentation) เพื่อป้องกัน Overfitting
        - 2.3 การออกแบบและฝึกสอนโมเดล CNN บนระบบคลาวด์ด้วย Google Colab (การใช้ GPU, การแบ่ง Training/Validation sets, การส่งออกโมเดลในรูปไฟล์ .h5 หรือ tflite)
        - 2.4 การประดิษฐ์แอปพลิเคชันมือถือ "Doctor AI App" ด้วย MIT App Inventor หรือ Kodular อธิบายสถาปัตยกรรมการต่อบล็อกโปรแกรมเพื่อดึงภาพขึ้นคลาวด์และแสดงผลวิเคราะห์ความสมบูรณ์ดิน/พืช
        - เขียนบรรยายอย่างสละสลวยเชิงวิชาการชั้นสูง
        """
    },
    {
        "title": "บทที่ 3: ระบบสมองกลอินเทอร์เน็ตของสรรพสิ่งและการบูรณาการ Capstone จริง (Day 3)",
        "instruction": """
        - 3.1 สถาปัตยกรรมบอร์ดควบคุม ESP32 บอร์ดขยาย และเซ็นเซอร์วัดความชื้นในดิน (Soil Moisture), เซ็นเซอร์แสง LDR Photoresistor และโมดูลควบคุมไฟ Relay
        - 3.2 ขั้นตอนการติดตั้งและกำหนดค่าโปรแกรม Arduino IDE และการติดตั้ง CH340 USB-to-Serial Driver เพื่อเชื่อมพอร์ตคอมพิวเตอร์กับบอร์ด
        - 3.3 ตรรกะควบคุมอัตโนมัติ (Smart Control Logic & Automation) ในการสั่งการ Relay: แสดงโค้ด C++ ของ Arduino ที่ใช้อ่านค่า Analog และตัดต่อปั๊มน้ำพร้อมการสอบเทียบค่า (Calibration)
        - 3.4 ปฏิบัติการบูรณาการสามประสาน "Agri-Smart Guardian Capstone Challenge": การเชื่อมโยงข้อมูลสภาพภูมิอากาศย้อนหลัง (วันแรก) + ดวงตา AI คัดกรองโรค (วันที่สอง) + เซ็นเซอร์หน้าดินวัดจริงคุมการรดน้ำน้ำคาร์บอนต่ำ (วันที่สาม)
        - 3.5 แนวทางการติดตั้งอุปกรณ์จริงในสวนทุเรียนโรงเรียนประณีตวิทยาคม: กล่องกันน้ำมาตรฐาน IP65, แผงโซลาร์เซลล์พลังงานสะอาด, และระบบส่งสถิติขึ้น Cloud Dashboard
        """
    },
    {
        "title": "บทสรุปและบรรณานุกรมเชิงวิชาการ (References)",
        "instruction": """
        - บทสรุปส่งท้ายถึงการสร้างความยั่งยืนและการต่อยอดโครงงานสู่ระดับชาติ (Science Week)
        - รายการบรรณานุกรมอ้างอิงเชิงวิชาการแบบผสมผสานทั้ง APA (สำหรับวิทยาศาสตร์ทั่วไป) และ IEEE (สำหรับระบบวิศวกรรม/IoT) รวมไม่น้อยกว่า 5 รายการที่เกี่ยวข้องกับ Smart Agriculture, CNN, ESP32, และการจัดการดิน
        """
    }
]

# Generate handbook content chapter by chapter
full_handbook = ""

for idx, sec in enumerate(sections):
    print(f"\n--- Progress: {idx+1}/{len(sections)} ---")
    content = generate_section(sec["title"], sec["instruction"])
    full_handbook += f"\n\n# {sec['title']}\n\n{content}\n\n---\n"

# Ensure output directory exists
os.makedirs(os.path.dirname(OUTPUT_FILE), exist_ok=True)

# Save the consolidated handbook
with open(OUTPUT_FILE, "w", encoding="utf-8") as f:
    f.write(full_handbook)

print(f"\n[SUCCESS] Consolidated Academic Handbook saved beautifully to: {OUTPUT_FILE}")
