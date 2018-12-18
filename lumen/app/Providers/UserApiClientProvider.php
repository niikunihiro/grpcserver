<?php

namespace App\Providers;

use Grpc\ChannelCredentials;
use Grpcserver\UserApiClient;
use Illuminate\Support\ServiceProvider;

class UserApiClientProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(UserApiClient::class, function ($app) {
            return new UserApiClient('host.docker.internal:18686', [
                'credentials' => ChannelCredentials::createInsecure(),
            ]);
        });
    }
}