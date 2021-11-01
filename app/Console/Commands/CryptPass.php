<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CryptPass extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crypt:pass {pass}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create hash password';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $pass = $this->argument('pass');
        $hash = Hash::make($pass);
        $this->info($hash);        
    }
}
