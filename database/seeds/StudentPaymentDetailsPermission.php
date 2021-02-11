<?php

use Illuminate\Database\Seeder;

class StudentPaymentDetailsPermission extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Laravue\Models\Permission::findOrCreate('view studentpaymentdetails', 'api');
        \App\Laravue\Models\Permission::findOrCreate('manage studentpaymentdetails', 'api');

        // Assign new permissions to admin group
        $adminRole = App\Laravue\Models\Role::findByName(App\Laravue\Acl::ROLE_ADMIN);
        $adminRole->givePermissionTo(['view studentpaymentdetails', 'manage studentpaymentdetails']);
    }
}
