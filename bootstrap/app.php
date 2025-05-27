<?php

use Google\Client;
use Google\Service\Drive;
use Illuminate\Support\Facades\Log;

use App\Services\GoogleDriveAdapter;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withSchedule(function (Schedule $schedule) {
        // $schedule->command('backup:clean')->everyMinute();
        // $schedule->command('backup:run')->everyMinute();
        $schedule->command('backup:run')->everyMinute();
        $schedule->command('backup:clean')->everyMinute();

        $schedule->command('backup:store-link', ['sass'])->everyMinute();
        $schedule->command('backup:delete-old-files')->everyMinute();
        // git the link of uploaded file
        // $schedule->call(function () {
        //     $clientId = env('GOOGLE_DRIVE_CLIENT_ID');
        //     $clientSecret = env('GOOGLE_DRIVE_CLIENT_SECRET');
        //     $refreshToken = env('GOOGLE_DRIVE_REFRESH_TOKEN');
        //     $folderId = env('GOOGLE_DRIVE_FOLDER_ID');
        //     $client = new Client();
        //     $client->setClientId($clientId);
        //     $client->setClientSecret($clientSecret);
        //     $client->refreshToken($refreshToken);

        //     $service = new Drive($client);
        //     $adapterService = new GoogleDriveAdapter($service, $folderId);
        //     $files = $adapterService->listFiles();
        //     $latestFile = $adapterService->getLatestUploadedFile();

        //     if ($latestFile) {
        //         Log::info('Latest backup uploaded:', $latestFile);

        //         // Step 2: Delete all others
        //         $adapterService->deleteAllExceptLatest();
        //     } else {
        //         Log::info('No backup file found.');
        //     }
        //     Log::info($files);
        //     Log::info(['latestFile' => $latestFile]);
        // })->everyMinute();
    })
    ->withProviders([
        App\Providers\GoogleDriveServiceProvider::class,

    ])
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
