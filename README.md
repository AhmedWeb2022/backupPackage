Here is a more professional, polished, and industry-standard version of your `README.md`, with enhanced formatting, clarity, and structure:

---

# ☁️ Laravel Backup to Google Drive

A Laravel-based system to automate application file and database backups, securely store them in Google Drive, and manage backup lifecycle efficiently using Laravel's task scheduler and custom Artisan commands.

---

## 🚀 Features

* **Automated Backups** – Powered by [Spatie Laravel Backup](https://github.com/spatie/laravel-backup) to back up files and databases.
* **Google Drive Integration** – Secure cloud storage via [Yaza Laravel Google Drive Storage](https://github.com/yaza-putu/laravel-google-drive-storage).
* **Scheduled Tasks** – Regular backups and cleanup via Laravel's task scheduler.
* **Backup Metadata** – Stores file links and project identifiers in a `backups` database table.
* **Custom Artisan Commands**:

  * `backup:store-link {project}` – Saves/updates the latest backup URL to the database.
  * `backup:delete-old-files` – Retains only the latest file on Google Drive.
* **Retention & Cleanup Policy** – Automatically removes older backups based on defined rules.
* **Logging & Monitoring** – Logs operations and errors for full observability.

---

## 🧰 Requirements

* PHP ≥ 8.1
* Laravel ≥ 10
* Composer
* MySQL (or any supported DB)
* Google Drive API credentials:

  * Client ID & Secret
  * Refresh Token
  * Folder ID

---

## ⚙️ Installation

### 1. Clone & Install Dependencies

```bash
git clone <repository-url>
cd <project-directory>
composer install
```

### 2. Required Packages

```json
"masbug/flysystem-google-drive-ext": "^2.4",
"spatie/laravel-backup": "^9.3",
"yaza/laravel-google-drive-storage": "^4.1",
"google/apiclient": "^2.15.0"
```

### 3. Set Environment Variables

Copy `.env.example` and configure the following:

```env
GOOGLE_DRIVE_CLIENT_ID=your-client-id
GOOGLE_DRIVE_CLIENT_SECRET=your-client-secret
GOOGLE_DRIVE_REFRESH_TOKEN=your-refresh-token
GOOGLE_DRIVE_FOLDER_ID=your-folder-id
GOOGLE_DRIVE_FOLDER=your-folder-name

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your-database
DB_USERNAME=your-username
DB_PASSWORD=your-password

APP_NAME=your-app-name
BACKUP_ARCHIVE_PASSWORD=your-optional-password

MAIL_FROM_ADDRESS=your-email@example.com
MAIL_FROM_NAME="Your App Name"
```

### 4. Google Drive API Setup

* Create a project in [Google Cloud Console](https://console.cloud.google.com/).
* Enable the **Google Drive API**.
* Generate OAuth 2.0 credentials.
* Obtain `Client ID`, `Client Secret`, `Refresh Token`, and `Folder ID`.

### 5. Database & Storage Setup

```bash
php artisan migrate
php artisan storage:link
```

### 6. Configure Cron for Scheduler

Add to your server's crontab:

```bash
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```

---

## 🔧 Configuration

### 📁 `config/backup.php`

* **Included paths**: Entire app directory (`base_path()`).
* **Excluded paths**: `vendor`, `node_modules`.
* **Database**: Uses `.env` DB config.
* **Destination**: Google Drive disk using ZIP format.
* **Cleanup Strategy**:

  * Keep all for 7 days.
  * Daily: 16 days
  * Weekly: 8 weeks
  * Monthly: 4 months
  * Yearly: 2 years
  * Limit: 5000 MB

### ☁️ `config/filesystems.php`

```php
'google_drive' => [
    'driver' => 'google',
    'clientId' => env('GOOGLE_DRIVE_CLIENT_ID'),
    'clientSecret' => env('GOOGLE_DRIVE_CLIENT_SECRET'),
    'refreshToken' => env('GOOGLE_DRIVE_REFRESH_TOKEN'),
    'folder' => env('GOOGLE_DRIVE_FOLDER'),
    'folderId' => env('GOOGLE_DRIVE_FOLDER_ID'),
],
```

---

## 📦 Usage

### Manually Trigger Backup

```bash
php artisan backup:run
```

### Store/Update Latest Backup URL

```bash
php artisan backup:store-link sass
```

### Delete All But Latest Backup File

```bash
php artisan backup:delete-old-files
```

### Clean Up Based on Retention Policy

```bash
php artisan backup:clean
```

### Monitor Logs

View logs in:

```
storage/logs/laravel.log
```

---

## 🗃️ Database Schema

Table: `backups`

| Column        | Type      | Description                     |
| ------------- | --------- | ------------------------------- |
| id            | BIGINT    | Auto-increment primary key      |
| project\_name | VARCHAR   | Name of the project (nullable)  |
| project\_slug | VARCHAR   | Unique slug for the project     |
| file\_link    | TEXT      | Backup file URL on Google Drive |
| created\_at   | TIMESTAMP | Record creation time            |
| updated\_at   | TIMESTAMP | Record last update time         |

---

## ⏱️ Scheduled Tasks (`app/Console/Kernel.php`)

| Task                      | Description                       |
| ------------------------- | --------------------------------- |
| `backup:run`              | Generates a fresh backup          |
| `backup:clean`            | Cleans up old backups             |
| `backup:store-link sass`  | Stores the latest backup link     |
| `backup:delete-old-files` | Deletes all but the latest backup |

---

## 🛠 Custom Components

### `App\Services\GoogleDriveAdapter`

* Lists files from Google Drive.
* Gets the most recently uploaded file.
* Deletes all files except the newest.

### Artisan Commands

* `StoreLatestBackupLink`: Fetches and stores latest backup link in DB.
* `DeleteOldBackupFiles`: Retains only the most recent file on Google Drive.

### Eloquent Model

* `App\Models\Backup`

  * Fillable: `project_name`, `project_slug`, `file_link`

---

## 🧪 Troubleshooting

| Issue                    | Resolution                                                |
| ------------------------ | --------------------------------------------------------- |
| Google Drive API errors  | Verify `.env` credentials and folder access               |
| Adapter method not found | Ensure `GoogleDriveAdapter` includes all required methods |
| Backups not running      | Confirm cron is active and points to correct Laravel path |
| Storage issues           | Validate disk config in `config/filesystems.php`          |
| Debugging                | Check logs: `storage/logs/laravel.log`                    |

---

## 🤝 Contributing

1. Fork the repo
2. Create a new branch (`git checkout -b feature/my-feature`)
3. Commit your changes (`git commit -m "Add feature"`)
4. Push to the branch (`git push origin feature/my-feature`)
5. Create a Pull Request

---

## 📄 License

This project is licensed under the [MIT License](LICENSE).

---

## 🙏 Acknowledgments

* [Spatie Laravel Backup](https://github.com/spatie/laravel-backup)
* [Yaza Google Drive Storage](https://github.com/yaza-putu/laravel-google-drive-storage)
* [Google API Client](https://github.com/googleapis/google-api-php-client)

---

Would you like me to update this version into your current canvas now?
# backupPackage
