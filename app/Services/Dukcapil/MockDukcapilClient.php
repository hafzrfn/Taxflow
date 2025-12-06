<?php
namespace App\Services\Dukcapil;

class MockDukcapilClient implements DukcapilClientInterface
{
    public function verify(string $nik): array
    {
        // Simple heuristic: if nik length == 16 and starts with '1' => success
        if (strlen($nik) === 16 && ctype_digit($nik)) {
            return [
                'success' => true,
                'data' => [
                    'nik' => $nik,
                    'name' => 'Nama Contoh',
                    'dob' => '1990-01-01',
                    'address' => 'Jl. Contoh No.1'
                ],
                'message' => null
            ];
        }

        return [
            'success' => false,
            'data' => null,
            'message' => 'NIK tidak ditemukan'
        ];
    }
}
