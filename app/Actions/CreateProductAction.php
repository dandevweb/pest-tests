<?php

namespace App\Actions;

use App\Models\User;
use App\Models\Product;

class CreateProductAction
{

    public function handle(string $title, User $user)
    {


        Product::create([
            'title' => request()->title,
            'owner_id' => request()->owner_id,
        ]);
    }
}
