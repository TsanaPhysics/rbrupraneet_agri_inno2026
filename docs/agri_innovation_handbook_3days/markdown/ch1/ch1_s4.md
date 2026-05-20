## 1.4 การวิเคราะห์อนุกรมเวลาสภาพอากาศด้วย Pandas (Weather Time Series Analysis with Pandas & Seaborn)

# ภาควิชาวิทยาศาสตร์การเกษตรดิจิทัลและฟิสิกส์ประยุกต์
# หัวข้อ 1.4 การวิเคราะห์อนุกรมเวลาสภาพอากาศด้วย Pandas (Weather Time Series Analysis with Pandas & Seaborn)

---

## บทนำ: ความสำคัญของการวิเคราะห์อนุกรมเวลาในอุตุนิยมวิทยาการเกษตร
*(Introduction: Importance of Time Series Analysis in Agro-Meteorology)*

ในบริบทของเกษตรกรรมยุคดิจิทัล (Digital Agriculture) ข้อมูลสภาพอากาศถือเป็นตัวแปรนำเข้า (Input Variable) ที่มีความสำคัญสูงสุดต่อการวางแผนการเพาะปลูก การจัดการน้ำ และการคาดการณ์ผลผลิต การทำความเข้าใจถึงการเปลี่ยนแปลงของสภาพอากาศในมิติของเวลาจึงเป็นหัวใจสำคัญของการเกษตรแม่นยำ (Precision Agriculture)

**อนุกรมเวลา (Time Series Data)** คือชุดของข้อมูลที่ถูกเก็บรวบรวมตามลำดับเวลาอย่างต่อเนื่อง (Sequential Data over Time) ในทางอุตุนิยมวิทยาการเกษตร (Agro-Meteorology) ข้อมูลอนุกรมเวลาอาจประกอบด้วยตัวแปรต่างๆ เช่น อุณหภูมิเฉลี่ยรายวัน (Daily Mean Temperature), ปริมาณน้ำฝนสะสม (Cumulative Rainfall), ความชื้นสัมพัทธ์ (Relative Humidity), หรือความเร็วลม (Wind Speed) ซึ่งข้อมูลเหล่านี้ไม่ได้เป็นเพียงค่า ณ จุดเวลาใดเวลาหนึ่ง แต่เป็นแนวโน้ม (Trend) และความผันผวน (Variability) ที่สะท้อนถึงสภาวะแวดล้อมที่เปลี่ยนแปลงไปตามกาลเวลา

การวิเคราะห์อนุกรมเวลาจึงมิใช่เพียงการดูค่าเฉลี่ย แต่คือการค้นหารูปแบบ (Pattern) ฤดูกาล (Seasonality) แนวโน้มระยะยาว (Long-term Trend) และความสัมพันธ์เชิงสาเหตุ (Causality) ระหว่างตัวแปรสภาพอากาศที่ส่งผลกระทบต่อวงจรชีวิตของพืช (Crop Life Cycle) อย่างเป็นระบบ

---

## 1. องค์ประกอบทางทฤษฎี: การจัดการข้อมูลอนุกรมเวลาด้วย Pandas
*(Theoretical Component: Handling Time Series Data with Pandas)*

ไลบรารี **Pandas** (Python Data Analysis Library) เป็นเครื่องมือหลักในการจัดการข้อมูลที่มีโครงสร้างแบบตาราง (Tabular Data) ในภาษา Python โดยเฉพาะอย่างยิ่งเมื่อต้องจัดการกับข้อมูลอนุกรมเวลา Pandas ได้ถูกออกแบบมาเพื่อรองรับโครงสร้างข้อมูลที่เรียกว่า **DataFrame** ซึ่งมีคุณสมบัติที่สำคัญอย่างยิ่งคือการรองรับ **Datetime Indexing**

### 1.1 การโหลดและการจัดการโครงสร้างข้อมูล (Data Loading and Structure Management)
เมื่อเราโหลดข้อมูลสภาพอากาศจากไฟล์สถิติ (เช่น CSV) สิ่งแรกที่ต้องดำเนินการคือการตรวจสอบให้แน่ใจว่าคอลัมน์ที่ระบุเวลา (Timestamp) ถูกระบุว่าเป็นรูปแบบวันที่และเวลา (Datetime Object) อย่างถูกต้อง

**หลักการทางเทคนิค:**
การกำหนดให้คอลัมน์ใดคอลัมน์หนึ่งเป็น Index ที่เป็น Datetime Index จะช่วยให้ Pandas สามารถดำเนินการทางเวลา (Time-based Operations) ได้อย่างมีประสิทธิภาพ เช่น การเลือกข้อมูลในช่วงเวลาที่กำหนด (Slicing by Date Range) หรือการ Resampling (การปรับความถี่ของข้อมูล)

### 1.2 การจัดการข้อมูลสูญหาย (Handling Missing Values: NaN)
ในข้อมูลสภาพอากาศจริง มักเกิดข้อมูลสูญหาย (Missing Values) เนื่องจากเซนเซอร์ขัดข้อง หรือการบันทึกข้อมูลที่ไม่สมบูรณ์ การจัดการข้อมูลสูญหายเป็นขั้นตอนที่สำคัญยิ่งก่อนการวิเคราะห์ใดๆ

**วิธีการทางสถิติที่ใช้:**
1.  **การลบทิ้ง (Dropping):** หากข้อมูลสูญหายมีปริมาณมากเกินไป หรืออยู่ในช่วงเวลาที่สำคัญจนไม่สามารถประมาณค่าได้ อาจพิจารณาลบแถวนั้นทิ้ง (Row Deletion)
2.  **การแทนที่ด้วยค่าก่อนหน้า/ถัดไป (Forward/Backward Filling):** สำหรับข้อมูลที่คาดว่าค่าจะไม่เปลี่ยนแปลงอย่างฉับพลัน (เช่น อุณหภูมิที่คงที่ตลอดคืน) สามารถใช้เทคนิค **Forward Fill (ffill)** หรือ **Backward Fill (bfill)** เพื่อประมาณค่าที่หายไปโดยใช้ค่าที่อยู่ใกล้เคียงที่สุด

---

## 2. การวิเคราะห์แนวโน้มด้วยค่าเฉลี่ยเคลื่อนที่ (Rolling Moving Average)
*(Trend Analysis using Rolling Moving Average)*

เมื่อข้อมูลอนุกรมเวลาสภาพอากาศถูกบันทึกมาอย่างต่อเนื่อง ข้อมูลที่ได้มักมีความผันผวนสูง (High Volatility) เนื่องจากได้รับผลกระทบจากสภาพอากาศเฉพาะวัน (Daily Weather Fluctuation) การวิเคราะห์ค่าดิบ (Raw Data) โดยตรงอาจทำให้เกิดสัญญาณรบกวน (Noise) มากเกินไป จนทำให้การระบุแนวโน้มระยะยาว (Long-term Trend) เป็นไปได้ยาก

**ค่าเฉลี่ยเคลื่อนที่ (Moving Average, MA)** คือเทคนิคทางสถิติที่ใช้ในการ "ทำให้ข้อมูลเรียบ" (Smoothing) โดยการคำนวณค่าเฉลี่ยของข้อมูลในช่วงเวลาที่กำหนด (Window Size) ค่าที่ได้จากการคำนวณนี้จะถูกเลื่อนไปตามลำดับเวลา ทำให้ได้ค่าประมาณของแนวโน้มที่แท้จริงของตัวแปรนั้นๆ

### 2.1 หลักการทางคณิตศาสตร์ (Mathematical Principle)
ให้ $X_t$ เป็นค่าของตัวแปรสภาพอากาศ ณ เวลา $t$ และให้ $W$ เป็นขนาดของหน้าต่าง (Window Size) ในการคำนวณค่าเฉลี่ยเคลื่อนที่ ณ เวลา $t$ ($\bar{X}_t$) เราจะใช้ค่าเฉลี่ยของ $W$ จุดข้อมูลที่อยู่รอบๆ เวลา $t$

$$
\bar{X}_t = \frac{1}{W} \sum_{i=0}^{W-1} X_{t-i}
$$

โดยที่:
*   $\bar{X}_t$: คือค่าเฉลี่ยเคลื่อนที่ ณ เวลา $t$
*   $W$: คือขนาดหน้าต่าง (Window Size) เช่น $W=7$ หมายถึงการใช้ข้อมูล 7 วัน
*   $X_{t-i}$: คือค่าของตัวแปร ณ เวลา $t-i$

**การประยุกต์ใช้ในเกษตรกรรม:**
การใช้ค่าเฉลี่ยเคลื่อนที่ 7 วัน (7-day Rolling Average) สำหรับปริมาณน้ำฝน (Rainfall) หรืออุณหภูมิ (Temperature) จะช่วยให้เราสามารถลดผลกระทบจากความผันผวนรายวัน (เช่น วันที่ฝนตกหนักผิดปกติ หรือวันที่แดดจัดผิดปกติ) และสามารถมองเห็น "แนวโน้มสะสม" (Accumulated Trend) ของสภาวะแวดล้อมในช่วงสัปดาห์ที่ผ่านมา ซึ่งเป็นข้อมูลที่มีประโยชน์อย่างยิ่งในการพยากรณ์การเจริญเติบโตของพืช

---

## 3. การปฏิบัติการ: การวิเคราะห์อนุกรมเวลาด้วย Python
*(Practical Implementation: Time Series Analysis with Python)*

ในส่วนนี้ เราจะทำการจำลองการวิเคราะห์ข้อมูลสภาพอากาศย้อนหลัง โดยใช้ไลบรารี Pandas และ Seaborn เพื่อคำนวณและแสดงผลค่าเฉลี่ยเคลื่อนที่ 7 วัน สำหรับปริมาณน้ำฝนและอุณหภูมิ

### 3.1 การเตรียมสภาพแวดล้อมและข้อมูลจำลอง
สมมติว่าเรามีไฟล์ CSV ชื่อ `weather_data.csv` ซึ่งมีคอลัมน์หลักดังนี้:
1.  `Date`: วันที่และเวลา (Timestamp)
2.  `Rainfall_mm`: ปริมาณน้ำฝน (หน่วย: มิลลิเมตร, mm)
3.  `Temperature_C`: อุณหภูมิเฉลี่ย (หน่วย: องศาเซลเซียส, °C)

### 3.2 โค้ด Python สำหรับการวิเคราะห์ (Python Code for Analysis)

```python
# --------------------------------------------------------------------------
# 📚 การนำเข้าไลบรารีที่จำเป็น (Importing Necessary Libraries)
# --------------------------------------------------------------------------
import pandas as pd
import numpy as np
import matplotlib.pyplot as plt
import seaborn as sns

# ตั้งค่าสไตล์ของกราฟให้เป็นมาตรฐานทางวิชาการ
sns.set_style("whitegrid")

# --------------------------------------------------------------------------
# 🛠️ ขั้นตอนที่ 1: การโหลดและการเตรียมข้อมูล (Data Loading and Preparation)
# --------------------------------------------------------------------------
# สร้างข้อมูลจำลองเพื่อสาธิตการทำงาน (Simulating the loading of a CSV file)
# ในการใช้งานจริง: df = pd.read_csv('weather_data.csv')
data = {
    'Date': pd.date_range(start='2023-01-01', periods=60, freq='D'), # สร้างข้อมูล 60 วัน
    'Rainfall_mm': np.random.rand(60) * 10 + np.sin(np.arange(60) / 10) * 5, # จำลองปริมาณน้ำฝน (0-10 mm)
    'Temperature_C': 25 + np.sin(np.arange(60) / 15) * 5 + np.random.randn(60) * 1.5 # จำลองอุณหภูมิ (20-30 °C)
}
df = pd.DataFrame(data)

# 💡 การกำหนด Datetime Index: กำหนดให้คอลัมน์ 'Date' เป็น Index หลักของ DataFrame
# นี่คือขั้นตอนสำคัญที่สุดในการวิเคราะห์อนุกรมเวลา
df = df.set_index('Date')

print("--- ข้อมูลต้นฉบับ 5 แถวแรก (Original Data Head) ---")
print(df.head())

# --------------------------------------------------------------------------
# 🧹 ขั้นตอนที่ 2: การจัดการข้อมูลสูญหาย (Handling Missing Values)
# --------------------------------------------------------------------------
# จำลองการเกิดข้อมูลสูญหายในวันที่ 30 และ 31
df.loc['2023-01-30':'2023-01-31', 'Rainfall_mm'] = np.nan
df.loc['2023-02-05', 'Temperature_C'] = np.nan

print("\n--- ข้อมูลหลังการจำลอง NaN ---")
print(df.loc['2023-01-28':'2023-02-02'])

# การจัดการ NaN: ใช้ Forward Fill (ffill) เพื่อประมาณค่าที่หายไป
# หมายความว่า ค่าที่หายไปจะถูกแทนที่ด้วยค่าที่เกิดขึ้นก่อนหน้า
df_cleaned = df.copy()
df_cleaned['Rainfall_mm'] = df_cleaned['Rainfall_mm'].fillna(method='ffill')
df_cleaned['Temperature_C'] = df_cleaned['Temperature_C'].fillna(method='ffill')

print("\n--- ข้อมูลหลังการทำ Forward Fill (Cleaned Data) ---")
print(df_cleaned.loc['2023-01-28':'2023-02-02'])


# --------------------------------------------------------------------------
# 📈 ขั้นตอนที่ 3: การคำนวณค่าเฉลี่ยเคลื่อนที่ (Calculating Rolling Average)
# --------------------------------------------------------------------------
WINDOW_SIZE = 7 # กำหนดขนาดหน้าต่างเป็น 7 วัน

# คำนวณค่าเฉลี่ยเคลื่อนที่ 7 วัน สำหรับปริมาณน้ำฝน
# .rolling(window=W) สร้างหน้าต่างข้อมูล
# .mean() คำนวณค่าเฉลี่ยภายในหน้าต่างนั้น
df_cleaned['Rainfall_MA_7D'] = df_cleaned['Rainfall_mm'].rolling(window=WINDOW_SIZE).mean()

# คำนวณค่าเฉลี่ยเคลื่อนที่ 7 วัน สำหรับอุณหภูมิ
df_cleaned['Temperature_MA_7D'] = df_cleaned['Temperature_C'].rolling(window=WINDOW_SIZE).mean()

print(f"\n--- ข้อมูลหลังการคำนวณ Rolling Average ({WINDOW_SIZE} วัน) ---")
# แสดงเฉพาะคอลัมน์ที่เกี่ยวข้องเพื่อความชัดเจน
print(df_cleaned[['Rainfall_mm', 'Rainfall_MA_7D', 'Temperature_C', 'Temperature_MA_7D']].head(10))


# --------------------------------------------------------------------------
# 📊 ขั้นตอนที่ 4: การแสดงผลด้วยกราฟ (Visualization using Seaborn/Matplotlib)
# --------------------------------------------------------------------------
# การสร้างกราฟสำหรับปริมาณน้ำฝน (Rainfall)
plt.figure(figsize=(14, 6))

# 1. พล็อตข้อมูลดิบ (Raw Data)
plt.plot(df_cleaned.index, df_cleaned['Rainfall_mm'], label='ปริมาณน้ำฝนรายวัน (Raw Data)', color='skyblue', alpha=0.6)

# 2. พล็อตแนวโน้ม (Trend Line)
# เนื่องจาก Rolling Average จะมีค่า NaN ในช่วง 6 วันแรก (เพราะต้องใช้ 7 วัน)
# เราจึงใช้ .dropna() เพื่อให้กราฟแสดงผลเฉพาะช่วงที่คำนวณได้
plt.plot(df_cleaned.index, df_cleaned['Rainfall_MA_7D'], label=f'ค่าเฉลี่ยเคลื่อนที่ 7 วัน (MA-{WINDOW_SIZE}D)', color='darkblue', linewidth=2.5)

plt.title('แนวโน้มปริมาณน้ำฝนสะสมรายสัปดาห์ (Weekly Rainfall Trend)', fontsize=16, pad=20)
plt.xlabel('วันที่ (Date)', fontsize=14)
plt.ylabel('ปริมาณน้ำฝน (mm)', fontsize=14)
plt.legend(loc='upper right')
plt.grid(True, linestyle='--', alpha=0.7)
plt.tight_layout()
plt.show()


# การสร้างกราฟสำหรับอุณหภูมิ (Temperature)
plt.figure(figsize=(14, 6))

# 1. พล็อตข้อมูลดิบ (Raw Data)
plt.plot(df_cleaned.index, df_cleaned['Temperature_C'], label='อุณหภูมิรายวัน (Raw Data)', color='salmon', alpha=0.6)

# 2. พล็อตแนวโน้ม (Trend Line)
plt.plot(df_cleaned.index, df_cleaned['Temperature_MA_7D'], label=f'ค่าเฉลี่ยเคลื่อนที่ 7 วัน (MA-{WINDOW_SIZE}D)', color='red', linewidth=2.5)

plt.title('แนวโน้มอุณหภูมิเฉลี่ยรายสัปดาห์ (Weekly Temperature Trend)', fontsize=16, pad=20)
plt.xlabel('วันที่ (Date)', fontsize=14)
plt.ylabel('อุณหภูมิเฉลี่ย (°C)', fontsize=14)
plt.legend(loc='upper right')
plt.grid(True, linestyle='--', alpha=0.7)
plt.tight_layout()
plt.show()
```

---

## 4. การวิเคราะห์เชิงลึกและข้อสรุปทางวิชาการ
*(In-Depth Analysis and
