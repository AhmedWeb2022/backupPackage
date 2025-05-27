<?php

namespace backup\GoogleDriveBackup;

use Illuminate\Support\ServiceProvider;
use Google\Client;
use Google\Service\Drive;

class GoogleDriveBackupServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Publish config
        $this->publishes([
            __DIR__ . '/../config/googleDriveBackup.php' => config_path('googleDriveBackup.php'),
        ], 'googleDriveBackup-config');
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/googleDriveBackup.php',
            'googleDriveBackup'
        );

        // Register Google Drive Client and Adapter as singleton
        $this->app->singleton(GoogleDriveAdapter::class, function ($app) {
            $config = $app['config']->get('googledrive');

            $client = new Client();
            $client->setClientId($config['client_id']);
            $client->setClientSecret($config['client_secret']);
            $client->refreshToken($config['refresh_token']);

            $service = new Drive($client);

            return new GoogleDriveAdapter($service, $config['folder_id'] ?? null);
        });

        // Optionally create a facade alias here
        $this->app->alias(GoogleDriveAdapter::class, 'googledrive');
    }
}
