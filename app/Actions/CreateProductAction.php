<?php

namespace App\Actions;

use App\Models\User;
use App\Models\Product;
use App\Notifications\NewProductNotification;

class CreateProductAction
{

    public function handle(string $title, User $user): void
    {

        Product::create([
            'title' => $title,
            'owner_id' => $user->id,
        ]);

        $user->notify(new NewProductNotification());
    }
}
