
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ForgotPasswordRequest extends FormRequest
{
    // Cho phép người dùng gửi yêu cầu
    public function authorize(): bool
    {
        return true;
    }

    // Kiểm tra dữ liệu nhập vào
    public function rules(): array
    {
        return [
            'email' => 'required|email',
        ];
    }

    // Thông báo lỗi
    public function messages(): array
    {
        return [
            'email.required' => 'Vui lòng nhập email.',
            'email.email' => 'Email không đúng định dạng.',
        ];
    }
}
