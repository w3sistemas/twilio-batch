<?php

namespace App\Http\Controllers;

use App\Exports\BatchResultExport;
use App\Http\Controllers\Controller;
use App\Imports\NumbersImport;
use App\Jobs\ProcessBatch;
use App\Models\Batch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class BatchController extends Controller
{
    public function index()
    {
        $batches = Batch::where('user_id', auth()->id())->latest()->paginate(10);
        return view('batches.index', compact('batches'));
    }

    public function store(Request $r)
    {
        $r->validate([
            'file' => ['required','file','mimes:xlsx,csv,txt','max:5120'],
            'name' => ['required','string','max:100'],
        ]);

        $batch = Batch::create([
            'user_id' => auth()->id(),
            'name'    => $r->string('name'),
            'status'  => 'pending',
        ]);

        Excel::import(new NumbersImport($batch->id), $r->file('file'));
        $total = $batch->items()->count();
        $batch->update(['total' => $total]);

        ProcessBatch::dispatch($batch->id);

        return redirect()->route('batches.index')->with('ok', 'Lote enviado para processamento.');
    }

    public function download(Batch $batch)
    {
        if ($batch->user_id !== auth()->id()) {
            abort(403);
        }
        abort_unless($batch->status === 'done' && $batch->result_path, 404);
        return Storage::download($batch->result_path);
    }
}
