// =================================================================
// Node-RED Function Node: ETc Calculation and Irrigation Control
// วัตถุประสงค์: รับข้อมูลสภาพอากาศและคำนวณปริมาณน้ำที่ต้องจ่าย
// =================================================================

// 1. กำหนดค่าคงที่ (Constants)
const ET_c_DAILY_MM = 7.8;      // ETc (mm/day)
const CANOPY_AREA_SQM = 15.0;   // พื้นที่เรือนยอด (m^2)
const IRRIGATION_EFFICIENCY = 0.85; // ประสิทธิภาพระบบ (85%)

// 2. ฟังก์ชันหลักในการคำนวณ (Main Calculation Function)
function calculateWaterRequirement(msg) {
    // ตรวจสอบว่ามีข้อมูลครบถ้วนหรือไม่
    if (!msg.payload || typeof msg.payload.soilMoisture === 'undefined') {
        return { payload: "Error: Missing sensor data.", topic: "error" };
    }

    // ดึงค่าความชื้นจาก Payload ที่ส่งมา (สมมติว่ามาจาก Sensor Node)
    const soilMoisture = msg.payload.soilMoisture;
    
    // คำนวณปริมาตรน้ำที่ต้องให้จริง (V_water)
    // V_water = (ETc * A_canopy * 1000) / Efficiency
    const requiredVolumeLiters = (ET_c_DAILY_MM * CANOPY_AREA_SQM * 1000) / IRRIGATION_EFFICIENCY;

    // 3. การตัดสินใจ (Decision Logic)
    let actionMessage = {};
    
    // เกณฑ์การตัดสินใจ: ถ้าความชื้นต่ำกว่า 400 (ค่าสมมติ) ให้เปิดน้ำ
    if (soilMoisture > 400) {
        actionMessage = {
            payload: "เปิดวาล์ว (Open Valve)", // คำสั่งสำหรับ Node ควบคุมรีเลย์
            waterVolume: requiredVolumeLiters.toFixed(2) + " L",
            timestamp: Date.now()
        };
        // ส่งข้อความไปยัง Node ควบคุมรีเลย์
        return actionMessage; 
    } else {
        actionMessage = {
            payload: "ปิดวาล์ว (Close Valve)", // คำสั่งสำหรับ Node ควบคุมรีเลย์
            waterVolume: requiredVolumeLiters.toFixed(2) + " L",
            timestamp: Date.now()
        };
        // ส่งข้อความไปยัง Node ควบคุมรีเลย์
        return actionMessage;
    }
}

// 4. การส่งผลลัพธ์ (Output)
// ส่งผลลัพธ์ที่คำนวณได้ไปยัง Node ถัดไป (เช่น Node สำหรับส่งคำสั่งไปยังรีเลย์)
msg.payload = calculateWaterRequirement(msg);
return msg;
