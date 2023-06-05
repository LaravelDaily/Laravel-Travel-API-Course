<?php

namespace App\Observers;

use App\Models\Travel;

class TravelObserver
{
    public function creating(Travel $travel): void
    {
        $travel->slug = str()->slug($travel->name);
    }
}
