<?php

namespace App\Console\Commands;

use App\Http\Definitions\RoleDefinitions;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Console\Command;

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

            $progressBar->advance();
        }

        $progressBar->finish();
    }
}
