<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\Supplier;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        $admin = \App\Models\User::factory()->create([
            'name' => 'Omar Pérez',
            'username' => 'OmarPerez',
            'email' => '2130073@upv.edu.mx',
        ]);

        $user = \App\Models\User::factory()->create([
            'name' => 'admin',
            'username' => 'admin',
            'email' => 'admin@gmail.com',
        ]);

        //Employee::factory(5)->create();
        // AdvanceSalary::factory(25)->create();

        //Customer::factory(25)->create();
        //Supplier::factory(10)->create();

        /*for ($i=0; $i < 5; $i++) {
            Product::factory()->create([
                'product_code' => IdGenerator::generate([
                    'table' => 'products',
                    'field' => 'product_code',
                    'length' => 4,
                    'prefix' => 'PC'
                ])
            ]);
        }*/
        Category::factory(5)->create();

        Permission::create(['name' => 'pos.menu', 'group_name' => 'pos']);
        Permission::create(['name' => 'employee.menu', 'group_name' => 'employee']);
        Permission::create(['name' => 'customer.menu', 'group_name' => 'customer']);
        Permission::create(['name' => 'supplier.menu', 'group_name' => 'supplier']);
        Permission::create(['name' => 'category.menu', 'group_name' => 'category']);
        Permission::create(['name' => 'product.menu', 'group_name' => 'product']);
        Permission::create(['name' => 'orders.menu', 'group_name' => 'orders']);
        Permission::create(['name' => 'stock.menu', 'group_name' => 'stock']);
        Permission::create(['name' => 'roles.menu', 'group_name' => 'roles']);
        Permission::create(['name' => 'user.menu', 'group_name' => 'user']);
        Permission::create(['name' => 'database.menu', 'group_name' => 'database']);

        Role::create(['name' => 'SuperAdmin'])->givePermissionTo(Permission::all());

        $admin->assignRole('SuperAdmin');
        $user->assignRole('SuperAdmin');
    }
}
