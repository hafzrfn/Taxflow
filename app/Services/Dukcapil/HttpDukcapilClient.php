<?php
namespace App\Services\Dukcapil;

use Illuminate\Support\Facades\Http;

class HttpDukcapilClient implements DukcapilClientInterface
{
    protected $baseUrl;
    protected $apiKey;

    public function __construct(array $config = [])
    {
        $this->baseUrl = $config['base_url'] ?? env('DUKCAPIL_BASE_URL');
        $this->apiKey = $config['api_key'] ?? env('DUKCAPIL_API_KEY');
    }

    public function verify(string $nik): array
    {
        try {
            $resp = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Accept' => 'application/json'
            ])->get($this->baseUrl . '/verify', ['nik' => $nik]);

            if ($resp->ok()) {
                $json = $resp->json();
                // adapt according to real response shape
                return [
                    'success' => true,
                    'data' => $json['data'] ?? $json,
                    'message' => null
                ];
            }

            return [
                'success' => false,
                'data' => null,
                'message' => $resp->body()
            ];
        } catch (\Throwable $e) {
            return [
                'success' => false,
                'data' => null,
                'message' => $e->getMessage()
            ];
        }
    }
}
