<?php

namespace App\Jobs;

use App\Models\Batch;
use App\Services\TwilioLookupService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\BatchResultExport;

class ProcessBatch implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $timeout = 3600;

    public function __construct(public int $batchId) {}

    public function handle(TwilioLookupService $svc): void
    {
        $batch = Batch::findOrFail($this->batchId);
        $batch->update(['status' => 'processing', 'processed' => 0]);

        $processed = 0;
        foreach ($batch->items()->orderBy('id')->cursor() as $item) {
            $res = $svc->lookup($item->raw_number);
            $item->update([
                'e164'         => $res['e164'] ?? null,
                'country_code' => $res['country_code'] ?? null,
                'carrier'      => $res['carrier'] ?? null,
                'type'         => $res['type'] ?? null,
                'valid'        => $res['valid'] ?? null,
                'lookup_error' => $res['error'] ?? null,
            ]);
            $processed++;
            if ($processed % 50 === 0) {
                $batch->update(['processed' => $processed]);
                usleep(150000);
            }
        }

        $batch->update(['processed' => $processed]);

        $path = "batches/batch_{$batch->id}_result.xlsx";
        Excel::store(new BatchResultExport($batch), $path);
        $batch->update(['status' => 'done', 'result_path' => $path]);
    }

    public function failed(\Throwable $e): void
    {
        Batch::whereKey($this->batchId)->update([
            'status' => 'failed',
            'error'  => $e->getMessage(),
        ]);
    }
}
