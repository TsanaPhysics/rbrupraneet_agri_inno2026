## 3.5 แล็บวิจัยเกษตรขั้นสูง: 1D Richards Infiltration Solver (Python) และระบบนำทาง Extended Kalman Filter (EKF)

# 3.5 แล็บวิจัยเกษตรขั้นสูง: การจำลองการซึมผ่านน้ำในดิน 1 มิติด้วยสมการริชาร์ดส และระบบนำทางด้วย Extended Kalman Filter

**(Advanced Agricultural Research Laboratory: 1D Richards Infiltration Solver and Extended Kalman Filter Navigation System)**

---

## บทนำ: หลักการบูรณาการทางวิศวกรรมและวิทยาศาสตร์ดิน (Introduction: Principles of Engineering and Soil Science Integration)

ในยุคของการเกษตรดิจิทัล (Digital Agriculture) การทำความเข้าใจกระบวนการทางกายภาพที่ซับซ้อนในระบบนิเวศการเพาะปลูกเป็นสิ่งจำเป็นอย่างยิ่ง การจัดการน้ำในดิน (Soil Water Management) ถือเป็นหัวใจสำคัญของการเพิ่มผลผลิตและลดผลกระทบต่อสิ่งแวดล้อม การจำลองการเคลื่อนที่ของน้ำในดิน (Soil Water Movement Simulation) จึงเป็นเครื่องมือทางวิศวกรรมที่ทรงพลังที่ช่วยให้เราสามารถทำนายพฤติกรรมของความชื้นในดิน (Soil Moisture) ภายใต้สภาวะการให้น้ำที่แตกต่างกัน

หัวข้อนี้จะนำเสนอการศึกษาเชิงลึกในสองส่วนหลัก: ส่วนแรกคือการจำลองการซึมผ่านน้ำแนวดิ่งในดิน (Vertical Water Infiltration) โดยใช้สมการริชาร์ดส (Richards Equation) ซึ่งเป็นสมการเชิงอนุพันธ์ย่อย (Partial Differential Equation: PDE) ที่อธิบายการไหลของน้ำในช่องว่างของดิน (Pore Water Flow) ส่วนที่สองคือการประยุกต์ใช้ตัวกรองคาลมานขยาย (Extended Kalman Filter: EKF) เพื่อการหลอมรวมข้อมูลเซ็นเซอร์นำทาง (Navigation Sensor Data Fusion) สำหรับการทำแผนที่ฟาร์ม (Farm Mapping) อย่างแม่นยำ

---

## ส่วนที่ 1: การจำลองการซึมผ่านน้ำในดิน 1 มิติด้วยสมการริชาร์ดส (1D Richards Infiltration Solver)

### 1.1 ทฤษฎีพื้นฐาน: สมการริชาร์ดส (Richards Equation Theory)

การไหลของน้ำในดินไม่ได้เป็นเพียงแค่การไหลของมวล (Mass Flow) เท่านั้น แต่ยังเกี่ยวข้องกับแรงดันน้ำในช่องว่าง (Pore Water Pressure) และแรงตึงผิว (Capillary Forces) ซึ่งทั้งหมดนี้ถูกรวมอยู่ในสมการริชาร์ดส (Richards Equation) ซึ่งเป็นสมการหลักที่ใช้อธิบายการเปลี่ยนแปลงของปริมาณความชื้นในดิน ($\theta$) ตามเวลา ($t$) และความลึก ($z$)

สมการริชาร์ดสในรูปแบบหนึ่งมิติ (1D) สำหรับการเปลี่ยนแปลงความชื้นในดิน ($\theta$) คือ:

$$\frac{\partial \theta}{\partial t} = \frac{\partial}{\partial z} \left[ K(\theta) \left( \frac{\partial \psi}{\partial z} + 1 \right) \right]$$

**คำอธิบายตัวแปร:**

*   $\theta$: ความชื้นในดิน (Soil Water Content) [$\text{L}/\text{L}$ หรือ $\text{m}^3/\text{m}^3$]
*   $t$: เวลา (Time) [$\text{s}$]
*   $z$: ความลึกในแนวตั้ง (Depth) [$\text{m}$]
*   $K(\theta)$: ค่าการนำความร้อนของน้ำในดิน (Hydraulic Conductivity) [$\text{L}/\text{T}$ หรือ $\text{m}/\text{s}$] ซึ่งขึ้นอยู่กับความชื้นในดิน
*   $\psi$: ศักย์น้ำในช่องว่าง (Pore Water Potential) [$\text{L}$ หรือ $\text{m}$]
*   $\frac{\partial \psi}{\partial z}$: การไล่ระดับของศักย์น้ำตามความลึก (Gradient of Pore Water Potential)

### 1.2 ความสัมพันธ์ระหว่างตัวแปร (Constitutive Relationships)

เพื่อให้สามารถแก้สมการนี้ได้ เราจำเป็นต้องนิยามความสัมพันธ์ทางกายภาพที่ควบคุมตัวแปรหลัก:

#### 1.2.1 ความสัมพันธ์ระหว่างศักย์น้ำและความชื้น ($\psi - \theta$ Relationship)
ความสัมพันธ์นี้มักถูกประมาณค่าโดยใช้ฟังก์ชันของ Van Genuchten (Van Genuchten Model) ซึ่งมีความแม่นยำสูงในการจำลองการดูดซับน้ำในดิน:

$$\frac{\theta - \theta_r}{\theta_s - \theta_r} = \left[ 1 + (\alpha |\psi|)^n \right]^{-1}$$

โดยที่:
*   $\theta_r$: ความชื้นที่จุดอิ่มตัว (Residual Water Content) [$\text{L}/\text{L}$]
*   $\theta_s$: ความชื้นที่จุดอิ่มตัวสูงสุด (Saturated Water Content) [$\text{L}/\text{L}$]
*   $\alpha$: ค่าสัมประสิทธิ์การดูดซับ (Parameter $\alpha$)
*   $n$: ค่าดัชนีการดูดซับ (Parameter $n$)

#### 1.2.2 ความสัมพันธ์ระหว่างการนำความร้อนและความชื้น ($K - \theta$ Relationship)
ค่าการนำความร้อนของน้ำในดิน $K(\theta)$ ก็ขึ้นอยู่กับความชื้นในดินเช่นกัน โดยทั่วไปสามารถใช้ฟังก์ชันที่เชื่อมโยงกับ Van Genuchten ได้:

$$K(\theta) = K_s \left[ \frac{1 - (1 - (\frac{\theta - \theta_r}{\theta_s - \theta_r})^m)^n}{1 - (1 - (\frac{\theta - \theta_r}{\theta_s - \theta_r})^m)} \right]^2$$

โดยที่ $K_s$ คือค่าการนำความร้อนเมื่อดินอิ่มตัว (Saturated Hydraulic Conductivity) [$\text{L}/\text{T}$] และ $m$ คือค่าที่เกี่ยวข้องกับ $n$

### 1.3 การประยุกต์ใช้กรณีศึกษา: ดินเหนียวจันทบุรี (Chanthaburi Clay)

สำหรับกรณีศึกษาการจำลองการดูดซับน้ำในดินชั้นดินของสวนทุเรียนในจังหวัดจันทบุรี เราจะใช้พารามิเตอร์จำลองของดินเหนียว (Clay Soil) ดังนี้:

*   $\theta_r = 0.098$
*   $\theta_s = 0.485$
*   $K_s = 1.15 \times 10^{-4} \text{ cm}/\text{s} = 1.15 \times 10^{-6} \text{ m}/\text{s}$

### 1.4 การแก้สมการด้วยระเบียบวิธีผลต่างอันดับสิ้นสุด (Finite Difference Method: FDM)

เนื่องจากสมการริชาร์ดสเป็น PDE ที่ซับซ้อน การแก้ปัญหาเชิงตัวเลข (Numerical Solution) จึงเป็นสิ่งจำเป็น เราจะใช้ระเบียบวิธีผลต่างอันดับสิ้นสุด (FDM) โดยการแบ่งโดเมนเวลาและพื้นที่ออกเป็นขั้นตอนย่อยๆ (Discretization)

**การแปลง PDE เป็นรูปแบบที่สามารถคำนวณได้:**

เราจะใช้การประมาณค่าแบบ Explicit หรือ Implicit (ในที่นี้จะใช้ Implicit Scheme เพื่อความเสถียร) โดยการประมาณค่าอนุพันธ์ย่อย ($\frac{\partial \theta}{\partial t}$ และ $\frac{\partial}{\partial z}$) ด้วยผลต่างจำกัด (Finite Difference).

**ขั้นตอนการคำนวณ:**

1.  **กำหนดโดเมน:** กำหนดความลึก $Z_{max}$ (เช่น 1.0 $\text{m}$) และจำนวนจุด $N_z$
2.  **กำหนดเวลา:** กำหนดช่วงเวลา $T_{max}$ และขนาดขั้นตอนเวลา $\Delta t$
3.  **การวนซ้ำ (Iteration):** ในแต่ละขั้นตอนเวลา $t^{k+1}$ เราจะคำนวณ $\theta$ ที่ตำแหน่ง $z_i$ โดยใช้ค่า $\theta$ จากเวลา $t^k$ และการไหลที่ขอบเขต (Boundary Conditions)

**เงื่อนไขขอบเขต (Boundary Conditions):**
*   **ขอบเขตด้านบน ($z=0$):** เป็นแหล่งกำเนิดน้ำ (Infiltration Flux, $q_{in}$) ซึ่งเป็นอัตราการซึมผ่านน้ำที่ผิวหน้า
*   **ขอบเขตด้านล่าง ($z=Z_{max}$):** เป็นการไหลออกสู่ชั้นน้ำใต้ดิน (Drainage Flux, $q_{out}$) ซึ่งมักจะกำหนดให้เป็นศูนย์หรือเป็นอัตราการไหลคงที่

---

### 1.5 ซอร์สโค้ด Python: ChanthaburiClayDiffusionSolver

โค้ดนี้ใช้หลักการของ FDM เพื่อจำลองการแพร่กระจายความชื้นในดิน 1 มิติ

```python
import numpy as np
import matplotlib.pyplot as plt
from scipy.interpolate import interp1d

# =============================================================================
# คลาส ChanthaburiClayDiffusionSolver
# ใช้ระเบียบวิธีผลต่างอันดับสิ้นสุด (FDM) เพื่อจำลองการซึมผ่านน้ำในดิน 1 มิติ
# =============================================================================
class ChanthaburiClayDiffusionSolver:
    """
    Solver for 1D Richards Equation using Finite Difference Method (FDM).
    Simulates water infiltration in Chanthaburi Clay soil profile.
    """
    def __init__(self, depth_m=1.0, num_points=100, initial_theta=0.3):
        """
        Initializes the solver parameters.
        :param depth_m: ความลึกรวมของดินที่จำลอง (เมตร).
        :param num_points: จำนวนจุดในการแบ่งความลึก (ยิ่งมากยิ่งแม่นยำ).
        :param initial_theta: ความชื้นเริ่มต้นของดิน (L/L).
        """
        self.L = depth_m  # ความลึกรวม (Length)
        self.N = num_points  # จำนวนจุด (Number of nodes)
        self.dz = self.L / (self.N - 1)  # ขนาดขั้นตอนความลึก (Delta z)
        self.theta = np.full(self.N, initial_theta, dtype=float) # อาร์เรย์ความชื้นเริ่มต้น
        
        # พารามิเตอร์ของดินเหนียวจันทบุรี (Chanthaburi Clay Parameters)
        self.theta_r = 0.098  # Residual Water Content (L/L)
        self.theta_s = 0.485  # Saturated Water Content (L/L)
        self.K_s = 1.15e-6   # Saturated Hydraulic Conductivity (m/s)
        self.alpha = 1.5     # Van Genuchten alpha (Hypothetical value)
        self.n_van = 1.5     # Van Genuchten n (Hypothetical value)
        self.m_van = 0.5     # Van Genuchten m (Hypothetical value)

    # ------------------------------------------------------------------------
    # 1. ฟังก์ชันความสัมพันธ์ทางกายภาพ (Constitutive Functions)
    # ------------------------------------------------------------------------

    def _van_genuchten_theta_psi(self, theta_val):
        """
        คำนวณศักย์น้ำ (psi) จากความชื้น (theta) โดยใช้ Van Genuchten Model.
        psi = - ( (theta - theta_r) / (theta_s - theta_r) ) ^ (1/m)
        """
        # ป้องกันการคำนวณค่าลอการิทึมหรือรากที่ติดลบ
        ratio = (theta_val - self.theta_r) / (self.theta_s - self.theta_r)
        if ratio < 0:
            return -1e6 # ให้ค่า psi ที่มาก (แรงดึงสูง) เมื่อ theta < theta_r
        
        # คำนวณ psi
        psi = - (ratio ** (1 / self.m_van))
        return psi

    def calculate_k(self, theta_val):
        """
        คำนวณค่าการนำความร้อนของน้ำในดิน K(theta) (m/s).
        ใช้สูตรที่ปรับมาจาก Van Genuchten สำหรับ K(theta).
        """
        if theta_val < self.theta_r:
            return 0.0 # เมื่อความชื้นต่ำกว่าค่าตกค้าง K = 0
        
        # คำนวณอัตราส่วนความชื้น
        ratio = (theta_val - self.theta_r) / (self.theta_s - self.theta_r)
        
        # คำนวณ K(theta)
        term1 = 1 - (1 - ratio**self.m_van)**self.n_van
        term2 = 1 - (1 - ratio**self.m_van)
        
        if term2 == 0:
            return self.K_s # ป้องกันการหารด้วยศูนย์เมื่อใกล้จุดอิ่มตัว
        
        K_theta = self.K_s * (term1 / term2)**2
        return K_theta

    # ------------------------------------------------------------------------
    # 2. ฟังก์ชันหลักในการจำลอง (Main Simulation Function)
    # ------------------------------------------------------------------------

    def solve_richards_1d(self, infiltration_rate_q_in, total_time_s, dt_s):
        """
        จำลองการซึมผ่านน้ำในดิน 1 มิติ (1D Richards Infiltration).
        :param infiltration_rate_q_in: อัตราการซึมผ่านน้ำที่ผิวหน้า (m/s).
        :param total_time_s: เวลาทั้งหมดที่จำลอง (วินาที).
        :param dt_s: ขนาดขั้นตอนเวลา (วินาที).
        :return: numpy array ของความชื้นในดินที่แต่ละช่วงเวลา (History of theta).
        """
        time_steps = int(total_time_s / dt_s)
        theta_history = [self.theta.copy()]
        
        # การวนซ้ำตามเวลา (Time stepping loop)
        for k in range(time_steps):
            theta_new = self.theta.copy()
            
            # คำนวณการไหลที่ขอบเขต (Boundary Fluxes)
            # 1. ขอบเขตด้านบน (z=0): กำหนดให้เป็นอัตราการซึมผ่านที่กำหนด (q_in)
            q_in_k = infiltration_rate_q_in 
            
            # 2. ขอบเขตด้านล่าง (z=L): กำหนดให้เป็นศูนย์ (Drainage condition)
            q_out_k = 0.0 
            
            # การวนซ้ำตามความลึก (Depth loop)
            for i in range(1, self.N - 1):
                # 1. คำนวณค่า K และ psi ที่ตำแหน่งปัจจุบัน (z_i)
                K_i = self.calculate_k(self.theta[i])
                psi_i = self._van_genuchten_theta_psi(self.theta[i])
                
                # 2. คำนวณการไล่ระดับของศักย์น้ำ (Approximation of d(psi)/dz)
                # ใช้ Central Difference Scheme สำหรับอนุพันธ์ในพื้นที่
                d_psi_dz_i = (self._van_genuchten_theta_psi(self.theta[i+1]) - 
                               self._van_genuchten_theta_psi(self.theta[i-1])) / (2 * self.dz)
                
                # 3. คำนวณการไหลที่ตำแหน่ง i (Flux, q)
                # q = -K(theta) * (d(psi)/dz + 1)
                # หมายเหตุ: การรวม +1 ในสูตร Richards คือการรวมแรงดันน้ำ (Pressure Head)
                q_i = -K_i * (d_psi_dz_i + 1.0)
                
                # 4. คำนวณอัตราการเปลี่ยนแปลงความชื้น (d(theta)/dt)
                # d(theta)/dt = -d^2(q)/dz / (rho * C_r)  (Simplified form for water only)
                # ในที่นี้เราใช้รูปแบบที่ง่ายขึ้นโดยเน้นที่การไหลเข้าออก
                
                # การประมาณค่าการไหลเข้าออกที่จุด i
                q_left = -self.calculate_k(self.theta[i]) * (self._van_genuchten_theta_psi(self.theta[i]) - self._van_genuchten_theta_psi(self.theta[i-1])) / self.dz
                q_right = -self.calculate_k(self.theta[i]) * (self._van_genuchten_theta_psi(self.theta[i+1]) - self._van_genuchten_theta_psi(self.theta[i])) / self.dz
                
                d_theta_dt = (q_right - q_left) / self.dz
                
                # 5. ปรับค่าความชื้นใหม่ตามกระบวนการ Explicit Euler Method
                theta_new[i] = self.theta[i] + d_theta_dt * dt_s
                
            # จัดการเงื่อนไขขอบเขตสำหรับโหนดแรกและโหนดสุดท้าย
            theta_new[0] = self.theta[0] + (infiltration_rate_q_in - self.calculate_k(self.theta[0])) * (dt_s / self.dz)
            theta_new[-1] = self.theta[-1] + (self.calculate_k(self.theta[-2]) - q_out_k) * (dt_s / self.dz)
            
            # บังคับขอบเขตจำกัดทางฟิสิกส์ (Physical Constraints: theta_r <= theta <= theta_s)
            theta_new = np.clip(theta_new, self.theta_r, self.theta_s)
            
            # อัปเดตค่าปัจจุบัน
            self.theta = theta_new.copy()
            theta_history.append(self.theta.copy())
            
        return np.array(theta_history)

# จำลองระบบดินเหนียวจันทบุรี
solver = ChanthaburiClayDiffusionSolver()
# อัตราการให้น้ำ 0.05 ซม./วินาที = 0.0005 เมตร/วินาที
history = solver.solve_richards_1d(infiltration_rate_q_in=0.0005, total_time_s=600, dt_s=1.0)
print("--- สรุปผลการจำลองการซึมผ่านน้ำดินเหนียวจันทบุรี (Richards 1D) ---")
print(f"จำนวนขั้นตอนจำลอง: {len(history)} วินาที")
print(f"ความชื้นเริ่มต้นผิวหน้าดิน: {history[0][0]:.4f} m^3/m^3")
print(f"ความชื้นหลังจำลอง 10 นาทีที่ผิวหน้าดิน: {history[-1][0]:.4f} m^3/m^3")
```

