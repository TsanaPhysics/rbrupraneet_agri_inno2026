// #include <ModbusMaster.h> // ต้องติดตั้งไลบรารี ModbusMaster
// ModbusMaster node(Serial1); // กำหนดให้ใช้พอร์ต Serial1 สำหรับ RS-485

// const int SLAVE_ID = 1;       // กำหนด Slave ID ของเซนเซอร์
// const int START_ADDRESS = 1000; // Address เริ่มต้นของ Holding Register
// const int QUANTITY = 1;       // จำนวน Registers ที่ต้องการอ่าน (1 Register)

void setup() {
  // Serial.begin(9600); // สำหรับ Debugging
  // Serial1.begin(9600); // สำหรับการสื่อสาร RS-485
  // node.begin(SLAVE_ID); // เริ่มต้นการสื่อสารกับ Slave ID 1
}

void loop() {
  // 1. การส่งคำสั่งอ่านค่า (Function Code 03)
  // node.readHoldingRegisters(START_ADDRESS, QUANTITY); 
  
  // 2. การรอให้ Master ส่งคำสั่งและรอการตอบกลับจาก Slave
  // delay(2000); 

  // 3. การตรวจสอบและแสดงผลค่าที่ได้รับ
  // if (node.readHoldingRegisters(START_ADDRESS, QUANTITY)) {
  //   // ค่าที่อ่านได้จะถูกเก็บไว้ในหน่วยความจำของไลบรารี
  //   uint16 bitVal = node.getResponseBuffer(0); 
  //   Serial.print("ค่าความชื้นในดินที่อ่านได้คือ: ");
  //   Serial.println(bitVal);
  // } else {
  //   Serial.println("!!! ERROR: ไม่สามารถสื่อสารกับ Slave ID 1 ได้");
  // }
}
