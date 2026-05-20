// C++ Code for Arduino (Simulation of Hazen-Williams Calculation)

// กำหนดค่าคงที่ทางฟิสิกส์
const float GRAVITY = 9.81; // ความเร่งเนื่องจากแรงโน้มถ่วง (m/s^2)
const float RHO_WATER = 1000.0; // ความหนาแน่นของน้ำ (kg/m^3)

// ตัวแปรสำหรับรับค่าอินพุต (Input Variables)
float L_meters = 100.0; // ความยาวท่อ (L) หน่วยเป็นเมตร
float Q_m3 s = 0.002778; // อัตราการไหล (Q) หน่วยเป็น m^3/s (จากตัวอย่าง)
float C_coeff = 120.0; // สัมประสิทธิ์ Hazen-Williams (C) สำหรับ PVC
float D_meters = 0.053; // เส้นผ่านศูนย์กลางภายใน (D) หน่วยเป็นเมตร

void setup() {
  // เริ่มต้นการสื่อสารผ่าน Serial Monitor เพื่อแสดงผลการคำนวณ
  Serial.begin(9600);
  Serial.println("==================================================");
  Serial.println("  ระบบคำนวณการสูญเสียพลังงาน (Hazen-Williams)");
  Serial.println("==================================================");
}

void loop() {
  // 1. คำนวณ Head Loss (h_f) โดยใช้สมการ Hazen-Williams
  // h_f = 10.67 * L * Q^1.852 * C^-1.852 * D^-4.87
  
  // คำนวณส่วน Q^1.852
  float Q_term = pow(Q_m3 s, 1.852); 
  
  // คำนวณส่วน C^-1.852
  float C_term = pow(C_coeff, -1.852); 
  
  // คำนวณส่วน D^-4.87
  float D_term = pow(D_meters, -4.87); 
  
  // คำนวณค่า h_f (หน่วยเป็นเมตร)
  float h_f = 10.67 * L_meters * Q_term * C_term * D_term;

  // 2. คำนวณ Pressure Loss (P_loss)
  // P_loss (Pa) = RHO * G * h_f
  // P_loss (bar) = h_f / 10.2
  float P_loss_bar = h_f / 10.2;

  // 3. แสดงผลลัพธ์
  Serial.println("--- ผลการคำนวณ ---");
  Serial.print("1. Head Loss (h_f): ");
  Serial.print(h_f, 3); // แสดงทศนิยม 3 ตำแหน่ง
  Serial.println(" เมตร (m)");

  Serial.print("2. Pressure Loss (P_loss): ");
  Serial.print(P_loss_bar, 3);
  Serial.println(" บาร์ (bar)");
  
  Serial.println("==================================================");
  delay(5000); // หน่วงเวลา 5 วินาที ก่อนรันใหม่
}
