<?php

namespace App\Observers;

use App\Models\Entry;
use App\Services\GoogleSheetService;
use Illuminate\Support\Facades\Log;

class EntryObserver
{
    public function created(Entry $entry)
    {
        try {
            $sheet = new \App\Services\GoogleSheetService();
            $result = $sheet->appendRow([
                $entry->{'your-name'},
                $entry->{'your-email'},
                $entry->{'your-subject'},
                $entry->{'your-message'},
                now()->toDateTimeString(),
            ]);

            Log::info('Google Sheets API success', ['result' => $result]);
        } catch (\Exception $e) {
            Log::error('Google Sheets API error: ' . $e->getMessage());
        }
    }
}
