<?php

namespace App\Console\Commands;

use App\Models\Permission;
use Illuminate\Console\Command;
use App\Http\Definitions\PermissionDefinitions;

class FillPermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permission:backfill';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fill the newly added permissions';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->info('Inserting permissions');
        //array of permission
        $permissions = PermissionDefinitions::get();

        foreach ($permissions as $permission) {
            Permission::create([
                'key' => $permission['key'],
                'name' => $permission['name']
            ]);
        }

        return;
    }
}
