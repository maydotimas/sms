<?php

use Illuminate\Database\Seeder;

class PaymentModePermission extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Laravue\Models\Permission::findOrCreate('view paymentmode', 'api');
        \App\Laravue\Models\Permission::findOrCreate('manage paymentmode', 'api');

        // Assign new permissions to admin group
        $adminRole = App\Laravue\Models\Role::findByName(App\Laravue\Acl::ROLE_ADMIN);
        $adminRole->givePermissionTo(['view paymentmode', 'manage paymentmode']);
    }
}
