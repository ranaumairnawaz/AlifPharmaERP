<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Storage;
use Google\Client as GoogleClient;
use Google\Service\Drive as GoogleServiceDrive;
use Masbug\Flysystem\GoogleDriveAdapter;
use League\Flysystem\Filesystem;
use Illuminate\Filesystem\FilesystemAdapter;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // ACL & Permission Hub initialization
        \Illuminate\Support\Facades\Blade::if('canRead', function ($module) {
            return auth()->check() && (auth()->user()->isAdmin() || auth()->user()->hasModuleAction($module, 'read'));
        });

        \Illuminate\Support\Facades\Blade::if('canEdit', function ($module) {
            return auth()->check() && (auth()->user()->isAdmin() || auth()->user()->hasModuleAction($module, 'edit'));
        });

        \Illuminate\Support\Facades\Blade::if('canDelete', function ($module) {
            return auth()->check() && (auth()->user()->isAdmin() || auth()->user()->hasModuleAction($module, 'delete'));
        });

        \Illuminate\Support\Facades\Blade::if('isAdmin', function () {
            return auth()->check() && auth()->user()->isAdmin();
        });

        // Global Data Hydration for Velocity (View Composers)
        view()->composer(['products.*', 'reports.*', 'stock.*'], function ($view) {
            $view->with('brands', \App\Models\Brand::all());
            $view->with('categories', \App\Models\Category::all());
            $view->with('units', \App\Models\Unit::all());
        });

        // Dynamically override Cloud Shield (S3) configuration at runtime
        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('settings')) {
                config([
                    'filesystems.disks.s3.key' => \App\Models\Setting::get('cloud_s3_key', config('filesystems.disks.s3.key')),
                    'filesystems.disks.s3.secret' => \App\Models\Setting::get('cloud_s3_secret', config('filesystems.disks.s3.secret')),
                    'filesystems.disks.s3.region' => \App\Models\Setting::get('cloud_s3_region', config('filesystems.disks.s3.region')),
                    'filesystems.disks.s3.bucket' => \App\Models\Setting::get('cloud_s3_bucket', config('filesystems.disks.s3.bucket')),
                    'filesystems.disks.s3.url' => \App\Models\Setting::get('cloud_s3_url', config('filesystems.disks.s3.url')),
                    'filesystems.disks.s3.endpoint' => \App\Models\Setting::get('cloud_s3_endpoint', config('filesystems.disks.s3.endpoint')),

                    'filesystems.disks.google.clientId' => \App\Models\Setting::get('google_drive_client_id', config('filesystems.disks.google.clientId')),
                    'filesystems.disks.google.clientSecret' => \App\Models\Setting::get('google_drive_client_secret', config('filesystems.disks.google.clientSecret')),
                    'filesystems.disks.google.refreshToken' => \App\Models\Setting::get('google_drive_refresh_token', config('filesystems.disks.google.refreshToken')),
                    'filesystems.disks.google.folderId' => \App\Models\Setting::get('google_drive_folder_id', config('filesystems.disks.google.folderId')),
                ]);

                Storage::extend('google', function ($app, $config) {
                    // Adding the leading slash tells PHP to ignore any 
                    // namespace issues and go straight to the vendor files.
                    $client = new GoogleClient();

                    $client->setClientId($config['clientId']);
                    $client->setClientSecret($config['clientSecret']);
                    $client->refreshToken($config['refreshToken']);

                    $service = new GoogleServiceDrive($client);
                    $adapter = new GoogleDriveAdapter($service, $config['folderId'] ?? '/');
                    $filesystem = new Filesystem($adapter);

                    return new FilesystemAdapter($filesystem, $adapter);
                });
            }
        } catch (\Exception $e) {
            // Silence exceptions during early boot/migrations
        }

        // Global Branding Engine (Corporate Identity Synchronization)
        view()->composer('*', function ($view) {
            $view->with('branding', [
                'name' => \App\Models\Setting::get('company_name', 'Alif Pharma'),
                'logo' => \App\Models\Setting::get('company_logo', '/alif-logo.png'),
                'color' => \App\Models\Setting::get('brand_color', '#0d9488'),
                'pdf_override' => \App\Models\Setting::get('pdf_override_colors', 'false') === 'true'
            ]);
        });
    }
}
