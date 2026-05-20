// =================================================================
// Arduino C++ Code: Precision Irrigation Controller for Durian
// วัตถุประสงค์: คำนวณปริมาณน้ำที่ต้องการและควบคุมวาล์วจ่ายน้ำ
// =================================================================

// กำหนดขา (Pin Definition)
const int RELAY_VALVE_PIN = 7; // ขาที่ต่อกับรีเลย์วาล์วหลัก (Active Low)
const int SENSOR_MOISTURE_PIN = A0; // ขาสำหรับอ่านค่าความชื้นในดิน (Analog Input)

// ค่าคงที่ทางฟิสิกส์และเกษตรกรรม (Constants)
// ค่าเหล่านี้ควรถูกคำนวณจากเซนเซอร์สภาพอากาศภายนอก
const float ET_c_DAILY_MM = 7.8; // ETc ที่คำนวณได้ (mm/day)
const float CANOPY_AREA_SQM = 15.0; // พื้นที่เรือนยอด (m^2)
const float IRRIGATION_EFFICIENCY = 0.85; // ประสิทธิภาพระบบ (85%)

void setup() {
  // 1. การตั้งค่าเริ่มต้น (Initialization)
  Serial.begin(9600);
  
  // *** ความปลอดภัยสำคัญที่สุด: กำหนดสถานะเริ่มต้นของรีเลย์เป็น HIGH (ปิด) ***
  // เนื่องจากรีเลย์นี้เป็น Active Low, HIGH หมายถึงวงจรเปิด (Off)
  pinMode(RELAY_VALVE_PIN, OUTPUT);
  digitalWrite(RELAY_VALVE_PIN, HIGH); 
  Serial.println("--- ระบบชลประทานแม่นยำเริ่มต้นทำงาน ---");
  Serial.println("สถานะวาล์ว: ปิด (Safe Mode)");
}

void loop() {
  // 2. การอ่านค่าเซนเซอร์ (Data Acquisition)
  float soilMoisture = analogRead(SENSOR_MOISTURE_PIN);
  
  // 3. การคำนวณปริมาณน้ำที่ต้องการ (Calculation Logic)
  // V_water = (ETc * A_canopy * 1000) / Efficiency
  float requiredVolumeLiters = (ET_c_DAILY_MM * CANOPY_AREA_SQM * 1000.0) / IRRIGATION_EFFICIENCY;

  Serial.print("ปริมาณน้ำที่ต้องให้วันนี้: ");
  Serial.print(requiredVolumeLiters);
  Serial.println(" ลิตร");

  // 4. การตัดสินใจเปิด/ปิดวาล์ว (Decision Making)
  // สมมติว่าเราจะเปิดน้ำเมื่อความชื้นในดินต่ำกว่าเกณฑ์ (เช่น 400)
  if (soilMoisture > 400) { 
    Serial.println("สถานะ: ดินแห้ง! ต้องเปิดระบบชลประทาน.");
    
    // เปิดวาล์ว (Active Low: LOW = ON)
    digitalWrite(RELAY_VALVE_PIN, LOW); 
    delay(5000); // เปิดน้ำเป็นเวลา 5 วินาที
    
    // ปิดวาล์ว (Active Low: HIGH = OFF)
    digitalWrite(RELAY_VALVE_PIN, HIGH);
    Serial.println("สถานะ: ปิดระบบชลประทานแล้ว.");
  } else {
    Serial.println("สถานะ: ความชื้นในดินเหมาะสม ไม่ต้องรดน้ำ.");
  }

  delay(60000); // รอ 1 นาที ก่อนตรวจสอบรอบถัดไป
}
