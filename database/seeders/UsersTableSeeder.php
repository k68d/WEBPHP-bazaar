<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $roles = Role::whereIn('name', ['Admin', 'Business', 'Private', 'Standard'])->get();

        $roleUsersData = [
            'Admin' => ['name' => 'Admin User', 'email' => 'admin@example.com'],
            'Business' => ['name' => 'Business User', 'email' => 'business@example.com'],
            'Private' => ['name' => 'Private User', 'email' => 'private@example.com'],
            'Standard' => ['name' => 'Standard User', 'email' => 'standard@example.com'],
        ];

        foreach ($roles as $role) {
            User::create([
                'name' => $roleUsersData[$role->name]['name'],
                'email' => $roleUsersData[$role->name]['email'],
                'password' => Hash::make('!Ab12345'),
                'role_id' => $role->id,
            ]);
        }
    }
}

