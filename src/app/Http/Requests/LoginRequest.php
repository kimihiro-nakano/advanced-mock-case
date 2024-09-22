<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => ['required', 'string', 'exists:users,email', 'email', 'max:191'],
            'password' => ['required', 'min:8', 'max:191'],
            'role' => ['required', 'in:user,shop/owner,admin']
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'メールアドレスを入力してください',
            'email.string' => 'メールアドレスを文字列で入力してください',
            'email.exists' => 'そのメールアドレスは登録されていません。',
            'email.email' => 'メールアドレスはメール形式で入力してください',
            'email.max' => 'メールアドレスを191文字以下で入力してください',
            'password.required' => 'パスワードを入力してください',
            'password.min' => 'パスワードを8文字以上で入力してください',
            'password.max' => 'パスワードを191文字以下で入力してください',
            'role,required' => '役割を選択してください',
            'role,in' => '無効な役割が選択されました'
        ];
    }
}
