<?php

namespace App\Exports;

use App\Models\Batch;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BatchResultExport implements FromCollection, WithHeadings
{
    public function __construct(private Batch $batch) {}

    public function collection(): Collection|\Illuminate\Support\Collection
    {
        return $this->batch->items()->select([
            'raw_number',
            'country_code',
            'carrier',
            'type',
            'valid'
        ])->get();
    }

    public function headings(): array
    {
        return [
            'Número',
            'País',
            'Operadora',
            'Tipo',
            'Válido'
        ];
    }
}
