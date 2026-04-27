<?php

/**
 * @file: AuthController.php
 * @description: متحكم المصادقة - تسجيل الدخول والخروج والتوكنات
 * @module: AuthIdentity
 * @author: Team Leader (Khalid)
 */

namespace App\Modules\AuthIdentity\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\AuthIdentity\Services\AuthService;
use App\Modules\AuthIdentity\Requests\LoginRequest;
use App\Modules\AuthIdentity\Requests\PasswordResetRequest;
use App\Modules\LoggingAudit\Models\SystemLog;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

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
        try {
            // ── Attempt authentication ────────────────────────────────────────
            $credentials = $request->only('email', 'password');

            if (!Auth::attempt($credentials)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid credentials.',
                ], 401);
            }

            // ── Session Fixation Protection ───────────────────────────────────
            // Regenerate the session ID immediately after a confirmed login.
            // This invalidates any pre-authentication session ID that an
            // attacker may have injected (OWASP A07: Session Fixation).
            $request->session()->regenerate();

            // ── Delegate token issuance to AuthService ────────────────────────
            $data = $this->authService->login($request->email, $request->password);

            // ── Audit Log — Successful Login ──────────────────────────────────
            $correlationId = $request->header('X-Correlation-ID')
                          ?? $request->header('X-Request-ID')
                          ?? (string) Str::uuid();

            SystemLog::create([
                'level'          => 'info',
                'channel'        => 'audit',
                'message'        => sprintf('[AUTH] Successful login — user_id: %d', Auth::id()),
                'context'        => [
                    'ip'         => $request->ip(),
                    'user_agent' => $request->userAgent(),
                    'email'      => $request->email,
                ],
                'correlation_id' => $correlationId,
                'user_id'        => Auth::id(),
                'module'         => 'AuthIdentity',
                'request_uri'    => $request->getRequestUri(),
                'duration_ms'    => null,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'تم تسجيل الدخول بنجاح',
                'data'    => $data,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 401);
        }
    }

    /**
     * تسجيل الخروج (الجهاز الحالي فقط)
     * POST /api/v1/auth/logout
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        // TODO: Implement logout
        // 1. $this->authService->logout($request->user()->user_id)
        // 2. Return: response()->json(['success' => true, 'message' => 'تم تسجيل الخروج بنجاح'], 200)
        // 3. Catch Exception
    }

    /**
     * تسجيل الخروج من جميع الأجهزة
     * POST /api/v1/auth/logout-all
     * @param Request $request
     * @return JsonResponse
     */
    public function logoutAll(Request $request): JsonResponse
    {
        // TODO: Implement logout from all devices
        // 1. $this->authService->logoutAll($request->user()->user_id)
        // 2. Return success response
        // 3. Catch Exception
    }

    /**
     * تحديث التوكن
     * POST /api/v1/auth/refresh
     * @param Request $request
     * @return JsonResponse
     */
    public function refreshToken(Request $request): JsonResponse
    {
        // TODO: Implement token refresh
        // 1. $data = $this->authService->refreshToken($request->user()->user_id)
        // 2. Return new token in response
        // 3. Catch Exception
    }

    /**
     * طلب إعادة تعيين كلمة المرور
     * POST /api/v1/auth/forgot-password
     * @param PasswordResetRequest $request
     * @return JsonResponse
     */
    public function forgotPassword(PasswordResetRequest $request): JsonResponse
    {
        // TODO: Implement forgot password
        // 1. $this->authService->requestPasswordReset($request->email)
        // 2. Return: response()->json(['success' => true, 'message' => 'تم إرسال رابط إعادة التعيين على بريدك'], 200)
        // 3. Catch Exception
    }

    /**
     * إعادة تعيين كلمة المرور
     * POST /api/v1/auth/reset-password
     * @param PasswordResetRequest $request
     * @return JsonResponse
     */
    public function resetPassword(PasswordResetRequest $request): JsonResponse
    {
        // TODO: Implement reset password
        // 1. $this->authService->resetPassword($request->token, $request->email, $request->password)
        // 2. Return success response
        // 3. Catch Exception
    }

    /**
     * تغيير كلمة المرور (المستخدم المسجل)
     * POST /api/v1/auth/change-password
     * @param PasswordResetRequest $request
     * @return JsonResponse
     */
    public function changePassword(PasswordResetRequest $request): JsonResponse
    {
        // TODO: Implement change password
        // 1. $this->authService->changePassword($request->user()->user_id, $request->current_password, $request->password)
        // 2. Return success response
        // 3. Catch Exception
    }

    /**
     * جلب بيانات المستخدم الحالي
     * GET /api/v1/auth/me
     * @param Request $request
     * @return JsonResponse
     */
    public function me(Request $request): JsonResponse
    {
        // TODO: Return authenticated user data
        // 1. $user = $request->user()->load(['roles', 'permissions'])
        // 2. Return user data
    }
}
