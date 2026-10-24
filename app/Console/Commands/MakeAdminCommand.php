<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class MakeAdminCommand extends Command
{
    protected $signature = 'store:make-admin {email : Email address of the existing user to promote}';

    protected $description = 'Grant store administrator access to an existing user';

    public function handle(): int
    {
        $user = User::query()->where('email', $this->argument('email'))->first();

        if ($user === null) {
            $this->components->error('No user exists with that email. Ask them to register first.');

            return self::FAILURE;
        }

        if ($user->is_admin) {
            $this->components->info('This user is already a store administrator.');

            return self::SUCCESS;
        }

        $user->forceFill(['is_admin' => true])->save();
        $this->components->info("Administrator access granted to {$user->email}.");

        return self::SUCCESS;
    }
}
