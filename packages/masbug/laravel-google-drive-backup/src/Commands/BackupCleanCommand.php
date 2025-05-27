<?php

namespace Masbug\GoogleDriveBackup\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class BackupCleanCommand extends Command
{
    protected $signature = 'backup:clean';
    protected $description = 'Clean old backups';

    public function handle()
    {
        $this->info('Cleaning old backups...');
        Artisan::call('backup:clean');
        $this->info('Cleanup completed!');
    }
}
