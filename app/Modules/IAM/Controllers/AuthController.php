<?php

/**
 * @file: AuthController.php
 * @description: متحكم المصادقة - يتعامل مع تسجيل الدخول والخروج وإدارة كلمات المرور
 * @author: Team Leader (Khalid)
 */

namespace App\Modules\IAM\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\IAM\Services\AuthService;
use App\Modules\IAM\Requests\LoginRequest;
use App\Modules\IAM\Requests\PasswordResetRequest;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    protected AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * تسجيل الدخول
     * POST /api/v1/auth/login
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        // TODO: Implement login endpoint
        // 1. Get validated email and password from request
        // 2. Call authService->login()
        // 3. Return token and user data as JSON
        // 4. Handle exceptions and return appropriate error response
    }

    /**
     * تسجيل الخروج
     * POST /api/v1/auth/logout
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        // TODO: Implement logout endpoint
        // 1. Get authenticated user from request
        // 2. Call authService->logout()
        // 3. Return success response
        // 4. Handle exceptions and return appropriate error response
    }

    /**
     * تحديث التوكن
     * POST /api/v1/auth/refresh
     * @return JsonResponse
     */
    public function refreshToken(): JsonResponse
    {
        // TODO: Implement token refresh endpoint
        // 1. Get current token from request
        // 2. Call authService->refreshToken()
        // 3. Return new token
        // 4. Handle exceptions and return appropriate error response
    }

    /**
     * طلب إعادة تعيين كلمة المرور
     * POST /api/v1/auth/forgot-password
     * @param PasswordResetRequest $request
     * @return JsonResponse
     */
    public function forgotPassword(PasswordResetRequest $request): JsonResponse
    {
        // TODO: Implement forgot password endpoint
        // 1. Get validated email from request
        // 2. Call authService->requestPasswordReset()
        // 3. Return success message
        // 4. Handle exceptions and return appropriate error response
    }

    /**
     * إعادة تعيين كلمة المرور
     * POST /api/v1/auth/reset-password
     * @param PasswordResetRequest $request
     * @return JsonResponse
     */
    public function resetPassword(PasswordResetRequest $request): JsonResponse
    {
        // TODO: Implement reset password endpoint
        // 1. Get validated token and new password from request
        // 2. Call authService->resetPassword()
        // 3. Return success response
        // 4. Handle exceptions and return appropriate error response
    }

    /**
     * تغيير كلمة المرور
     * POST /api/v1/auth/change-password
     * @param PasswordResetRequest $request
     * @return JsonResponse
     */
    public function changePassword(PasswordResetRequest $request): JsonResponse
    {
        // TODO: Implement change password endpoint
        // 1. Get authenticated user from request
        // 2. Get validated old and new passwords from request
        // 3. Call authService->changePassword()
        // 4. Return success response
        // 5. Handle exceptions and return appropriate error response
    }
}
