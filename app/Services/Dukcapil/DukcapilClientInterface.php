<?php
namespace App\Services\Dukcapil;

interface DukcapilClientInterface
{
    /**
     * Verify a NIK number.
     * Return array with keys: success(bool), data(array)|null, message|null
     *
     * @param string $nik
     * @return array
     */
    public function verify(string $nik): array;
}
