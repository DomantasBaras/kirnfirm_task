<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\ImportProductsJob;
use Illuminate\Support\Facades\Storage;

class ImportProducts extends Command
{
    protected $signature = 'import:products {--file=products.json}';
    protected $description = 'Import products from a JSON file';

    public function handle()
    {
        $filePath = $this->option('file');

        if (!Storage::exists($filePath)) {
            $this->error("File not found: $filePath");
            return 1; // Return a non-zero exit code to indicate failure
        }

        // Dispatch the job to the queue
        ImportProductsJob::dispatch($filePath);

        $this->info('Products import job dispatched!');
    }
}
