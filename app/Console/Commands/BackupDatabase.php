<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Setting;

class BackupDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:backup-database';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automated Redundant Database Backup (Local & Google Drive)';

    public function handle()
    {
        // Get backup path from settings or fallback to D drive
        $backupPath = Setting::get('backup_path') ?? 'D:/AlifPharmaBackups';

        // 1. Prepare Filenames
        $filename = 'alif_pharma_backup_' . date('Y_m_d_His') . '.sqlite';
        $tempLocalPath = storage_path('app/temp_' . $filename);
        $finalLocalDestination = rtrim($backupPath, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $filename;

        try {
            // 2. SAFE SQLite Export
            // VACUUM INTO creates a clean copy without locking the main database
            $this->info("Creating safe database export...");
            DB::statement("VACUUM INTO '$tempLocalPath'");

            // 3. Move to Local Redundant Storage (D: Drive)
            if (!is_dir($backupPath)) {
                mkdir($backupPath, 0777, true);
            }

            rename($tempLocalPath, $finalLocalDestination);
            $this->info("Backup secured locally: {$finalLocalDestination}");

            // 4. Cloud Mirroring Logic
            $cloudEnabled = Setting::get('cloud_backup_enabled') == '1';

            if ($cloudEnabled) {
                $this->info('Initiating Permanent Cloud Mirroring (Google Drive)...');

                $fileStream = fopen($finalLocalDestination, 'r');

                if ($fileStream === false) {
                    throw new \Exception("Failed to open local backup file for streaming.");
                }

                // Uploading to 'google' disk
                // Note: The flysystem adapter automatically closes the stream after put()
                Storage::disk('google')->put($filename, $fileStream);

                $this->info("Permanent Mirror Secured: {$filename}");
            }

            return 0;
        } catch (\Exception $e) {
            // Clean up temp file if something went wrong
            if (file_exists($tempLocalPath)) {
                unlink($tempLocalPath);
            }

            $this->error("Backup Process Failed: " . $e->getMessage());
            return 1;
        }
    }
}