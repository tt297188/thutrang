<?php

namespace App\Http\Controllers;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;
use App\Mail\WelcomeMail;
class AuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }
    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);
        Log::channel('auth')->info('Đăng ký', [
            'user_id' => $user->id,
            'email'   => $user->email,
            'time'    => now()->toDateTimeString(),
            'ip'      => $request->ip(),
        ]);
        try {
            Mail::to($user->email)->send(new WelcomeMail($user));
        } catch (\Throwable $e) {
            Log::error('Gửi mail chào mừng thất bại', [
                'email' => $user->email,
                'error' => $e->getMessage(),
            ]);
        }
        Auth::login($user);
        $request->session()->regenerate();
        return redirect()->route('home')
            ->with('success', 'Đăng ký thành công, chào mừng bạn!');
    }

    public function showLogin()
    {
        return view('auth.login');
    }
    public function login(LoginRequest $request)
    {
        $credential = $request->validated();

        if (Auth::attempt($credential)) {
            $request->session()->regenerate();

            Log::channel('auth')->info('Đăng nhập', [
                'user_id' => Auth::id(),
                'email'   => Auth::user()->email,
                'time'    => now()->toDateTimeString(),
                'ip'      => $request->ip(),
            ]);

            return redirect()->route('post.index');
        }

        Log::channel('auth')->warning('Đăng nhập thất bại', [
            'email' => $request->email,
            'time'  => now()->toDateTimeString(),
            'ip'    => $request->ip(),
        ]);

        return back()
            ->withErrors([
                'email' => 'Email hoặc mật khẩu không đúng.',
            ])
            ->onlyInput('email');
    }

    // Hiển thị trang quên mật khẩu
    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    // Gửi email cấp lại mật khẩu
    public function forgotPassword(ForgotPasswordRequest $request)
    {
        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {

            // Ghi log gửi email
            Log::channel('auth')->info('Gửi email cấp lại mật khẩu', [
                'email' => $request->email,
                'time'  => now()->toDateTimeString(),
                'ip'    => $request->ip(),
            ]);

            return back()->with(
                'success',
                'Đã gửi email cấp lại mật khẩu!'
            );
        }

        return back()->withErrors([
            'email' => 'Không tìm thấy email trong hệ thống.',
        ]);
    }

    // Hiển thị trang đặt lại mật khẩu
    public function showResetPassword(Request $request, $token)
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->email,
        ]);
    }

    // Xử lý đặt lại mật khẩu
    public function resetPassword(ResetPasswordRequest $request)
    {
        $status = Password::reset(
            $request->validated(),

            function ($user, $password) use ($request) {

                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));

                // Ghi log đổi mật khẩu
                Log::channel('auth')->info('Đổi mật khẩu', [
                    'user_id' => $user->id,
                    'email'   => $user->email,
                    'time'    => now()->toDateTimeString(),
                    'ip'      => $request->ip(),
                ]);
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('login')
                ->with('success', 'Đặt lại mật khẩu thành công!');
        }

        return back()->withErrors([
            'email' => 'Liên kết đặt lại mật khẩu không hợp lệ hoặc đã hết hạn.',
        ]);
    }

    // Đăng xuất
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')
            ->with('success', 'Bạn đã đăng xuất.');
    }
}
