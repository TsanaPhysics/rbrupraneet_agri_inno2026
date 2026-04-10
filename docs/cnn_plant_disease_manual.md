# 🖼️ คู่มือหลักสูตรเบื้องต้น: Deep Dive Lab: CNN for Plant Disease
### โครงการ RBRU-Praneet Digital Agri-Innovation Center

ยินดีต้อนรับสู่หลักสูตรการสร้าง "ดวงตาอัจฉริยะ" เพื่อวิเคราะห์โรคพืชด้วยเทคนิคการเรียนรู้เชิงลึก (Deep Learning) สำหรับการเกษตรยุคใหม่

---

## 🛠️ การเตรียมตัว (Prerequisites)

1.  **Google Account:** เพื่อใช้งาน Google Colab เทรนโมเดลบน GPU
2.  **Dataset:** เตรียมภาพใบพืชที่ต้องการจำแนก (หรือใช้ Dataset ตัวอย่างที่เตรียมไว้ให้)
3.  **Basic Python:** ควรผ่าน Session 1 ของหมวด Climate มาก่อนเพื่อให้คุ้นเคยกับ Syntax

---

## 📅 โครงสร้างการเรียนรู้ (Curriculum Overview)

### 1. [Session 1: Computer Vision Basics](../notebooks/cnn_s1.ipynb)
- **เรียนรู้:** การอ่านพิกเซล, การแปลงสี (Grayscale), และ OpenCV
- **Highlight:** ฝึกประมวลผลใบไม้เพื่อหาพื้นที่โรคเบื้องต้น

### 2. [Session 2: Advanced Data Augmentation](../notebooks/cnn_s2.ipynb)
- **เรียนรู้:** เทคนิคการบิด หมุน ปรับแสง และการจัดสรรข้อมูล (Train/Val/Test Split)
- **Highlight:** สร้าง Synthetic Data เพื่อให้ AI ทนทานต่อสภาพแสงที่แตกต่างกันในสวนจริง

### 3. [Session 3: Transfer Learning Architecture](../notebooks/cnn_s3.ipynb)
- **เรียนรู้:** การใช้งานโมเดลสำเร็จรูป (MobileNet-V2 / ResNet) และการทำ Fine-tuning
- **Highlight:** ยืมพลังสมองกลระดับโลกมาช่วยจำแนกโรคทุเรียนเมืองจันท์

### 4. [Session 4: Edge Optimization & TFLite](../notebooks/cnn_s4.ipynb)
- **เรียนรู้:** การทำ Quantization และการส่งออกโมเดลสำหรับอุปกรณ์เคลื่อนที่
- **Highlight:** เปลี่ยนโมเดลขนาดใหญ่ให้กลายเป็นไฟล์จิ๋วที่พร้อมทำงานบนโดรนและสมาร์ทโฟน

---

## 🖥️ วิธีการรันบน Google Colab

1.  ไปที่ [Google Colab](https://colab.research.google.com/)
2.  เลือก **GitHub** -> วาง URL: `https://github.com/TsanaPhysics/rbrupraneet_agri_inno2026`
3.  **ข้อควรระวัง:** ในหมวด CNN ควรไปที่เมนู `Runtime` -> `Change runtime type` -> เลือก **GPU** เพื่อให้การเทรนรวดเร็วขึ้น

---
> [!IMPORTANT]
> **สำหรับนักเรียน:** การสร้าง AI ที่ดีเริ่มจากการเตรียมข้อมูลที่สะอาด (Clean Data) การคัดเลือกภาพใบพืชที่ชัดเจนจะช่วยให้โมเดลของเราแม่นยำขึ้นอย่างมาก

---
*จัดทำโดย: ทีมวิศวกรซอฟต์แวร์ RBRU-Praneet Agri-Innovation 2026*
