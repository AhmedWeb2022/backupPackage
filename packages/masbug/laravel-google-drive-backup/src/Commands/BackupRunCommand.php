<?php

namespace Masbug\GoogleDriveBackup\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class BackupRunCommand extends Command
{
    protected $signature = 'backup:run';
    protected $description = 'Run the backup process';

    public function handle()
    {
        $this->info('Running backup...');
        Artisan::call('backup:run');
        $this->info('Backup completed!');
    }
}
