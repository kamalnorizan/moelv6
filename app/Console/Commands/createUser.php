<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;
class createUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'createUser';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will create new user';

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
     * @return mixed
     */
    public function handle()
    {
        $this->call('db:seed');
        $user = User::count();
        echo 'Current users count: '.$user;
    }
}
