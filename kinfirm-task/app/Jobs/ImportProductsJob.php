<?php

namespace App\Jobs;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class ImportProductsJob implements ShouldQueue
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
        $products = json_decode($json, true);

        foreach ($products as $productData) {
            Product::updateOrCreate(
                ['sku' => $productData['sku']], // Ensure 'sku' matches the column in the table
                [
                    'description' => $productData['description'],
                    'size' => $productData['size'],
                    'photo' => $productData['photo'],
                ]
            );
        }

        // Optionally delete the file after import
        Storage::delete($this->filePath);
    }
}
