<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Offer;
use Carbon\Carbon;

class UpdateOfferStatus extends Command
{
   
    protected $signature = 'offer:update-status';
    protected $description = 'Update offer statuses based on expiration date';
    
    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $now = Carbon::now();

        Offer::where('expire_at', '<=', $now)
            ->update(['status' => 3]);

        $this->info('Offer status updated successfully.');
    }

    
}
