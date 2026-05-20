## 2.4 การประดิษฐ์แอปพลิเคชันมือถือ Doctor AI App บน Kodular/App Inventor (Client-Server and Mobile Block Logic)

# 2.4 การประดิษฐ์แอปพลิเคชันมือถือ Doctor AI App บน Kodular/App Inventor (Client-Server and Mobile Block Logic)

---

## บทนำเชิงทฤษฎี: แนวคิดการประยุกต์ใช้ปัญญาประดิษฐ์ในการเกษตรปลายทาง (Agro-AI Deployment)

ในยุคของการเกษตรแม่นยำ (Precision Agriculture) การวินิจฉัยโรคพืชที่รวดเร็วและแม่นยำถือเป็นปัจจัยสำคัญในการเพิ่มผลผลิตและลดการสูญเสียทางการเกษตร การพัฒนาแอปพลิเคชันมือถือ (Mobile Application) ที่สามารถถ่ายภาพใบพืชและส่งข้อมูลภาพเหล่านั้นไปยังระบบประมวลผลปัญญาประดิษฐ์ (Artificial Intelligence) เพื่อทำการวินิจฉัยโรค (Disease Diagnosis) จึงเป็นแนวทางที่ทรงประสิทธิภาพสูงสุด

แอปพลิเคชันประเภทนี้ไม่ได้เป็นเพียงแค่เครื่องมือแสดงผล แต่เป็นระบบนิเวศ (Ecosystem) ที่ประกอบด้วยองค์ประกอบหลักสามส่วน ได้แก่ **ส่วนหน้า (Client)** ซึ่งคือแอปพลิเคชันที่ติดตั้งบนโทรศัพท์มือถือ, **ส่วนหลัง (Server)** ซึ่งคือระบบประมวลผลหลักที่ทำงานบนคลาวด์ (Cloud Computing), และ **การสื่อสาร (Communication Protocol)** ซึ่งทำหน้าที่เป็นสะพานเชื่อมข้อมูลระหว่างสองส่วนนี้

การทำความเข้าใจสถาปัตยกรรม (Architecture) ของระบบนี้จึงเป็นสิ่งจำเป็นอย่างยิ่งก่อนการลงมือปฏิบัติการพัฒนา

---

## 2.4.1 การออกแบบสถาปัตยกรรมของแอปพลิเคชันมือถือในการเกษตรปลายทาง (Agro-Mobile App Architecture)

สถาปัตยกรรมของระบบวินิจฉัยโรคพืชด้วย AI ที่ทำงานบนมือถือและคลาวด์ (Cloud-Based AI Diagnosis System) สามารถแบ่งออกเป็นชั้น (Layers) ต่าง ๆ ได้ดังนี้:

### 1. ชั้นส่วนหน้า (Client Layer: Mobile Device)
ส่วนนี้คือแอปพลิเคชันที่ผู้ใช้งานโต้ตอบด้วยโดยตรง (User Interface) หน้าที่หลักของ Client คือ:
*   **การรับข้อมูล (Data Acquisition):** การถ่ายภาพ (Image Capture) หรือการเลือกภาพจากแกลเลอรี่ (Gallery Selection)
*   **การเตรียมข้อมูล (Data Preprocessing):** การเข้ารหัสภาพดิจิทัล (Digital Image Encoding) ให้พร้อมสำหรับการส่งผ่านเครือข่าย (Network Transmission) ซึ่งโดยทั่วไปคือการแปลงเป็น Base64 String
*   **การส่งคำขอ (Request Sending):** การส่งข้อมูลภาพที่เข้ารหัสแล้วไปยัง API Endpoint ของ Server ผ่านโปรโตคอล HTTP (Hypertext Transfer Protocol)

### 2. ชั้นการสื่อสาร (Communication Layer: Internet/API)
ชั้นนี้ทำหน้าที่เป็นช่องทางขนส่งข้อมูล (Data Transport) ข้อมูลที่ส่งผ่านต้องเป็นไปตามมาตรฐานสากล:
*   **HTTP Protocol:** ใช้ในการกำหนดรูปแบบการร้องขอ (Request) และการตอบกลับ (Response)
*   **RESTful API (Representational State Transfer):** เป็นรูปแบบสถาปัตยกรรมที่กำหนดให้การสื่อสารเป็นแบบทรัพยากร (Resource-based) โดยใช้เมธอด (Method) ต่าง ๆ เช่น `POST` (สำหรับส่งข้อมูลใหม่), `GET` (สำหรับดึงข้อมูล)
*   **JSON (JavaScript Object Notation):** เป็นรูปแบบมาตรฐานในการจัดโครงสร้างข้อมูล (Data Structure) ที่ใช้ในการส่งและรับข้อมูลระหว่าง Client และ Server เนื่องจากมีน้ำหนักเบา (Lightweight) และอ่านง่าย

### 3. ชั้นส่วนหลัง (Server Layer: Cloud Computing)
ส่วนนี้คือสมองของระบบ (The Brain) ซึ่งประกอบด้วยโมเดลปัญญาประดิษฐ์ที่ได้รับการฝึกฝนมาอย่างดี (Trained AI Model) หน้าที่หลักของ Server คือ:
*   **การรับข้อมูล (Receiving Data):** รับ Base64 String ของภาพจาก Client ผ่าน HTTP `POST` Request
*   **การถอดรหัส (Decoding):** แปลง Base64 String กลับเป็นรูปแบบภาพดิจิทัล (เช่น JPEG หรือ PNG)
*   **การประมวลผล (Inference):** ป้อนภาพเข้าสู่โมเดล Machine Learning (เช่น Convolutional Neural Network, CNN) เพื่อทำการพยากรณ์ (Prediction)
*   **การสร้างผลลัพธ์ (Response Generation):** แปลงผลลัพธ์เชิงตัวเลข (Numerical Output) ของโมเดลให้เป็นรูปแบบ JSON ที่มีข้อมูลที่มนุษย์อ่านได้ (เช่น ชื่อโรค, ระดับความน่าจะเป็น)

---

## 2.4.2 แนวทางการพัฒนารูปแบบไร้โค้ด (No-code / Low-code Mobile App)

การพัฒนาแอปพลิเคชันในบริบทของการเกษตรปลายทางที่ต้องการความรวดเร็วในการทดสอบแนวคิด (Proof of Concept) และการปรับปรุงอย่างต่อเนื่อง (Iterative Improvement) การใช้แพลตฟอร์มแบบ Low-code เช่น Kodular หรือ MIT App Inventor ถือเป็นทางเลือกที่เหมาะสมอย่างยิ่ง

**ข้อดีของการใช้ Low-code Platform:**
1.  **ความรวดเร็วในการพัฒนา (Rapid Prototyping):** สามารถสร้างฟังก์ชันการทำงานที่ซับซ้อนได้โดยไม่ต้องเขียนโค้ดระดับล่าง (Low-level Code) ทั้งหมด
2.  **การเน้นตรรกะ (Logic Focus):** นักพัฒนาสามารถมุ่งเน้นไปที่การออกแบบตรรกะทางธุรกิจ (Business Logic) และการไหลของข้อมูล (Data Flow) แทนที่จะต้องกังวลกับไวยากรณ์ (Syntax) ของภาษาโปรแกรมมิ่ง
3.  **การเชื่อมต่อ API ที่ง่ายดาย:** แพลตฟอร์มเหล่านี้มีคอมโพเนนต์ (Component) ที่ออกแบบมาเพื่อการเชื่อมต่อเครือข่าย (เช่น Web Component) โดยเฉพาะ ทำให้การส่งข้อมูล HTTP POST เป็นเรื่องง่าย

---

## 2.4.3 กลไกการสื่อสารข้อมูล: Base64 Encoding และ HTTP POST Request

หัวใจของการส่งภาพจาก Client ไปยัง Server คือการแปลงข้อมูลไบนารี (Binary Data) ของภาพให้เป็นรูปแบบข้อความ (Text Format) ที่สามารถส่งผ่าน HTTP ได้อย่างปลอดภัยและมีประสิทธิภาพ นั่นคือ **Base64 Encoding**

### 1. หลักการของ Base64 Encoding
ภาพดิจิทัล (Image) คือชุดของค่าไบนารี (Binary values) ซึ่งประกอบด้วย 0 และ 1 การส่งไบนารีโดยตรงผ่าน JSON หรือ HTTP Body อาจเกิดปัญหาความไม่เข้ากันของข้อมูล (Data Incompatibility) ดังนั้น Base64 จึงถูกใช้เพื่อเข้ารหัสชุดไบนารีเหล่านี้ให้กลายเป็นชุดตัวอักษร ASCII (A-Z, a-z, 0-9, +, /)

**สูตรการเข้ารหัส (Conceptual Encoding):**
$$ \text{Base64 String} = \text{Encode}(\text{Binary Image Data}) $$

เมื่อ Client ได้รับ Base64 String แล้ว จะต้องนำไปบรรจุไว้ใน Payload ของ HTTP Request Body ในรูปแบบ JSON ดังนี้:

```json
{
    "image_data": "data:image/jpeg;base64,/9j/4AAQSkZJRgABAQEAYABgAAD/2wBDAAg..." ,
    "metadata": {
        "plant_type": "Mango",
        "symptom_observed": "Yellow spots"
    }
}
```

### 2. การส่งข้อมูลด้วย HTTP POST Request
การส่งข้อมูลภาพที่เข้ารหัสแล้วไปยัง Server จะต้องใช้เมธอด `POST` เสมอ เนื่องจากเป็นการส่งข้อมูลใหม่ (New Resource) ไปให้ Server ประมวลผล

**รายละเอียดทางเทคนิค:**
*   **URL:** `https://your-api-endpoint.com/diagnose`
*   **Method:** `POST`
*   **Headers:** `Content-Type: application/json`
*   **Body:** JSON Payload ที่มี Base64 String

---

## 2.4.4 การจำลองโค้ดส่วนหลัง (Server-Side Backend Simulation)

เพื่อให้เห็นภาพการทำงานของ Server ที่รับข้อมูล Base64 และทำการประมวลผล เราจะจำลองโค้ดส่วนหลังด้วยภาษา Python ซึ่งเป็นภาษาที่นิยมใช้ในการพัฒนา Machine Learning (ML) และ API Backend

**วัตถุประสงค์:** รับ JSON, ถอดรหัส Base64, บันทึกเป็นภาพ, และส่งผลลัพธ์ JSON กลับไป

```python
# Python Backend (Flask/Django Framework Simulation)
import base64
import io
from PIL import Image
import json

def diagnose_plant_image(json_payload: str) -> str:
    """
    ฟังก์ชันจำลองการรับข้อมูลภาพ Base64 และทำการวินิจฉัย
    :param json_payload: JSON string ที่ได้รับจาก Client
    :return: JSON string ของผลลัพธ์การวินิจฉัย
    """
    try:
        # 1. การแยก Base64 String
        data = json.loads(json_payload)
        base64_string = data.get("image_data", "")
        
        if not base64_string:
            return json.dumps({"status": "error", "message": "No image data provided."})

        # 2. การถอดรหัส Base64 และการสร้าง Image Object
        # Base64 String มักจะมี Prefix เช่น "data:image/jpeg;base64,"
        # ต้องทำการตัด Prefix ออกก่อน
        if "," in base64_string:
            base64_string = base64_string.split(",")[1]
            
        image_bytes = base64.b64decode(base64_string)
        image_stream = io.BytesIO(image_bytes)
        img = Image.open(image_stream)
        
        # 3. การประมวลผล (Inference Simulation)
        # ในความเป็นจริง ส่วนนี้คือการเรียกใช้โมเดล CNN (e.g., TensorFlow/PyTorch)
        # model_input = preprocess(img)
        # prediction = model.predict(model_input)
        
        # จำลองผลลัพธ์การวินิจฉัย
        prediction_result = {
            "diagnosis": "โรคราสนิม (Rust Disease)",
            "confidence_score": 0.92, # ค่าความน่าจะเป็น (Probability)
            "severity": "ปานกลาง (Moderate)",
            "recommendation": "ควรฉีดพ่นสารป้องกันเชื้อราทุก 7 วัน"
        }
        
        # 4. การสร้าง JSON Response
        response = {
            "status": "success",
            "diagnosis": prediction_result["diagnosis"],
            "confidence": prediction_result["confidence_score"],
            "severity": prediction_result["severity"],
            "message": "การวินิจฉัยสำเร็จแล้ว"
        }
        return json.dumps(response)

    except Exception as e:
        return json.dumps({"status": "error", "message": f"Server processing failed: {str(e)}"})

# ตัวอย่างการใช้งาน (Simulation Call)
# sample_payload = '{"image_data": "..."}' # ใส่ Base64 จริงที่นี่
# print(diagnose_plant_image(sample_payload))
```

---

## 2.4.5 การออกแบบผังการต่อบล็อกคำสั่งใน Kodular (Client-Side Block Logic)

ในส่วนนี้ เราจะอธิบายการทำงานของแอปพลิเคชัน Client โดยใช้แนวคิดการเขียนบล็อก (Block Programming) ของ Kodular/App Inventor ซึ่งเป็นกระบวนการที่ต้องอาศัยการจัดการเหตุการณ์ (Event Handling) และการจัดการข้อมูล (Data Handling) อย่างแม่นยำ

### องค์ประกอบหลัก (Components) ที่ต้องใช้:
1.  **Camera Component:** สำหรับการถ่ายภาพสด (Live Capture).
2.  **Image Picker Component:** สำหรับการเลือกภาพจากแกลเลอรี่ (Gallery Selection).
3.  **Web Component:** หัวใจของการสื่อสารเครือข่าย (Network Communication) ทำหน้าที่ส่ง HTTP Request.
4.  **Storage Component:** สำหรับการเก็บภาพชั่วคราว (Temporary Image Storage).

### 1. บล็อกคำสั่งการเปิดกล้องและการเลือกรูปภาพ (Image Acquisition Logic)

**วัตถุประสงค์:** ให้ผู้ใช้มีทางเลือกในการนำเข้าภาพ
**ตรรกะ (Logic Flow):**
*   เมื่อผู้ใช้คลิกปุ่ม "ถ่ายภาพ" $\rightarrow$ เรียกใช้ `Camera.TakePicture`
*   เมื่อผู้ใช้คลิกปุ่ม "เลือกจากแกลเลอรี่" $\rightarrow$ เรียกใช้ `ImagePicker.PickImage`

**การจัดการเหตุการณ์ (Event Handling):**
*   **เมื่อ `Camera.AfterPicture`:** หมายความว่าการถ่ายภาพเสร็จสมบูรณ์ ระบบจะได้รับภาพไบนารี (Binary Image) มาเก็บไว้ในตัวแปรภาพ (Image Variable)
*   **เมื่อ `ImagePicker.AfterPicking`:** หมายความว่าการเลือกภาพจากแกลเลอรี่เสร็จสมบูรณ์ ระบบจะได้รับภาพไบนารีมาเก็บไว้ในตัวแปรภาพ

### 2. บล็อกคำสั่งของ Web Component ในการแปลงภาพเป็น Base64 และโพสต์ส่งไปยัง API Endpoint (Encoding and Posting Logic)

นี่คือขั้นตอนที่ซับซ้อนที่สุด เพราะต้องมีการแปลงข้อมูลไบนารีเป็นข้อความก่อนส่ง

**ตรรกะ (Logic Flow):**
1.  **รับภาพ:** ดึงภาพไบนารีที่ได้จากขั้นตอนที่ 1
2.  **เข้ารหัส:** ใช้ฟังก์ชันเฉพาะของแพลตฟอร์ม (หรือใช้บล็อกที่จำลองการเข้ารหัส Base64) เพื่อแปลงภาพไบนารีให้เป็น Base64 String
3.  **สร้าง Payload:** สร้างโครงสร้าง JSON ที่มี Base64 String และ Metadata (เช่น ประเภทพืช)
4.  **ส่งคำขอ:** ใช้ `Web.PostText` เพื่อส่ง JSON Payload ไปยัง API Endpoint

**รายละเอียดการทำงานของบล็อก (Conceptual Block Layout):**

*   **Event:** เมื่อผู้ใช้คลิกปุ่ม "วิเคราะห์ภาพ"
*   **Action:**
    1.  `Set Web.URL to "https://your-api-endpoint.com/diagnose"`
    2.  `Set Web.RequestMethod to "POST"`
    3.  `Set Web.ContentType to "application/json"`
    4.  **การสร้าง JSON Payload:**
        *   `Set variable 'json_payload' to JSON String`
        *   `{`
        *   `"image_data": [Base64 String ของภาพที่ได้],`
        *   `"metadata": {`
        *   `"plant_type": [ค่าจาก Dropdown Menu],`
        *   `"symptom_observed": [ค่าจาก Text Input]`
        *   `}`
    5.  `Call Web.PostText(json_payload)`
 
### 3. บล็อกคำสั่งการรับผลลัพธ์ JSON ตอบกลับและแยกแยะระดับความน่าจะเป็น (Receiving and Parsing Response Logic)

หลังจากที่ส่งข้อมูลไปยังเซิร์ฟเวอร์แล้ว ตัวแอปพลิเคชันจะต้องรอสัญญาณตอบรับกลับจากเซิร์ฟเวอร์ เพื่อถอดรหัสรูปแบบข้อมูลและแสดงผลลัพธ์การคาดการณ์

**การจัดการเหตุการณ์ (Event Handling):**
*   **เมื่อ `Web.GotText`:** เหตุการณ์นี้จะถูกเปิดทำงานเมื่อเซิร์ฟเวอร์ตอบกลับรหัสสถานะความสำเร็จ (เช่น HTTP 200 OK) โดยจะให้ตัวแปรตอบกลับมา ได้แก่ `responseContent`
*   **การถอดรหัสข้อความ (JSON Parsing):**
    1.  ใช้บล็อก `JsonTextDecode` เพื่อแปลง `responseContent` ซึ่งเดิมเป็นข้อความ (JSON String) ให้เป็นโครงสร้างข้อมูลแบบพจนานุกรม (Dictionary/List of Pairs)
    2.  ใช้บล็อกดึงข้อมูลเฉพาะคอลัมน์ (Get Value for Key) เช่น:
        *   ดึงค่าชื่อโรคจากคีย์ `"diagnosis"`
        *   ดึงค่าความน่าเชื่อถือจากคีย์ `"confidence"`
        *   ดึงค่าคำแนะนำการรักษาจากคีย์ `"message"` หรือ `"recommendation"`
    3.  ปรับแต่งการแสดงผลเชิงภาพบนหน้าจอโทรศัพท์ (UI Control): เปลี่ยนสีพื้นหลังหน้าจอตามระดับความรุนแรงของโรค (เช่น สีเขียวเมื่อปกติ, สีเหลืองเมื่อเริ่มเฝ้าระวัง, และสีแดงเข้มเมื่อโรควิกฤต)

---

## 2.4.6 การวิเคราะห์เปรียบเทียบเชิงวิพากษ์: การแบ่งสีระดับส้มเด่นชัด (Traditional Thresholding) กับโครงข่ายประสาทเทียมลึก (CNN Deep Learning)

ในมิติของการตรวจจำโรคพืชจากภาพถ่ายใบ มีการแข่งขันระหว่างสองสถาปัตยกรรมทางคอมพิวเตอร์วิทัศน์หลัก ซึ่งมีข้อดีและข้อจำกัดเปรียบเทียบดังนี้:

| มิติการเปรียบเทียบ | การแบ่งเกณฑ์ระดับสีแบบดั้งเดิม (Traditional Color-based Thresholding) | การใช้โครงข่ายประสาทเทียมลึก (CNN Deep Learning) [2], [5] |
| :--- | :--- | :--- |
| **หลักการคำนวณ (Mathematical Principle)**| ใช้ค่าขอบเขตความเข้มสี (Color Threshold) ในปริภูมิสี HSV หรือ RGB ในการแบ่งแยกส่วนพิกเซลเสียของใบพืช | ใช้ตัวกรอง Convolutional Filters [5] ในการสกัดคุณลักษณะระดับสูง (High-level Features) โดยไม่ยึดติดกับสีเพียงอย่างเดียว |
| **การใช้ทรัพยากรเครื่อง (Resource Consumption)** | ต่ำมาก (ประมวลผลเสร็จในหลักมิลลิวินาที ไม่จำเป็นต้องมี GPU สามารถประมวลผลบนบอร์ดควบคุมขนาดเล็กได้) | สูง (ต้องการทรัพยากรการคำนวณมากในการฝึกฝนโมดูล และความเร็วการจำแนกต้องอาศัยชิปประมวลผลเร่งความเร็ว เช่น NPU หรือ Cloud [2]) |
| **ความอ่อนไหวต่อสิ่งแวดล้อม (Environmental Sensitivity)** | สูงมาก (เกิดความผิดพลาดสูงเมื่อสภาวะแสงภายนอกเปลี่ยนไป หรือมีดินและหญ้าสะท้อนรังสีในพื้นหลัง) | ต่ำ (มีความทนทานต่อสภาวะแสงแปรปรวน เงาเมฆ และมุมกล้องที่เอียง เนื่องจากมีคุณลักษณะ Invariance [5]) |
| **ขีดจำกัดความสามารถ (Functional Limit)** | แยกได้เพียงว่าจุดนั้นสีเปลี่ยนไปหรือไม่ แต่ไม่สามารถจำแนกโรคราสนิมกับโรคใบจุดสีเหลืองทั่วไปที่มีสีใกล้เคียงกันได้ | สามารถจำแนกความแตกต่างของโรคพืชที่มีลักษณะแผลใกล้เคียงกันได้อย่างแม่นยำสูงกว่า 90% [2] |
| **ปริมาณข้อมูลที่ต้องการ (Data Requirement)** | ไม่ต้องการข้อมูลสำหรับฝึกฝน (กำหนดขอบเขตด้วยมือมนุษย์เป็นอันจบ) | ต้องการชุดข้อมูลภาพถ่ายใบพืชที่ระบุลาเบล (Labeled Dataset) ปริมาณหลายพันถึงหมื่นภาพ [5] |

---

## 2.4.7 คำศัพท์สำคัญประจำบทเรียน (Key Terms)

1.  **Client-Server Architecture:** สถาปัตยกรรมเครือข่ายคอมพิวเตอร์ที่แบ่งหน้าที่ระหว่างผู้ขอรับบริการ (Client) และผู้ให้บริการประมวลผลแกนกลาง (Server).
2.  **Base64 Encoding:** กระบวนการเข้ารหัสข้อมูลไบนารีให้กลายเป็นสายอักขระอักษรโรมัน ASCII เพื่อความปลอดภัยและมีเสถียรภาพในการขนส่งบนเครือข่ายอินเทอร์เน็ต.
3.  **Convolutional Neural Network (CNN):** สถาปัตยกรรมโครงข่ายประสาทเทียมลึกที่เลียนแบบการรับภาพของสายตามนุษย์ เหมาะสำหรับการประมวลผลอาร์เรย์สองมิติเช่นภาพถ่าย [5].
4.  **No-Code/Low-Code Platform:** แพลตฟอร์มที่เปิดโอกาสให้นักพัฒนาสร้างซอฟต์แวร์ประยุกต์ผ่านการจัดเรียงอินเทอร์เฟซแบบกราฟิกหรือบล็อก แทนการพิมพ์ชุดคำสั่งแบบพิมพ์มือ.

---

## 2.4.8 แบบฝึกหัดทบทวนและโจทย์คิดวิเคราะห์ (Review Exercises)

**โจทย์ข้อที่ 1 (ระดับความเข้าใจ - Comprehension):**
ทำไมการพัฒนาแอปพลิเคชันปัญญาประดิษฐ์ตรวจวินิจฉัยโรคพืชในแปลงสวนทุเรียนจึงนิยมใช้สถาปัตยกรรมแบบ Client-Server (ประมวลผลโมเดลบนคลาวด์) มากกว่าสถาปัตยกรรมประมวลผลภาพบนโทรศัพท์มือถือโดยตรง (On-device Edge Inference) ในกรณีทั่วไป? จงอภิปรายโดยยกตัวอย่างขีดจำกัดเชิงฮาร์ดแวร์ประกอบ [2].

**โจทย์ข้อที่ 2 (ระดับการวิเคราะห์และการประเมินค่า - Analysis & Evaluation):**
สมมติว่าคุณกำลังสร้างบล็อกคำสั่งในแอปพลิเคชัน Kodular เพื่อตรวจจับความล้มเหลวในการส่งข้อมูลของ Web Component ไปยังโมเดลปัญญาประดิษฐ์ปลายทาง 
*   ก) จงระบุเหตุผลว่าทำไมคุณต้องใช้บล็อกทดสอบค่ารหัสตอบรับสถานะ (HTTP Response Code) และรหัสใดที่บ่งบอกว่าเกิดความล้มเหลวจากฝั่งระบบประมวลผลส่วนหลัง (Server-Side)?
*   ข) จงระบุแนวทางการเขียนบล็อกควบคุมตรรกะ (If-Else Logic) เพื่อจัดการกรณีสถานภาพเครือข่ายอินเทอร์เน็ตของมือถือในพื้นที่อําเภอเขาสมิง จ.ตราด เกิดขัดข้องระหว่างเก็บข้อมูลในแปลงจริง.

