<?php

use Illuminate\Database\Seeder;

class PaymentModeTypePermission extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Laravue\Models\Permission::findOrCreate('view paymentmodetype', 'api');
        \App\Laravue\Models\Permission::findOrCreate('manage paymentmodetype', 'api');

        // Assign new permissions to admin group
        $adminRole = App\Laravue\Models\Role::findByName(App\Laravue\Acl::ROLE_ADMIN);
        $adminRole->givePermissionTo(['view paymentmodetype', 'manage paymentmodetype']);
    }
}
