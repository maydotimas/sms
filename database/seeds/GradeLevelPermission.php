<?php

use Illuminate\Database\Seeder;

class GradeLevelPermission extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Laravue\Models\Permission::findOrCreate('view gradelevel', 'api');
        \App\Laravue\Models\Permission::findOrCreate('manage gradelevel', 'api');

        // Assign new permissions to admin group
        $adminRole = App\Laravue\Models\Role::findByName(App\Laravue\Acl::ROLE_ADMIN);
        $adminRole->givePermissionTo(['view gradelevel', 'manage gradelevel']);
    }
}
