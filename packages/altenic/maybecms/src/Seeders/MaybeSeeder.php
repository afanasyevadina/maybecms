<?php

namespace Altenic\MaybeCms\Seeders;

use Altenic\MaybeCms\Models\Page;
use Altenic\MaybeCms\Models\Role;
use Altenic\MaybeCms\Models\Setting;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class MaybeSeeder extends Seeder
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
        $modelName = config('maybecms.user_model');
        $user = $modelName::firstOrCreate([
            'email' => 'admin@admin.com',
        ], [
            'name' => 'Admin',
            'password' => Hash::make('gsd8ythwg8h8h4'),
        ]);
        $user->roles()->attach(Role::where('slug', 'admin')->first());
        $page = Page::firstOrCreate([
            'title' => 'Главная',
        ]);
        $page->update(['user_id' => $user->id]);
        Setting::query()->insert([
            [
                'title' => 'Название сайта',
                'slug' => 'site_name',
                'type' => 'text',
                'value' => env('APP_NAME'),
            ],
            [
                'title' => 'Главная страница',
                'slug' => 'home_page',
                'type' => 'select',
                'value' => $page->id,
            ],
            [
                'title' => 'Активная тема',
                'slug' => 'active_theme',
                'type' => 'select',
                'value' => 'maybe_theme',
            ],
        ]);
        Setting::query()->update(['user_id' => $user->id]);
    }
}