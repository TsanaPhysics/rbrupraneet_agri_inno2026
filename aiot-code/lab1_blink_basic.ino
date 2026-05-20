// ========================================================================
// Lab 1: Blink Sketch - การกะพริบไฟพื้นฐาน
// วัตถุประสงค์: ทดสอบการเชื่อมต่อและการสื่อสารข้อมูล (Serial Communication)
// ========================================================================

// 1. การกำหนดค่าคงที่ (Define Constant)
// กำหนดให้ขา Digital Pin 2 เป็นขาสำหรับควบคุม LED
const int ledPin = 2; 

// ฟังก์ชัน setup() จะถูกเรียกใช้เพียงครั้งเดียวเมื่อบอร์ดเริ่มทำงาน (Initialization)
void setup() {
  // 2. การกำหนดโหมดขา (pinMode)
  // pinMode(pin, mode): บอกให้ ESP32 รู้ว่าขาใดจะใช้ทำอะไร
  // OUTPUT: หมายความว่าขา 2 นี้จะทำหน้าที่ "ส่ง" สัญญาณไฟฟ้าออกไป
  pinMode(ledPin, OUTPUT); 
  
  // (Optional) เริ่มต้นการสื่อสารผ่าน Serial Monitor เพื่อดูค่า Debug
  Serial.begin(115200); 
  Serial.println("--- System Initialized: Blink Test Ready ---");
}

// ฟังก์ชัน loop() จะถูกเรียกซ้ำๆ อย่างต่อเนื่องตลอดเวลาที่บอร์ดมีไฟเลี้ยง
void loop() {
  // 3. การเปิดสัญญาณ (digitalWrite)
  // digitalWrite(pin, value): ส่งสัญญาณไฟฟ้าไปที่ขา 2
  // HIGH: หมายถึงการจ่ายแรงดันไฟฟ้า (Voltage) 3.3 V (เปิดไฟ)
  digitalWrite(ledPin, HIGH); 
  Serial.println("LED ON (HIGH)");
  
  // 4. การหน่วงเวลา (delay)
  // delay(milliseconds): หยุดการทำงานชั่วคราวตามจำนวนมิลลิวินาทีที่กำหนด
  // 500 ms = 0.5 วินาที
  delay(500); 
  
  // 5. การปิดสัญญาณ (digitalWrite)
  // digitalWrite(pin, value): ส่งสัญญาณไฟฟ้าไปที่ขา 2 อีกครั้ง
  // LOW: หมายถึงการจ่ายแรงดันไฟฟ้า 0 V (ปิดไฟ)
  digitalWrite(ledPin, LOW); 
  Serial.println("LED OFF (LOW)");
  
  // 6. การหน่วงเวลา (delay)
  // หน่วงเวลาอีก 500 ms ก่อนจะวนกลับไปทำ loop ใหม่
  delay(500); 
}
