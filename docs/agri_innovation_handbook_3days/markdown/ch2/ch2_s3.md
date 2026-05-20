## 2.3 ปฏิบัติการสะสมชุดภาพถ่าย การขยายข้อมูลภาพ การฝึกโมเดลบน Google Colab และการส่งออก TFLite

# 2.3 ปฏิบัติการสะสมชุดภาพถ่าย การขยายข้อมูลภาพ การฝึกโมเดลบน Google Colab และการส่งออก TFLite

---

## บทนำเชิงทฤษฎี (Theoretical Introduction)

ในสาขาปัญญาประดิษฐ์ (Artificial Intelligence, AI) โดยเฉพาะอย่างยิ่งในแขนงย่อยของคอมพิวเตอร์วิทัศน์ (Computer Vision) การพัฒนาแบบจำลอง (Model) ที่มีความแม่นยำสูงและสามารถนำไปใช้งานได้จริงในสภาพแวดล้อมที่หลากหลาย (Real-world Deployment) นั้น ไม่ได้ขึ้นอยู่กับความซับซ้อนของสถาปัตยกรรมโครงข่ายประสาทเทียม (Neural Network Architecture) เพียงอย่างเดียว แต่ยังขึ้นอยู่กับคุณภาพและปริมาณของชุดข้อมูลภาพถ่าย (Image Dataset) ที่ใช้ในการฝึกสอนเป็นสำคัญ

หัวข้อ 2.3 นี้ มุ่งเน้นการบูรณาการองค์ความรู้ทางฟิสิกส์ประยุกต์ (Applied Physics) และเกษตรดิจิทัล (Digital Agriculture) เข้ากับกระบวนการเรียนรู้ของเครื่อง (Machine Learning) โดยเฉพาะการจัดการชุดข้อมูลภาพถ่ายใบพืช (Plant Leaf Image Dataset) ตั้งแต่ขั้นตอนการเก็บข้อมูลภาคสนาม (Field Data Collection) การจัดการปัญหาความไม่สมดุลของข้อมูล (Data Imbalance) ด้วยเทคนิคการเพิ่มขยายข้อมูลภาพ (Data Augmentation) ไปจนถึงการปรับใช้โมเดลให้มีขนาดเล็กลงและมีประสิทธิภาพสูงสำหรับระบบประมวลผลปลายทาง (Edge Computing) ด้วยรูปแบบ TensorFlow Lite (TFLite)

---

## 2.3.1 กระบวนการเตรียมและรวบรวมชุดข้อมูลภาพถ่ายใบพืช (Dataset Collection Protocol)

การรวบรวมชุดข้อมูลภาพถ่าย (Dataset Collection) ที่มีคุณภาพถือเป็นขั้นตอนที่สำคัญที่สุด (Most Critical Step) ในวงจรชีวิตของโครงการ AI (AI Lifecycle) เนื่องจากประสิทธิภาพของแบบจำลอง (Model Performance) จะถูกจำกัดด้วยคุณภาพของข้อมูลที่ป้อนเข้าไป (Garbage In, Garbage Out Principle)

### 2.3.1.1 หลักการเก็บข้อมูลภาคสนาม (Field Data Acquisition Principles)

ในการเก็บภาพถ่ายใบพืชเพื่อจำแนกชนิดหรือตรวจจับโรค (Disease Detection) ต้องมีการวางแผนที่ครอบคลุมมิติทางกายภาพและสถิติ ดังนี้:

1.  **ความหลากหลายของสภาวะแวดล้อม (Environmental Variability):** ชุดข้อมูลต้องครอบคลุมภาพที่ถ่ายภายใต้สภาวะแสงที่แตกต่างกัน เช่น แสงแดดจ้า (High Illumination), แสงรำไร (Low Illumination), และเงา (Shadows) เนื่องจากความแปรปรวนของแสงส่งผลกระทบโดยตรงต่อค่าความสว่าง (Brightness) และความเปรียบต่าง (Contrast) ของภาพ
2.  **ความหลากหลายของมุมมอง (Viewpoint Variation):** ควรเก็บภาพจากมุมกล้องที่หลากหลาย (เช่น มุมสูง, มุมระดับสายตา) เพื่อให้แบบจำลองสามารถเรียนรู้คุณลักษณะของใบพืชได้โดยไม่ขึ้นอยู่กับมุมมองใดมุมมองหนึ่งโดยเฉพาะ
3.  **ความหลากหลายของโรคและระดับความรุนแรง (Disease and Severity Variation):** หากวัตถุประสงค์คือการตรวจจับโรค (Classification/Detection) ต้องมั่นใจว่าได้เก็บภาพตัวอย่างของโรคในระดับความรุนแรงที่แตกต่างกัน (เช่น ระยะเริ่มต้น, ระยะปานกลาง, ระยะรุนแรง) และต้องมีภาพตัวอย่างของใบพืชที่สุขภาพดี (Healthy Samples) ในปริมาณที่เพียงพอเพื่อเป็นคลาสควบคุม (Control Class)

### 2.3.1.2 การจัดโครงสร้างชุดข้อมูล (Dataset Structure)

ชุดข้อมูลควรถูกจัดโครงสร้างในรูปแบบที่สามารถเข้าถึงได้ง่ายสำหรับไลบรารีการเรียนรู้ของเครื่อง เช่น การจัดเก็บในโฟลเดอร์หลัก (Root Folder) ที่มีโฟลเดอร์ย่อยสำหรับแต่ละคลาส (Class-specific Subfolders)

สมมติให้เรามี 3 คลาส คือ 'Healthy', 'Disease A', และ 'Disease B' โครงสร้างจะเป็นดังนี้:

```
/Dataset_Root
├── /Train
│   ├── /Healthy
│   │   ├── img_001.jpg
│   │   ├── img_002.jpg
│   │   └── ...
│   ├── /Disease_A
│   │   ├── img_101.jpg
│   │   └── ...
│   └── /Disease_B
│       ├── img_201.jpg
│       └── ...
└── /Validation
    ├── /Healthy
    ├── /Disease_A
    └── /Disease_B
```

---

## 2.3.2 ปัญหาการเรียนรู้เกินและการแก้ไขด้วย Data Augmentation

### 2.3.2.1 ปัญหาการเรียนรู้เกิน (Overfitting)

**คำจำกัดความ:** การเรียนรู้เกิน (Overfitting) คือปรากฏการณ์ที่แบบจำลอง (Model) เรียนรู้คุณลักษณะเฉพาะ (Specific Features) ของชุดข้อมูลฝึกสอน (Training Data) มากเกินไป จนทำให้แบบจำลองมีความแม่นยำสูงมากบนชุดข้อมูลฝึกสอน แต่กลับมีประสิทธิภาพต่ำอย่างมากเมื่อนำไปทดสอบกับข้อมูลใหม่ที่ไม่เคยเห็นมาก่อน (Unseen Data)

**สาเหตุหลัก:** มักเกิดจากการที่แบบจำลองมีความซับซ้อนสูงเกินไป (High Model Capacity) เมื่อเทียบกับขนาดของชุดข้อมูล (Small Dataset Size) ทำให้แบบจำลองเริ่มจดจำ "สัญญาณรบกวน" (Noise) หรือรายละเอียดที่ไม่ใช่คุณลักษณะที่แท้จริงของคลาส (Irrelevant Details) แทนที่จะเรียนรู้รูปแบบ (Pattern) ที่เป็นสากล (Generalizable Pattern)

**การแก้ไข:** วิธีการแก้ไขที่สำคัญ ได้แก่ การลดความซับซ้อนของโมเดล (Regularization), การใช้ Dropout, และที่สำคัญที่สุดคือ **การเพิ่มขยายข้อมูลภาพ (Data Augmentation)**

### 2.3.2.2 หลักการเพิ่มขยายข้อมูลภาพ (Data Augmentation Theory)

**คำจำกัดความ:** Data Augmentation คือเทคนิคการสร้างตัวอย่างข้อมูลสังเคราะห์ (Synthetic Data Samples) จากชุดข้อมูลเดิม โดยการแปลงรูปภาพ (Image Transformation) ในรูปแบบที่ยังคงรักษาคุณลักษณะทางกายภาพ (Physical Characteristics) ของวัตถุนั้น ๆ ไว้ การทำเช่นนี้เป็นการเพิ่มขนาดของชุดข้อมูลฝึกสอนอย่างมีประสิทธิภาพ โดยไม่จำเป็นต้องเก็บภาพถ่ายใหม่ในภาคสนาม

**หลักการทางสถิติ:** หากชุดข้อมูลเดิม $D = \{(x_1, y_1), (x_2, y_2), \dots, (x_N, y_N)\}$ โดยที่ $x_i$ คือภาพและ $y_i$ คือป้ายกำกับ (Label) การทำ Data Augmentation จะสร้างชุดข้อมูลใหม่ $D' = \{(T(x_1), y_1), (T(x_2), y_2), \dots\}$ โดยที่ $T$ คือฟังก์ชันการแปลงภาพ (Transformation Function)

**เทคนิคที่ใช้บ่อย:**

1.  **การหมุนภาพ (Rotation):** การหมุนภาพรอบแกน (Rotation around an axis) ด้วยมุม $\theta$ โดยที่ $\theta \in [-\alpha, \alpha]$ องศา
2.  **การกลับภาพ (Flipping):** การสะท้อนภาพตามแกน (Reflection) เช่น การกลับแนวนอน (Horizontal Flip) หรือแนวตั้ง (Vertical Flip)
3.  **การเปลี่ยนระดับความสว่าง/ความเปรียบต่าง (Brightness/Contrast Adjustment):** การปรับค่าพิกเซล $P(x, y)$ ด้วยสมการเชิงเส้น (Linear Equation) เพื่อให้ได้ภาพใหม่ $P'(x, y)$:
    $$P'(x, y) = \alpha \cdot P(x, y) + \beta$$
    โดยที่ $\alpha$ คือตัวปรับความเปรียบต่าง (Contrast Factor) และ $\beta$ คือตัวปรับความสว่าง (Brightness Offset)

---

## 2.3.3 การปฏิบัติการบน Google Colab: การสร้างและฝึกโมเดล (Implementation on Google Colab)

เราจะใช้สภาพแวดล้อม Google Colaboratory (Colab) เนื่องจากมีการติดตั้งไลบรารีที่จำเป็น (TensorFlow, Keras, NumPy) และมีทรัพยากร GPU/TPU ให้ใช้งานโดยอัตโนมัติ

### 2.3.3.1 โค้ด Python สำหรับการเตรียมข้อมูลและการสร้างโมเดล

โค้ดชุดนี้จะครอบคลุมตั้งแต่การโหลดข้อมูล, การทำ Data Augmentation, การสร้างสถาปัตยกรรม CNN, การฝึกสอน, และการส่งออก TFLite

```python
# -*- coding: utf-8 -*-
"""
Module: Plant Disease Classification Pipeline
Author: รศ.ดร. [Your Name]
Date: 2024
Description: Pipeline for Image Classification using CNN, Data Augmentation, 
             and TFLite Export for Edge Computing.
"""

# 1. การนำเข้าไลบรารีที่จำเป็น (Importing Necessary Libraries)
import tensorflow as tf
from tensorflow.keras.models import Sequential
from tensorflow.keras.layers import Conv2D, MaxPooling2D, Flatten, Dense, Dropout
from tensorflow.keras.preprocessing.image import ImageDataGenerator
import numpy as np
import os
import time

print(f"TensorFlow Version: {tf.__version__}")

# 2. การกำหนดค่าพารามิเตอร์ (Defining Hyperparameters)
IMAGE_SIZE = 128  # ขนาดภาพที่ใช้ในการประมวลผล (Pixels)
BATCH_SIZE = 32   # จำนวนภาพต่อชุดข้อมูล (Samples per Batch)
NUM_CLASSES = 3   # จำนวนคลาส (Healthy, Disease A, Disease B)
EPOCHS = 15       # จำนวนรอบการฝึกสอน (Epochs)

# 3. การกำหนดเส้นทางชุดข้อมูล (Defining Data Paths)
# *** หมายเหตุ: ผู้ใช้ต้องอัปโหลดชุดข้อมูลไปยัง Google Drive หรือ Colab Environment ก่อน ***
# สมมติว่าชุดข้อมูลถูกจัดเก็บในโฟลเดอร์ 'dataset_root'
DATA_DIR = 'dataset_root' 
TRAIN_DIR = os.path.join(DATA_DIR, 'Train')
VALIDATION_DIR = os.path.join(DATA_DIR, 'Validation')

# ===================================================================================
# 4. การทำ Data Augmentation และการโหลดข้อมูล (Data Augmentation and Data Loading)
# ===================================================================================

print("\n[STEP 1/4] กำลังสร้าง Data Augmentation และเตรียม Data Generators...")

# 4.1 การสร้าง Data Augmentation Generator สำหรับชุดฝึกสอน (Training Data Generator)
# การใช้ ImageDataGenerator ช่วยให้เราสามารถทำ Data Augmentation ได้อย่างง่ายดาย
train_datagen = ImageDataGenerator(
    rescale=1./255,          # การปรับขนาดพิกเซล (Normalization) ให้เป็น [0, 1]
    rotation_range=20,      # การหมุนภาพได้สูงสุด 20 องศา (Rotation)
    width_shift_range=0.2,  # การเลื่อนภาพตามแนวกว้างได้สูงสุด 20% (Width Shift)
    height_shift_range=0.2, # การเลื่อนภาพตามแนวสูงได้สูงสุด 20% (Height Shift)
    shear_range=0.2,        # การเฉือนภาพ (Shear)
    zoom_range=0.2,         # การซูมภาพ (Zoom)
    horizontal_flip=True,   # การกลับภาพแนวนอน (Horizontal Flip)
    vertical_flip=False     # ไม่ทำการกลับภาพแนวตั้ง
)

# 4.2 การสร้าง Generator สำหรับชุดตรวจสอบ (Validation Data Generator)
# ชุดตรวจสอบต้องใช้การปรับขนาดพิกเซลเท่านั้น ห้ามทำการ Augmentation เพื่อให้การประเมินผลเป็นกลาง
validation_datagen = ImageDataGenerator(rescale=1./255)

# 4.3 การสร้าง Flow จาก Directory (Creating Data Flow from Directory)
# flow_from_directory จะจัดการการโหลดภาพและสร้าง Label One-Hot Encoding ให้โดยอัตโนมัติ
train_generator = train_datagen.flow_from_directory(
    TRAIN_DIR,
    target_size=(IMAGE_SIZE, IMAGE_SIZE),
    batch_size=BATCH_SIZE,
    class_mode='categorical' # ใช้ 'categorical' สำหรับการจำแนกหลายคลาส
)

validation_generator = validation_datagen.flow_from_directory(
    VALIDATION_DIR,
    target_size=(IMAGE_SIZE, IMAGE_SIZE),
    batch_size=BATCH_SIZE,
    class_mode='categorical'
)

print("✅ การโหลดข้อมูลและ Data Augmentation สำเร็จแล้ว.")

# ===================================================================================
# 5. การสร้างสถาปัตยกรรม CNN (Building the CNN Model Architecture)
# ===================================================================================

print("\n[STEP 2/4] กำลังสร้างสถาปัตยกรรม Convolutional Neural Network (CNN)...")

model = Sequential([
    # ชั้นคอนโวลูชันที่ 1 (Convolutional Layer 1)
    Conv2D(filters=32, kernel_size=(3, 3), activation='relu', input_shape=(IMAGE_SIZE, IMAGE_SIZE, 3)),
    MaxPooling2D(pool_size=(2, 2)), # การลดมิติภาพ (Pooling)
    
    # ชั้นคอนโวลูชันที่ 2 (Convolutional Layer 2)
    Conv2D(filters=64, kernel_size=(3, 3), activation='relu'),
    MaxPooling2D(pool_size=(2, 2)),
    
    # ชั้นคอนโวลูชันที่ 3 (Convolutional Layer 3)
    Conv2D(filters=128, kernel_size=(3, 3), activation='relu'),
    MaxPooling2D(pool_size=(2, 2)),
    
    # การทำให้เป็นระนาบ (Flattening) เพื่อเตรียมข้อมูลเข้าสู่ชั้น Dense
    Flatten(),
    
    # ชั้น Dropout เพื่อป้องกัน Overfitting (Regularization)
    Dropout(0.5), 
    
    # ชั้น Dense (Fully Connected Layer)
    Dense(512, activation='relu'),
    
    # ชั้น Output Layer: ใช้ Softmax สำหรับการจำแนกหลายคลาส
    Dense(NUM_CLASSES, activation='softmax')
])

# 5.1 การคอมไพล์โมเดล (Compiling the Model)
model.compile(
    optimizer='adam', # ตัวปรับค่าพารามิเตอร์ (Optimizer) ที่มีประสิทธิภาพ
    loss='categorical_crossentropy', # ฟังก์ชันความสูญเสีย (Loss Function) สำหรับ Multi-class
    metrics=['accuracy'] # ตัวชี้วัดประสิทธิภาพ (Metric)
)

model.summary()

# ===================================================================================
# 6. การฝึกสอนโมเดล (Model Training)
# ===================================================================================

print("\n[STEP 3/4] เริ่มต้นการฝึกสอนโมเดล (Model Training)...")

start_time = time.time()

history = model.fit(
    train_generator,
    steps_per_epoch=train_generator.samples // BATCH_SIZE,
    epochs=EPOCHS,
    validation_data=validation_generator,
    validation_steps=validation_generator.samples // BATCH_SIZE
)

end_time = time.time()
print(f"\n✅ การฝึกสอนโมเดลเสร็จสมบูรณ์ ใช้เวลา: {end_time - start_time:.2f} วินาที")

# 6.1 การบันทึกโมเดลที่ฝึกเสร็จแล้ว (Saving the Trained Model)
model_save_path = 'plant_cnn_model.h5'
model.save(model_save_path)
print(f"💾 บันทึกโมเดลขนาดเต็มที่: {model_save_path}")

# ===================================================================================
# 7. การส่งออกโมเดลเป็น TensorFlow Lite (TFLite Export for Edge Computing)
# ===================================================================================

print("\n[STEP 4/4] กำลังแปลงและส่งออกโมเดลเป็น TFLite Format...")

# 7.1 การสร้างตัวแทน (Representative Dataset) สำหรับการแปลง
# TFLite ต้องการข้อมูลตัวอย่างเพื่อกำหนดประเภทข้อมูล (Data Type) ที่เหมาะสม
# เราใช้ข้อมูลจากชุดตรวจสอบ (Validation Generator)
representative_data = lambda: next(validation_generator)

# 7.2 การแปลงโมเดล (Conversion)
# 7.3 กำหนดฟังก์ชันสำหรับการสร้างข้อมูลตัวแทนเพื่อทำ Quantization
def representative_dataset_gen():
    for _ in range(100):
        # รับภาพตัวอย่างจาก generator
        X, _ = next(validation_generator)
        # ส่งข้อมูลภาพตัวอย่างออกไปทีละภาพ
        for img in X:
            yield [np.expand_dims(img, axis=0).astype(np.float32)]

# การนำไปใช้งานกับการทำ Integer Quantization เพื่อลดขนาดลง 4 เท่า
converter.representative_dataset = representative_dataset_gen
converter.target_spec.supported_ops = [tf.lite.OpsSet.TFLITE_BUILTINS_INT8]
converter.inference_input_type = tf.uint8
converter.inference_output_type = tf.uint8

tflite_quant_model = converter.convert()

# 7.4 บันทึกไฟล์โมเดล TFLite ลงในระบบ
tflite_save_path = 'plant_model_quantized.tflite'
with open(tflite_save_path, 'wb') as f:
    f.write(tflite_quant_model)

print(f"✅ แปลงและบันทึกโมเดล TFLite เรียบร้อย: {tflite_save_path}")
print(f"📦 ขนาดไฟล์เดิม: {os.path.getsize(model_save_path) / (1024*1024):.2f} MB")
print(f"📦 ขนาดไฟล์ TFLite หลังทำ Quantization: {os.path.getsize(tflite_save_path) / (1024*1024):.2f} MB")
```

