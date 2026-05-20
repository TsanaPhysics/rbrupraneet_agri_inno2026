## Lab 4: การจัดส่งข้อมูลระยะไกลด้วยโปรโตคอลระบบส่งข้อมูลน้ำหนักเบา (MQTT IoT Protocol)

# 💧 Lab 4: การจัดส่งข้อมูลระยะไกลด้วยโปรโตคอลระบบส่งข้อมูลน้ำหนักเบา (MQTT IoT Protocol)

**วิชา:** วิศวกรรมชลประทานแม่นยำและระบบเกษตรอัจฉริยะ (Precision Irrigation and Smart Agriculture Systems)
**ระดับ:** มัธยมศึกษาตอนต้น (STEM Focus)
**ผู้สอน:** ปัญญาประดิษฐ์ไอด้า [ชื่อสมมติ] (Elite Thai Professor)

---

## 📚 บทนำ: ทำไมเราต้องใช้ MQTT? (The Need for Lightweight Communication)

สวัสดีครับนักเรียนทุกคน! วันนี้เราจะมาเรียนรู้หัวข้อที่สำคัญมากในการสร้างระบบเกษตรอัจฉริยะ นั่นคือการส่งข้อมูลระยะไกล (Remote Data Transmission) ครับ

ในโลกของ IoT (Internet of Things หรือ อินเทอร์เน็ตของสรรพสิ่ง) ข้อมูลที่เราเก็บได้จากเซนเซอร์ต่างๆ เช่น ความชื้นดิน (Soil Moisture), อุณหภูมิ (Temperature), หรือค่า pH นั้น มีปริมาณมหาศาล และต้องถูกส่งผ่านเครือข่าย (Network) ไปยังที่ที่เหมาะสมอย่างรวดเร็วและประหยัดพลังงาน

ถ้าเราใช้โปรโตคอล (Protocol) การสื่อสารแบบเก่าๆ เช่น HTTP (Hypertext Transfer Protocol) ในการส่งข้อมูลเล็กๆ น้อยๆ อย่างเช่นค่าความชื้นดิน 52.4 % VWC (Volumetric Water Content) มันจะเหมือนกับการส่งจดหมายขบวนใหญ่ ทั้งๆ ที่เราต้องการแค่การส่งโน้ตสั้นๆ เท่านั้น ทำให้เกิดการใช้พลังงาน (Energy Consumption) และแบนด์วิดท์ (Bandwidth) ที่สูงเกินความจำเป็น

นี่คือที่มาของ **MQTT (Message Queuing Telemetry Transport)** ครับ!

**MQTT** คือโปรโตคอลการสื่อสารที่ถูกออกแบบมาโดยเฉพาะสำหรับอุปกรณ์ IoT ที่มีข้อจำกัดด้านพลังงานและแบนด์วิดท์ (Power and Bandwidth Constrained Devices) มันจึงเป็นโปรโตคอลที่ "เบา" (Lightweight) และมีประสิทธิภาพสูงมากในการส่งข้อมูลขนาดเล็กๆ ข้ามเครือข่ายที่หลากหลาย

---

## 🧠 ส่วนที่ 1: ทฤษฎีและสถาปัตยกรรมของ MQTT (MQTT Architecture Theory)

### 1.1 หลักการทำงานแบบเผยแพร่และสมัครรับข้อมูล (Publish/Subscribe Model)

หัวใจสำคัญที่ทำให้ MQTT แตกต่างจากโปรโตคอลอื่นๆ คือการใช้สถาปัตยกรรมแบบ **Publish/Subscribe (Pub/Sub)**

**คำถาม:** ถ้าเรามีเซนเซอร์ 10 ตัวที่วัดค่าความชื้นดิน และมีแอปพลิเคชัน 3 ตัวที่ต้องการข้อมูลนี้ (เช่น แดชบอร์ด, ระบบแจ้งเตือน, และ AI วิเคราะห์) ถ้าใช้แบบ Client-Server ทั่วไป ทุกครั้งที่เซนเซอร์วัดค่าได้ จะต้องส่งข้อมูลไปหาแอปพลิเคชันทั้ง 3 ตัวทีละตัว ซึ่งซับซ้อนและสิ้นเปลืองทรัพยากรมาก

**คำตอบด้วย MQTT:** เราไม่จำเป็นต้องรู้ว่าใครจะรับข้อมูลบ้าง!

1.  **ผู้เผยแพร่ (Publisher):** คืออุปกรณ์ที่สร้างและส่งข้อมูล (เช่น ESP32 ที่อ่านค่าความชื้นดิน)
2.  **ผู้สมัครรับสารข้อมูล (Subscriber):** คืออุปกรณ์ที่ต้องการรับข้อมูล (เช่น แดชบอร์ด หรือ Doctor AI App)
3.  **เครื่องบริการตัวกลาง (Broker):** คือศูนย์กลางการสื่อสาร (Central Hub) เปรียบเสมือน "ไปรษณีย์กลาง" ที่คอยรับข้อมูลจาก Publisher และส่งต่อข้อมูลไปยัง Subscriber ที่สนใจ

**ลอจิก:** Publisher จะไม่ส่งข้อมูลให้ใครโดยตรง แต่จะส่งข้อมูลไปที่ **"หัวข้อ" (Topic)** ที่กำหนดไว้เท่านั้น ส่วน Subscriber ก็จะบอก Broker ว่า "ฉันสนใจข้อมูลที่หัวข้อนี้"

**Broker** จะทำหน้าที่เป็นตัวกลางที่ชาญฉลาด: เมื่อมีข้อมูลมาถึงหัวข้อใดหัวข้อหนึ่ง Broker จะตรวจสอบว่ามีใครสมัครรับสาร (Subscribe) หัวข้อนั้นหรือไม่ ถ้ามี ก็จะส่งข้อมูลนั้นให้ทุกคนที่สนใจทันที!

### 1.2 บทบาทและหน้าที่ขององค์ประกอบหลัก

| องค์ประกอบ (Component) | บทบาท (Role) | หน้าที่หลัก (Function) | อุปมาอุปไมย (Analogy) |
| :--- | :--- | :--- | :--- |
| **Client** (เครื่องลูกข่าย) | อุปกรณ์ที่เชื่อมต่อกับ Broker | สามารถเป็นได้ทั้ง Publisher และ Subscriber | ผู้ส่งสาร/ผู้รับสารที่เชื่อมต่อกับศูนย์กลาง |
| **Publisher** (ผู้เผยแพร่) | Client ที่ส่งข้อมูล | ส่งข้อมูลไปยังหัวข้อ (Topic) ที่กำหนด | นักข่าวที่รายงานข่าวไปยังศูนย์กลาง |
| **Subscriber** (ผู้สมัครรับสาร) | Client ที่รับข้อมูล | ลงทะเบียนความสนใจในหัวข้อ (Topic) ที่ต้องการรับ | ผู้ชมที่ติดตามข่าวสารจากศูนย์กลาง |
| **Broker** (เครื่องบริการตัวกลาง) | Server กลาง | รับ, จัดเก็บ, และกระจายข้อมูลตามหัวข้อ | ไปรษณีย์กลางที่คัดแยกจดหมายตามชื่อหัวข้อ |
| **Topic** (หัวข้อ) | ป้ายกำกับข้อมูล | เป็นการจัดระเบียบข้อมูลให้เป็นลำดับชั้น (Hierarchical Structure) | ชื่อหมวดหมู่ของข่าวสาร (เช่น `farm/zone1/moisture`) |

### 1.3 การจัดแยกประเภทหัวข้อแบบลำดับชั้นย่อย (Topic Level Separator)

MQTT ใช้เครื่องหมาย **`/` (Slash)** เป็นตัวคั่น (Separator) ในการสร้าง Topic ให้เป็นโครงสร้างแบบลำดับชั้น (Hierarchy)

**ตัวอย่าง:**
*   `farm/zone1/moisture`
*   `farm/zone2/temperature`
*   `control/pump/status`

**ความสำคัญ:** การใช้โครงสร้างแบบลำดับชั้นทำให้เราสามารถจัดการข้อมูลได้อย่างละเอียดมาก เช่น ถ้าเราต้องการรับข้อมูลความชื้นของทุกโซนในฟาร์ม เราสามารถ Subscribe ที่หัวข้อ `farm/+/moisture` (โดยที่ `+` คือ Wildcard) ซึ่งมีประโยชน์อย่างยิ่งในการขยายระบบในอนาคต

---

## 🌐 ส่วนที่ 2: การจำลองโครงสร้างการลำเลียงข้อมูล (Mermaid Diagram)

เราจะจำลองการไหลของข้อมูลจากเซนเซอร์ (Publisher) ไปยังระบบควบคุม (Subscriber) และแอปพลิเคชัน (Subscriber)

```mermaid
graph TD
    A[ESP32 Sensor Node (Publisher)] -->|Publish Data: farm/zone1/moisture (52.4 % VWC)| B(MQTT Broker: broker.hivemq.com);
    B -->|Topic: farm/zone1/moisture| C[Dashboard Web App (Subscriber)];
    B -->|Topic: farm/zone1/moisture| D[Doctor AI App (Subscriber)];
    
    E[Control Panel (Client)] -->|Publish Command: control/pump/command (String "1")| B;
    B -->|Topic: control/pump/command| A;
    
    style A fill:#f9f,stroke:#333,stroke-width:2px
    style B fill:#ccf,stroke:#333,stroke-width:2px
    style C fill:#cfc,stroke:#333,stroke-width:2px
    style D fill:#cfc,stroke:#333,stroke-width:2px
    style E fill:#ffc,stroke:#333,stroke-width:2px
```

**คำอธิบายการไหลของข้อมูล:**
1.  **การวัดค่า (Publish):** ESP32 (Publisher) วัดค่าความชื้นดินได้ 52.4 % VWC และส่งข้อมูลนี้ไปยัง Broker ที่หัวข้อ `farm/zone1/moisture`
2.  **การกระจาย (Broker):** Broker รับข้อมูลนี้ และตรวจสอบว่ามีใคร Subscribe หัวข้อนี้หรือไม่
3.  **การรับข้อมูล (Subscribe):** ทั้ง Dashboard และ Doctor AI App (Subscribers) ได้ลงทะเบียนความสนใจในหัวข้อนี้ไว้ล่วงหน้า เมื่อ Broker ได้รับข้อมูล ก็จะส่งข้อมูล 52.4 % VWC ไปให้ทั้งสองแอปฯ ทันที
4.  **การควบคุม (Command):** เมื่อผู้ใช้ต้องการเปิดปั๊มน้ำ จะส่งคำสั่ง "1" ไปที่หัวข้อ `control/pump/command` Broker จะส่งคำสั่งนี้กลับมาให้ ESP32 (Subscriber) เพื่อให้ ESP32 ทำการเปิดรีเลย์

---

## 💻 ส่วนที่ 3: การปฏิบัติการ: การเขียนโค้ด ESP32 (Robust C++ Implementation)

เราจะใช้บอร์ด ESP32 ซึ่งเป็นไมโครคอนโทรลเลอร์ (Microcontroller) ที่มีประสิทธิภาพสูงในการเชื่อมต่อ Wi-Fi และทำหน้าที่เป็น Client ทั้ง Publisher และ Subscriber

**อุปกรณ์ที่ต้องใช้:**
1.  ESP32 Development Board
2.  Relay Module (Active Low)
3.  Breadboard และ Jumper Wires

**การเชื่อมต่อวงจร (Wiring Diagram):**
*   **Relay Signal Pin:** เชื่อมต่อกับ GPIO 12 ของ ESP32
*   **Relay Power:** ต่อแหล่งจ่ายไฟภายนอก (External Power Supply) เพื่อความปลอดภัย

### 3.1 โค้ด C++ สำหรับ ESP32 (Arduino IDE)

โค้ดนี้ถูกออกแบบให้มีความเสถียรสูง (Robust) โดยมีระบบกู้คืนการเชื่อมต่ออัตโนมัติ (Automatic Reconnect) และการจัดการคำสั่งควบคุมที่ปลอดภัย

```cpp
// -------------------------------------------------------------------
// [Header Files] การเรียกใช้ไลบรารีที่จำเป็น
// -------------------------------------------------------------------
#include <WiFi.h>         // ไลบรารีสำหรับจัดการการเชื่อมต่อ Wi-Fi
#include <PubSubClient.h> // ไลบรารีสำหรับจัดการโปรโตคอล MQTT

// -------------------------------------------------------------------
// [Constants] การกำหนดค่าคงที่ของระบบ
// -------------------------------------------------------------------
// ข้อมูล Wi-Fi สำหรับการเชื่อมต่อ
const char* ssid = "YOUR_WIFI_SSID";      // กรุณาเปลี่ยนเป็นชื่อ Wi-Fi ของคุณ
const char* password = "YOUR_WIFI_PASSWORD"; // กรุณาเปลี่ยนเป็นรหัสผ่าน Wi-Fi ของคุณ

// ข้อมูล MQTT Broker
const char* mqtt_server = "broker.hivemq.com"; // Broker สาธารณะที่เสถียร
const int mqtt_port = 1883;                   // พอร์ตมาตรฐานสำหรับ MQTT
const char* mqtt_client_id_prefix = "ESP32_Agri_"; // ส่วนนำหน้า Client ID
const int RELAY_PIN = 12;                     // กำหนดขา GPIO 12 สำหรับควบคุมรีเลย์
const int PUBLISH_INTERVAL = 10000;          // ช่วงเวลาในการ Publish ข้อมูล (10000 มิลลิวินาที = 10 วินาที)

// ตัวแปร Global สำหรับ MQTT และ Wi-Fi
WiFiClient espClient;
PubSubClient client(espClient);

// ตัวแปรสำหรับควบคุมเวลาการ Publish
long lastPublishTime = 0;

// -------------------------------------------------------------------
// [Function: Setup] ฟังก์ชันเริ่มต้นระบบ
// -------------------------------------------------------------------
void setup() {
  Serial.begin(115200);
  
  // 1. ตั้งค่าขา GPIO สำหรับรีเลย์
  // *** ความปลอดภัย: กำหนดสถานะเริ่มต้นเป็น HIGH เสมอ (Active Low) ***
  // หมายความว่า: HIGH = ปิด (Open Circuit), LOW = เปิด (Close Circuit)
  pinMode(RELAY_PIN, OUTPUT);
  digitalWrite(RELAY_PIN, HIGH); 
  Serial.println("--- ระบบเริ่มต้น: Relay ถูกตั้งค่าเป็นสถานะปิด (HIGH) ---");

  // 2. เชื่อมต่อ Wi-Fi
  Serial.print("Connecting to ");
  Serial.println(ssid);
  WiFi.begin(ssid, password);
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }
  Serial.println("\nWiFi connected successfully!");
  Serial.print("IP Address: ");
  Serial.println(WiFi.localIP());

  // 3. ตั้งค่า MQTT
  client.setServer(mqtt_server, mqtt_port);
  // 4. ลงทะเบียน Callback Function สำหรับการรับคำสั่ง
  client.setCallback(callback); 
}

// -------------------------------------------------------------------
// [Function: Callback] ฟังก์ชันที่ถูกเรียกเมื่อมีข้อความเข้ามา (Subscriber Logic)
// -------------------------------------------------------------------
void callback(char* topic, byte* payload, unsigned int length) {
  Serial.print("\n[MQTT Received] Topic: ");
  Serial.println(topic);
  
  // แปลง Payload (ข้อมูลที่ได้รับ) จาก Byte Array เป็น String
  String message;
  message = "";
  for (unsigned int i = 0; i < length; i++) {
    message += (char)payload[i];
  }
  Serial.print("Message: ");
  Serial.println(message);

  // ตรวจสอบหัวข้อและคำสั่งควบคุม
  if (String(topic) == "control/pump/command") {
    if (message == "1") {
      // คำสั่ง "1" = เปิดปั๊มน้ำ (Active Low: ต้องส่ง LOW เพื่อให้รีเลย์ทำงาน)
      digitalWrite(RELAY_PIN, LOW); 
      Serial.println(">>> [ACTION] 💧 เปิดปั๊มน้ำ: Relay Activated (LOW)");
    } else if (message == "0") {
      // คำสั่ง "0" = ปิดปั๊มน้ำ (Active Low: ต้องส่ง HIGH เพื่อให้รีเลย์หยุดทำงาน)
      digitalWrite(RELAY_PIN, HIGH); 
      Serial.println(">>> [ACTION] 💧 ปิดปั๊มน้ำ: Relay Deactivated (HIGH)");
    }
  }
}

// -------------------------------------------------------------------
// [Function: Reconnect] ฟังก์ชันจัดการการเชื่อมต่อ MQTT
// -------------------------------------------------------------------
void reconnect() {
  // สร้าง Client ID แบบสุ่มเพื่อป้องกันการชนกัน (Collision)
  String randomId = String(random(1000, 9999));
  String clientID = String(mqtt_client_id_prefix) + randomId;
  
  Serial.print("Attempting to connect to MQTT Broker as Client ID: ");
  Serial.println(clientID);

  // Loop เพื่อพยายามเชื่อมต่อจนกว่าจะสำเร็จ
  while (!client.connected()) {
    if (client.connect(clientID)) {
      Serial.println("MQTT Connected successfully!");
      
      // 1. การสมัครรับสาร (Subscription): บอก Broker ว่าเราสนใจหัวข้อใด
      client.subscribe("control/pump/command");
      Serial.println("Subscribed to topic: control/pump/command");
    } else {
      Serial.print("Failed to connect, rc=");
      Serial.print(client.state());
      Serial.println(" try again in 5 seconds");
      delay(5000); // รอ 5 วินาทีก่อนลองใหม่
    }
  }
}

// -------------------------------------------------------------------
// [Function: Loop] ลูปหลักของโปรแกรม
// -------------------------------------------------------------------
void loop() {
  // 1. รักษาการเชื่อมต่อ MQTT (ต้องเรียกใช้เสมอ)
  if (!client.connected()) {
    reconnect();
  }
  client.loop(); // ต้องเรียกใช้เพื่อตรวจสอบข้อความขาเข้าและรักษาการเชื่อมต่อ

  // 2. ตรวจสอบเวลาเพื่อการ Publish ข้อมูล
  if (millis() - lastPublishTime > PUBLISH_INTERVAL) {
    // 2.1 จำลองการอ่านค่าเซนเซอร์ (Simulated Sensor Reading)
    // ค่าความชื้นดินจำลอง: 52.4 % VWC
    float simulated_vwc = 52.4; 
    
    // 2.2 สร้าง Payload (ข้อมูลที่จะส่ง)
    String payload = "VWC=" + String(simulated_vwc) + "%";
    
    // 2.3 กำหนด Topic และ Publish
    const char* topic = "farm/zone1/moisture";
    if (client.publish(topic, payload.c_str())) {
      Serial.print("[MQTT Publish] Topic: ");
      Serial.print(topic);
      Serial.print(" | Payload: ");
      Serial.println(payload);
      lastPublishTime = millis(); // อัปเดตเวลา
    } else {
      Serial.println("!!! Failed to publish message. Check connection.");
    }
  }
  
  // หน่วงเวลาเล็กน้อยเพื่อไม่ให้ CPU ทำงานหนักเกินไป
  delay(100); 
}
```

### 3.2 คำอธิบายเชิงลึกของโค้ด (Code Physics and Logic Explanation)

1.  **การจัดการพลังงานและเวลา (Time Management):**
    *   เราใช้ตัวแปร `lastPublishTime` และ `PUBLISH_INTERVAL` เพื่อให้มั่นใจว่าการส่งข้อมูล (Publish) จะเกิดขึ้นทุกๆ 10 วินาที (10,000 มิลลิวินาที) เท่านั้น การทำเช่นนี้ช่วยประหยัดพลังงานของแบตเตอรี่ (Energy Efficiency) และลดภาระของเครือข่าย (Network Load)
2.  **การเชื่อมต่อที่ทนทาน (Robust Connection):**
    *   ฟังก์ชัน `reconnect()` ถูกออกแบบมาให้เป็น **Automatic MQTT Reconnect loop** หากการเชื่อมต่อกับ Broker หลุด (เช่น Wi-Fi หลุด หรือ Broker ล่ม) ระบบจะเข้าสู่ลูป `while (!client.connected())` และพยายามเชื่อมต่อใหม่ทุกๆ 5 วินาทีโดยอัตโนมัติ
3.  **ความปลอดภัยของ Client ID:**
    *   การใช้ `random(1000, 9999)` ในการสร้าง Client ID ทำให้มั่นใจได้ว่าอุปกรณ์หลายตัวที่ใช้โค้ดเดียวกันจะไม่ส่งข้อมูลไปชนกัน (Collision) ที่ Broker
4.  **การควบคุมรีเลย์ (Active Low Logic):**
    *   **หลักการ:** รีเลย์ส่วนใหญ่เป็นแบบ Active Low หมายความว่า การส่งสัญญาณ **LOW** (0 V) ไปที่ขาควบคุม จะทำให้รีเลย์ **ทำงาน (ON)** และการส่งสัญญาณ **HIGH** (3.3 V หรือ 5 V) จะทำให้รีเลย์ **หยุดทำงาน (OFF)**
    *   **การป้องกัน:** ในฟังก์ชัน `setup()` เราตั้งค่าเริ่มต้นเป็น `digitalWrite(RELAY_PIN, HIGH)` เสมอ เพื่อให้มั่นใจว่าเมื่อระบบเริ่มต้นทำงาน ปั๊มน้ำจะอยู่ในสถานะ **ปิด** อย่างปลอดภัย
    *   **การทำงาน:** เมื่อได้รับคำสั่ง "1" (เปิด) เราจึงสั่ง `digitalWrite(RELAY_PIN, LOW)`

---

## 📝 ส่วนที่ 4: แบบฝึกหัดท้ายปฏิบัติการ 4 (Lab 4 Exercises)

**คำชี้แจง:** ให้นักเรียนตอบคำถามต่อไปนี้เพื่อทบทวนความรู้เรื่อง MQTT และ IoT

**คำถามข้อที่ 1 (Conceptual):**
จงอธิบายความแตกต่างที่สำคัญที่สุดระหว่างสถาปัตยกรรมแบบ Client-Server ทั่วไป กับสถาปัตยกรรมแบบ Publish/Subscribe ในบริบทของการส่งข้อมูลความชื้นดินจากเซนเซอร์ไปยังแอปพลิเคชันหลายตัว

**คำถามข้อที่ 2 (Technical):**
ในโค้ดที่กำหนดให้ หากเราต้องการให้ระบบส่งข้อมูลความชื้นดินทุกๆ 5 วินาที เราจะต้องแก้ไขค่าคงที่ (Constant) ใด และแก้ไขเป็นค่าเท่าใด?

**คำถามข้อที่ 3 (Application & Safety):**
เมื่อเราได้รับคำสั่งควบคุมที่หัวข้อ `control/pump/command` และ Payload คือ String `"1"` ซึ่งหมายถึงการเปิดปั๊มน้ำ (Active Low) จงเขียนคำสั่ง `digitalWrite()` ที่ถูกต้องเพื่อสั่งเปิดรีเลย์ (สมมติว่า `RELAY_PIN` คือ 12) พร้อมอธิบายเหตุผลทางไฟฟ้าสั้นๆ

**คำถามข้อที่ 4 (Advanced Topic):**
ถ้าเราต้องการให้ ESP32 ของเราสามารถรับข้อมูลความชื้นดินจากโซนที่ 2 และโซนที่ 3 ได้ด้วย โดยไม่ต้องเขียนโค้ดใหม่ เราควรใช้ Topic Pattern (รูปแบบหัวข้อ) ใดในการ Subscribe เพื่อให้ครอบคลุมทั้งสองโซน?

***

### 🔑 เฉลยแบบฝึกหัด (Answer Key)

**คำตอบข้อที่ 1:**
*   **Client-Server:** ผู้ส่งข้อมูล (Client) ต้องรู้ที่อยู่ (Address) ของผู้รับข้อมูล (Server) และต้องส่งข้อมูลไปหาผู้รับทีละราย (One-to-One Communication)
*   **Publish/Subscribe:** ผู้ส่งข้อมูล (Publisher) ไม่จำเป็นต้องรู้ว่าใครคือผู้รับข้อมูล (Subscriber) เพียงแค่ส่งข้อมูลไปยัง **Topic** กลางเท่านั้น และ Broker จะทำหน้าที่กระจายข้อมูลไปยังผู้รับทุกคนที่สนใจ Topic นั้นๆ (One-to-Many Communication)

**คำตอบข้อที่ 2:**
*   ต้องแก้ไขค่าคงที่ `PUBLISH_INTERVAL`
*   แก้ไขเป็น: `const int PUBLISH_INTERVAL = 5000;` (5000 มิลลิวินาที = 5 วินาที)

**คำตอบข้อที่ 3:**
*   **คำสั่ง:** `digitalWrite(RELAY_PIN, LOW);`
*   **เหตุผล:** เนื่องจากรีเลย์ที่ใช้เป็นแบบ Active Low การส่งสัญญาณไฟฟ้า **LOW** (ใกล้ 0 V) ไปยังขาควบคุม จะทำให้วงจรภายในของรีเลย์ทำงานและทำให้ปั๊มน้ำเปิด (ON)

**คำตอบข้อที่ 4:**
*   ควรใช้ Topic Pattern: `farm/+/moisture`
*   **คำอธิบาย:** เครื่องหมาย `+` (Wildcard) หมายถึงการจับคู่กับค่าใดก็ได้ที่อยู่ตรงตำแหน่งนั้นๆ ทำให้ระบบสามารถรับข้อมูลความชื้นจากโซนใดๆ ก็ได้ (เช่น `farm/zone2/moisture` หรือ `farm/zone3/moisture`) โดยที่โค้ดไม่จำเป็นต้องแก้ไข

---
**[จบการบรรยาย]**
ขอให้ทุกคนสนุกกับการเรียนรู้และนำความรู้เรื่อง MQTT นี้ไปสร้างสรรค์ระบบเกษตรอัจฉริยะที่ยั่งยืนต่อไปนะครับ!
