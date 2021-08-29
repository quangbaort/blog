<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
class PerrmissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arrPermission = [
            'view post',
            'create post',
            'edit post',
            'delete post',
            'view user',
            'create user',
            'edit user',
            'delete user',
            'view category',
            'user grant',
            'create category',
            'update category',
            'delete category',
            'view tag',
            'create tag',
            'update tag',
            'delete tag',
        ];
        for($i = 0; $i < count($arrPermission); $i++):
            Permission::create(['name' => $arrPermission[$i]]);
        endfor;
        
    }
}
