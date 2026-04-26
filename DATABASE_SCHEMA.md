# Database Schema & ERD - Fleet Management System

## نظرة عامة على الجداول

هذا الملف يشرح بنية قاعدة البيانات والعلاقات بين الجداول.

---

## جداول المشروع

### 1️⃣ الجدول الأساسي: Users (IAM)
```sql
CREATE TABLE users (
    user_id BIGINT PRIMARY KEY IDENTITY(1,1),
    
    -- البيانات الأساسية
    name NVARCHAR(255) NOT NULL,
    email NVARCHAR(255) UNIQUE NOT NULL,
    phone NVARCHAR(20),
    
    -- المصادقة
    password NVARCHAR(255) NOT NULL,
    email_verified_at DATETIME NULL,
    
    -- الأدوار والصلاحيات
    role NVARCHAR(50) NOT NULL, -- admin, supervisor, driver, technician, customer
    is_active BIT DEFAULT 1,
    
    -- الـ Timestamps
    created_at DATETIME DEFAULT GETUTCDATE(),
    updated_at DATETIME DEFAULT GETUTCDATE(),
    deleted_at DATETIME NULL,
    
    INDEX idx_email (email),
    INDEX idx_role (role),
    INDEX idx_is_active (is_active)
);
```

---

### 2️⃣ جدول المركبات: Vehicles (FleetMonitoring)
```sql
CREATE TABLE vehicles (
    vehicle_id BIGINT PRIMARY KEY IDENTITY(1,1),
    
    -- معلومات المركبة
    license_plate NVARCHAR(20) UNIQUE NOT NULL,
    brand NVARCHAR(100) NOT NULL,          -- Toyota, Mercedes, etc.
    model NVARCHAR(100) NOT NULL,          -- Hiace, Sprinter, etc.
    year INT NOT NULL,
    vin NVARCHAR(50) UNIQUE,               -- Vehicle Identification Number
    
    -- التصنيفات
    vehicle_type NVARCHAR(50) NOT NULL,    -- truck, van, car, motorcycle
    status NVARCHAR(50) DEFAULT 'active',  -- active, maintenance, damaged, retired
    
    -- المعلومات الشاملة
    purchase_date DATE,
    current_mileage DECIMAL(12,2),
    max_mileage_per_service DECIMAL(12,2),
    
    -- الملاك والمسؤول
    owner_id BIGINT,
    assigned_driver_id BIGINT,
    
    -- الـ Timestamps
    created_at DATETIME DEFAULT GETUTCDATE(),
    updated_at DATETIME DEFAULT GETUTCDATE(),
    deleted_at DATETIME NULL,
    
    -- الفهارس
    INDEX idx_license_plate (license_plate),
    INDEX idx_status (status),
    INDEX idx_assigned_driver_id (assigned_driver_id),
    
    -- المفاتيح الخارجية
    FOREIGN KEY (owner_id) REFERENCES users(user_id) ON DELETE SET NULL,
    FOREIGN KEY (assigned_driver_id) REFERENCES users(user_id) ON DELETE SET NULL
);
```

---

### 3️⃣ جدول الصيانة: Maintenance Trackers ✅
```sql
CREATE TABLE maintenance_trackers (
    maintenance_id BIGINT PRIMARY KEY IDENTITY(1,1),
    
    -- المراجع
    vehicle_id BIGINT NOT NULL,
    technician_id BIGINT,
    created_by BIGINT NOT NULL,
    updated_by BIGINT,
    
    -- تفاصيل الصيانة
    maintenance_type NVARCHAR(50) NOT NULL,  -- oil_change, repair, inspection, etc.
    status NVARCHAR(50) DEFAULT 'pending',   -- pending, scheduled, in-progress, completed, cancelled
    description NVARCHAR(MAX),
    
    -- التواريخ
    scheduled_date DATETIME NOT NULL,
    completion_date DATETIME,
    next_maintenance_date DATETIME,
    
    -- التكاليف والمواد
    cost DECIMAL(10,2),
    parts_replaced JSON,                     -- ["Oil Filter", "Air Filter"]
    
    -- الـ Timestamps
    created_at DATETIME DEFAULT GETUTCDATE(),
    updated_at DATETIME DEFAULT GETUTCDATE(),
    deleted_at DATETIME NULL,
    
    -- الفهارس
    INDEX idx_vehicle_id (vehicle_id),
    INDEX idx_status (status),
    INDEX idx_scheduled_date (scheduled_date),
    INDEX idx_created_at (created_at),
    UNIQUE INDEX idx_vehicle_status_date (vehicle_id, status, scheduled_date),
    
    -- المفاتيح الخارجية
    FOREIGN KEY (vehicle_id) REFERENCES vehicles(vehicle_id) ON DELETE CASCADE,
    FOREIGN KEY (technician_id) REFERENCES users(user_id) ON DELETE SET NULL,
    FOREIGN KEY (created_by) REFERENCES users(user_id) ON DELETE RESTRICT,
    FOREIGN KEY (updated_by) REFERENCES users(user_id) ON DELETE SET NULL
);
```

---

### 4️⃣ جدول سجل أنشطة الصيانة: Maintenance Activity Logs
```sql
CREATE TABLE maintenance_activity_logs (
    log_id BIGINT PRIMARY KEY IDENTITY(1,1),
    
    -- المراجع
    maintenance_id BIGINT NOT NULL,
    user_id BIGINT NOT NULL,
    
    -- تفاصيل النشاط
    action NVARCHAR(50) NOT NULL,           -- created, updated, status_changed, completed
    description NVARCHAR(MAX),
    changes JSON,                            -- {"status": "pending -> completed", "cost": "150 -> 200"}
    
    -- الـ Timestamp
    created_at DATETIME DEFAULT GETUTCDATE(),
    
    -- الفهارس
    INDEX idx_maintenance_id (maintenance_id),
    INDEX idx_created_at (created_at),
    
    -- المفاتيح الخارجية
    FOREIGN KEY (maintenance_id) REFERENCES maintenance_trackers(maintenance_id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);
```

---

### 5️⃣ جدول الـ Dispatch والتوجيه: Dispatches
```sql
CREATE TABLE dispatches (
    dispatch_id BIGINT PRIMARY KEY IDENTITY(1,1),
    
    -- المراجع
    vehicle_id BIGINT NOT NULL,
    driver_id BIGINT NOT NULL,
    route_id BIGINT,
    created_by BIGINT NOT NULL,
    
    -- تفاصيل الـ Dispatch
    status NVARCHAR(50) DEFAULT 'pending',  -- pending, assigned, in-progress, completed, cancelled
    description NVARCHAR(MAX),
    
    -- التواريخ والوقت
    scheduled_date DATE NOT NULL,
    estimated_start_time TIME,
    estimated_end_time TIME,
    actual_start_time DATETIME,
    actual_end_time DATETIME,
    
    -- الموقع
    pickup_location NVARCHAR(MAX),
    dropoff_location NVARCHAR(MAX),
    
    -- الـ Timestamps
    created_at DATETIME DEFAULT GETUTCDATE(),
    updated_at DATETIME DEFAULT GETUTCDATE(),
    deleted_at DATETIME NULL,
    
    -- الفهارس
    INDEX idx_status (status),
    INDEX idx_driver_id (driver_id),
    INDEX idx_scheduled_date (scheduled_date),
    
    -- المفاتيح الخارجية
    FOREIGN KEY (vehicle_id) REFERENCES vehicles(vehicle_id) ON DELETE CASCADE,
    FOREIGN KEY (driver_id) REFERENCES users(user_id) ON DELETE RESTRICT,
    FOREIGN KEY (created_by) REFERENCES users(user_id) ON DELETE RESTRICT
);
```

---

### 6️⃣ جدول المراقبة: Fleet Monitoring
```sql
CREATE TABLE fleet_monitoring (
    monitoring_id BIGINT PRIMARY KEY IDENTITY(1,1),
    
    -- المرجع
    vehicle_id BIGINT NOT NULL,
    
    -- موقع ومعلومات GPS
    latitude DECIMAL(10,8),
    longitude DECIMAL(11,8),
    altitude DECIMAL(10,2),
    
    -- حالة المركبة
    speed DECIMAL(10,2),                    -- كم/ساعة
    engine_temperature DECIMAL(5,2),
    fuel_level DECIMAL(5,2),               -- نسبة مئوية
    battery_voltage DECIMAL(5,2),
    
    -- الحالات والتنبيهات
    is_moving BIT DEFAULT 0,
    ignition_status BIT DEFAULT 0,
    alert_status NVARCHAR(50),             -- none, warning, critical
    
    -- الـ Timestamp
    recorded_at DATETIME DEFAULT GETUTCDATE(),
    
    -- الفهارس
    INDEX idx_vehicle_id (vehicle_id),
    INDEX idx_recorded_at (recorded_at),
    
    -- المفتاح الخارجي
    FOREIGN KEY (vehicle_id) REFERENCES vehicles(vehicle_id) ON DELETE CASCADE
);
```

---

### 7️⃣ جدول الإشعارات: Notifications
```sql
CREATE TABLE notifications (
    notification_id BIGINT PRIMARY KEY IDENTITY(1,1),
    
    -- المرجع
    user_id BIGINT NOT NULL,
    
    -- تفاصيل الإشعار
    type NVARCHAR(50),                     -- maintenance_reminder, alert, message, etc.
    title NVARCHAR(255) NOT NULL,
    message NVARCHAR(MAX),
    
    -- البيانات الإضافية
    data JSON,                             -- بيانات إضافية حسب النوع
    
    -- الحالة
    is_read BIT DEFAULT 0,
    read_at DATETIME,
    
    -- الـ Timestamps
    created_at DATETIME DEFAULT GETUTCDATE(),
    
    -- الفهارس
    INDEX idx_user_id (user_id),
    INDEX idx_is_read (is_read),
    INDEX idx_created_at (created_at),
    
    -- المفتاح الخارجي
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);
```

---

### 8️⃣ جدول التدقيق: System Audit Logs
```sql
CREATE TABLE system_audit_logs (
    audit_id BIGINT PRIMARY KEY IDENTITY(1,1),
    
    -- معلومات المستخدم والإجراء
    user_id BIGINT,
    action NVARCHAR(100) NOT NULL,         -- CREATE, UPDATE, DELETE, LOGIN, etc.
    module NVARCHAR(100),                  -- MaintenanceTracker, DispatchAndRouting, etc.
    
    -- تفاصيل
    entity_type NVARCHAR(100),             -- MaintenanceTracker, Dispatch, etc.
    entity_id BIGINT,
    description NVARCHAR(MAX),
    
    -- التغييرات
    old_values JSON,                       -- القيم القديمة
    new_values JSON,                       -- القيم الجديدة
    
    -- معلومات الطلب
    ip_address NVARCHAR(45),
    user_agent NVARCHAR(MAX),
    
    -- الـ Timestamp
    created_at DATETIME DEFAULT GETUTCDATE(),
    
    -- الفهارس
    INDEX idx_user_id (user_id),
    INDEX idx_action (action),
    INDEX idx_entity_type (entity_type),
    INDEX idx_created_at (created_at),
    
    -- المفتاح الخارجي
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE SET NULL
);
```

---

## Relationship Diagram (ERD)

```
┌─────────────────────────────────────────────────────────────────┐
│                                                                 │
│                  FLEET MANAGEMENT SYSTEM - ERD                 │
│                                                                 │
├─────────────────────────────────────────────────────────────────┤

                              ┌──────────┐
                              │  Users   │
                              │  (IAM)   │
                              └────┬─────┘
                                   │
                  ┌────────────────┼────────────────┐
                  │                │                │
                  │ (driver)       │ (technician)   │
                  │                │ (created_by)   │
                  ▼                ▼                │
            ┌──────────┐    ┌──────────────┐      │
            │ Vehicles │◄───┤ Dispatches   │      │
            └────┬─────┘    └──────────────┘      │
                 │                                 │
        ┌────────┼────────┐                        │
        │        │        │                        │
    (vehicle_id) │    (vehicle_id)                 │
        │        │        │                        │
        ▼        ▼        ▼                        │
    ┌───────────────────────────────┐             │
    │  Maintenance Trackers         │◄────────────┘
    │  (Maintenance Tracking)       │
    ├───────────────────────────────┤
    │ maintenance_id (PK)           │
    │ vehicle_id (FK)               │
    │ technician_id (FK)            │
    │ created_by (FK)               │
    │ updated_by (FK)               │
    │                               │
    │ maintenance_type              │
    │ status                        │
    │ scheduled_date                │
    │ completion_date               │
    │ cost                          │
    │ parts_replaced                │
    └───────────────────────────────┘
            │
            │ (maintenance_id)
            ▼
    ┌──────────────────────────────┐
    │ Maintenance Activity Logs     │
    │ (Activity Tracking)          │
    ├──────────────────────────────┤
    │ log_id (PK)                  │
    │ maintenance_id (FK)          │
    │ user_id (FK)                 │
    │ action                       │
    │ changes                      │
    │ created_at                   │
    └──────────────────────────────┘

            ┌──────────┐
            │ Vehicles │
            └────┬─────┘
                 │
                 │ (vehicle_id)
                 ▼
        ┌──────────────────────┐
        │ Fleet Monitoring     │
        │ (Real-time Tracking) │
        ├──────────────────────┤
        │ monitoring_id (PK)   │
        │ vehicle_id (FK)      │
        │ latitude             │
        │ longitude            │
        │ speed                │
        │ fuel_level           │
        │ recorded_at          │
        └──────────────────────┘

        ┌──────────┐
        │  Users   │
        └────┬─────┘
             │ (user_id)
             ▼
    ┌──────────────────────┐
    │ Notifications        │
    │ (Alerts & Messages)  │
    ├──────────────────────┤
    │ notification_id (PK) │
    │ user_id (FK)         │
    │ type                 │
    │ title                │
    │ message              │
    │ is_read              │
    │ created_at           │
    └──────────────────────┘

        ┌──────────┐
        │  Users   │
        └────┬─────┘
             │ (user_id)
             ▼
    ┌──────────────────────────┐
    │ System Audit Logs        │
    │ (System Monitoring)      │
    ├──────────────────────────┤
    │ audit_id (PK)            │
    │ user_id (FK)             │
    │ action                   │
    │ entity_type              │
    │ old_values               │
    │ new_values               │
    │ ip_address               │
    │ created_at               │
    └──────────────────────────┘
```

---

## العلاقات التفصيلية

### Users ↔ Vehicles
- **علاقة**: One-to-Many
- **شرح**: كل مستخدم (owner) يمكن أن يمتلك عدة مركبات
- **النوع**: owner_id في جدول vehicles

### Users ↔ Maintenance Trackers
- **علاقة**: One-to-Many
- **شرح**: كل فني يمكن أن يقوم بعدة صيانات
- **النوع**: technician_id, created_by في جدول maintenance_trackers

### Vehicles ↔ Maintenance Trackers
- **علاقة**: One-to-Many
- **شرح**: كل مركبة لها سجل صيانة
- **النوع**: vehicle_id في جدول maintenance_trackers

### Maintenance Trackers ↔ Activity Logs
- **علاقة**: One-to-Many
- **شرح**: كل صيانة لها سجل أنشطة
- **النوع**: maintenance_id في جدول maintenance_activity_logs

### Vehicles ↔ Fleet Monitoring
- **علاقة**: One-to-Many
- **شرح**: كل مركبة لها سجلات مراقبة حية
- **النوع**: vehicle_id في جدول fleet_monitoring

### Users ↔ Notifications
- **علاقة**: One-to-Many
- **شرح**: كل مستخدم يمكن أن يستقبل عدة إشعارات
- **النوع**: user_id في جدول notifications

### Users ↔ System Audit Logs
- **علاقة**: One-to-Many
- **شرح**: كل إجراء يتم تسجيله مع المستخدم
- **النوع**: user_id في جدول system_audit_logs

---

## نمط البيانات والمعايير

### Primary Keys (المفاتيح الأساسية)
```sql
-- استخدام BIGINT IDENTITY
user_id BIGINT PRIMARY KEY IDENTITY(1,1)
```

### Foreign Keys (المفاتيح الخارجية)
```sql
-- مع الإجراءات التلقائية
FOREIGN KEY (vehicle_id) 
    REFERENCES vehicles(vehicle_id) 
    ON DELETE CASCADE         -- حذف تلقائي للسجلات ذات الصلة
    ON UPDATE CASCADE         -- تحديث تلقائي للمفاتيح الأجنبية
```

### Indexes (الفهارس)
```sql
-- فهرس بسيط
INDEX idx_vehicle_id (vehicle_id)

-- فهرس مركب (لأداء أفضل)
INDEX idx_vehicle_status_date (vehicle_id, status, scheduled_date)

-- فهرس فريد (لضمان التفرد)
UNIQUE INDEX idx_license_plate (license_plate)
```

### Constraints (القيود)
```sql
-- NOT NULL - قيمة مطلوبة
name NVARCHAR(255) NOT NULL

-- DEFAULT - قيمة افتراضية
status NVARCHAR(50) DEFAULT 'pending'

-- UNIQUE - قيمة فريدة
email NVARCHAR(255) UNIQUE NOT NULL

-- CHECK - تحقق من القيمة
cost DECIMAL(10,2) CHECK (cost >= 0)
```

---

## SQL Server Specific Features

### JSON Support
```sql
-- تخزين JSON
parts_replaced JSON,

-- استعلام JSON
SELECT JSON_VALUE(parts_replaced, '$[0]') FROM maintenance_trackers

-- تحديث JSON
UPDATE maintenance_trackers 
SET parts_replaced = JSON_MODIFY(parts_replaced, '$[0]', 'New Value')
```

### Soft Deletes
```sql
-- تاريخ الحذف
deleted_at DATETIME NULL

-- استعلام بدون السجلات المحذوفة
SELECT * FROM maintenance_trackers WHERE deleted_at IS NULL

-- استعلام فقط السجلات المحذوفة
SELECT * FROM maintenance_trackers WHERE deleted_at IS NOT NULL
```

### DATETIME Functions
```sql
-- الوقت الحالي بـ UTC
DEFAULT GETUTCDATE()

-- التحويل بين الأوقات
CONVERT(NVARCHAR(50), created_at, 121) -- ISO format
```

---

## مثال: طلب معقد

```sql
-- الحصول على جميع الصيانات المتأخرة مع تفاصيل المركبة والفني
SELECT 
    m.maintenance_id,
    m.scheduled_date,
    m.status,
    v.license_plate,
    v.brand,
    u.name AS technician_name,
    DATEDIFF(DAY, m.scheduled_date, GETUTCDATE()) AS days_overdue
FROM 
    maintenance_trackers m
INNER JOIN 
    vehicles v ON m.vehicle_id = v.vehicle_id
LEFT JOIN 
    users u ON m.technician_id = u.user_id
WHERE 
    m.status = 'pending' 
    AND m.scheduled_date < GETUTCDATE()
    AND m.deleted_at IS NULL
ORDER BY 
    m.scheduled_date ASC;
```

---

## النسخ الاحتياطية والصيانة

### إنشاء نسخة احتياطية
```sql
BACKUP DATABASE FleetManagementDB 
TO DISK = 'C:\Backups\FleetManagementDB.bak'
WITH COMPRESSION;
```

### فحص التكامل
```sql
DBCC CHECKDB (FleetManagementDB);
```

### إعادة بناء الفهارس
```sql
ALTER INDEX ALL ON maintenance_trackers REBUILD;
```

---

**وثيقة قاعدة البيانات**: Fleet Management System
**آخر تحديث**: 2025-01-15
**الإصدار**: 2.0
