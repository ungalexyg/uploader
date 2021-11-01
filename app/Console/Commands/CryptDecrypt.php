<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Lib\Crypt;

class CryptDecrypt extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crypt:decrypt {value}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Decrypt - short version - for ids';

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
        $decrypted = Crypt::decrypt($value);        
        $this->info($decrypted);        
    }
}
