// =================================================================
// ระบบควบคุมการให้น้ำแม่นยำสำหรับทุเรียน (Precision Irrigation Control)
// ผู้สอน: ปัญญาประดิษฐ์ไอด้า [ชื่อสมมติ]
// อุปกรณ์: Arduino UNO, Soil Moisture Sensor (Analog), Relay Module (Active Low)
// =================================================================

// 1. การกำหนดขา (Pin Definitions)
const int sensorPin = A0;    // กำหนดขา Analog A0 สำหรับรับค่าจากเซ็นเซอร์ VWC
const int relayPin = 7;      // กำหนดขา Digital 7 สำหรับควบคุมรีเลย์ปั๊มน้ำ

// 2. การกำหนดค่าเกณฑ์ (Threshold Values)
// ค่า VWC ที่ต่ำกว่านี้ (เช่น 0.20 m^3/m^3) แสดงว่าดินแห้งเกินไป ต้องเปิดน้ำ
const float VWC_THRESHOLD = 0.20; 

// 3. ตัวแปรสำหรับเก็บค่า
float currentVWC = 0.0; // ตัวแปรสำหรับเก็บค่า VWC ที่อ่านได้ (หน่วย: m^3/m^3)

void setup() {
  // เริ่มต้นการสื่อสาร Serial Monitor เพื่อดูค่าที่อ่านได้
  Serial.begin(9600); 
  Serial.println("--- ระบบชลประทานแม่นยำเริ่มต้นทำงาน ---");

  // ตั้งค่าขา Relay: ต้องตั้งค่าเป็น HIGH เสมอเมื่อเริ่มต้น
  // เนื่องจากเราใช้ Active Low Relay: HIGH = ปิด (Safe State), LOW = เปิด (Action)
  pinMode(relayPin, OUTPUT);
  digitalWrite(relayPin, HIGH); 
  Serial.println("สถานะเริ่มต้น: ปั๊มน้ำปิด (Safe State)");
}

void loop() {
  // 1. การอ่านค่าเซ็นเซอร์ (Sensor Reading)
  // อ่านค่า Analog จากเซ็นเซอร์ (ค่าที่ได้จะแปรผันตามความชื้น)
  int sensorValue = analogRead(sensorPin); 
  
  // *** (สมมติฐาน: มีฟังก์ชันแปลงค่า Analog เป็น VWC จริง) ***
  // ในทางปฏิบัติ ต้องมีการสอบเทียบ (Calibration) เพื่อแปลง sensorValue เป็น VWC
  currentVWC = convertAnalogToVWC(sensorValue); 

  // 2. การตัดสินใจทางฟิสิกส์ (Decision Making based on Physics)
  Serial.print("VWC ปัจจุบัน: ");
  Serial.print(currentVWC, 3); // แสดงค่า VWC ทศนิยม 3 ตำแหน่ง
  Serial.println(" m^3/m^3");

  // ตรวจสอบว่า VWC ต่ำกว่าเกณฑ์ที่กำหนดหรือไม่
  if (currentVWC < VWC_THRESHOLD) {
    // ภาวะ: ดินแห้งเกินไป (Water Stress Detected)
    Serial.println(">>> [ALERT] VWC ต่ำกว่าเกณฑ์! ต้องเปิดปั๊มน้ำ!");
    
    // การควบคุม Active Low Relay: ส่ง LOW เพื่อให้รีเลย์ทำงาน (ปั๊มเปิด)
    digitalWrite(relayPin, LOW); 
    Serial.println("สถานะปั๊ม: เปิด (Irrigation ON)");
  } else {
    // ภาวะ: ความชื้นเหมาะสม (Optimal Moisture Level)
    Serial.println("สถานะปั๊ม: ปิด (Irrigation OFF)");
    
    // การควบคุม Active Low Relay: ส่ง HIGH เพื่อให้รีเลย์หยุดทำงาน (ปั๊มปิด)
    digitalWrite(relayPin, HIGH); 
  }

  // หน่วงเวลาการทำงาน 5 วินาที ก่อนการวัดรอบถัดไป
  delay(5000); 
}

// ฟังก์ชันจำลองการแปลงค่า (Placeholder Function)
// ในงานจริง ฟังก์ชันนี้ต้องใช้สมการทางฟิสิกส์ที่ซับซ้อนในการสอบเทียบ
float convertAnalogToVWC(int analogValue) {
  // สมมติว่าค่า Analog 0-1023 ถูกแปลงเป็น VWC 0.00 - 0.40
  // (ยิ่งค่า Analog สูง แปลว่าความชื้นสูง)
  return (float)analogValue / 1023.0 * 0.40; 
}
