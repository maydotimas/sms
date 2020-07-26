<?php

use Illuminate\Database\Seeder;

class SubFeePermission extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Laravue\Models\Permission::findOrCreate('view subfee', 'api');
        \App\Laravue\Models\Permission::findOrCreate('manage subfee', 'api');

        // Assign new permissions to admin group
        $adminRole = App\Laravue\Models\Role::findByName(App\Laravue\Acl::ROLE_ADMIN);
        $adminRole->givePermissionTo(['view subfee', 'manage subfee']);
    }
}
