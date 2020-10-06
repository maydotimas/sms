<?php

use App\Laravue\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Laravue\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@laravue.dev',
            'password' => Hash::make('laravue'),
        ]);
        $manager = User::create([
            'name' => 'Manager',
            'email' => 'manager@laravue.dev',
            'password' => Hash::make('laravue'),
        ]);
        $editor = User::create([
            'name' => 'Editor',
            'email' => 'editor@laravue.dev',
            'password' => Hash::make('laravue'),
        ]);
        $user = User::create([
            'name' => 'User',
            'email' => 'user@laravue.dev',
            'password' => Hash::make('laravue'),
        ]);
        $visitor = User::create([
            'name' => 'Visitor',
            'email' => 'visitor@laravue.dev',
            'password' => Hash::make('laravue'),
        ]);

        $adminRole = Role::findByName(\App\Laravue\Acl::ROLE_ADMIN);
        $managerRole = Role::findByName(\App\Laravue\Acl::ROLE_MANAGER);
        $editorRole = Role::findByName(\App\Laravue\Acl::ROLE_EDITOR);
        $userRole = Role::findByName(\App\Laravue\Acl::ROLE_USER);
        $visitorRole = Role::findByName(\App\Laravue\Acl::ROLE_VISITOR);

        $this->call(CategoryPermission::class);
        $this->call(DepartmentPermission::class);
        $this->call(GradeLevelPermission::class);
        $this->call(SectionPermission::class);
        $this->call(SubjectPermission::class);
        $this->call(FeePermission::class);
        $this->call(SubFeePermission::class);
        $this->call(PaymentModePermission::class);
        $this->call(PaymentModeTypePermission::class);
        $this->call(StudentPermission::class);
        $this->call(ParentPermission::class);

        $admin->syncRoles($adminRole);
        $manager->syncRoles($managerRole);
        $editor->syncRoles($editorRole);
        $user->syncRoles($userRole);
        $visitor->syncRoles($visitorRole);

        $this->call(UsersTableSeeder::class);
//        $this->call(CategoriesSeeder::class);

        $this->call(BarangaySeeder::class);
//        $this->call(CityTableSeeder::class);
        $this->call(ProvinceTableSeeder::class);
        $this->call(CitiesTableSeeder::class);
    }
}
