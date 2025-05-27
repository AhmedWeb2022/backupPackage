<?php

namespace backup\GoogleDriveBackup\Facades;

use Illuminate\Support\Facades\Facade;

class GoogleDriveAdapter extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \backup\GoogleDriveBackup\GoogleDriveAdapter::class;
    }
}
