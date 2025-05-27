<?php

namespace Masbug\GoogleDriveBackup;

use Illuminate\Support\ServiceProvider;

class GoogleDriveBackupServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Publish config file
        // Publish config file
        $this->publishes([
            __DIR__ . '/../../config/backup.php' => config_path('backup.php'),
        ], 'config');

        // Register commands only if running in console
        if ($this->app->runningInConsole()) {
            $this->commands([
                Commands\BackupRunCommand::class,
                Commands\BackupCleanCommand::class,
                Commands\BackupStoreLinkCommand::class,
                Commands\BackupDeleteOldFilesCommand::class,
            ]);
        }
    }

    public function register()
    {
        // Merge config so users can override defaults
        $this->mergeConfigFrom(__DIR__ . '/../../config/backup.php', 'backup');
    }
}
