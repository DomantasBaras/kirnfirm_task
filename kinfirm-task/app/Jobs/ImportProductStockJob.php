<?php

namespace App\Jobs;

use App\Models\Stock;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class ImportProductStockJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $filePath;

    /**
     * Create a new job instance.
     *
     * @param string $filePath
     * @return void
     */
    public function __construct($filePath)
    {
        $this->filePath = $filePath;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Read the JSON file
        $json = Storage::get($this->filePath);
        $stocks = json_decode($json, true);

        foreach ($stocks as $stockData) {
            // Check if the necessary keys exist in the data
            if (!isset($stockData['sku']) || !isset($stockData['stock']) || !isset($stockData['city'])) {
                // Log or handle missing keys if necessary
                continue;
            }

            Stock::updateOrCreate(
                ['sku' => $stockData['sku']],
                [
                    'stock' => $stockData['stock'],
                    'city' => $stockData['city'],
                ]
            );
        }

        // Optionally delete the file after import
        Storage::delete($this->filePath);
    }
}
