## 1.3 การดึงข้อมูลสภาพอากาศ TMD Open Data API และโครงสร้าง JSON

# 1.3 การดึงข้อมูลสภาพอากาศจาก TMD Open Data API และโครงสร้าง JSON

**(บทที่ 1.3: การบูรณาการข้อมูลสภาพอากาศแบบเรียลไทม์ด้วย Web API และการวิเคราะห์โครงสร้างข้อมูล JSON)**

---

## 1.3.1 แนวคิดพื้นฐานของคลังข้อมูลเปิด (Open Data Repository) และ Web API

ในยุคของการปฏิวัติอุตสาหกรรมครั้งที่สี่ (Industry 4.0) ข้อมูล (Data) ได้ถูกยกสถานะให้เป็นทรัพยากรที่มีมูลค่าสูงที่สุด (Most Valuable Resource) การเข้าถึงข้อมูลที่ถูกต้อง แม่นยำ และทันเวลาจึงเป็นปัจจัยสำคัญในการขับเคลื่อนระบบเกษตรอัจฉริยะ (Smart Agriculture) และการตัดสินใจทางวิศวกรรม (Engineering Decision-Making)

### 1.3.1.1 คลังข้อมูลเปิด (Open Data Repository)

**คลังข้อมูลเปิด (Open Data Repository)** คือ แหล่งรวบรวมข้อมูลที่ถูกเผยแพร่สู่สาธารณะโดยหน่วยงานภาครัฐหรือองค์กรขนาดใหญ่ โดยมีเงื่อนไขที่เปิดให้บุคคลทั่วไปสามารถเข้าถึง นำไปใช้ประโยชน์ และนำไปต่อยอดเชิงพาณิชย์ได้โดยไม่มีข้อจำกัดด้านลิขสิทธิ์ที่เข้มงวด (Non-restrictive Licensing)

ในบริบทของอุตุนิยมวิทยา (Meteorology) การที่กรมอุตุนิยมวิทยา (Thai Meteorological Department: TMD) เปิดเผยข้อมูลผ่านช่องทาง **Open Data** ถือเป็นการสร้างรากฐานที่สำคัญให้แก่นักวิจัยและผู้ประกอบการสามารถนำข้อมูลสภาพอากาศมาใช้ในการสร้างแบบจำลองทางฟิสิกส์ (Physical Modeling) เช่น การพยากรณ์ผลผลิตทางการเกษตร (Crop Yield Forecasting) หรือการบริหารจัดการทรัพยากรน้ำ (Water Resource Management)

### 1.3.1.2 สถาปัตยกรรม Web API (Web Application Programming Interface)

การเข้าถึงข้อมูลจากคลังข้อมูลขนาดใหญ่มักไม่ได้ทำโดยการดาวน์โหลดไฟล์ทั้งหมด (เช่น ไฟล์ CSV หรือ XML ขนาดใหญ่) แต่จะใช้กลไกที่เรียกว่า **Web API (Web Application Programming Interface)**

**Web API** คือ ชุดของกฎเกณฑ์ (Set of Rules) และโปรโตคอล (Protocol) ที่กำหนดวิธีการที่แอปพลิเคชันซอฟต์แวร์หนึ่งจะสามารถสื่อสารและแลกเปลี่ยนข้อมูลกับแอปพลิเคชันซอฟต์แวร์อื่นได้โดยไม่จำเป็นต้องทราบรายละเอียดการทำงานภายใน (Internal Mechanism) ของระบบต้นทาง

สำหรับ TMD Open Data API นั้น ทำหน้าที่เป็น **ตัวกลางในการแปลข้อมูล (Data Translator)** โดยผู้ใช้งาน (Client) จะส่งคำขอ (Request) ไปยัง API Endpoint และ API จะรับผิดชอบในการประมวลผลคำขอเหล่านั้น จากนั้นจึงส่งข้อมูลที่ต้องการกลับมาในรูปแบบมาตรฐาน (Standardized Format) ซึ่งโดยทั่วไปคือ **JSON (JavaScript Object Notation)**

---

## 1.3.2 กลไกการร้องขอข้อมูลผ่าน API (API Request Mechanism)

การสื่อสารระหว่างไคลเอนต์ (Client) และเซิร์ฟเวอร์ (Server) ผ่าน Web API อาศัยโปรโตคอล **HTTP (Hypertext Transfer Protocol)** เป็นหลัก

### 1.3.2.1 องค์ประกอบของการร้องขอ (Request Components)

การร้องขอข้อมูล API โดยทั่วไปประกอบด้วยองค์ประกอบสำคัญ 3 ส่วน:

1.  **API Endpoint URL:** คือที่อยู่เฉพาะเจาะจงที่ระบุว่าต้องการข้อมูลประเภทใด (เช่น ข้อมูลสภาพอากาศปัจจุบัน, ข้อมูลย้อนหลัง)
2.  **HTTP Method:** คือวิธีการที่ไคลเอนต์ต้องการใช้ในการกระทำกับทรัพยากร (Resource) นั้น ๆ
3.  **Parameters/Headers:** คือข้อมูลเพิ่มเติมที่จำเป็นในการระบุตัวตนและการกรองข้อมูล (เช่น API Key, สถานีตรวจวัด, วันที่)

### 1.3.2.2 การเปรียบเทียบ HTTP GET และ HTTP POST

การเลือกใช้ HTTP Method มีความสำคัญอย่างยิ่งต่อความสมบูรณ์ของข้อมูลและการทำงานของระบบ:

#### 1. HTTP GET Method
*   **วัตถุประสงค์:** ใช้สำหรับ **การเรียกดู (Retrieving)** ข้อมูลจากเซิร์ฟเวอร์เท่านั้น (Read-Only Operation)
*   **การส่งข้อมูล:** ข้อมูลที่จำเป็นทั้งหมดจะถูกแนบไปกับ URL ในรูปแบบของ Query Parameters (เช่น `?station_id=KhaoSaming&date=2024-05-15`)
*   **ข้อดี:** ง่ายต่อการทำ Caching และเหมาะสำหรับการดึงข้อมูลที่ไม่เปลี่ยนแปลงหรือข้อมูลสถานะปัจจุบัน
*   **การประยุกต์ใช้ใน TMD API:** เหมาะสมที่สุดสำหรับการดึงข้อมูลสภาพอากาศปัจจุบัน (Current Weather Data)

#### 2. HTTP POST Method
*   **วัตถุประสงค์:** ใช้สำหรับ **การส่งข้อมูล (Submitting)** หรือการสร้างทรัพยากรใหม่บนเซิร์ฟเวอร์ (Create Operation)
*   **การส่งข้อมูล:** ข้อมูลจะถูกส่งไปในส่วนของ Body ของคำขอ (Request Body) ซึ่งมีความปลอดภัยกว่าการส่งใน URL หากข้อมูลมีความยาวหรือเป็นข้อมูลที่ละเอียดอ่อน
*   **การประยุกต์ใช้:** มักใช้เมื่อผู้ใช้ต้องการส่งข้อมูลการพยากรณ์ที่ซับซ้อน หรือต้องการบันทึกข้อมูลใหม่เข้าสู่ระบบ

**สรุป:** สำหรับการดึงข้อมูลสภาพอากาศปัจจุบันจาก TMD Open Data API ซึ่งเป็นเพียงการ "อ่าน" ข้อมูล จึงควรใช้ **HTTP GET Method**

### 1.3.2.3 การใช้ API Key (Authentication)

API Key คือรหัสประจำตัวที่ออกให้กับผู้ใช้งานแต่ละราย ทำหน้าที่เป็นกลไกการพิสูจน์ตัวตน (Authentication) และการจำกัดอัตราการร้องขอ (Rate Limiting)

เมื่อมีการร้องขอข้อมูล API Key จะถูกส่งไปในส่วนของ Header หรือเป็น Query Parameter เพื่อให้เซิร์ฟเวอร์สามารถตรวจสอบได้ว่าผู้ร้องขอมีสิทธิ์ในการเข้าถึงข้อมูลหรือไม่ และเพื่อป้องกันการใช้งานเกินขีดจำกัดที่กำหนดไว้ (Quota Exceeded Error)

---

## 1.3.3 โครงสร้างข้อมูล JSON (JavaScript Object Notation)

เมื่อ API ประมวลผลคำขอสำเร็จ ข้อมูลที่ส่งกลับมาจะอยู่ในรูปแบบ **JSON (JavaScript Object Notation)** ซึ่งเป็นรูปแบบการแลกเปลี่ยนข้อมูล (Data Interchange Format) ที่ได้รับความนิยมสูงสุดในปัจจุบัน เนื่องจากมีโครงสร้างที่อ่านง่ายสำหรับมนุษย์ (Human-readable) และง่ายต่อการประมวลผลด้วยภาษาโปรแกรมส่วนใหญ่

### 1.3.3.1 โครงสร้างพื้นฐานของ JSON

JSON มีโครงสร้างหลักที่เรียบง่าย ประกอบด้วยคู่ของ **ชื่อ (Key)** และ **ค่า (Value)** (Key-Value Pair)

1.  **Object (วัตถุ):** คือการรวมกลุ่มของคู่ Key-Value ซึ่งถูกล้อมรอบด้วยวงเล็บปีกกา `{}`
    *   *ตัวอย่าง:* `{"temperature": 30.5, "humidity": 75}`
2.  **Array (อาเรย์):** คือรายการของค่าที่เรียงลำดับกัน ซึ่งถูกล้อมรอบด้วยวงเล็บเหลี่ยม `[]`
    *   *ตัวอย่าง:* `["2024-05-15", "2024-05-16", "2024-05-17"]`

### 1.3.3.2 การวิเคราะห์พารามิเตอร์สภาพอากาศใน JSON

ข้อมูลสภาพอากาศที่ได้จาก TMD API มักจะถูกจัดโครงสร้างเป็น Object ที่ซับซ้อน ซึ่งภายใน Object นั้นอาจมี Array ของข้อมูลย่อย (Nested Array)

พารามิเตอร์หลักที่มักถูกดึงมาประกอบด้วย:

| พารามิเตอร์ (Key) | คำอธิบายทางฟิสิกส์ | หน่วย SI (SI Unit) | ประเภทข้อมูล (Data Type) |
| :--- | :--- | :--- | :--- |
| `temperature` | อุณหภูมิอากาศ ณ เวลาที่วัด | เคลวิน (K) หรือ องศาเซลเซียส ($\text{°C}$) | Floating Point Number |
| `humidity` | ความชื้นสัมพัทธ์ของอากาศ | เปอร์เซ็นต์ (%) | Floating Point Number |
| `wind_speed` | ความเร็วลม | เมตรต่อวินาที ($\text{m/s}$) | Floating Point Number |
| `rainfall` | ปริมาณน้ำฝนสะสมในช่วงเวลาที่กำหนด | มิลลิเมตร ($\text{mm}$) | Floating Point Number |
| `timestamp` | เวลาที่บันทึกข้อมูล | ISO 8601 Format (String) | String |

### 1.3.3.3 กระบวนการแปลงค่า (JSON Parsing)

**JSON Parsing** คือกระบวนการที่โปรแกรมคอมพิวเตอร์อ่านข้อความ (String) ที่อยู่ในรูปแบบ JSON และแปลงโครงสร้างนั้นให้กลายเป็นโครงสร้างข้อมูลที่ภาษาโปรแกรมสามารถนำไปใช้งานทางคณิตศาสตร์หรือตรรกะได้ (เช่น การแปลง String เป็น Dictionary หรือ Object ใน Python)

ในทางปฏิบัติ การใช้ไลบรารีเฉพาะทาง (เช่น `json` ใน Python) จะช่วยให้เราสามารถจัดการกับความซับซ้อนของโครงสร้างข้อมูลได้อย่างมีประสิทธิภาพ

---

## 1.3.4 การประยุกต์ใช้เชิงปฏิบัติ: การดึงข้อมูลสภาพอากาศด้วย Python

ในส่วนนี้ เราจะสาธิตการเขียนโค้ด Python ที่มีความเสถียรสูง (Robust Code) เพื่อทำการร้องขอข้อมูลสภาพอากาศปัจจุบันของสถานีอุตุนิยมวิทยาเขาสมิง จังหวัดตราด โดยใช้ไลบรารีมาตรฐานของ Python คือ `urllib.request` สำหรับการสื่อสารเครือข่าย และ `json` สำหรับการจัดการโครงสร้างข้อมูล

**สมมติฐาน:**
1.  เราได้ทำการลงทะเบียนและได้รับ `API_KEY` จาก TMD Open Data Portal แล้ว
2.  เราทราบ Endpoint URL สำหรับข้อมูลสภาพอากาศปัจจุบัน

### 1.3.4.1 โค้ด Python สำหรับการดึงและวิเคราะห์ข้อมูล

```python
import urllib.request
import urllib.parse
import json
import datetime

# =============================================================================
# 1. การกำหนดค่าคงที่ (Configuration Parameters)
# =============================================================================

# *** คำเตือน: กรุณาแทนที่ด้วย API Key ของท่านเอง ***
API_KEY = "YOUR_TMD_API_KEY_HERE" 

# Endpoint URL สำหรับการดึงข้อมูลสภาพอากาศ (สมมติฐานตามโครงสร้าง API)
BASE_URL = "https://api.example.com/weather/current" 

# พารามิเตอร์ที่ต้องการ: สถานีเขาสมิง จังหวัดตราด
STATION_ID = "KhaoSaming" 

# =============================================================================
# 2. ฟังก์ชันหลักในการดึงข้อมูล (Core Data Retrieval Function)
# =============================================================================

def fetch_weather_data(api_key: str, station_id: str, base_url: str) -> dict or None:
    """
    ฟังก์ชันสำหรับร้องขอข้อมูลสภาพอากาศจาก TMD Open Data API
    
    Args:
        api_key (str): คีย์สำหรับยืนยันตัวตน (Authentication Key).
        station_id (str): รหัสสถานีตรวจวัด (Station Identifier).
        base_url (str): URL หลักของ API Endpoint.
        
    Returns:
        dict or None: Dictionary ที่มีข้อมูลสภาพอากาศที่ถูก Parse แล้ว หรือ None หากเกิดข้อผิดพลาด
    """
    print("="*70)
    print(f"[{datetime.datetime.now().strftime('%Y-%m-%d %H:%M:%S')}] เริ่มต้นกระบวนการร้องขอข้อมูลสภาพอากาศ...")
    
    # 2.1 การสร้าง Query Parameters
    # การใช้ urllib.parse.urlencode เพื่อเข้ารหัสพารามิเตอร์ให้ถูกต้องตามมาตรฐาน URL
    params = {
        "api_key": api_key,
        "station": station_id,
        "data_type": "current" # ระบุว่าต้องการข้อมูลปัจจุบัน
    }
    
    # การเข้ารหัสพารามิเตอร์เป็นรูปแบบ Query String (เช่น ?station=KhaoSaming&api_key=...)
    query_string = urllib.parse.urlencode(params)
    
    # 2.2 การประกอบ URL เต็มรูปแบบ
    full_url = f"{base_url}?{query_string}"
    print(f"-> URL ที่จะร้องขอ: {full_url}")
    
    try:
        # 2.3 การร้องขอข้อมูล (HTTP GET Request)
        # urllib.request.urlopen ทำหน้าที่ส่งคำขอ HTTP GET ไปยังเซิร์ฟเวอร์
        with urllib.request.urlopen(full_url) as response:
            # ตรวจสอบสถานะการตอบกลับ (HTTP Status Code)
            status_code = response.getcode()
            if status_code != 200:
                print(f"\n[ERROR] การร้องขอข้อมูลล้มเหลว! สถานะโค้ด: {status_code}")
                print("โปรดตรวจสอบ API Key หรือ Endpoint URL ว่าถูกต้องหรือไม่")
                return None
            
            # อ่านข้อมูลที่ได้รับกลับมาในรูปแบบไบต์ (bytes)
            data_bytes = response.read()
            
            # 2.4 การถอดรหัสและการแปลง JSON (Decoding and Parsing)
            # 1. ถอดรหัสจาก bytes เป็น string (UTF-8)
            json_string = data_bytes.decode('utf-8')
            
            # 2. แปลง JSON string ให้เป็น Python dictionary
            weather_data = json.loads(json_string)
            
            print("\n[SUCCESS] ดึงข้อมูลสภาพอากาศสำเร็จ!")
            return weather_data

    except urllib.error.URLError as e:
        # จัดการข้อผิดพลาดที่เกิดจากการเชื่อมต่อเครือข่าย (Network Error)
        print(f"\n[FATAL ERROR] เกิดข้อผิดพลาดในการเชื่อมต่อเครือข่าย: {e.reason}")
        return None
    except json.JSONDecodeError:
        # จัดการข้อผิดพลาดที่เกิดจากโครงสร้างข้อมูล JSON ไม่ถูกต้อง
        print("\n[ERROR] ข้อผิดพลาดในการถอดรหัส JSON: ข้อมูลที่ได้รับไม่เป็นไปตามรูปแบบ JSON มาตรฐาน")
        return None
    except Exception as e:
        # จัดการข้อผิดพลาดอื่น ๆ ที่ไม่คาดคิด
        print(f"\n[CRITICAL ERROR] เกิดข้อผิดพลาดที่ไม่ทราบสาเหตุ: {e}")
        return None

# =============================================================================
# 3. ฟังก์ชันการวิเคราะห์และแสดงผลข้อมูล (Data Analysis and Display)
# =============================================================================

def display_weather_report(data: dict):
    """
    ฟังก์ชันสำหรับวิเคราะห์และแสดงผลข้อมูลสภาพอากาศที่ได้รับมา
    
    Args:
        data (dict): Dictionary ที่มีข้อมูลสภาพอากาศ
    """
    if not data:
        print("\nไม่สามารถแสดงรายงานได้เนื่องจากข้อมูลไม่สมบูรณ์")
        return

    print("\n" + "="*70)
    print("✨ รายงานสภาพอากาศปัจจุบัน (Current Weather Report) ✨")
    print("="*70)
    
    # ดึงข้อมูลหลักจาก dictionary
    main = data.get("main", {})
    wind = data.get("wind", {})
    weather = data.get("weather", [{}])[0]
    
    print(f"📍 เมือง/พื้นที่: {data.get('name', 'ไม่ระบุ')}")
    print(f"🌤️ สภาพอากาศ: {weather.get('description', 'ไม่ระบุ')}")
    print(f"🌡️ อุณหภูมิ: {main.get('temp', 0) - 273.15:.2f} °C (อุณหภูมิความรู้สึก: {main.get('feels_like', 0) - 273.15:.2f} °C)")
    print(f"💧 ความชื้นสัมพัทธ์: {main.get('humidity', 0)}%")
    print(f"💨 ความเร็วลม: {wind.get('speed', 0)} m/s")
    print("="*70)

# ทดสอบการเรียกใช้
mock_data = {
    "name": "Chanthaburi",
    "main": {
        "temp": 305.15,      # 32 °C
        "feels_like": 308.15, # 35 °C
        "humidity": 75
    },
    "wind": {
        "speed": 3.6
    },
    "weather": [
        {"description": "ท้องฟ้าโปร่ง (Clear sky)"}
    ]
}

display_weather_report(mock_data)
```

