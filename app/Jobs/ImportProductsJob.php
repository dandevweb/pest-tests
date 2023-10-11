<?php

namespace App\Jobs;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class ImportProductsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        protected readonly array $data,
        protected readonly int $ownerId,

    ) {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        foreach ($this->data as $products) {
            foreach ($products as $product) {
                Product::create([
                    'title' => $product['title'],
                    'owner_id' => $this->ownerId,
                ]);
            }
        }
    }
}
