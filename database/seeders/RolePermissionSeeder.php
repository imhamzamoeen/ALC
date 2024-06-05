<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $AdminRole = Role::firstOrCreate([
            'name' => 'admin',
            'guard_name' => 'sanctum',
            'status' => 'active',
            'is_locked' => 0,
        ]);
        $CustomerRole = Role::firstOrCreate([
            'name' => 'customer',
            'guard_name' => 'sanctum',
            'status' => 'active',
            'is_locked' => 0,
        ]);
        $CustomerSupportRole = Role::firstOrCreate([
            'name' => 'customersupport',
            'guard_name' => 'sanctum',
            'status' => 'active',
            'is_locked' => 0,
        ]);
        $SalesSupportRole = Role::firstOrCreate([
            'name' => 'sales-support',
            'guard_name' => 'sanctum',
            'status' => 'active',
            'is_locked' => 0,
        ]);
        $TeacherRole = Role::firstOrCreate([
            'name' => 'teacher',
            'guard_name' => 'sanctum',
            'status' => 'active',
            'is_locked' => 0,
        ]);
        $TC = Role::firstOrCreate([
            'name' => 'tc',
            'guard_name' => 'sanctum',
            'status' => 'active',
            'is_locked' => 0,
        ]);
        $TeacherCoordinatorRole = Role::firstOrCreate([
            'name' => 'teacher-coordinator',
            'guard_name' => 'sanctum',
            'status' => 'active',
            'is_locked' => 0,
        ]);


        $ViewDashboardPermission = Permission::firstOrCreate([
            'name' => 'view-dashboard',
            'guard_name' => 'sanctum',
            'status' => 'active',
            'is_locked' => 0,
        ]);

        /* user permission */
        $ViewUserPermission = Permission::firstOrCreate([
            'name' => 'view-users',
            'guard_name' => 'sanctum',
            'status' => 'active',
            'is_locked' => 0,
        ]);
        $AddUserPermission = Permission::firstOrCreate([
            'name' => 'add-users',
            'guard_name' => 'sanctum',
            'status' => 'active',
            'is_locked' => 0,
        ]);
        $EditUserPermission = Permission::firstOrCreate([
            'name' => 'edit-users',
            'guard_name' => 'sanctum',
            'status' => 'active',
            'is_locked' => 0,
        ]);
        $DeleteUserPermission = Permission::firstOrCreate([
            'name' => 'delete-users',
            'guard_name' => 'sanctum',
            'status' => 'active',
            'is_locked' => 0,
        ]);

        /* courses permission */

        $AddCoursePermission = Permission::firstOrCreate([
            'name' => 'add-courses',
            'guard_name' => 'sanctum',
            'status' => 'active',
            'is_locked' => 0,
        ]);
        $EditCoursePermission = Permission::firstOrCreate([
            'name' => 'edit-courses',
            'guard_name' => 'sanctum',
            'status' => 'active',
            'is_locked' => 0,
        ]);
        $DeleteCoursePermission = Permission::firstOrCreate([
            'name' => 'delete-courses',
            'guard_name' => 'sanctum',
            'status' => 'active',
            'is_locked' => 0,
        ]);


        $ViewCoursePermission = Permission::firstOrCreate([
            'name' => 'view-courses',
            'guard_name' => 'sanctum',
            'status' => 'active',
            'is_locked' => 0,
        ]);


        // $SalesSupportRole->givePermissionTo($ViewUserPermission);
        // $TC->givePermissionTo($ViewDashboardPermission);
        // $TC->givePermissionTo($ViewUserPermission);
        // $TC->givePermissionTo($AddUserPermission);
        // $TC->givePermissionTo($EditUserPermission);
        // $TC->givePermissionTo($DeleteUserPermission);

        $TC->syncPermissions([
            $AddCoursePermission, $EditCoursePermission, $DeleteCoursePermission, $ViewCoursePermission,
            $ViewDashboardPermission,
            $ViewUserPermission,
            $AddUserPermission,
            $EditUserPermission,
            $DeleteUserPermission,

        ]);

        $CustomerSupportRole->givePermissionTo($ViewUserPermission);
        $CustomerSupportRole->givePermissionTo($AddUserPermission);
        $CustomerSupportRole->givePermissionTo($EditUserPermission);
        $CustomerSupportRole->givePermissionTo($DeleteUserPermission);
        $CustomerSupportRole->givePermissionTo($ViewDashboardPermission);


        User::find(1)->assignRole($AdminRole);
        User::find(2)->assignRole($SalesSupportRole);
        User::find(3)->assignRole($CustomerRole);
        User::find(4)->assignRole($TeacherCoordinatorRole);
        User::find(5)->assignRole($TeacherRole);
        User::find(6)->assignRole($CustomerSupportRole);
        User::find(7)->assignRole($TC);
    }
}
