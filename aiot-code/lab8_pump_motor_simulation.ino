// #include <Arduino.h> // ต้องรวมไลบรารี Arduino
// กำหนดขา Digital Input/Output (สมมติว่าใช้ขาเหล่านี้)

// --- INPUTS (สัญญาณรับเข้า) ---
const int PIN_START_BUTTON = 2;    // ขาสำหรับปุ่ม Start (NO)
const int PIN_EMERGENCY_BUTTON = 3; // ขาสำหรับปุ่ม Emergency (NC)
const int PIN_OVERLOAD_STATUS = 4;  // ขาสำหรับสถานะ Overload (LOW = OK, HIGH = Trip)

// --- OUTPUTS (สัญญาณจ่ายออก) ---
const int PIN_KM1_COIL = 5;        // ขาควบคุมขดลวดแมกเนติกคอนแทกเตอร์ KM1 (Active Low)

// ตัวแปรสถานะ (State Variables)
bool isRunning = false; // สถานะการทำงานของปั๊ม

void setup() {
  // 1. กำหนดโหมดขา (Pin Mode Setup)
  pinMode(PIN_START_BUTTON, INPUT_PULLUP); // ใช้ Internal Pull-up สำหรับปุ่มกด
  pinMode(PIN_EMERGENCY_BUTTON, INPUT_PULLUP);
  pinMode(PIN_OVERLOAD_STATUS, INPUT_PULLUP);
  pinMode(PIN_KM1_COIL, OUTPUT);

  // 2. การตั้งค่าความปลอดภัยเริ่มต้น (Safety Initialization)
  // กำหนดให้ Output ทั้งหมดเป็น HIGH เสมอ (Active Low Logic)
  // หมายความว่า: เมื่อเริ่มระบบ KM1 จะถูกตัดไฟ (OFF) ทันที
  digitalWrite(PIN_KM1_COIL, HIGH); 
  Serial.begin(9600);
  Serial.println("System Initialized: KM1 is OFF (Safe State).");
}

void loop() {
  // 1. อ่านค่าสถานะอินพุต (Read Inputs)
  int startState = digitalRead(PIN_START_BUTTON);
  int emergencyState = digitalRead(PIN_EMERGENCY_BUTTON);
  int overloadState = digitalRead(PIN_OVERLOAD_STATUS);

  // 2. ตรวจสอบเงื่อนไขความปลอดภัย (Safety Check)
  // เงื่อนไขที่ 1: Overload ต้องไม่ Trip (Overload State ต้องเป็น LOW)
  // เงื่อนไขที่ 2: Emergency ต้องไม่ Trip (Emergency State ต้องเป็น LOW)
  // เงื่อนไขที่ 3: ต้องมีการกด Start (Start Button ต้องเป็น LOW เพราะใช้ PULLUP)
  
  bool canRun = (overloadState == LOW) && (emergencyState == LOW) && (startState == LOW);

  // 3. การตัดสินใจควบคุม (Control Logic)
  if (canRun && !isRunning) {
    // ถ้าทุกอย่างพร้อม และปั๊มยังไม่ทำงาน
    // 1. เปิดขดลวด KM1 (Active Low: ต้องส่ง LOW)
    digitalWrite(PIN_KM1_COIL, LOW); 
    isRunning = true;
    Serial.println("--- Pump Started! KM1 Activated. ---");
  } 
  else if (startState == HIGH && isRunning) {
    // ถ้าผู้ใช้ปล่อยปุ่ม Start (Start State กลับไป HIGH)
    // ระบบจะเข้าสู่ Self-Holding Logic (ใน PLC จริง หน้าสัมผัสช่วยจะทำงานแทน)
    // แต่ในโค้ดนี้ เราจะจำลองการหยุดเมื่อมีการกดปุ่ม Stop (สมมติว่ามีปุ่ม Stop แยก)
    // *ในทางปฏิบัติ: ต้องมีปุ่ม Stop แยกเพื่อตัดวงจร*
  }
  else if (overloadState == HIGH || emergencyState == HIGH) {
    // ถ้าเกิด Overload หรือ Emergency Trip
    // 1. ปิดขดลวด KM1 (Active Low: ส่ง HIGH)
    digitalWrite(PIN_KM1_COIL, HIGH); 
    isRunning = false;
    Serial.println("!!! System Trip Detected! KM1 Deactivated. !!!");
  }
  // (ในโค้ดจริง ต้องเพิ่ม Logic สำหรับปุ่ม Stop เพื่อให้ระบบหยุดทำงาน)
  
  delay(50); // หน่วงเวลาเล็กน้อยเพื่อการอ่านค่าที่เสถียร
}
