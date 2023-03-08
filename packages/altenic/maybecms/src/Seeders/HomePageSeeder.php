<?php

namespace Altenic\MaybeCms\Seeders;

use Altenic\MaybeCms\Models\Page;
use Altenic\MaybeCms\Models\Setting;
use Illuminate\Database\Seeder;

class HomePageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userModel = config('maybecms.user_model');
        $admin = $userModel::whereHas('roles', fn($query) => $query->where('slug', 'admin'))->firstOrNew();
        $page = Page::firstOrCreate([
            'title' => 'Главная',
        ]);
        $page->update(['user_id' => $admin->id]);
        $setting = Setting::query()->create([
            'title' => 'Главная страница',
            'slug' => 'home_page',
            'type' => 'select',
            'value' => $page->id,
        ]);
        $setting->update(['user_id' => $admin->id]);
    }
}
