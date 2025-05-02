<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
// 1) Definiujemy uprawnienia
        $perms = [
            'view invoices',
            'create invoices',
            'edit invoices',
            'delete invoices',
            'view products',
            'manage users',

        ];
        foreach ($perms as $perm) {
            Permission::firstOrCreate(['name' => $perm]);
        }

// 2) Definiujemy role i przypisujemy im uprawnienia
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $accountant = Role::firstOrCreate(['name' => 'accountant']);
        $viewer = Role::firstOrCreate(['name' => 'viewer']);

// Admin może wszystko
        $admin->givePermissionTo(Permission::all());

// Accountant widzi i edytuje faktury
        $accountant->givePermissionTo([
            'view invoices',
            'create invoices',
            'edit invoices',
        ]);

// Viewer tylko przegląda
        $viewer->givePermissionTo('view invoices');
    }
}
