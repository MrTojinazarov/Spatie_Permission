<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make(123456789),
        ]);

        $role1 = Role::create([
            'name' => 'admin',
        ]);

        $role2 = Role::create([
            'name' => 'hr',
        ]);

        $routes = Route::getRoutes();

        foreach($routes as $route){

            $key = $route->getName();

            if($key && !str_starts_with($key, 'generated::') && $key !== 'storage.local'){
                $permission = Permission::create([
                    'name' => $key,
                ]);
                $role1->givePermissionTo($permission);
                $role2->givePermissionTo($permission);
            }
        }

        $user->assignRole($role1);
    }
}
