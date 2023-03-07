<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AdminReportByCountry
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    
    public $totalUsersByCountry;

    public function __construct()
    {
        $this->totalUsersByCountry = User::select('country')
        ->selectRaw("COUNT('country') AS total")
        ->groupBy('country')
        ->get()
        ->all();
    }
}
