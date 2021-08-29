<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
class RoleHasPermission extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::find(1);
        $permissions = Permission::all();
        foreach($permissions as $permission):
            $role->givePermissionTo($permission->name);
        endforeach;
    }
}
