<?php

use Illuminate\Database\Seeder;

class StudentPaymentPermission extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Laravue\Models\Permission::findOrCreate('view studentpayment', 'api');
        \App\Laravue\Models\Permission::findOrCreate('manage studentpayment', 'api');

        // Assign new permissions to admin group
        $adminRole = App\Laravue\Models\Role::findByName(App\Laravue\Acl::ROLE_ADMIN);
        $adminRole->givePermissionTo(['view studentpayment', 'manage studentpayment']);
    }
}
