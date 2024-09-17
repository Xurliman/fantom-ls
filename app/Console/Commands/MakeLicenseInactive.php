<?php

namespace App\Console\Commands;

use App\Models\License;
use Illuminate\Console\Command;

class MakeLicenseInactive extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:make-license-inactive';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make license inactive';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        License::whereDate('expires_at', '<', now())->update(['status' => 'inactive']);
    }
}
