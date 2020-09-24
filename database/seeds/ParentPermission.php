<?php

use Illuminate\Database\Seeder;

class ParentPermission extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Laravue\Models\Permission::findOrCreate('view parents', 'api');
        \App\Laravue\Models\Permission::findOrCreate('manage parents', 'api');

        // Assign new permissions to admin group
        $adminRole = App\Laravue\Models\Role::findByName(App\Laravue\Acl::ROLE_ADMIN);
        $adminRole->givePermissionTo(['view parents', 'manage parents']);
    }
}
