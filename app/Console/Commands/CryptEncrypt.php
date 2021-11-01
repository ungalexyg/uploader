<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Lib\Crypt;

class CryptEncrypt extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crypt:encrypt {value}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Encrypt - short version - for ids';

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
        $value = $this->argument('value');
        $encrypted = Crypt::encrypt($value);
        $this->info($encrypted);        
    }
}
