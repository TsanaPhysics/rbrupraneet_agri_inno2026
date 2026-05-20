import json
import os

cnn_sessions = [
    # Phase A: OpenCV
    {
        "id": "cnn-session-1",
        "title": "ด่านแรก: พิกเซลและสีสัน (Pixels & Colors)",
        "desc": "คอมพิวเตอร์มองภาพไม่ใช่รูปร่าง แต่เป็นตารางตัวเลข (Matrix) สามมิติ (R, G, B) เริ่มเรียนรู้การเปิดภาพเข้าสู่หน่วยความจำของ AI",
        "xr_image": "assets/images/sim/tree_healthy.png",
        "xr_caption": "XR Simulator: แสดงภาพ 3D อาเรย์ของใบไม้ที่คอมพิวเตอร์มองเห็น",
        "examples": [
            {
                "title": "เปิดภาพด้วย OpenCV",
                "code": "import cv2\nimport matplotlib.pyplot as plt\n\n# โหลดภาพใบไม้และสลับค่าสี BGR สู่ RGB ให้สีสมจริง\nimg = cv2.imread('leaf.jpg')\nimg_rgb = cv2.cvtColor(img, cv2.COLOR_BGR2RGB)\n\nplt.imshow(img_rgb)\nplt.title('Original Leaf')\nplt.show()"
            },
            {
                "title": "ชำแหละพิกเซล (Matrix Slice)",
                "code": "# ดึงค่าสีจากมุมซ้ายบนของภาพ (ตำแหน่งพิกเซล (10,10))\npixel_color = img_rgb[10, 10]\nprint(f'สี RGB: Red={pixel_color[0]}, Green={pixel_color[1]}, Blue={pixel_color[2]}')"
            },
            {
                "title": "ย้อมสีวิเคราะห์โรค (Grayscale)",
                "code": "# แปลงภาพเป็นโหมดขาวดำ เพื่อลดความซับซ้อนให้ AI\ngray_img = cv2.cvtColor(img, cv2.COLOR_BGR2GRAY)\n\nplt.imshow(gray_img, cmap='gray')\nplt.title('Grayscale Analysis')\nplt.show()"
            }
        ]
    },
    {
        "id": "cnn-session-2",
        "title": "หาร่องรอย (Feature Extraction)",
        "desc": "ตรวจจับรอยขอบใบ รอยกัดแมลง หรือรอยโรคบนใบไม้ผ่านกระบวนการ Edge Detection",
        "xr_image": "assets/images/sim/tree_diseased.png",
        "xr_caption": "Hologram: เน้นเส้นขอบเรืองแสงสีเขียวบนรอยโรคใบไหม้",
        "examples": [
            {
                "title": "เบลอภาพเพื่อลดจุดรบกวน",
                "code": "# เบลอภาพแบบ Gaussian ก่อนหาขอบ เพื่อลดสิ่งสกปรกบนใบพืช\nblurred = cv2.GaussianBlur(gray_img, (5, 5), 0)\nplt.imshow(blurred, cmap='gray')\nplt.show()"
            },
            {
                "title": "ใช้งาน Canny Edge Detector",
                "code": "# ตรวจจับเส้นขอบ โดยปรับลดตัวเลข 50 และ 150 เพื่อรับความไวแสง\nedges = cv2.Canny(blurred, 50, 150)\nplt.imshow(edges, cmap='gray')\nplt.title('Leaf Edge Detection')\nplt.show()"
            },
            {
                "title": "ตีกรอบรอบรอยโรค (Bounding Box)",
                "code": "# ค้นหา Object ในภาพ\ncontours, _ = cv2.findContours(edges.copy(), cv2.RETR_EXTERNAL, cv2.CHAIN_APPROX_SIMPLE)\n\nimg_copy = img_rgb.copy()\ncv2.drawContours(img_copy, contours, -1, (255, 0, 0), 2)\n\nplt.imshow(img_copy)\nplt.show()"
            }
        ]
    },
    {
        "id": "cnn-session-3",
        "title": "ครอบตัดจุดตาย (Precision Cropping)",
        "desc": "ตัดส่วนของใบไม้ที่ไม่เกี่ยวข้องออก เพื่อให้ AI โฟกัสเฉพาะจุดที่มีรอยโรค",
        "xr_image": "assets/images/activities/cnn_plant_lab.png",
        "xr_caption": "Visualizer: ภาพซูมมาโครเนื้อเยื่อพืชผ่านกล้อง 3D",
        "examples": [
            {
                "title": "Matrix Slicing 101",
                "code": "# ตัดภาพให้เหลือเฉพาะตรงกลางแกน Y และ X\ncropped_leaf = img_rgb[100:400, 200:500]\nplt.imshow(cropped_leaf)\nplt.title('Cropped Disease Area')\nplt.show()"
            },
            {
                "title": "ย่อขยายขนาด (Resizing)",
                "code": "# บีบขนาดถาพให้เป็น 224x224 พิกเซล เตรียมป้อนเข้าสู่โมเดล\nresized_leaf = cv2.resize(cropped_leaf, (224, 224))\nprint('ขนาดภาพใหม่:', resized_leaf.shape)\nplt.imshow(resized_leaf)\nplt.show()"
            },
            {
                "title": "กรองสีเฉพาะใบ (Color Masking)",
                "code": "import numpy as np\n# แปลงเป็น HSV แล้วคัดลอกเฉพาะพื้นที่สีเขียว\nhsv_img = cv2.cvtColor(img, cv2.COLOR_BGR2HSV)\nlower_green = np.array([35, 40, 40])\nupper_green = np.array([85, 255, 255])\n\nmask = cv2.inRange(hsv_img, lower_green, upper_green)\nresult = cv2.bitwise_and(img_rgb, img_rgb, mask=mask)\n\nplt.imshow(result)\nplt.show()"
            }
        ]
    },
    {
        "id": "cnn-session-4",
        "title": "จัดการคลังภาพ (Dataset Prep)",
        "desc": "จัดการโฟลเดอร์รูปภาพของกลุ่มพืชที่ปกติดี (Healthy) และพืชที่ติดโรค (Diseased)",
        "xr_image": "assets/images/activities/cnn_lab.png",
        "xr_caption": "AI System Directory: จำลองการจัดกลุ่มหมวดหมู่ภาพหลายล้านภาพอัตโนมัติ",
        "examples": [
            {
                "title": "ตรวจเช็กโฟลเดอร์ด้วย Python OS",
                "code": "import os\n\ndataset_path = 'dataset/train/'\nclasses = os.listdir(dataset_path)\nprint('พบประเภทของโรคในระบบ:', classes)"
            },
            {
                "title": "นับจำนวนทหาร (Count Files)",
                "code": "# นับจำนวนรูปทั้งหมดในแต่ละหมวด\nfor cls in classes:\n    count = len(os.listdir(f'{dataset_path}/{cls}'))\n    print(f'หมวดหมู่ {cls} มีรูปภาพให้เรียนรู้ {count} รูป')"
            },
            {
                "title": "อ่านภาพเป็นชุด (Batch Load)",
                "code": "import glob\n\n# โหลดรูปทั้งหมดที่เป็น .jpg และเก็บไว้ในตัวแปร List\nhealthy_images = glob.glob(dataset_path + 'healthy/*.jpg')\nprint(f'โหลดรวบยอดทั้งหมดสำเร็จ {len(healthy_images)} รายการ')"
            }
        ]
    },
    
    # Phase B: Data Pipeline
    {
        "id": "cnn-session-5",
        "title": "จำลองพันธุกรรมข้อมูล (Data Augmentation)",
        "desc": "เพิ่มจำนวนภาพให้ AI ด้วยการสร้างภาพเสมือนใหม่ เช่น พลิกภาพ หมุนภาพ ปรับแสงให้มืดหรือสว่าง",
        "xr_image": "assets/images/sim/tree_healthy.png",
        "xr_caption": "Simulator: หมุนมุมกล้อง 3D เพื่อสร้างความซับซ้อนให้ AI สังเกต",
        "examples": [
            {
                "title": "เซ็ตอัพ ImageDataGenerator",
                "code": "from tensorflow.keras.preprocessing.image import ImageDataGenerator\n\n# ตั้งค่าการผสมภาพ\ndatagen = ImageDataGenerator(\n    rotation_range=30,\n    zoom_range=0.2,\n    horizontal_flip=True\n)\nprint('เตรียมเครื่องปั่นภาพสำเร็จ')"
            },
            {
                "title": "สร้างภาพแฝดผ่านโค้ด",
                "code": "import numpy as np\n# เปลี่ยนภาพเป็น Array แล้วทดลองสุ่มสร้าง 5 รูป\nimg_array = np.expand_dims(resized_leaf, 0)\naug_iter = datagen.flow(img_array, batch_size=1)\n\nfor i in range(3):\n    batch = next(aug_iter)\n    image = batch[0].astype('uint8')\n    plt.imshow(image); plt.show()"
            },
            {
                "title": "Normalization สู่ 0-1",
                "code": "# แปลงค่าพิกเซล 0-255 ให้กลายเป็นทศนิยม\nnormalized_dataset = ImageDataGenerator(rescale=1./255)\nprint('ลดทอนสัญญาณทุกภาพเพื่อการคำนวณที่รวดเร็วขึ้น!')"
            }
        ]
    },
    {
        "id": "cnn-session-6",
        "title": "เชื่อมท่อส่งข้อมูล (Data Flow Generator)",
        "desc": "สั่งให้ Python ดึงข้อมูลจากโฟลเดอร์ค่อยๆ ทยอยป้อนเข้า AI เป็น Batch เพื่อไม่ให้ RAM เต็ม",
        "xr_image": "assets/images/activities/cnn_plant_lab.png",
        "xr_caption": "System Diagram: แสดงท่อข้อมูล Data Pipeline เข้าชิปประมวลผล",
        "examples": [
            {
                "title": "ผูกท่อเข้ากับโฟลเดอร์ (Flow from Directory)",
                "code": "train_generator = normalized_dataset.flow_from_directory(\n    'dataset/train/',\n    target_size=(224, 224),\n    batch_size=32,\n    class_mode='categorical'\n)\nprint('ท่อส่งข้อมูล Train พร้อมทำงาน')"
            },
            {
                "title": "ผูกท่อตรวจสอบ (Validation Flow)",
                "code": "val_generator = normalized_dataset.flow_from_directory(\n    'dataset/val/',\n    target_size=(224, 224),\n    batch_size=32,\n    class_mode='categorical'\n)\nprint('ท่อส่งข้อมูล Validation พร้อมทำงาน')"
            },
            {
                "title": "ตรวจสอบ Class Index",
                "code": "# ตรวจสอบว่า AI กำหนดรหัส 0, 1, 2 ให้กับโรคใดบ้าง\nlabels = (train_generator.class_indices)\nprint('รหัสโรคพืชที่จะเรียนรู้:', labels)"
            }
        ]
    },
    {
        "id": "cnn-session-7",
        "title": "ชั้นสกลัดลอจิก (The Secret of Tensors)",
        "desc": "แปลงรูปภาพทั้งหมดให้กลายเป็นมิติข้อมูล (Tensors) ก้อนใหญ่ที่สุดสำหรับ Deep Learning",
        "xr_image": "assets/images/activities/cnn_lab.png",
        "xr_caption": "XR Tensor Viz: กราฟิกแท่ง 3 มิติแสดงมิติข้อมูล Tensor (B, W, H, C)",
        "examples": [
            {
                "title": "การสำรวจ Tensor Shape",
                "code": "# สุ่มดึงภาพมา 1 Batch (32 รูป)\nx_batch, y_batch = next(train_generator)\n\n# รูปทรงจะออกมาเป็น (32, 224, 224, 3)\nprint('รูปแบบของ Tensor ขาเข้า:', x_batch.shape)"
            },
            {
                "title": "การเช็ก Labels Tensors",
                "code": "print('รูปแบบของคำตอบขาเข้า (หมวดหมู่โรค):', y_batch.shape)\nprint('ตัวอย่างคำตอบแบบ One-hot encoding:', y_batch[0])"
            },
            {
                "title": "แปลงคืนเป็นภาพมนุษย์",
                "code": "# ลองเอาค่า Tensor แปลงกลับมาให้คนดู\nsample = x_batch[0]\nplt.imshow(sample)\nplt.title('Tensor Recovered')\nplt.show()"
            }
        ]
    },
    {
        "id": "cnn-session-8",
        "title": "หัวใจเครื่องจักร (The Neural Architecture)",
        "desc": "เริ่มต้นนำเลโก้มาต่อกันเป็นสมอง AI (Keras Sequential) โดยจะเริ่มจากชั้น Input Layer",
        "xr_image": "assets/images/sim/agri_bot.png",
        "xr_caption": "Blueprint: แปลนโครงสร้างสมองหุ่นยนต์พ่นยาอัจฉริยะ",
        "examples": [
            {
                "title": "สร้างโครงข่ายเปล่า",
                "code": "from tensorflow.keras.models import Sequential\nfrom tensorflow.keras.layers import Conv2D, MaxPooling2D, Flatten, Dense\n\n# สร้างภาชนะรับสมองกล\nmodel = Sequential()\nprint('เปิดระบบ Sequential สำเร็จ')"
            },
            {
                "title": "สร้างตามดวงตา CNN",
                "code": "# เพิ่มชั้น Conv2D ทำหน้าที่กวาดสายตาหาเส้นขอบ\nmodel.add(Conv2D(32, (3,3), activation='relu', input_shape=(224, 224, 3)))\nprint('ชั้นตรวจจับและ Activation ReLU ถูกติดตั้ง')"
            },
            {
                "title": "การย่อขนาด (MaxPooling)",
                "code": "# ย่อขนาดฟิลเจอร์ลงครึ่งหนึ่งเพื่อให้ประมวลผลเร็วขึ้น\nmodel.add(MaxPooling2D(pool_size=(2, 2)))\nprint('เพิ่มชั้นลดความซับซ้อน Pooling Layer พร้อมแล้ว')"
            }
        ]
    },
    
    # Phase C: CNN Deep Learning
    {
        "id": "cnn-session-9",
        "title": "ต่อยอดสมองสู่ปัญญาชน (Deep Architecture)",
        "desc": "ประกอบเลเยอร์ Dense Network (โครงข่ายประสาทลึก) เพื่อนำจุดเด่นมารวบรวมและตัดสินใจหาโรค",
        "xr_image": "assets/images/sim/tree_diseased.png",
        "xr_caption": "Neural Tree: โครงข่ายเส้นเลเซอร์เชื่อมโยงจุดพิกเซลต่อเข้าด้วยกัน",
        "examples": [
            {
                "title": "แบนข้อมูลด้วย Flatten",
                "code": "# ปรับภาพ 2D ให้แบนลงเป็น 1 เส้นตรงมิติ\nmodel.add(Flatten())\nprint('แบนข้อมูลเป็น 1 มิติเรียบร้อย เพื่อเตรียมเข้า Dense')"
            },
            {
                "title": "เครือข่ายความรู้ (Dense)",
                "code": "# เพิ่มเซลล์สมองเทียม 128 เซลล์\nmodel.add(Dense(128, activation='relu'))\n# ชั้นส่งออก (Output) ตามจำนวน 3 คลาสด้วยแกนคณิตศาสตร์ Softmax\nmodel.add(Dense(3, activation='softmax'))"
            },
            {
                "title": "ตรวจสอบสถาปัตยกรรม (Summary)",
                "code": "# สถาปนิกตรวจพารามิเตอร์รวม\nmodel.summary()"
            }
        ]
    },
    {
        "id": "cnn-session-10",
        "title": "ระเบียบการเรียน (Compile Models)",
        "desc": "ก่อนจะเริ่มเรียน ต้องสั่งให้ AI รู้ตัวว่าจะวัดคะแนนยังไง (Accuracy) และใช้ Optimizer ตัวไหน",
        "xr_image": "assets/images/activities/cnn_plant_lab.png",
        "xr_caption": "Loss Simulator: กราฟิกจำลองการทำงานสูตรคณิตศาสตร์เพื่อลดค่าความผิดพลาดลง",
        "examples": [
            {
                "title": "ฝังระบบ Optimizer แบบ Adam",
                "code": "from tensorflow.keras.optimizers import Adam\n\n# Adam คือผู้ช่วยคำนวณทิศทางการปรับลดค่าผิดพลาดให้แม่นสุด\nopt = Adam(learning_rate=0.001)\nprint('Optimizer Adam is loaded!')"
            },
            {
                "title": "ผูกสมการเรียนรู้",
                "code": "# ใช้ categorical_crossentropy เพราะเรามีเป้าหมายมากกว่า 2 โรค\nmodel.compile(optimizer=opt,\n              loss='categorical_crossentropy',\n              metrics=['accuracy'])"
            },
            {
                "title": "เตรียมระบบหยุดฉุกเฉิน (Early Stopping)",
                "code": "from tensorflow.keras.callbacks import EarlyStopping\n\n# จะหยุดเรียนทันทีถ้า Loss ไม่ลดลงต่อเนื่อง 5 รอบ เพื่อป้องกันการจำข้อสอบ (Overfit)\nstop_early = EarlyStopping(monitor='val_loss', patience=5)\nprint('เปิดระบบเซฟตี้ Guardian พร้อม!')"
            }
        ]
    },
    {
        "id": "cnn-session-11",
        "title": "ฝึกฝนสุนัขดมกลิ่น (Training AI)",
        "desc": "ขั้นตอนการเดินเครื่องรันโค้ดประมวลผล GPU ในช่วง Epochs ให้นักเรียนสังเกตพัฒนาการความฉลาดในแต่ละรอบคล้ายกับการฝึกสุนัขดมกลิ่น",
        "xr_image": "assets/images/sim/agri_drone.png",
        "xr_caption": "Drone Simulator: ภาพโฮโลแกรมโดรนกำลังสแกนเรียนรู้แผนที่สวน 3 มิติ",
        "examples": [
            {
                "title": "ปล่อยพลังประมวลผล (Model Fit)",
                "code": "# ให้นักเรียนลองปรับใช้ epochs=10\nhistory = model.fit(\n    train_generator,\n    epochs=10,\n    validation_data=val_generator,\n    callbacks=[stop_early]\n)\nprint('การหล่อหลอมปัญญาประดิษฐ์เสร็จสิ้น!')"
            },
            {
                "title": "วิเคราะห์พัฒนาการผ่าน Plot",
                "code": "# ดึงประวัติมาวาดกราฟดูความแม่นยำรายรอบ (Accuracy)\nplt.plot(history.history['accuracy'], label='Train Acc', color='#10b981')\nplt.plot(history.history['val_accuracy'], label='Val Acc', color='#ef4444')\nplt.legend()\nplt.title('AI Learning Curve')\nplt.show()"
            },
            {
                "title": "บันทึกสมองกลสู่ไฟล์ .H5",
                "code": "# บันทึกน้ำหนักสมองเก็บไว้ เผื่อส่งต่อให้เพื่อนร่วมทีม\nmodel.save('rbru_plant_model.h5')\nprint('Saved Model Checkpoint Successfully!')"
            }
        ]
    },
    {
        "id": "cnn-session-12",
        "title": "ส่งมอบพลังสู่โลกกว้าง (Deploy to Drone)",
        "desc": "Capstone: บีบอัดสมอง AI ให้เบาที่สุดด้วยรหัส TFLite เพื่อทำการอัปโหลดปัญญาประดิษฐ์ลงสู่อากาศยานไร้คนขับ (Agri-Drone)",
        "xr_image": "assets/images/sim/agri_drone.png",
        "xr_caption": "XR Deployment: 3D Hologram ซิงโครไนซ์ไฟล์ TFLite ลงสู่บอร์ดโดรนไร้ขอบเขต",
        "examples": [
            {
                "title": "อัปโหลดโมเดลเข้าสู่วงจรบีบอัด",
                "code": "import tensorflow as tf\n\n# โหลดโมเดลตัวเต็มกลับขึ้นมา\nfull_model = tf.keras.models.load_model('rbru_plant_model.h5')\nconverter = tf.lite.TFLiteConverter.from_keras_model(full_model)\nprint('Ready to optimize for IoT Devices.')"
            },
            {
                "title": "คำสั่งแปลงสู่ TFLite",
                "code": "# กระบวนการ Quantization แปลงสมองเป็นไฟล์รหัสเบาสำหรับมือถือและโดรน\ntflite_model = converter.convert()\nwith open('drone_ai_vision.tflite', 'wb') as f:\n    f.write(tflite_model)\nprint('✅ แปลงไฟล์สำเร็จ: drone_ai_vision.tflite')"
            },
            {
                "title": "เปิดทดสอบเสมือนบน Drone",
                "code": "def drone_inference(image_sensor):\n    print('--- Drone Vision Engine ---')\n    print('Loading tflite...')\n    print('Scanning Leaves...')\n    return 'TARGET DETECTED: [Leaf Blight] - Action: Spraying 10ml fungicide'\n\n# เริ่มปฏิบัติการ\nprint(drone_inference('camera_frame_001.jpg'))"
            }
        ]
    }
]

file_path = 'data/cnn_sessions.json'
os.makedirs('data', exist_ok=True)
with open(file_path, 'w', encoding='utf-8') as f:
    json.dump(cnn_sessions, f, ensure_ascii=False, indent=4)

print(f"✅ Generated {len(cnn_sessions)} CNN sessions into {file_path}")
