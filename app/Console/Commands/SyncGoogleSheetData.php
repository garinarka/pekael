<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Google_Client;
use Google_Service_Sheets;
use App\Models\Department;
use App\Models\Paralel;

class SyncGoogleSheetData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:google-sheets';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync Department and Paralel data from Google Sheets';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $spreadsheetId = '1jQlbrEmxyHPIAeM7n7WW9FQromKu7L8lEGRc1qya7f0';
        $departmentRange = 'Sheet1!B2:B';
        $paralelRange = 'Sheet2!B2:B';

        $client = new Google_Client();
        $client->setApplicationName('YourAppName');
        $client->setScopes([Google_Service_Sheets::SPREADSHEETS_READONLY]);
        $client->setAuthConfig(storage_path('credentials.json'));

        $service = new Google_Service_Sheets($client);

        // Sync Department
        $response = $service->spreadsheets_values->get($spreadsheetId, $departmentRange);
        $departments = $response->getValues();

        Department::truncate();

        foreach ($departments as $row) {
            Department::create(['name' => $row[0]]);
        }

        // Sync Paralels
        $response = $service->spreadsheets_values->get($spreadsheetId, $paralelRange);
        $paralels = $response->getValues();

        Paralel::truncate();

        foreach ($paralels as $row) {
            Paralel::create(['name' => $row[0]]);
        }

        $this->info('Data has been synchronized from Google Sheets.');
    }
}
