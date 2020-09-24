<?php

use Illuminate\Database\Seeder;

class FeePermission extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        \App\Laravue\Models\Permission::findOrCreate('view fee', 'api');
        \App\Laravue\Models\Permission::findOrCreate('manage fee', 'api');

        // Assign new permissions to admin group
        $adminRole = App\Laravue\Models\Role::findByName(App\Laravue\Acl::ROLE_ADMIN);
        $adminRole->givePermissionTo(['view fee', 'manage fee']);

    }
}
