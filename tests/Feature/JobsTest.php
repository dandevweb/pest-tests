<?php

use App\Jobs\ImportProductsJob;

use function Pest\Laravel\postJson;
use Illuminate\Support\Facades\Queue;

it('should dispatch a job to the queue', function () {

    Queue::fake();

    postJson(route('products.import'), [
        'data' => [
            [
                ['title' => 'Product 1'],
                ['title' => 'Product 2'],
                ['title' => 'Product 3'],
            ]
        ]
    ]);

    Queue::assertPushed(ImportProductsJob::class);
});
