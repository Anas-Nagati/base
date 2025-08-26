<?php

namespace App\Services;

use Google\Client;
use Google\Service\Sheets;

class GoogleSheetService
{
    protected $service;
    protected $spreadsheetId;

    public function __construct()
    {
        $client = new Client();
        $client->setAuthConfig(storage_path('app/google/credentials.json'));
        $client->addScope(Sheets::SPREADSHEETS);

        $this->service = new Sheets($client);

        // Replace with your real Google Sheet ID
        $this->spreadsheetId = '19YXvsTMVSa9Fse4v2hhonQ4204r4dtB-7aaHEmBjRZI';
    }

    public function appendRow(array $row)
    {
        $range = 'Sheet1!A:E'; // adjust based on your sheet layout
        $body = new \Google\Service\Sheets\ValueRange([
            'values' => [$row]
        ]);
        $params = ['valueInputOption' => 'RAW'];

        return $this->service->spreadsheets_values->append(
            $this->spreadsheetId,
            $range,
            $body,
            $params
        );
    }
}
