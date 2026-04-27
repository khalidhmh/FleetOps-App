<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// مسار تجريبي للتأكد من الاتصال بقاعدة البيانات وجلب بيانات العربات
Route::get('/test-db', function () {
    try {
        // جلب جميع البيانات من جدول العربات
        $vehicles = DB::table('vehicles')->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Connected to SQL Server successfully!',
            'data' => $vehicles
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Connection failed: ' . $e->getMessage()
        ], 500);
    }
});

// مسار افتراضي للحصول على بيانات المستخدم (يأتي مع لارافيل بشكل أساسي)
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});