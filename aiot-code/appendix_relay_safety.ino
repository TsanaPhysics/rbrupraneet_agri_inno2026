// C++ Code for Arduino (Microcontroller)
// Safety Note: Always use Optocoupler/Relay Module for high voltage!

// กำหนดขาสำหรับควบคุมรีเลย์ (Relay Pin)
const int pumpRelayPin = 7; 

void setup() {
    // 1. กำหนดให้ขาเป็น Output
    pinMode(pumpRelayPin, OUTPUT);
    
    // 2. *** CRITICAL SAFETY STEP ***
    // ตั้งค่าเริ่มต้นให้รีเลย์อยู่ในสถานะ "เปิด" (Active Low: HIGH = OFF)
    // การตั้งค่านี้ช่วยให้มั่นใจว่าปั๊มจะไม่ทำงานเมื่อไฟดับหรือรีเซ็ต
    digitalWrite(pumpRelayPin, HIGH); 
    Serial.println("System Initialized. Pump is OFF (Safety Default).");
}

void loop() {
    // ตัวอย่าง: เมื่อต้องการเปิดปั๊ม (Activate the relay)
    // ต้องส่งสัญญาณ LOW ไปที่ขาควบคุม
    if (checkWaterLevel() == LOW) {
        digitalWrite(pumpRelayPin, LOW); // สั่งให้รีเลย์ทำงาน (Active Low)
        Serial.println("Pump Activated: Water level low.");
    } else {
        // เมื่อไม่ต้องการให้ปั๊มทำงาน (Deactivate the relay)
        digitalWrite(pumpRelayPin, HIGH); // สั่งให้รีเลย์หยุดทำงาน
        Serial.println("Pump Deactivated: Water level sufficient.");
    }
    delay(5000);
}
