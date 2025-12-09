<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $userId = $this->user() ? $this->user()->id : null;

        return [
            'name' => ['required','string','max:191'],
            // 'email' => ['required','email','max:191','unique:users,email,'.$userId],
            'nik' => ['nullable','digits:16','unique:wajib_pajaks,nik,'.$this->user()->wajibPajak?->id],
            'no_hp' => ['nullable','string','max:30'],
            'alamat' => ['nullable','string','max:1000'],
        ];
    }

    public function messages()
    {
        return [
            'nik.digits' => 'NIK harus terdiri dari 16 digit.',
            'nik.unique' => 'NIK sudah terdaftar pada akun lain.',
        ];
    }
}
