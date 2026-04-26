# 🚀 دليل البدء السريع - Fleet Management System

## المتطلبات

- **PHP**: 8.2+
- **Laravel**: 12.x
- **Database**: SQL Server 2019+
- **Composer**: آخر إصدار
- **Node.js**: 18+ (اختياري للأدوات الإضافية)

---

## التثبيت

### 1️⃣ استنساخ المستودع
```bash
git clone <repository-url>
cd FleetOps-Backend
```

### 2️⃣ تثبيت المكتبات
```bash
composer install
```

### 3️⃣ نسخ ملف البيئة
```bash
cp .env.example .env
```

### 4️⃣ إنشاء مفتاح التطبيق
```bash
php artisan key:generate
```

### 5️⃣ إعداد قاعدة البيانات

#### إنشاء قاعدة البيانات في SQL Server
```sql
CREATE DATABASE FleetManagementDB;
USE FleetManagementDB;
```

#### تحديث ملف .env
```env
DB_CONNECTION=sqlsrv
DB_HOST=127.0.0.1
DB_PORT=1433
DB_DATABASE=FleetManagementDB
DB_USERNAME=sa
DB_PASSWORD=your_password
```

### 6️⃣ تشغيل Migrations
```bash
php artisan migrate
```

### 7️⃣ تشغيل Seeders (اختياري)
```bash
php artisan db:seed
```

### 8️⃣ بدء خادم التطوير
```bash
php artisan serve
```

التطبيق الآن متاح على: `http://localhost:8000`

---

## الهيكل الأساسي

```
FleetOps-Backend/
├── app/
│   ├── Modules/                    # الموديولات المستقلة
│   │   ├── MaintenanceTracker/     # ✅ كمثال شامل
│   │   ├── IAM/
│   │   ├── DispatchAndRouting/
│   │   ├── DriverOps/
│   │   ├── FleetMonitoring/
│   │   ├── CustomerPortalAPI/
│   │   ├── NotificationEngine/
│   │   └── SystemAudit/
│   ├── Providers/
│   │   └── ModuleServiceProvider.php  # Service Provider
│   └── Http/
│       └── Controllers/
├── database/
│   └── migrations/                  # Database Schema
├── routes/
│   └── api.php                      # Main API Routes
├── ARCHITECTURE.md                  # 📖 المعمارية
├── API_DOCUMENTATION.md             # 📖 توثيق API
└── README.md                        # هذا الملف

```

---

## استكشاف الموديول

دعنا نستكشف موديول **MaintenanceTracker** كمثال:

### 📁 البنية
```
app/Modules/MaintenanceTracker/
├── Models/
│   └── MaintenanceTrackerModel.php
├── Repositories/
│   └── MaintenanceTrackerRepository.php
├── Services/
│   └── MaintenanceTrackerService.php
├── Controllers/
│   └── MaintenanceTrackerController.php
├── Requests/
│   └── MaintenanceTrackerRequest.php
└── routes.php
```

### 🔄 تدفق الطلب

```
API Request
    ↓
Router (routes.php)
    ↓
Controller (MaintenanceTrackerController)
    ↓
FormRequest Validation (MaintenanceTrackerRequest)
    ↓
Service (MaintenanceTrackerService)
    ↓
Repository (MaintenanceTrackerRepository)
    ↓
Model (MaintenanceTrackerModel)
    ↓
Database (SQL Server)
```

---

## أمثلة استخدام سريعة

### 1️⃣ الحصول على جميع الصيانات
```bash
curl -X GET http://localhost:8000/api/maintenance \
  -H "Authorization: Bearer YOUR_TOKEN"
```

### 2️⃣ إنشاء صيانة جديدة
```bash
curl -X POST http://localhost:8000/api/maintenance \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -d '{
    "vehicle_id": 1,
    "maintenance_type": "oil_change",
    "scheduled_date": "2025-02-01",
    "cost": 150.00,
    "created_by": 2
  }'
```

### 3️⃣ الصيانات المتأخرة
```bash
curl -X GET http://localhost:8000/api/maintenance/overdue \
  -H "Authorization: Bearer YOUR_TOKEN"
```

### 4️⃣ تحديث حالة صيانة
```bash
curl -X PATCH http://localhost:8000/api/maintenance/1/status \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -d '{
    "status": "completed"
  }'
```

---

## الأوامر المهمة

### Migrations
```bash
# تشغيل جميع Migrations
php artisan migrate

# التراجع عن آخر Migration
php artisan migrate:rollback

# إعادة تشغيل قاعدة البيانات
php artisan migrate:refresh

# إعادة التشغيل مع الـ Seeding
php artisan migrate:fresh --seed
```

### الإنتاجية
```bash
# حذف الـ Cache
php artisan cache:clear

# مسح جميع الـ Cache
php artisan optimize:clear

# إعادة بناء Autoloader
composer dump-autoload
```

### الإصلاح والصيانة
```bash
# فحص صحة التطبيق
php artisan health

# عرض معلومات الخادم
php artisan about

# اختبار الاتصال بـ Database
php artisan tinker
```

---

## الاختبارات

### تشغيل جميع الاختبارات
```bash
php artisan test
```

### اختبارات معينة
```bash
# اختبارات Feature فقط
php artisan test --testsuite=Feature

# اختبارات Unit فقط
php artisan test --testsuite=Unit

# اختبار ملف محدد
php artisan test tests/Feature/MaintenanceTest.php
```

---

## إضافة موديول جديد

### الخطوات

#### 1️⃣ أنشئ المجلدات
```bash
mkdir -p app/Modules/NewModule/{Models,Repositories,Services,Controllers,Requests}
touch app/Modules/NewModule/routes.php
```

#### 2️⃣ أنشئ الملفات الأساسية

**Model** (app/Modules/NewModule/Models/NewModuleModel.php):
```php
<?php
namespace App\Modules\NewModule\Models;
use Illuminate\Database\Eloquent\Model;

class NewModuleModel extends Model
{
    protected $table = 'new_modules';
    protected $fillable = ['name', 'description'];
}
```

**Repository** (يرث من BaseRepository):
```php
<?php
namespace App\Modules\NewModule\Repositories;
use App\Modules\Shared\Repositories\BaseRepository;
use App\Modules\NewModule\Models\NewModuleModel;

class NewModuleRepository extends BaseRepository
{
    public function __construct(NewModuleModel $model)
    {
        parent::__construct($model);
    }
}
```

**Service**:
```php
<?php
namespace App\Modules\NewModule\Services;
use App\Modules\NewModule\Repositories\NewModuleRepository;

class NewModuleService
{
    public function __construct(NewModuleRepository $repository)
    {
        $this->repository = $repository;
    }
}
```

**Controller** (Thin Controller):
```php
<?php
namespace App\Modules\NewModule\Controllers;
use App\Http\Controllers\Controller;
use App\Modules\NewModule\Services\NewModuleService;

class NewModuleController extends Controller
{
    public function __construct(NewModuleService $service)
    {
        $this->service = $service;
    }
}
```

**FormRequest**:
```php
<?php
namespace App\Modules\NewModule\Requests;
use Illuminate\Foundation\Http\FormRequest;

class NewModuleRequest extends FormRequest
{
    public function authorize() { return true; }
    
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ];
    }
}
```

**Routes** (app/Modules/NewModule/routes.php):
```php
<?php
use Illuminate\Support\Facades\Route;
use App\Modules\NewModule\Controllers\NewModuleController;

Route::prefix('new-module')->group(function () {
    Route::get('/', [NewModuleController::class, 'index']);
    Route::post('/', [NewModuleController::class, 'store']);
    Route::get('/{id}', [NewModuleController::class, 'show']);
    Route::put('/{id}', [NewModuleController::class, 'update']);
    Route::delete('/{id}', [NewModuleController::class, 'destroy']);
});
```

#### 3️⃣ سجل في ModuleServiceProvider

في `app/Providers/ModuleServiceProvider.php`:

```php
public function register()
{
    // تسجيل Repository كـ Singleton
    $this->app->singleton(
        \App\Modules\NewModule\Repositories\NewModuleRepository::class,
        function ($app) {
            return new \App\Modules\NewModule\Repositories\NewModuleRepository(
                new \App\Modules\NewModule\Models\NewModuleModel()
            );
        }
    );

    // تسجيل Service
    $this->app->singleton(
        \App\Modules\NewModule\Services\NewModuleService::class,
        function ($app) {
            return new \App\Modules\NewModule\Services\NewModuleService(
                $app->make(\App\Modules\NewModule\Repositories\NewModuleRepository::class)
            );
        }
    );
}
```

#### 4️⃣ أضف الموديول للقائمة

```php
protected $modules = [
    'IAM',
    'MaintenanceTracker',
    'NewModule',  // ← جديد
    // ...
];
```

#### 5️⃣ أنشئ Migration
```bash
php artisan make:migration create_new_modules_table
```

#### 6️⃣ شغل Migration
```bash
php artisan migrate
```

---

## العمل مع قاعدة البيانات

### Eloquent ORM

#### الاستعلامات البسيطة
```php
// الكل
$all = Maintenance::all();

// مع الفلترة
$pending = Maintenance::where('status', 'pending')->get();

// بـ ID
$one = Maintenance::find(1);

// الأول
$first = Maintenance::first();

// العد
$count = Maintenance::count();
```

#### العلاقات
```php
// تحميل العلاقات
$maintenance = Maintenance::with('vehicle', 'technician')->find(1);

// الوصول للعلاقات
echo $maintenance->vehicle->brand;
```

#### الإنشاء والتحديث والحذف
```php
// إنشاء
$maintenance = Maintenance::create(['vehicle_id' => 1, ...]);

// تحديث
$maintenance->update(['status' => 'completed']);

// حذف
$maintenance->delete();

// حذف منطقي (soft delete)
// بدلاً من الحذف النهائي، يتم تعيين deleted_at
```

---

## معالجة الأخطاء

### في Service
```php
try {
    return $this->repository->create($data);
} catch (Exception $e) {
    throw new Exception('خطأ: ' . $e->getMessage());
}
```

### في Controller
```php
try {
    $result = $this->service->create($request->validated());
    return response()->json(['success' => true, 'data' => $result]);
} catch (Exception $e) {
    return response()->json(['success' => false, 'message' => $e->getMessage()], 400);
}
```

---

## الأمان والأفضليات

### 🔒 الأمان
- استخدم FormRequest للتحقق من البيانات
- أضف Authorization Checks في Controller/Service
- استخدم prepared statements (Eloquent يفعل هذا تلقائياً)
- صرح CORS بشكل صحيح
- استخدم HTTPS في الإنتاج

### 📈 الأداء
- استخدم Eager Loading (with) لتجنب N+1 Queries
- فهرس الأعمدة المهمة في Database
- استخدم Caching للبيانات الثقيلة
- استخدم Pagination للبيانات الكبيرة
- Singleton Repositories توفر أداء أفضل

### 📝 الجودة
- اتبع PSR-12 لـ Code Style
- اكتب اختبارات للكود الحرج
- استخدم Type Hints
- وثق الكود الصعب
- استخدم Git للـ Version Control

---

## المراجع المفيدة

- 📖 [Laravel Documentation](https://laravel.com/docs)
- 📖 [Eloquent ORM](https://laravel.com/docs/eloquent)
- 📖 [Repository Pattern](https://developer.mozilla.org/en-US/)
- 📖 [SOLID Principles](https://en.wikipedia.org/wiki/SOLID)
- 📖 [Clean Code](https://www.oreilly.com/library/view/clean-code/9780136083238/)

---

## استكشاف الأخطاء

### مشاكل قاعدة البيانات
```bash
# اختبر الاتصال
php artisan tinker
> DB::connection()->getPdo();

# اعرض آخر الأخطاء
php artisan tinker
> Log::get_last_error();
```

### مشاكل الـ Routes
```bash
# اعرض جميع الـ Routes
php artisan route:list

# اعرض تفاصيل Route محدد
php artisan route:show api.maintenance.store
```

### مشاكل الـ Composer
```bash
# امسح الـ Cache
composer clear-cache

# أعد تشغيل Autoloader
composer dump-autoload -o
```

---

## الخطوات التالية

1. **اقرأ الوثائق**:
   - [ARCHITECTURE.md](./ARCHITECTURE.md) - شرح المعمارية
   - [API_DOCUMENTATION.md](./API_DOCUMENTATION.md) - توثيق API

2. **استكشف الموديول**:
   - افحص `app/Modules/MaintenanceTracker/` كمثال

3. **ابدأ بالتطوير**:
   - أضف موديول جديد
   - اكتب الاختبارات
   - شارك في المشروع

---

## الدعم والمساعدة

إذا واجهت أي مشاكل:

1. **تحقق من الأخطاء**: `storage/logs/laravel.log`
2. **اقرأ الوثائق**: ابدأ مع ARCHITECTURE.md
3. **اسأل المجتمع**: Laravel Discussions
4. **تواصل مع الفريق**: Team Leader (Khalid)

---

**آخر تحديث**: 2025-01-15  
**الإصدار**: 2.0  
**الحالة**: ✅ جاهز للإنتاج
