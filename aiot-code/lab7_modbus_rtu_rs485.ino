// ========================================================================
// LAB 7: Modbus RTU Communication via RS-485 (ESP32)
// อาจารย์: ปัญญาประดิษฐ์ไอด้า [ชื่อสมมติ]
// วัตถุประสงค์: อ่านค่าความชื้นดินจากเซนเซอร์ Modbus Slave
// ========================================================================

#include <Arduino.h>

// กำหนดขา GPIO สำหรับการสื่อสาร UART2
// RX2 (รับข้อมูล) เชื่อมต่อกับ A/B ของ RS485
// TX2 (ส่งข้อมูล) เชื่อมต่อกับ A/B ของ RS485
#define RS485_RX_PIN 16 
#define RS485_TX_PIN 17

// สร้าง Object สำหรับการสื่อสาร Serial Port 2
HardwareSerial ModbusSerial(2); 

// ------------------------------------------------------------------------
// 1. การประกาศเฟรมคำขอ (Raw Hex Frame Request Array)
// ------------------------------------------------------------------------
// โครงสร้าง: {Slave Address, Function Code, Start Address, Length, Register Count, Byte Count, CRC Low, CRC High}
// ตัวอย่าง: อ่านค่าความชื้นดิน (Holding Register 0x0000)
// 0x01: Slave Address (เซนเซอร์ตัวที่ 1)
// 0x03: Function Code (Read Holding Registers)
// 0x00, 0x00: Starting Address (ตำแหน่งที่ 0)
// 0x00, 0x01: Number of Registers (ต้องการอ่าน 1 ตัว)
// 0x84, 0x0A: CRC Checksum (ค่าตรวจสอบความถูกต้อง)
const byte ReadSoilMoistureRequestFrame[] = {0x01, 0x03, 0x00, 0x00, 0x00, 0x01, 0x84, 0x0A};
const int REQUEST_FRAME_SIZE = sizeof(ReadSoilMoistureRequestFrame);

// ตัวแปรสำหรับเก็บข้อมูลตอบกลับจากเซนเซอร์
byte responseFrame[10]; 
int responseLength = 0;

void setup() {
    // 1. การตั้งค่า Serial Monitor สำหรับ Debugging (สำหรับการแสดงผล)
    Serial.begin(115200);
    Serial.println("--- Modbus RTU Communication Initialized ---");

    // 2. การตั้งค่า Modbus Serial Port (UART2)
    // กำหนด Baud Rate (อัตราการส่งข้อมูล) และรูปแบบการสื่อสาร
    ModbusSerial.begin(9600, SERIAL_8N1, RS485_RX_PIN, RS485_TX_PIN);
    Serial.println("Modbus Serial Port (UART2) Ready @ 9600 bps.");
}

void loop() {
    Serial.println("\n==================================================");
    Serial.println(">>> 1. Sending Modbus Request Frame...");

    // ------------------------------------------------------------------------
    // A. การส่งคำขอ (Sending the Request)
    // ------------------------------------------------------------------------
    // ส่งเฟรมคำขอทั้งหมดออกไปทาง RS-485
    ModbusSerial.write(ReadSoilMoistureRequestFrame, REQUEST_FRAME_SIZE);
    Serial.printf("Sent %d bytes request: 0x%02X 0x%02X ...\n", 
                    REQUEST_FRAME_SIZE, 
                    ReadSoilMoistureRequestFrame[0], 
                    ReadSoilMoistureRequestFrame[1]);

    // ------------------------------------------------------------------------
    // B. การรอรับข้อมูล (Waiting for Response)
    // ------------------------------------------------------------------------
    // ดีเลย์เพื่อรอให้เซนเซอร์ประมวลผลและส่งข้อมูลกลับมา
    delay(150); // รอ 150 มิลลิวินาที (ms) ตามมาตรฐานการสื่อสาร
    
    // ------------------------------------------------------------------------
    // C. การอ่านข้อมูลตอบกลับ (Reading the Response)
    // ------------------------------------------------------------------------
    // อ่านข้อมูลที่เข้ามาในบัฟเฟอร์ของ Serial Port
    responseLength = ModbusSerial.available();
    
    if (responseLength > 0) {
        // อ่านข้อมูลทั้งหมดที่เข้ามาเก็บไว้ใน responseFrame
        ModbusSerial.readBytes(responseFrame, responseLength);
        Serial.printf("<<< Received %d bytes response.\n", responseLength);

        // ------------------------------------------------------------------------
        // D. การตรวจสอบความสมบูรณ์ของแพ็กเกจ (Packet Validation)
        // ------------------------------------------------------------------------
        // ตามมาตรฐาน Modbus RTU, การตอบกลับที่สมบูรณ์ควรมีขนาด 7 ไบต์ (Address, Function, Data, CRC)
        const int EXPECTED_RESPONSE_SIZE = 7; 
        if (responseLength >= EXPECTED_RESPONSE_SIZE) {
            Serial.println("✅ Packet size OK. Proceeding to data parsing.");

            // ------------------------------------------------------------------------
            // E. การแกะกล่องไบต์ข้อมูล (Bitwise Parsing)
            // ------------------------------------------------------------------------
            // ข้อมูลความชื้นดิน (Soil Moisture) ถูกเก็บในตำแหน่งที่ 3 และ 4 ของเฟรมตอบกลับ
            // responseFrame[3] คือ High Byte (ไบต์ซ้าย)
            // responseFrame[4] คือ Low Byte (ไบต์ขวา)
            
            // การรวมไบต์: (High Byte << 8) | Low Byte
            // 1. เลื่อน High Byte ไปทางซ้าย 8 ตำแหน่ง (<< 8)
            // 2. ใช้ Bitwise OR (|) เพื่อรวมกับ Low Byte
            int rawSoilMoistureData = (responseFrame[3] << 8) | responseFrame[4];
            
            // ------------------------------------------------------------------------
            // F. การคำนวณค่าจริง (Final Calculation)
            // ------------------------------------------------------------------------
            // ค่าที่ได้มาเป็นหน่วย 10 เท่าของเปอร์เซ็นต์ความชื้น
            float actualMoisturePercentage = (float)rawSoilMoistureData / 10.0;

            Serial.println("--------------------------------------------------");
            Serial.printf("Raw Hex Data (Bytes 3 & 4): 0x%02X 0x%02X\n", 
                            responseFrame[3], responseFrame[4]);
            Serial.printf("Combined Raw Integer Value: %d\n", rawSoilMoistureData);
            Serial.printf("💧 Soil Moisture Level: %.2f %%\n", actualMoisturePercentage);
            Serial.println("--------------------------------------------------");

        } else {
            // กรณีที่ข้อมูลไม่ครบตามมาตรฐาน
            Serial.println("❌ ERROR: Received packet size is too small or corrupted.");
            // สำคัญมาก: ต้องล้างสัญญาณที่ค้างอยู่ในพอร์ตรับข้อมูลทันที
            ModbusSerial.flush(); 
        }
    } else {
        Serial.println("⚠️ No response received from the sensor. Check wiring or sensor power.");
    }

    // หน่วงเวลาเพื่อไม่ให้ส่งคำขอถี่เกินไป
    delay(3000); 
}
