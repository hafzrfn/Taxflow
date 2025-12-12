<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SPTRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * For now allow authenticated users (adjust if needed).
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Validation rules for SPT submission (e-Filing).
     *
     * - tahun_pajak: required, 4 digits (e.g. 2025)
     * - penghasilan: required, numeric, min 0
     * - jenis_spt: required, in list
     * - attachments[]: optional, array of files; each file max 5MB, allowed types pdf,jpg,png
     *
     * Adjust rules to match your DB/migration fields.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'tahun_pajak' => ['required', 'digits:4', 'integer'],
            'penghasilan' => ['required', 'numeric', 'min:0'],
            'jenis_spt' => ['required', 'in:TAHUNAN,BULANAN'],
            'attachments' => ['required', 'array', 'min:1'], // Changed from 'sometimes' to 'required'
            'attachments.*' => ['file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'], // max 5MB
        ];
    }

    /**
     * Customize validation messages (optional).
     *
     * @return array
     */
    public function messages()
    {
        return [
            'tahun_pajak.required' => 'Tahun pajak wajib diisi.',
            'tahun_pajak.digits' => 'Isi tahun pajak 4 digit (mis. 2025).',
            'penghasilan.required' => 'Penghasilan wajib diisi.',
            'jenis_spt.in' => 'Jenis SPT harus TAHUNAN atau BULANAN.',
            'attachments.required' => 'Dokumen lampiran wajib diunggah.',
            'attachments.min' => 'Minimal 1 dokumen harus diunggah.',
            'attachments.*.mimes' => 'Lampiran harus berupa PDF atau gambar (jpg/png).',
            'attachments.*.max' => 'Lampiran maksimal 5MB per file.',
        ];
    }
}
