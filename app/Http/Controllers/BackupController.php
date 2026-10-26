<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

class BackupController extends Controller
{
    /**
     * Trigger the pharmaceutical database backup command programmatically.
     */
    public function run()
    {
        try {
            // Execute the automated redundant backup command
            $exitCode = Artisan::call('app:backup-database');
            $output = Artisan::output();

            if ($exitCode === 0) {
                return response()->json([
                    'success' => true,
                    'message' => 'Pharmaceutical ledger successfully mirrored to secondary redundant path.',
                    'details' => $output
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Redundancy protocol encountered an internal exception.',
                'details' => $output
            ], 500);

        } catch (\Exception $e) {
            Log::error("Manual Backup Failed: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Critical Infrastructure Failure: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Detect and return the pharmaceutical engine's network access coordinates.
     */
    public function getInfo()
    {
        $hostname = gethostname();
        $ip = gethostbyname($hostname);
        
        // Permanent mDNS Link based on Hostname
        $domainLink = "http://" . strtoupper($hostname) . ".local:8000";
        $ipLink = "http://" . $ip . ":8000";

        return response()->json([
            'success' => true,
            'hostname' => $hostname,
            'ip' => $ip,
            'domain_link' => $domainLink,
            'ip_link' => $ipLink
        ]);
    }
}
