<?php

use Illuminate\Database\Seeder;

class StudentPermission extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Laravue\Models\Permission::findOrCreate('view students', 'api');
        \App\Laravue\Models\Permission::findOrCreate('manage students', 'api');

        // Assign new permissions to admin group
        $adminRole = App\Laravue\Models\Role::findByName(App\Laravue\Acl::ROLE_ADMIN);
        $adminRole->givePermissionTo(['view students', 'manage students']);
    }
}
