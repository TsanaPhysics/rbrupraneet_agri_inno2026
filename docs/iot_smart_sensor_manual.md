# 📟 คู่มือหลักสูตรเบื้องต้น: AI-IoT Smart Sensor Prototyping
### โครงการ RBRU-Praneet Digital Agri-Innovation Center

ยินดีต้อนรับสู่โลกของวิศวกรรมฮาร์ดแวร์เพื่อการเกษตร! ในหลักสูตรนี้ น้องๆ จะได้สร้าง "อุปกรณอัจฉริยะ" ที่สามารถวัดค่า พูดคุยกับเน็ต และตัดสินใจแทนคนได้จริง

---

## 🛠️ รายการอุปกรณ์ที่ต้องใช้ (BOM List)

เพื่อให้การทำ Workshop สำเร็จ น้องๆ ควรเตรียมอุปกรณ์ดังนี้:
1.  **Microcontroller:** บอร์ด ESP32 (พร้อมสาย USB)
2.  **Sensors:** เซ็นเซอร์วัดความชื้นในดิน (Soil Moisture), เซ็นเซอร์อุณหภูมิและความชื้น (DHT22)
3.  **Actuators:** โมดูลรีเลย์ (Relay Module) สำหรับควบคุมปั๊มน้ำ
4.  **Connectivity:** สายจัมเปอร์ (Jumper Wires) และ Breadboard

---

## 📅 โครงสร้างการเรียนรู้ (Curriculum Overview)

### 1. [Session 1: ESP32 & MicroPython](../notebooks/iot_s1.ipynb)
- **เรียนรู้:** พื้นฐาน MicroPython และการควบคุม Digital I/O
- **Highlight:** โปรแกรมไฟกระพริบเพื่อทดสอบสถานะสมองกล

### 2. [Session 2: Sensor Integration](../notebooks/iot_s2.ipynb)
- **เรียนรู้:** การอ่านค่า Analog (ADC) และการสอบเทียบค่า (Calibration)
- **Highlight:** เปลี่ยนค่าไฟฟ้าให้เป็นค่าเปอร์เซ็นต์ความชื้นในดิน

### 3. [Session 3: Cloud & MQTT](../notebooks/iot_s3.ipynb)
- **เรียนรู้:** โปรโตคอล MQTT และการส่งข้อมูลเข้าสู่ Internet
- **Highlight:** ส่งข้อมูลฟาร์มขึ้น Dashboard ระดับโลก (Real-time Monitoring)

### 4. [Session 4: Edge AI Irrigation](../notebooks/iot_s4.ipynb)
- **เรียนรู้:** การเขียนโปรแกรมตัดสินใจ (Decision Logic) และระบบแจ้งเตือน LINE
- **Highlight:** **Final Project!** ระบบรดน้ำอัตโนมัติที่คำนึงถึงพยากรณ์อากาศ

---

## 🖥️ วิธีการรันและส่งโค้ด

1.  น้องๆ สามารถแก้ไขโค้ดผ่าน [Google Colab](../notebooks/iot_s1.ipynb) หรือโปรแกรม Thonny IDE
2.  คัดลอกโค้ดและส่งข้อมูลลงบอร์ด ESP32 ผ่านสาย USB
3.  ตรวจสอบผลลัพธ์ผ่าน Serial Monitor หรือทาง LINE ของน้องๆ เอง!

---
> [!IMPORTANT]
> **ความปลอดภัยมาก่อน:** ในการเชื่อมต่อวงจรไฟฟ้าที่มีแรงดันสูง (เช่น ปั๊มน้ำ) กรุณาให้พี่ๆ วิทยากรตรวจสอบความถูกต้องก่อนเสียบปลั๊กทุกครั้งครับ

---
*จัดทำโดย: ทีมวิศวกรซอฟต์แวร์ RBRU-Praneet Agri-Innovation 2026*
