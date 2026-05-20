# -*- coding: utf-8 -*-
import os
import json
import urllib.request
import urllib.error
import re
import sys

OLLAMA_API_URL = "http://localhost:11434/api/generate"
MODEL_NAME = "gemma4:latest"
BASE_DIR = "/Applications/XAMPP/xamppfiles/htdocs/rbrupraneet_agri_inno2026/docs/agri_innovation_handbook_3days"
OUTPUT_MERGED_FILE = "/Applications/XAMPP/xamppfiles/htdocs/rbrupraneet_agri_inno2026/docs/agri_innovation_handbook_3days.md"

# Define high-level writing parameters
SYSTEM_INSTRUCTION = """
You are an Elite Thai Professor in Applied Physics, Precision Agriculture, and Artificial Intelligence (รศ.ดร. ด้านฟิสิกส์ประยุกต์และเกษตรดิจิทัล).
Write in highly professional THAI academic textbook quality (ภาษาเขียนทางการวิชาการที่สระสลวย ถูกต้องตามอักขรวิธี).
Ensure all scientific words have their English terms in parentheses on their first occurrence, e.g., คอมพิวเตอร์วิทัศน์ (Computer Vision).
Use standard SI units with a space between numbers and units (e.g., 5 V, 10 kg, 2.4 GHz).
Ensure all mathematical models, physical laws, and equations are written using standard LaTeX math formatting ($...$ for inline and $$...$$ for block).
Be extremely verbose and comprehensive. Write detailed explanations, derivations, and step-by-step practical guides. Avoid abbreviations or placeholders.
Include detailed, production-grade code listings (Python or C++) with detailed Thai comments explaining each line and the physics/logic behind it.
"""

# Outline of all modular sections for the 3-day handbook
sections = [
    {
        "filepath": "markdown/preface.md",
        "title": "หน้าปก คำนำ และการวิเคราะห์วัตถุประสงค์เชิงเป้าหมายการเรียนรู้ (Preface & Educational Objectives Matrix)",
        "instruction": """
        - เขียนชื่อหนังสือ: "คู่มือนวัตกรเกษตรดิจิทัลรุ่นเยาว์: การบูรณาการปัญญาประดิษฐ์และอินเทอร์เน็ตของสรรพสิ่งในแปลงเกษตรแม่นยำ"
        - คำนำที่เป็นทางการ (Preface): เชื่อมโยงผลกระทบของการเปลี่ยนแปลงสภาพภูมิอากาศ (Climate Change) และวิกฤตภัยแล้ง/ฝนทิ้งช่วงในภาคตะวันออกของไทย (จันทบุรี-ตราด) กับความจำเป็นของการยกระดับเกษตรดั้งเดิมสู่เกษตรแม่นยำ (Precision Agriculture) ตามแนวคิดเศรษฐกิจ BCG (Bio-Circular-Green Economy)
        - กำหนดวัตถุประสงค์การเรียนรู้อย่างเป็นระบบตามกรอบอนุกรมวิธานของบลูม (Bloom's Taxonomy) ในลักษณะตารางเมทริกซ์ 6 ระดับ (ความรู้, ความเข้าใจ, การประยุกต์ใช้, การวิเคราะห์, การประเมินค่า, และการสร้างสรรค์นวัตกรรม)
        - อธิบายเป้าหมายของโครงการในการส่งมอบองค์ความรู้แก่นักเรียนเพื่อประดิษฐ์และติดตั้ง "กล่องนวัตกรสมาร์ทฟาร์ม" ในแปลงทุเรียนจริงของโรงเรียนประณีตวิทยาคม อ.เขาสมิง จ.ตราด
        """
    },
    {
        "filepath": "markdown/ch1/ch1_s1.md",
        "title": "1.1 ดุลภูมิอากาศและสรีรวิทยาของทุเรียนตะวันออก (Agro-Climatology and Eastern Durian Physiology)",
        "instruction": """
        - อธิบายกายภาพและสรีรวิทยาการเจริญเติบโตของต้นทุเรียน (Durio zibethinus) ในระยะวิกฤต เช่น ระยะออกดอกและติดผลที่ไวต่อสภาวะตึงเครียดจากน้ำ (Water Stress)
        - อธิบายแนวคิดทางฟิสิกส์เกษตรเรื่อง ดัชนีความตึงเครียดจากน้ำของพืช (Crop Water Stress Index: CWSI) และอุณหภูมิเรือนยอด (Canopy Temperature)
        - เขียนและวิเคราะห์สมการ ดุลพลังงานของเรือนยอดพืช (Canopy Energy Balance Equation):
          $$R_n = G + H + \\lambda ET_o$$
          โดยระบุคำอธิบายตัวแปรอย่างละเอียด ($R_n$ คือรังสีสุทธิ, $G$ คือฟลักซ์ความร้อนในดิน, $H$ คือฟลักซ์ความร้อนสัมผัส, และ $\\lambda ET_o$ คือฟลักซ์ความร้อนแฝงจากการคายระเหยน้ำ)
        - อธิบายความสัมพันธ์ของอุณหภูมิและความชื้นสัมพัทธ์ในอากาศต่อความแตกต่างของความดันไอน้ำในใบกับอากาศ (Vapor Pressure Deficit: VPD)
        """
    },
    {
        "filepath": "markdown/ch1/ch1_s2.md",
        "title": "1.2 พื้นฐาน Python Sandbox สำหรับนวัตกรเยาวชน (Introduction to Python Programming & Variables)",
        "instruction": """
        - แนะนำการใช้งานคอมพิวเตอร์และสิ่งแวดล้อมภาษา Python (Python Sandbox) สำหรับผู้เริ่มต้น
        - อธิบายชนิดข้อมูลพื้นฐาน (Data Types) เช่น integer, float, string, boolean และโครงสร้างข้อมูลแบบ List และ Dictionary
        - สอนตรรกะควบคุมทิศทางโปรแกรม (Control Structures) เช่น โครงสร้างเงื่อนไข `if-elif-else` และการวนลูป `for` และ `while`
        - แสดงตัวอย่างสคริปต์คอมพิวเตอร์ Python ที่จำลองการตรวจจับสภาวะวิกฤตของความชื้นดินและพิมพ์คำสั่งเตือนภัยในแปลงทุเรียน
        - เขียนคำอธิบายโค้ดทีละบรรทัด (Line-by-line annotation) ด้วยภาษาไทยที่เข้าใจง่ายและเป็นมิตรกับเยาวชน
        """
    },
    {
        "filepath": "markdown/ch1/ch1_s3.md",
        "title": "1.3 การดึงข้อมูลสภาพอากาศ TMD Open Data API และโครงสร้าง JSON",
        "instruction": """
        - อธิบายสถาปัตยกรรมคลังข้อมูลเปิดและ Web API โดยเฉพาะบริการข้อมูลอุตุนิยมวิทยาของกรมอุตุนิยมวิทยา (TMD Open Data API)
        - สอนวิธีการร้องขอข้อมูล (API Request) การใช้ API key และความแตกต่างระหว่างโปรโตคอล HTTP GET และ POST
        - อธิบายโครงสร้างข้อมูลแบบ JSON (JavaScript Object Notation) และการแปลงค่า (Parsing) ข้อมูลพารามิเตอร์สภาพอากาศ เช่น อุณหภูมิ, ปริมาณน้ำฝนสะสม, ความเร็วลม
        - แสดงซอร์สโค้ด Python ที่มีความเสถียรสูง (Robust) โดยใช้ไลบรารีมาตรฐาน `urllib.request` และ `json` ในการดึงข้อมูลอากาศปัจจุบันของสถานีอุตุนิยมวิทยาเขาสมิง จังหวัดตราด พร้อมพิมพ์ผลลัพธ์ออกมาเป็นระเบียบ
        """
    },
    {
        "filepath": "markdown/ch1/ch1_s4.md",
        "title": "1.4 การวิเคราะห์อนุกรมเวลาสภาพอากาศด้วย Pandas (Weather Time Series Analysis with Pandas & Seaborn)",
        "instruction": """
        - อธิบายความหมายของข้อมูลอนุกรมเวลา (Time Series Data) ในมิติทางอุตุนิยมวิทยาการเกษตร
        - สอนการใช้งานไลบรารี Pandas ในการโหลดข้อมูล (Dataframe), การจัดการข้อมูลสูญหาย (Missing values), และการดัชนีเวลา (Datetime Indexing)
        - อธิบายการวิเคราะห์แนวโน้มข้อมูลสภาพอากาศระยะยาวด้วยการหาค่าเฉลี่ยเคลื่อนที่ (Rolling Moving Average) เพื่อลดสัญญาณรบกวนระยะสั้น
        - แสดงตัวอย่างสคริปต์ Python ที่อ่านไฟล์ CSV สถิติภูมิอากาศย้อนหลัง ทำการคำนวณ Rolling Average 7 วัน และใช้ไลบรารี Seaborn หรือ Matplotlib ในการวาดกราฟเส้นแสดงทิศทางแนวโน้มปริมาณน้ำฝนสะสมและอุณหภูมิเฉลี่ยอย่างสวยงาม
        """
    },
    {
        "filepath": "markdown/ch1/ch1_s5.md",
        "title": "1.5 แบบจำลอง Drought Risk Index (DRI) Dashboard และระบบสนับสนุนการตัดสินใจ (Decision Support System)",
        "instruction": """
        - อธิบายแนวคิดของระบบสนับสนุนการตัดสินใจในการทำฟาร์ม (Farm Decision Support System: DSS)
        - พัฒนาแบบจำลองทางคณิตศาสตร์อย่างง่ายในการคำนวณ ดัชนีความเสี่ยงภัยแล้งในสวนทุเรียน (Drought Risk Index: DRI) โดยคำนวณแบบถ่วงน้ำหนักจากอุณหภูมิสะสม ความชื้นสัมพัทธ์ในอากาศ และปริมาณฝนย้อนหลัง:
          $$DRI = w_1 \\cdot \\left(\\frac{T_{max} - T_{avg}}{T_{max}}\\right) + w_2 \\cdot (1 - RH_{avg}) + w_3 \\cdot \\left(1 - \\frac{Rain_{sum}}{Rain_{threshold}}\\right)$$
        - แสดงซอร์สโค้ด Python สมบูรณ์แบบที่นำข้อมูลอนุกรมเวลาสภาพอากาศมาคำนวณ DRI ในแต่ละวัน และสร้างแดชบอร์ดจำลองในเทอร์มินัลที่แสดงระดับความเตือนภัยแล้ง (Normal, Warning, Critical) พร้อมให้คำแนะนำการจัดการน้ำแก่เกษตรกรอย่างเหมาะสมตามผลลัพธ์
        """
    },
    {
        "filepath": "markdown/ch2/ch2_s1.md",
        "title": "2.1 ดัชนีสเปกตรัมพืชพรรณ (NDVI, EVI) และหลักการของคอมพิวเตอร์วิทัศน์ (Spectral Vegetation Indices & Computer Vision)",
        "instruction": """
        - อธิบายหลักการฟิสิกส์ของการแผ่รังสีเชิงแสงและการตกกระทบสะท้อนของคลื่นแม่เหล็กไฟฟ้าบนพืชพรรณ โดยเฉพาะคุณสมบัติของใบพืชที่ดูดกลืนแสงสีแดง (Red Light) และสะท้อนแสงอินฟราเรดย่านใกล้ (Near-Infrared: NIR) สูงเนื่องจากโครงสร้างเซลล์มีโซฟิลล์ (Mesophyll Cells)
        - แสดงสมการและอธิบายความหมายเชิงลึกของ ดัชนีพืชพรรณผลต่างปกติ (Normalized Difference Vegetation Index: NDVI):
          $$NDVI = \\frac{NIR - Red}{NIR + Red}$$
        - แสดงสมการ ดัชนีพืชพรรณที่ปรับปรุงแล้ว (Enhanced Vegetation Index: EVI) และดัชนีสเปกตรัมขอบเขตสีแดง (Normalized Difference Red Edge: NDRE) สำหรับประเมินความเครียดไนโตรเจน
        - อธิบายการประยุกต์คอมพิวเตอร์วิทัศน์ (Computer Vision) และกล้องถ่ายภาพในการเกษตร เช่น การใช้ภาพถ่ายถ่ายวิเคราะห์ความเขียวของใบพืชและคัดกรองโรค
        """
    },
    {
        "filepath": "markdown/ch2/ch2_s2.md",
        "title": "2.2 โครงสร้างคณิตศาสตร์ของ CNN (Convolutional Neural Networks: Convolution, ReLU, Max Pooling, Softmax)",
        "instruction": """
        - อธิบายสถาปัตยกรรมโครงข่ายประสาทเทียมแบบคอนโวลูชัน (Convolutional Neural Network: CNN) ซึ่งเป็นแกนหลักของการเรียนรู้เชิงลึกด้านภาพ
        - อธิบายกลไกทางคณิตศาสตร์ทีละชั้นอย่างละเอียด:
          1. ชั้นคอนโวลูชัน (Convolutional Layer) และสมการตัวกรองฟิลเตอร์คูณเมทริกซ์ 2 มิติ:
             $$G[i, j] = (I * K)[i, j] = \\sum_{m} \\sum_{n} I[i-m, j-n] K[m, n]$$
          2. ฟังก์ชันกระตุ้นค่าเชิงเส้นแบบปรับแก้ (Rectified Linear Unit: ReLU):
             $$f(x) = \\max(0, x)$$
          3. ชั้นลดขนาดพื้นที่สูงสุด (Max Pooling Layer) ในการลดจำนวนมิติข้อมูล
          4. ชั้นเชื่อมต่อสมบูรณ์ (Fully Connected Layer) และฟังก์ชันซอฟต์แมกซ์ (Softmax Function) สำหรับพยากรณ์ความน่าจะเป็นของคลาส:
             $$P(y = c \\mid \\mathbf{x}) = \\frac{e^{z_c}}{\\sum_{j} e^{z_j}}$$
        - อธิบายภาพรวมของการทำงานของ CNN ในการรับสัญญาณภาพใบพืชเข้าทางอินพุตและจำแนกสายพันธุ์หรือโรคทางเอาต์พุต
        """
    },
    {
        "filepath": "markdown/ch2/ch2_s3.md",
        "title": "2.3 ปฏิบัติการสะสมชุดภาพถ่าย การขยายข้อมูลภาพ การฝึกโมเดลบน Google Colab และการส่งออก TFLite",
        "instruction": """
        - อธิบายกระบวนการเตรียมและรวบรวมชุดข้อมูลภาพถ่ายใบพืช (Dataset Collection) ในภาคสนาม
        - แนะนำปัญหาการเรียนรู้เกิน (Overfitting) และทางแก้โดยเทคนิคการเพิ่มขยายข้อมูลภาพ (Data Augmentation) เช่น การหมุนภาพ, การกลับภาพ, การเปลี่ยนระดับความสว่าง
        - แสดงซอร์สโค้ด Python สมบูรณ์แบบที่ใช้อินเตอร์เฟซ TensorFlow/Keras บน Google Colab ในการโหลดชุดข้อมูลภาพใบพืช, ทำ Data Augmentation, สร้างโมเดล CNN แบบง่ายที่มี 3 ชั้นคอนโวลูชัน, ทำการฝึกสอนโมเดล (Model Training), และส่งออกโมเดลในฟอร์แมตขนาดเล็ก TensorFlow Lite (.tflite) สำหรับใช้งานบนระบบประมวลผลปลายทาง (Edge Computing)
        """
    },
    {
        "filepath": "markdown/ch2/ch2_s4.md",
        "title": "2.4 การประดิษฐ์แอปพลิเคชันมือถือ Doctor AI App บน Kodular/App Inventor (Client-Server and Mobile Block Logic)",
        "instruction": """
        - อธิบายการออกแบบสถาปัตยกรรมของแอปพลิเคชันมือถือในการเกษตรปลายทาง (Agro-Mobile App Architecture)
        - อธิบายแนวทางการพัฒนารูปแบบไร้โค้ด (No-code / Low-code Mobile App) ด้วยแพลตฟอร์ม Kodular หรือ MIT App Inventor
        - อธิบายสถาปัตยกรรมแบบ Client-Server ในการเชื่อมต่อแอปพลิเคชันโทรศัพท์มือถือกับระบบประมวลผลคลาวด์ผ่าน HTTP POST Request เพื่อส่งข้อมูลภาพใบพืชไปพยากรณ์
        - อธิบายและวาดผังการต่อบล็อกคำสั่ง (Block Programming Layout) ใน Kodular อย่างละเอียด:
          1. บล็อกคำสั่งการเปิดกล้องและการเลือกรูปภาพในแกลเลอรี่มือถือ
          2. บล็อกคำสั่งของคอมโพเนนต์ Web Component ในการแปลงภาพเป็น Base64 และโพสต์ส่งไปยัง API Endpoint
          3. บล็อกคำสั่งการรับผลลัพธ์ JSON ตอบกลับและแยกแยะระดับความน่าจะเป็นเพื่อแสดงสถานะสุขภาพใบพืชบนหน้าจอมือถือ
        """
    },
    {
        "filepath": "markdown/ch3/ch3_s1.md",
        "title": "3.1 ฟิสิกส์โซลาร์เซลล์ ความนำสารกึ่งตัวนำ และระบบพลังงานเก็บกักแบตเตอรี่ (Photovoltaic Semiconductor Physics & Battery Systems)",
        "instruction": """
        - อธิบายหลักการทางฟิสิกส์ของปรากฏการณ์โฟโตวอลเทอิก (Photovoltaic Effect) ในสารกึ่งตัวนำ (Semiconductor) ซิลิคอนแบบรอยต่อ p-n (p-n junction)
        - แสดงสมการคำนวณกำลังไฟฟ้าสูงสุดของแผงโซลาร์เซลล์ (Solar Panel Power Output):
          $$P_{pv} = \\eta_{pv} \\cdot A \\cdot G_t \\cdot [1 - \\beta_{temp} \\cdot (T_{cell} - 25)]$$
          โดยอธิบายตัวแปรอย่างละเอียด ($\\eta_{pv}$ คือประสิทธิภาพแผง, $A$ คือพื้นที่แผง, $G_t$ คือรังสีดวงอาทิตย์ตกกระทบ, และ $\\beta_{temp}$ คือสัมประสิทธิ์อุณหภูมิของกำลังไฟฟ้า)
        - อธิบายหลักการเคมีไฟฟ้าและระบบประจุพลังงานในแบตเตอรี่ โดยเฉพาะ แบตเตอรี่ลิเธียมฟอสเฟต (Lithium Iron Phosphate: LiFePO4) ที่มีเสถียรภาพและความปลอดภัยสูง
        - อธิบายพารามิเตอร์จำลอง สถานะการชาร์จ (State of Charge: SOC) และดัชนีสุขภาพของแบตเตอรี่ (State of Health: SOH) ในตู้ควบคุมไฟของสมาร์ทฟาร์มภายนอกอาคาร
        """
    },
    {
        "filepath": "markdown/ch3/ch3_s2.md",
        "title": "3.2 บอร์ดฝังตัว ESP32, ไดรเวอร์ CH340 และสิ่งแวดล้อมโปรแกรม Arduino IDE",
        "instruction": """
        - แนะนำสถาปัตยกรรมของชิปสมองกลฝังตัว ESP32 ไมโครคอนโทรลเลอร์ขนาด 32 บิตที่มี Wi-Fi และ Bluetooth ในตัว
        - อธิบายความแตกต่างของขาพิน (Pinout Map) ทั้งแบบสัญญาณดิจิทัล (GPIO), ขาพินอนาล็อกสู่อดิจิทัล (Analog-to-Digital Converter: ADC), และขาสัญญาณจ่ายกำลังไฟฟ้า
        - อธิบายความสำคัญของชิปแปลงสัญญาณ USB-to-Serial (เช่น CH340 Driver) และขั้นตอนการติดตั้งไดรเวอร์ในระบบปฏิบัติการ Windows/macOS เพื่อคุยกับบอร์ด
        - อธิบายขั้นตอนการตั้งค่าโปรแกรม Arduino IDE การเพิ่มบอร์ด ESP32 ผ่านบอร์ดผู้จัดการ (Boards Manager) และโครงสร้างหลักของสเก็ตช์โค้ด C++ (ฟังก์ชัน `setup()` และ `loop()`)
        """
    },
    {
        "filepath": "markdown/ch3/ch3_s3.md",
        "title": "3.3 การเขียนโค้ดอ่านเซนเซอร์ วิเคราะห์กราฟคาลิเบรตดินเหนียวตราด (Soil Moisture Sensor Calibration for Trat Clay)",
        "instruction": """
        - อธิบายหลักการทำงานของเซ็นเซอร์วัดความชื้นในดินแบบเก็บประจุ (Capacitive Soil Moisture Sensor) ซึ่งทนทานต่อการกัดกร่อนกว่าแบบต้านทาน
        - อธิบายกลไกทางฟิสิกส์ของการวัดค่าความต่างศักย์อนาล็อก (Analog Voltage Output) ที่ผกผันกับค่าคงที่ไดอิเล็กทริก (Dielectric Constant) ของดินรอบๆ เซ็นเซอร์
        - นำเสนอทฤษฎีการ สอบเทียบเซ็นเซอร์ (Sensor Calibration) ในเชิงวิชาการเพื่อแปลงค่าดิบดิจิทัล (0 ถึง 4095 ของบอร์ด ESP32) ให้เป็นเปอร์เซ็นต์ความชื้นดินเชิงปริมาตร (Volumetric Water Content: VWC %):
          $$VWC = m \\cdot ADC_{raw} + c$$
          โดยแสดงตรรกะการหาค่าความชื้นต่ำสุดในดินทรายแห้ง (Dry Soil Point) และค่าความชื้นสูงสุดในดินอิ่มตัวด้วยน้ำ (Wet Soil Point) สำหรับดินเหนียวชุดจันทบุรี/ตราด
        - แสดงสเก็ตช์โค้ด C++ ของ Arduino ที่อ่านค่า ADC จากเซ็นเซอร์ กรองสัญญาณรบกวนแบบหาค่าเฉลี่ยเคลื่อนที่ในบอร์ด (Moving Average Filter) และแปลงค่าเป็นเปอร์เซ็นต์อย่างถูกต้องสมบูรณ์
        """
    },
    {
        "filepath": "markdown/ch3/ch3_s4.md",
        "title": "3.4 ตรรกะระบบควบคุมป้อนกลับ (Feedback Control Loop) สั่งงานวงจรไฟฟ้าปั๊มน้ำด้วยรีเลย์",
        "instruction": """
        - อธิบายหลักการทางวิศวกรรมควบคุมป้อนกลับ (Feedback Control Loop) ในการควบคุมความชื้นดินแบบสองตำแหน่ง (On-Off Controller)
        - อธิบายหลักการทำงานของโมดูลรีเลย์ (Relay Module) ที่ทำหน้าที่เป็นสวิตช์ควบคุมระบบไฟฟ้าแรงสูงด้วยสัญญาณแรงดันต่ำจากไมโครคอนโทรลเลอร์
        - อธิบายปรากฏการณ์รีเลย์ทำงานแบบ Active Low และการป้องกันไฟกระชากกลับโดยใช้ออปโตคัปเปลอร์ (Optocoupler isolation) ในตรรกะระบบควบคุม
        - แสดงซอร์สโค้ด C++ สมบูรณ์ของ Arduino ในการอ่านความชื้นดินเชิงปริมาตร ตรวจสอบเงื่อนไขหากความชื้นต่ำกว่าค่าขีดเริ่มต่ำสุด (Lower Threshold เช่น 35% VWC) ให้ทำการสั่งเปิดรีเลย์ปั๊มน้ำ และหากสูงกว่าค่าขีดเริ่มสูงสุด (Upper Threshold เช่น 65% VWC) ให้สั่งปิดรีเลย์ พร้อมใส่ตรรกะหน่วงเวลาแบบไม่มีการหยุดการประมวลผล (Non-blocking delay using `millis()`) เพื่อความปลอดภัย
        """
    },
    {
        "filepath": "markdown/ch3/ch3_s5.md",
        "title": "3.5 แล็บวิจัยเกษตรขั้นสูง: 1D Richards Infiltration Solver (Python) และระบบนำทาง Extended Kalman Filter (EKF)",
        "instruction": """
        - นำเสนอแบบจำลองการไหลซึมผ่านน้ำแนวดิ่งในดินที่ซับซ้อนด้วย สมการริชาร์ดส (Richards Equation 1D PDE):
          $$\\frac{\\partial \\theta}{\\partial t} = \\frac{\\partial}{\\partial z} \\left[ K(\\theta) \\left( \\frac{\\partial \\psi}{\\partial z} + 1 \\right) \\right]$$
          โดยอธิบายความสัมพันธ์ของการซึมน้ำผ่าน ดินเหนียวจันทบุรี (Chanthaburi Clay) โดยมีตัวแปรดัชนีของ Van Genuchten: $\\theta_r = 0.098$, $\\theta_s = 0.485$, $K_s = 1.15 \\times 10^{-4} \\text{ cm/s}$
        - แสดง ซอร์สโค้ด Python สมบูรณ์ของคลาส `ChanthaburiClayDiffusionSolver` ที่ใช้ระเบียบวิธีผลต่างอันดับสิ้นสุด (Finite Difference Method: FDM) ในการจำลองการกระจายตัวของความชื้นในดินชั้นดินแนวดิ่ง 1 มิติ (100 ซม.) ตามเวลา เพื่อให้นักเรียนเข้าใจกระบวนการดูดซับน้ำใต้ดินในสวนทุเรียนจริง
        - อธิบายทฤษฎีและสมการของ ตัวกรองคาลมานขยาย (Extended Kalman Filter: EKF) ในการหลอมรวมข้อมูลเซ็นเซอร์นำทางสำหรับการทำแผนที่ฟาร์ม
        - ให้เขียนโค้ดและคำอธิบายเป็นภาษาไทยอย่างละเอียด ลึกซึ้ง และงดงามในเชิงวิชาการชั้นสูง
        """
    },
    {
        "filepath": "markdown/ch3/ch3_s6.md",
        "title": "3.6 การประกอบกล่องภายนอกอาคารมาตรฐาน IP65 และ Telemetry ส่งพารามิเตอร์ขึ้น Cloud (MQTT)",
        "instruction": """
        - อธิบายหลักการติดตั้งอุปกรณ์ไอโอทีภายนอกอาคาร (Outdoor IoT Deployments) เพื่อความคงทนและเผชิญมรสุมในแปลงปลูกภาคตะวันออก
        - สอนมาตรฐานป้องกันฝุ่นและน้ำ (Ingress Protection: IP rating) โดยเน้นมาตรฐานระดับ IP65 และแนวทางการเจาะยึดกล่องพลาสติกอะคริลิก การเดินสายไฟร้อยท่อกระดูกงู และการติดตั้งแผงโซลาร์เซลล์
        - อธิบายแนวคิดของการสื่อสารข้อมูลระยะไกลด้วยโปรโตคอล เทเลเมทรี (Telemetry) ผ่านระบบเผยแพร่และบอกรับพาดหัว (Publish/Subscribe Architecture) ด้วยโปรโตคอล MQTT (Message Queuing Telemetry Transport)
        - แสดงสเก็ตช์โค้ด C++ ของ Arduino ESP32 ในการเชื่อมต่อเครือข่าย Wi-Fi และส่งค่าความชื้นดินและแสงขึ้นสู่เซิร์ฟเวอร์คลาวด์บิต (MQTT broker) ผ่านหัวข้อพับลิช (Publish Topic) ในรูปโครงสร้างข้อมูลสายอักขระ
        """
    },
    {
        "filepath": "markdown/references.md",
        "title": "บรรณานุกรมเชิงวิชาการมาตรฐานสากล (References - APA and IEEE Styles)",
        "instruction": """
        - รวบรวมและจัดรูปแบบรายการอ้างอิงเชิงวิชาการอย่างเป็นทางการ (Bibliography)
        - ใส่รายการอ้างอิงอย่างน้อย 6 รายการที่อัปเดตและทันสมัย ผสมผสานตามรูปแบบมาตรฐาน APA 7th edition (สำหรับพฤกษศาสตร์และวิทยาศาสตร์ดิน) และ IEEE Style (สำหรับวิศวกรรมฝังตัวและคอมพิวเตอร์วิทัศน์)
        - รายการอ้างอิงควรครอบคลุม:
          1. หนังสือและงานวิจัยเกี่ยวกัยแบบจำลองน้ำในดินดินเหนียวจันทบุรี (Richards & Van Genuchten)
          2. บทความทางวิชาการเกี่ยวกัยสถาปัตยกรรม CNN คลาสสิกสำหรับการจำแนกโรคใบพืช
          3. งานอ้างอิงด้านระบบสมองกลฝังตัว ESP32 และเกษตรอัจฉริยะแม่นยำ
          4. แหล่งข้อมูลทางการเกี่ยวกัยดัชนีความตึงเครียดจากน้ำของทุเรียน
        - ตรวจสอบให้แน่ใจว่าไม่มีข้อความ Placeholder และทุกรายการเขียนสะกดอย่างถูกต้องสมบูรณ์แบบ
        """
    }
]

def clean_model_thinking(text):
    """Clean typical deepseek/gemma thinking processes if any exist in the response"""
    cleaned = re.sub(r'<think>.*?</think>', '', text, flags=re.DOTALL)
    cleaned = re.sub(r'Thinking\.\.\..*?done thinking\.', '', cleaned, flags=re.DOTALL)
    cleaned = re.sub(r'\[Thinking\.\.\.\].*?\[done thinking\]', '', cleaned, flags=re.DOTALL)
    return cleaned.strip()

def generate_section(filepath, title, instruction):
    """Calls Ollama locally to generate detailed academic content for one specific section"""
    target_abs_path = os.path.join(BASE_DIR, filepath)
    
    # Enable resume capability: if the file already exists and has a solid size (> 1500 chars), skip generation
    if os.path.exists(target_abs_path):
        size = os.path.getsize(target_abs_path)
        if size > 1500:
            print(f"  [SKIP] '{filepath}' already exists and is expanded ({size} bytes).")
            return
            
    print(f"  [PROCESS] Generating '{filepath}' ... Please wait ...")
    
    prompt = f"""
    {SYSTEM_INSTRUCTION}
    
    หัวข้อที่ให้เขียนตำราเรียน: {title}
    คำแนะนำและโครงร่างเนื้อหาที่ต้องลงลึกเชิงทฤษฎีและเชิงปฏิบัติ:
    {instruction}
    
    จงเขียนเนื้อหาอธิบายอย่างละเอียด มีระดับความยาวและระดับวิชาการสูงสุด ไม่เขียนสรุปย่อหรือละเว้นส่วนสำคัญ เขียนทฤษฎี สมการ LaTeX ฟอนต์สัญลักษณ์ SI และตัวอย่างซอร์สโค้ด (ถ้าคำแนะนำร้องขอ) แบบสมบูรณ์ที่สุด:
    """
    
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
        with urllib.request.urlopen(req, timeout=900) as response:
            res_body = response.read().decode("utf-8")
            result = json.loads(res_body)
            raw_text = result.get("response", "")
            cleaned_text = clean_model_thinking(raw_text)
            
            # Write content to specific file
            os.makedirs(os.path.dirname(target_abs_path), exist_ok=True)
            with open(target_abs_path, "w", encoding="utf-8") as f:
                f.write(f"## {title}\n\n{cleaned_text}\n")
            print(f"  [SUCCESS] Written {len(cleaned_text)} characters to '{filepath}'")
            
    except urllib.error.URLError as e:
        print(f"  [ERROR] Ollama connection error for '{filepath}': {e}")
        sys.exit(1)
    except Exception as e:
        print(f"  [ERROR] Unexpected error for '{filepath}': {e}")
        sys.exit(1)

def write_toc():
    """Generates the Table of Contents file (TOC.md)"""
    toc_path = os.path.join(BASE_DIR, "markdown/TOC.md")
    print(f"  [PROCESS] Writing Table of Contents to '{toc_path}'...")
    
    toc_content = """# สารบัญรายละเอียดวิชาเรียนอบรม 3 วัน
    
## โครงการศูนย์พัฒนานวัตกรรมเกษตรดิจิทัลรำไพพรรณี ประณีตวิทยาคม
**กิจกรรม อบรมเชิงปฏิบัติการ การพัฒนานวัตกรรมเกษตรดิจิทัลด้วยปัญญาประดิษฐ์**
*ณ โรงเรียนประณีตวิทยาคม อ.เขาสมิง จ.ตราด*

---

*   [**คำนำ และวัตถุประสงค์เป้าหมายการเรียนรู้ (Preface)**](file:///preface.md)
*   [**บทที่ 1: ฟิสิกส์อุตุนิยมวิทยาเกษตรและการประมวลผลข้อมูลอนุกรมเวลา (Day 1)**](file:///ch1/ch1_s1.md)
    *   [1.1 ดุลภูมิอากาศและสรีรวิทยาของทุเรียนตะวันออก](file:///ch1/ch1_s1.md)
    *   [1.2 พื้นฐาน Python Sandbox สำหรับนวัตกรเยาวชน](file:///ch1/ch1_s2.md)
    *   [1.3 การดึงข้อมูลสภาพอากาศ TMD Open Data API และโครงสร้าง JSON](file:///ch1/ch1_s3.md)
    *   [1.4 การวิเคราะห์อนุกรมเวลาสภาพอากาศด้วย Pandas](file:///ch1/ch1_s4.md)
    *   [1.5 แบบจำลอง Drought Risk Index (DRI) Dashboard และระบบสนับสนุนการตัดสินใจ](file:///ch1/ch1_s5.md)
*   [**บทที่ 2: คอมพิวเตอร์วิทัศน์เชิงแสงและโครงข่ายประสาทเทียมลึกวิเคราะห์โรคพืช (Day 2)**](file:///ch2/ch2_s1.md)
    *   [2.1 ดัชนีสเปกตรัมพืชพรรณ (NDVI, EVI) และหลักการของคอมพิวเตอร์วิทัศน์](file:///ch2/ch2_s1.md)
    *   [2.2 โครงสร้างคณิตศาสตร์ของ CNN (Convolution, ReLU, Max Pooling, Softmax)](file:///ch2/ch2_s2.md)
    *   [2.3 ปฏิบัติการสะสมชุดภาพถ่าย การขยายข้อมูลภาพ การฝึกโมเดลบน Google Colab และการส่งออก TFLite](file:///ch2/ch2_s3.md)
    *   [2.4 การประดิษฐ์แอปพลิเคชันมือถือ Doctor AI App บน Kodular/App Inventor](file:///ch2/ch2_s4.md)
*   [**บทที่ 3: ชลศาสตร์เขตรากพืช ระบบสมองกลฝังตัว และระบบนำทางอัจฉริยะ (Day 3)**](file:///ch3/ch3_s1.md)
    *   [3.1 ฟิสิกส์โซลาร์เซลล์ ความนำสารกึ่งตัวนำ และระบบพลังงานเก็บกักแบตเตอรี่](file:///ch3/ch3_s1.md)
    *   [3.2 บอร์ดฝังตัว ESP32, ไดรเวอร์ CH340 และสิ่งแวดล้อมโปรแกรม Arduino IDE](file:///ch3/ch3_s2.md)
    *   [3.3 การเขียนโค้ดอ่านเซนเซอร์ วิเคราะห์กราฟคาลิเบรตดินเหนียวตราด](file:///ch3/ch3_s3.md)
    *   [3.4 ตรรกะระบบควบคุมป้อนกลับ (Feedback Control Loop) สั่งงานวงจรไฟฟ้าปั๊มน้ำด้วยรีเลย์](file:///ch3/ch3_s4.md)
    *   [3.5 แล็บวิจัยเกษตรขั้นสูง: 1D Richards Infiltration Solver (Python) และระบบนำทาง Extended Kalman Filter (EKF)](file:///ch3/ch3_s5.md)
    *   [3.6 การประกอบกล่องภายนอกอาคารมาตรฐาน IP65 และ Telemetry ส่งพารามิเตอร์ขึ้น Cloud (MQTT)](file:///ch3/ch3_s6.md)
*   [**บรรณานุกรมเชิงวิชาการมาตรฐานสากล (References)**](file:///references.md)
"""
    
    os.makedirs(os.path.dirname(toc_path), exist_ok=True)
    with open(toc_path, "w", encoding="utf-8") as f:
        f.write(toc_content)
    print("  [SUCCESS] TOC.md created.")

def merge_markdown_files():
    """Combines all individual sections in order and saves the consolidated file"""
    print(f"\n[PROCESS] Starting Consolidation into a single master file...")
    
    order = [
        "markdown/TOC.md",
        "markdown/preface.md",
        "markdown/ch1/ch1_s1.md",
        "markdown/ch1/ch1_s2.md",
        "markdown/ch1/ch1_s3.md",
        "markdown/ch1/ch1_s4.md",
        "markdown/ch1/ch1_s5.md",
        "markdown/ch2/ch2_s1.md",
        "markdown/ch2/ch2_s2.md",
        "markdown/ch2/ch2_s3.md",
        "markdown/ch2/ch2_s4.md",
        "markdown/ch3/ch3_s1.md",
        "markdown/ch3/ch3_s2.md",
        "markdown/ch3/ch3_s3.md",
        "markdown/ch3/ch3_s4.md",
        "markdown/ch3/ch3_s5.md",
        "markdown/ch3/ch3_s6.md",
        "markdown/references.md"
    ]
    
    merged_data = []
    
    # Main title header
    merged_data.append("# โครงการศูนย์พัฒนานวัตกรรมเกษตรดิจิทัลรำไพพรรณี ประณีตวิทยาคม\n")
    merged_data.append("## คู่มือนวัตกรเกษตรดิจิทัลรุ่นเยาว์: การบูรณาการปัญญาประดิษฐ์และอินเทอร์เน็ตของสรรพสิ่งในแปลงเกษตรแม่นยำ\n")
    merged_data.append("### คณะวิทยาศาสตร์และเทคโนโลยี มหาวิทยาลัยราชภัฏรำไพพรรณี\n")
    merged_data.append("แหล่งที่มาของงบประมาณ: งบประมาณรายจ่ายประจำปีงบประมาณ พ.ศ. 2569 (งบแผ่นดิน 76,000 บาท - รหัสโครงการ 110100463)\n")
    merged_data.append("ผู้อำนวยการโครงการ: ผู้ช่วยศาสตราจารย์ ดร.ชีวะ ทัศนา และ ผู้ช่วยศาสตราจารย์อรรถกร คำฉัตร\n")
    merged_data.append("\n---\n\n")
    
    for relative_path in order:
        abs_path = os.path.join(BASE_DIR, relative_path)
        if not os.path.exists(abs_path):
            print(f"  [WARNING] File not found: '{relative_path}'. Skipping.")
            continue
            
        with open(abs_path, "r", encoding="utf-8") as f:
            content = f.read()
            
        # Clean double # titles or standardize heading levels
        if relative_path.endswith("TOC.md"):
            merged_data.append(content)
        elif relative_path.endswith("preface.md") or relative_path.endswith("references.md"):
            # Ensure it is a main chapter-level section
            content = re.sub(r'^## ', '# ', content)
            merged_data.append(content)
        elif "ch1_s" in relative_path:
            if "ch1_s1.md" in relative_path:
                merged_data.append("\n\n# บทที่ 1: ฟิสิกส์อุตุนิยมวิทยาเกษตรและการประมวลผลข้อมูลอนุกรมเวลา (Day 1)\n\n")
                merged_data.append("**ระดับวิชา:** กายภาพอุตุนิยมวิทยาการเกษตรและวิทยาการวิเคราะห์ข้อมูลระดับเบื้องต้น\n")
                merged_data.append("**ผู้บรรยาย:** ผู้ช่วยศาสตราจารย์ ดร.ชีวะ ทัศนา และ ผู้ช่วยศาสตราจารย์อรรถกร คำฉัตร\n\n---\n\n")
            merged_data.append(content)
        elif "ch2_s" in relative_path:
            if "ch2_s1.md" in relative_path:
                merged_data.append("\n\n# บทที่ 2: คอมพิวเตอร์วิทัศน์เชิงแสงและโครงข่ายประสาทเทียมลึกวิเคราะห์โรคพืช (Day 2)\n\n")
                merged_data.append("**ระดับวิชา:** ปัญญาประดิษฐ์เชิงลึกและเทคโนโลยีคอมพิวเตอร์วิทัศน์ประยุกต์ทางการเกษตร\n")
                merged_data.append("**ผู้บรรยาย:** ผู้ช่วยศาสตราจารย์ ดร.ชีวะ ทัศนา และ ผู้ช่วยศาสตราจารย์อรรถกร คำฉัตร\n\n---\n\n")
            merged_data.append(content)
        elif "ch3_s" in relative_path:
            if "ch3_s1.md" in relative_path:
                merged_data.append("\n\n# บทที่ 3: ชลศาสตร์เขตรากพืช ระบบสมองกลฝังตัว และระบบนำทางอัจฉริยะ (Day 3)\n\n")
                merged_data.append("**ระดับวิชา:** สถาปัตยกรรมอินเทอร์เน็ตของสรรพสิ่ง ชลศาสตร์เกษตร และวิศวกรรมฝังตัวภาคสนาม\n")
                merged_data.append("**ผู้บรรยาย:** ผู้ช่วยศาสตราจารย์ ดร.ชีวะ ทัศนา และ ผู้ช่วยศาสตราจารย์อรรถกร คำฉัตร\n\n---\n\n")
            merged_data.append(content)
            
        merged_data.append("\n\n---\n\n")
        
    master_text = "".join(merged_data)
    
    # Save the final consolidated file
    with open(OUTPUT_MERGED_FILE, "w", encoding="utf-8") as f:
        f.write(master_text)
    print(f"\n[SUCCESS] Consolidated Markdown Handbook written successfully to: '{OUTPUT_MERGED_FILE}' ({len(master_text)} characters)")

def main():
    print("=================================================================")
    print("STARTING MODULAR HANDBOOK GENERATION PROCESS")
    print(f"Target Directory: '{BASE_DIR}'")
    print(f"Ollama Model: '{MODEL_NAME}'")
    print("=================================================================")
    
    os.makedirs(BASE_DIR, exist_ok=True)
    
    # 1. Write the Table of Contents
    write_toc()
    
    # 2. Sequentially generate all sections
    for idx, sec in enumerate(sections):
        print(f"\n--- Section Progress: {idx+1}/{len(sections)} ---")
        generate_section(sec["filepath"], sec["title"], sec["instruction"])
        
    # 3. Consolidate into a single master file
    merge_markdown_files()
    
    print("\n=================================================================")
    print("MODULAR RUN COMPLETE.")
    print("=================================================================")

if __name__ == "__main__":
    main()
