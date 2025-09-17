<?php

namespace App\Imports;

use App\Models\BatchItem;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class NumbersImport implements ToCollection
{
    public function __construct(private int $batchId) {}

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {

            $raw = trim(implode(' ', $row->toArray()));

            if ($raw === '') continue;

            BatchItem::create([
                'batch_id'   => $this->batchId,
                'raw_number' => $raw,
            ]);
        }
    }
}
