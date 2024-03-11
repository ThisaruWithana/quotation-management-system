<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'category', 
            'category.create', 
            'category-edit', 
            'category-delete', 
            'product',
            'product-create',
            'product-edit',
            'product-delete',
            'admin.user.index',
            'admin.user.create',
            'admin.user.edit',
            'admin.user.delete',
            'admin.role.index',
            'admin.role.create',
            'admin.role.edit',
            'admin.role.delete',
            'admin.permission.index',
            'admin.permission.create',
            'admin.permission.edit',
            'admin.permission.delete',
        ];

        foreach ($permissions as $permissionName) {
            Permission::create(['name' => $permissionName]);
        }

    }
}
