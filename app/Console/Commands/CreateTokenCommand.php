<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class CreateTokenCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auth:create-token';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new user and generate an API token';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $user = User::factory()->create();
        $token = $user->createToken('auth-token');

        $this->info('User created successfully.');
        $this->info('API Token: '.$token->plainTextToken);
    }
}
