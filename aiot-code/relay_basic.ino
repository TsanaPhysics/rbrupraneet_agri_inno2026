// #include <Arduino.h> // ต้องรวมไลบรารี Arduino
// กำหนดขา Digital Pin สำหรับควบคุมรีเลย์ (Relay Control Pin)
const int RELAY_PIN = 7; 
// กำหนดค่าเกณฑ์ความชื้นในดิน (Soil Moisture Threshold) ที่ต้องการให้ระบบทำงาน
const int DRY_THRESHOLD = 300; // ค่าความต้านทานที่สูง (ค่าความชื้นต่ำ)

void setup() {
  // 1. การตั้งค่าขา Digital Pin
  pinMode(RELAY_PIN, OUTPUT);
  
  // 2. การกำหนดสถานะเริ่มต้น (Initialization Safety Practice)
  // เนื่องจากเป็น Active Low Relay: 
  // HIGH = ปล่อยให้รีเลย์อยู่ในสถานะ "ปิด" (OFF) อย่างปลอดภัย
  digitalWrite(RELAY_PIN, HIGH); 
  Serial.begin(9600); // เริ่มต้นการสื่อสาร Serial Monitor ที่ 9600 bps
  Serial.println("--- Smart Irrigation System Initialized ---");
}

void loop() {
  // 1. การอ่านค่าจากเซนเซอร์ความชื้นในดิน (Soil Moisture Sensor)
  // สมมติว่าค่าที่อ่านได้คือค่าความต้านทาน (Resistance Value)
  int moistureValue = analogRead(A0); 
  
  Serial.print("Current Moisture Value (Resistance): ");
  Serial.println(moistureValue);

  // 2. การตัดสินใจควบคุม (Control Logic)
  // ตรวจสอบว่าค่าความชื้นสูงกว่าเกณฑ์ที่กำหนดหรือไม่ (หมายถึงดินแห้งเกินไป)
  if (moistureValue > DRY_THRESHOLD) {
    // เงื่อนไข: ดินแห้งเกินไป (ต้องรดน้ำ)
    Serial.println("!!! Soil is too dry. Activating Irrigation System.");
    
    // 3. การสั่งงานรีเลย์ (Active Low Logic)
    // ส่งสัญญาณ LOW เพื่อ "เปิด" รีเลย์ (ปั๊มน้ำทำงาน)
    digitalWrite(RELAY_PIN, LOW); 
    delay(5000); // ปล่อยให้ปั๊มทำงานเป็นเวลา 5 วินาที (5 s)
    
    // 4. การหยุดทำงาน (Safety Shutdown)
    // ส่งสัญญาณ HIGH เพื่อ "ปิด" รีเลย์ (ปั๊มน้ำหยุดทำงาน)
    digitalWrite(RELAY_PIN, HIGH); 
    Serial.println("Irrigation finished. System is now OFF.");
  } else {
    // เงื่อนไข: ความชื้นอยู่ในระดับที่เหมาะสม
    Serial.println("Soil moisture is adequate. System remains OFF.");
  }
  
  // หน่วงเวลาการตรวจสอบรอบถัดไป (Sampling Interval)
  delay(60000); // รอ 60 วินาที ก่อนตรวจสอบรอบใหม่
}
