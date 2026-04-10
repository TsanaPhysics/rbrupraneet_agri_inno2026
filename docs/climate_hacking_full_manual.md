# 📘 คู่มือหลักสูตรเบื้องต้น: Climate Data Hacking with Python
### โครงการ RBRU-Praneet Digital Agri-Innovation Center

ยินดีต้อนรับสู่คู่มือการเรียนรู้ฉบับสมบูรณ์สำหรับการจัดการข้อมูลภูมิอากาศด้วยภาษา Python เพื่อยกระดับเกษตรกรรมในจังหวัดจันทบุรี

---

## 🛠️ การเตรียมตัวก่อนเริ่ม (Prerequisites)

เพื่อให้การเรียนรู้เป็นไปอย่างราบรื่น น้องๆ และคุณครูควรเตรียมสิ่งต่างๆ ดังนี้:
1.  **Google Account:** สำหรับใช้งาน Google Colab
2.  **Dataset:** ดาวน์โหลดไฟล์ [chanthaburi_climate_sample.csv](../data/chanthaburi_climate_sample.csv)
3.  **Basic Curiosity:** ความสงสัยใคร่รู้ในการแก้ปัญหาชุมชนด้วยเทคโนโลยี

---

## 📅 โครงสร้างการเรียนรู้ (Curriculum Overview)

กิจกรรมนี้แบ่งออกเป็น 4 เซสชันหลัก โดยใช้เวลาเรียนรวมประมาณ 12 ชั่วโมง

### 1. [Session 1: ปฐมบทนักโปรแกรมเมอร์เกษตร](../notebooks/session1_basics.ipynb)
- **เจาะลึก:** ตัวแปร (Variables), ประเภทข้อมูล และการคำนวณทางคณิตศาสตร์
- **Highlight:** สร้างสูตรคำนวณ **Heat Index** เพื่อพยากรณ์ความเสี่ยงต่อต้นทุเรียน

### 2. [Session 2: เชื่อมต่อฟาร์มเข้ากับโลกข้อมูล](../notebooks/session2_api.ipynb)
- **เจาะลึก:** รูปแบบข้อมูล JSON และการใช้งาน Library `requests`
- **Highlight:** จำลองการดึงข้อมูลสด (Real-time) จาก API กรมอุตุนิยมวิทยา

### 3. [Session 3: นักสืบข้อมูล (Data Detective)](../notebooks/session3_data.ipynb)
- **เจาะลึก:** การใช้งาน `Pandas` เพื่อวิเคราะห์ข้อมูลตาราง (Dataframes)
- **Highlight:** คืนเวลาให้อดีตด้วยการวิเคราะห์ข้อมูลฝนย้อนหลัง 10 ปีของเมืองจันท์

### 4. [Session 4: ระบบปรึกษาเกษตรอัจฉริยะ](../notebooks/session4_advisor.ipynb)
- **เจาะลึก:** การออกแบบ Logic ซับซ้อน และการแสดงผลด้วยกราฟ (Matplotlib)
- **Highlight:** **Final Project!** พัฒนา AI Advisor ที่ให้คำแนะนำตามพยากรณ์อากาศจริง

---

## 🖥️ วิธีการรันบน Google Colab

น้องๆ สามารถนำลิงก์จากหน้าเว็บไซต์หรือ GitHub ไปรันบน Cloud ได้ดังนี้:
1.  เปิดเว็บไซต์ [Google Colab](https://colab.research.google.com/)
2.  เลือกแท็บ **GitHub**
3.  วาง URL: `https://github.com/TsanaPhysics/rbrupraneet_agri_inno2026`
4.  เลือกไฟล์ `.ipynb` ที่ต้องการเรียนรู้

> [!TIP]
> **เคล็ดลับความสำเร็จ:** อย่ากลัวที่จะลองเปลี่ยนตัวเลขในโค้ด (Play with numbers!) ภาษา Python จะเก่งขึ้นได้จากการลองผิดลองถูกและการสังเกตผลลัพธ์ที่เปลี่ยนไปครับ

---
> [!IMPORTANT]
> **สำหรับคุณครูวิทยากร:** กรุณาตรวจสอบ API Keys ของนักเรียนก่อนเริ่ม Session 2 เพื่อให้แน่ใจว่าทุกคนสามารถเชื่อมต่อกับระบบคลาวด์ได้พร้อมกัน

---
*จัดทำโดย: ทีมวิศวกรซอฟต์แวร์ RBRU-Praneet Agri-Innovation 2026*
