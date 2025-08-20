<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // 1) Định nghĩa permission
        $permissions = [
            'users.view', 'users.create', 'users.update', 'users.delete',
            'posts.view', 'posts.create', 'posts.update', 'posts.delete',
        ];

        foreach ($permissions as $p) {
            Permission::firstOrCreate(['name' => $p, 'guard_name' => 'web']);
        }

        // 2) Tạo role và gán permission
        $admin = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $editor = Role::firstOrCreate(['name' => 'editor', 'guard_name' => 'web']);
        $user   = Role::firstOrCreate(['name' => 'user',   'guard_name' => 'web']);

        $admin->syncPermissions($permissions);
        $editor->syncPermissions([
            'posts.view', 'posts.create', 'posts.update', 'posts.delete',
        ]);
        $user->syncPermissions(['posts.view']);

        // 3) Tạo tài khoản admin mẫu
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            ['name' => 'Super Admin', 'password' => Hash::make('password')]
        );
        $adminUser->syncRoles(['admin']);
    }
}