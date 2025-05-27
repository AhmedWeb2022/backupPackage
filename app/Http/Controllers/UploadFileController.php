<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Services\GoogleDriveAdapter;
use Yaza\LaravelGoogleDriveStorage\Gdrive;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;
use Google\Client;
use Google\Service\Drive;
use Telegram\Bot\Laravel\Facades\Telegram;
// use App\Services\GoogleDriveAdapter;
use Illuminate\Filesystem\FilesystemAdapter;

class UploadFileController extends Controller
{
    /**
     * Handle the incoming request.
     */
    protected $adapterService;

    public function __construct()
    {
        $clientId = env('GOOGLE_DRIVE_CLIENT_ID');
        $clientSecret = env('GOOGLE_DRIVE_CLIENT_SECRET');
        $refreshToken = env('GOOGLE_DRIVE_REFRESH_TOKEN');
        $folderId = env('GOOGLE_DRIVE_FOLDER_ID');
        $client = new Client();
        $client->setClientId($clientId);
        $client->setClientSecret($clientSecret);
        $client->refreshToken($refreshToken);

        $service = new Drive($client);

        $this->adapterService = new GoogleDriveAdapter($service, $folderId);
    }
    public function __invoke()
    {
        $chatId = 'YOUR_CHAT_ID'; // Replace with your chat ID
        $message = 'Hello, this is a message from Laravel!';

        // $update = Telegram::commandsHandler(true);
        // // dd($update);
        // $message = $update->getMessage();
        // // dd($message);
        // $chat_id = $message->getChat()->getId();
        // dd($chat_id);
        // Telegram::sendMessage([
        //     'chat_id' => $chatId,
        //     'text' => $message,
        // ]);
        $updates = Telegram::getUpdates();
        $chat_id = $updates[0]['my_chat_member']['chat']['id'];
         Telegram::sendMessage([
            'chat_id' => $chat_id,
            'text' => $message,
        ]);


        
        // $html = Storage::disk('google_drive')->url('BackupTest/photo33.jpg');
        // $img = Storage::disk('google_drive')->url('BackupTest/photo33.jpg');
        // dd($img);
        // return $img;
        // dd($request->file('image'));
        // $img = $this->adapterService->read('BackupTest/photo33.jpg');
        // return $html;
        // $drive =  Gdrive::put('BackupTest/photo33.jpg', $request->file('image'));
        // dd($drive);
        // return response('Image Uploaded!', 200);
    }
}
