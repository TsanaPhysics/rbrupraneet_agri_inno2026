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
