// #include <Arduino.h> // Library สำหรับฟังก์ชันพื้นฐานของ Arduino
// กำหนดขาควบคุมรีเลย์ปั๊มน้ำ (Relay Pin)
const int RELAY_PIN = 7; 
// กำหนดขาอ่านค่าความชื้น (Moisture Sensor Pin)
const int MOISTURE_PIN = A0; 

// ค่า Threshold (ขีดจำกัด) ความชื้นที่กำหนดให้ปั๊มทำงาน (ค่า Analog)
const int DRY_THRESHOLD = 300; // สมมติว่าค่า Analog < 300 คือแห้งเกินไป

void setup() {
  // 1. การตั้งค่าขา (Pin Initialization)
  // กำหนดขา RELAY_PIN เป็น OUTPUT
  pinMode(RELAY_PIN, OUTPUT); 
  // กำหนดขา MOISTURE_PIN เป็น INPUT
  pinMode(MOISTURE_PIN, INPUT); 

  // 2. การตั้งค่า Fail-safe (CRITICAL STEP)
  // **สำคัญมาก:** ต้องตั้งค่ารีเลย์ให้เป็นสถานะ "ปิด" (Fail-safe) ทันทีที่เริ่มทำงาน
  // เนื่องจากเป็น Active Low, สถานะ HIGH คือ "ปิด" (OFF)
  digitalWrite(RELAY_PIN, HIGH); 
  Serial.begin(9600); // เริ่มต้นการสื่อสาร Serial Monitor
  Serial.println("--- ระบบชลประทานแม่นยำเริ่มต้นทำงาน ---");
  Serial.println("สถานะเริ่มต้น: ปั๊มปิด (Fail-safe)");
}

void loop() {
  // 1. อ่านค่าความชื้นจากเซนเซอร์
  int moistureValue = analogRead(MOISTURE_PIN); 
  Serial.print("ค่าความชื้นที่อ่านได้: ");
  Serial.print(moistureValue);
  Serial.println(" (Analog)");

  // 2. การตัดสินใจเชิงตรรกะ (Decision Logic)
  // ตรวจสอบว่าค่าความชื้นต่ำกว่าเกณฑ์ที่กำหนดหรือไม่ (แห้งเกินไป)
  if (moistureValue < DRY_THRESHOLD) {
    // ถ้าแห้งเกินไป: สั่งเปิดปั๊ม
    // Active Low: ต้องส่งสัญญาณ LOW เพื่อให้รีเลย์ทำงาน (ON)
    digitalWrite(RELAY_PIN, LOW); 
    Serial.println(">>> สถานะ: ปั๊มเปิด (LOW) - ต้องให้น้ำ!");
  } else {
    // ถ้าความชื้นเพียงพอ: สั่งปิดปั๊ม
    // Active Low: ต้องส่งสัญญาณ HIGH เพื่อให้รีเลย์หยุดทำงาน (OFF)
    digitalWrite(RELAY_PIN, HIGH); 
    Serial.println(">>> สถานะ: ปั๊มปิด (HIGH) - ความชื้นเพียงพอ");
  }

  // หน่วงเวลาการทำงาน 5 วินาที ก่อนอ่านค่ารอบถัดไป
  delay(5000); 
}
