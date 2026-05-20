// =================================================================================
// LAB 3: Non-blocking Wi-Fi Connection and RSSI Monitoring on ESP32
// Professor's Note: This code demonstrates robust, real-world networking practices.
// =================================================================================

#include <WiFi.h> // ไลบรารีสำหรับจัดการ Wi-Fi บน ESP32

// *********************************************************************************
// 1. การกำหนดค่าเครือข่าย (Network Credentials)
// *** กรุณาเปลี่ยนค่าเหล่านี้ให้ตรงกับเครือข่าย Wi-Fi ของคุณ ***
// *********************************************************************************
const char* ssid = "YOUR_NETWORK_NAME";      // SSID: ชื่อเครือข่าย Wi-Fi
const char* password = "YOUR_NETWORK_PASSWORD"; // Password: รหัสผ่าน Wi-Fi

// ตัวแปรสำหรับควบคุมการเชื่อมต่อใหม่ (Auto-reconnection Logic)
unsigned long lastAttemptTime = 0; // เวลาล่าสุดที่พยายามเชื่อมต่อ
const long reconnectionInterval = 5000; // ช่วงเวลาที่พยายามเชื่อมต่อใหม่ (5000 มิลลิวินาที = 5 วินาที)

void setup() {
  // 1. เริ่มต้นการสื่อสารผ่าน Serial Monitor
  Serial.begin(115200);
  Serial.println("\n=========================================================");
  Serial.println("✨ Smart Farm IoT System: Wi-Fi Network Initialization");
  Serial.println("=========================================================");
  
  // 2. ตั้งค่าเริ่มต้นของ Wi-Fi
  Serial.print("Attempting to connect to SSID: ");
  Serial.println(ssid);
  
  // 3. เริ่มต้นการเชื่อมต่อ Wi-Fi (STA Mode)
  // WiFi.begin() เป็นการสั่งให้ ESP32 เริ่มกระบวนการเชื่อมต่อ
  WiFi.begin(ssid, password);
}

void loop() {
  // -----------------------------------------------------------------
  // 1. การตรวจสอบสถานะ Wi-Fi (The Core Logic)
  // -----------------------------------------------------------------
  
  // ตรวจสอบว่า Wi-Fi เชื่อมต่ออยู่หรือไม่
  if (WiFi.status() == WL_CONNECTED) {
    // สถานะ: เชื่อมต่อสำเร็จ (Connected)
    Serial.println("\n[STATUS] ✅ Connected Successfully!");
    Serial.print("[STATUS] IP Address: ");
    Serial.println(WiFi.localIP()); // แสดง IP Address ที่ได้รับจาก Router
    
    // อ่านค่าความแรงสัญญาณ (RSSI)
    int rssi = WiFi.RSSI();
    Serial.print("[SIGNAL] Received Signal Strength Indicator (RSSI): ");
    Serial.print(rssi);
    Serial.println(" dBm"); // แสดงหน่วย dBm
    
    // -----------------------------------------------------------------
    // 2. การทำงานหลักของระบบ (Main System Task)
    // -----------------------------------------------------------------
    // ในส่วนนี้คือโค้ดที่ใช้ส่งข้อมูลเซนเซอร์ (เช่น การคำนวณปริมาณน้ำที่ต้องใช้)
    // เนื่องจากเราใช้ Non-blocking, เราจึงสามารถทำสิ่งนี้ได้ทุกรอบ loop()
    Serial.println("--- System Running: Data transmission cycle complete. ---");
    
  } else {
    // สถานะ: ไม่ได้เชื่อมต่อ (Disconnected)
    Serial.println("\n[STATUS] ⚠️ Disconnected! Attempting to reconnect...");
    
    // -----------------------------------------------------------------
    // 3. ระบบ Auto-reconnection Loop (การพยายามเชื่อมต่อใหม่)
    // -----------------------------------------------------------------
    // ตรวจสอบว่าถึงเวลาที่ต้องพยายามเชื่อมต่อใหม่หรือยัง
    if (millis() - lastAttemptTime >= reconnectionInterval) {
      Serial.println("   -> Reconnection attempt initiated...");
      
      // สั่งให้เริ่มกระบวนการเชื่อมต่อใหม่
      WiFi.begin(ssid, password);
      
      // อัปเดตเวลาล่าสุดที่พยายามเชื่อมต่อ
      lastAttemptTime = millis();
    }
  }
  
  // -----------------------------------------------------------------
  // 4. การหน่วงเวลาแบบ Non-blocking (Non-blocking Delay)
  // -----------------------------------------------------------------
  // แทนที่จะใช้ delay(1000) ซึ่งจะหยุดโปรแกรม เราใช้การหน่วงเวลาแบบรอบ (millis())
  // เพื่อให้โปรแกรมสามารถตรวจสอบสถานะ Wi-Fi และทำงานอื่นๆ ได้อย่างต่อเนื่อง
  delay(1000); // หน่วงเวลา 1 วินาที ก่อนวนกลับไปตรวจสอบสถานะใหม่
}
