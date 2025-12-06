<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Dukcapil\DukcapilClientInterface;
use App\Services\Dukcapil\MockDukcapilClient;
use App\Services\Dukcapil\HttpDukcapilClient;

class DukcapilServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(DukcapilClientInterface::class, function ($app) {
            // toggle by env var DUKCAPIL_USE_MOCK=true
            if (config('services.dukcapil.mock', true) || env('DUKCAPIL_USE_MOCK', true)) {
                return new MockDukcapilClient();
            }
            return new HttpDukcapilClient(config('services.dukcapil', []));
        });
    }

    public function boot()
    {
        //
    }
}
