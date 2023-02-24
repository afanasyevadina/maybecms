<?php

namespace Altenic\MaybeCms\Seeders;

use Altenic\MaybeCms\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::upsert([
            ['slug' => 'admin', 'title' => 'Admin'],
        ], ['slug', 'title'], []);
    }
}
