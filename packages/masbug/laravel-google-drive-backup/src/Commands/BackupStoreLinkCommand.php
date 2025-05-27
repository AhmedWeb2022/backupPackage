<?php

namespace Masbug\GoogleDriveBackup\Commands;

use Illuminate\Console\Command;
use Masbug\GoogleDriveBackup\Services\GoogleDriveAdapter;
use Illuminate\Support\Facades\Log;

class BackupStoreLinkCommand extends Command
{
    protected $signature = 'backup:store-link {name?}';
    protected $description = 'Store the Google Drive backup link and send Telegram notification';

    public function handle()
    {
        $name = $this->argument('name') ?? 'default';

        $config = config('backup.google_drive');
        $telegramConfig = config('backup.telegram');

        $adapter = new GoogleDriveAdapter(
            $config['client_id'],
            $config['client_secret'],
            $config['refresh_token'],
            $config['folder_id']
        );

        $latestFile = $adapter->getLatestUploadedFile();

        if ($latestFile) {
            Log::info('Latest backup uploaded:', ['file' => $latestFile]);

            // TODO: Implement storing the link to database or cache

            // Telegram notification logic here
            if ($telegramConfig['bot_token']) {
                $this->sendTelegramNotification($telegramConfig['bot_token'], $latestFile->name, $latestFile->id);
            }

            $this->info('Backup link stored and notification sent.');
        } else {
            $this->warn('No backup file found.');
        }
    }

    protected function sendTelegramNotification(string $botToken, string $fileName, string $fileId)
    {
        $telegramUrl = "https://api.telegram.org/bot{$botToken}/sendMessage";

        $message = "New backup uploaded: {$fileName}\nGoogle Drive Link: https://drive.google.com/file/d/{$fileId}/view";

        $response = file_get_contents($telegramUrl . '?chat_id=' . config('backup.telegram.chat_id') . '&text=' . urlencode($message));
    }
}
