<?php

namespace App\Exports;

use App\Models\Batch;
use Maatwebsite\Excel\Concerns\FromCollection;

class BatchResultExport implements FromCollection
{
    public function __construct(private Batch $batch) {}

    public function collection()
    {
        return $this->batch->items()->select([
            'raw_number','e164','country_code','carrier','type','valid','lookup_error'
        ])->get();
    }
}
