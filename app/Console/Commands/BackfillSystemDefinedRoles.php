<?php

namespace App\Console\Commands;

use App\Enums\RoleEnum;
use App\Http\Definitions\RoleDefinitions;
use App\Mail\PasswordMail;
use App\Mail\RegisterMail;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;


class BackfillSystemDefinedRoles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:backfill-system-defined-roles';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if (!$this->confirm('Do you want to bakfill the system defined roles')) {
            die;
        }

        $this->info('Bakfilling permissions');

        $systemDefinedRoles = RoleDefinitions::get();

        $progressBar = $this->output->createProgressBar(count($systemDefinedRoles));

        DB::transaction(function () use ($systemDefinedRoles, &$progressBar) {

            foreach ($systemDefinedRoles as $systemDefinedRole) {
                /** @var Role $role */
                $role = Role::create([
                    'slug' => $systemDefinedRole['slug'],
                    'name' => $systemDefinedRole['name'],
                    'is_system_role' => $systemDefinedRole['readOnly'],
                ]);

                $permissons = Permission::query()
                    ->whereIn('key', $systemDefinedRole['permissions'])
                    ->get()
                    ->pluck('id')
                    ->toArray();

                $role->permissions()->sync($permissons);

                if ($role->slug === RoleEnum::ADMIN->value) {
                    $password = Str::random(10);

                    /** @var User $user */
                    $user = User::create([
                        'name' => 'System',
                        'email' => 'kashu7102@gmail.com',
                        'password' => $password,
                        'mobile' => 9999999999,
                        'age' => 26,
                        'email_verified_at' => now(),
                    ]);

                    //Mail the password
                    Mail::to($user->email)->send(new PasswordMail(user: $user, password: $password));


                    $user->role()->sync([$role->id]);
                }

                $progressBar->advance();
            }
        });
    }
}
