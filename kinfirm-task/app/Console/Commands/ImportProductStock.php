<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\ImportProductStockJob;
use Illuminate\Support\Facades\Storage;

class ImportProductStock extends Command
{
    protected $signature = 'import:stock {--file=stocks.json}';
    protected $description = 'Import stock from a JSON file';

    public function handle()
    {
        $filePath = $this->option('file');

        if (!Storage::exists($filePath)) {
            $this->error("File not found: $filePath");
            return 1; // Return a non-zero exit code to indicate failure
        }

        // Dispatch the job to the queue
        ImportProductStockJob::dispatch($filePath);

        $this->info('Stock import job dispatched!');
    }
}
