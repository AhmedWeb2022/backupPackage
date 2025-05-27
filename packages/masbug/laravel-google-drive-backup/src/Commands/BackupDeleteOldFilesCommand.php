<?php

namespace Masbug\GoogleDriveBackup\Commands;

use Illuminate\Console\Command;
use Masbug\GoogleDriveBackup\Services\GoogleDriveAdapter;

class BackupDeleteOldFilesCommand extends Command
{
    protected $signature = 'backup:delete-old-files';
    protected $description = 'Delete all old backup files except the latest one';

    public function handle()
    {
        $config = config('backup.google_drive');

        $adapter = new GoogleDriveAdapter(
            $config['client_id'],
            $config['client_secret'],
            $config['refresh_token'],
            $config['folder_id']
        );

        $adapter->deleteAllExceptLatest();

        $this->info('Deleted all old backup files except the latest one.');
    }
}
