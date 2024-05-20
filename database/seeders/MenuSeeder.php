<?php

namespace Database\Seeders;

use App\Services\MenuService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{

    public function run()
    {
        $menus = collect([
            // Dashboard
            [
                'url' => '/',
                'name' => 'Home',
                'icon' => 'dashboard',
                'is_active' => true,
                'children' => [],
            ],
            // Bumi Ngapak Raya
            [
                'url' => '/bumi-ngapak-raya',
                'name' => 'Bumi Ngapak Raya',
                'icon' => 'public',
                'is_active' => true,
                'children' => [],
            ],
            // Data
            [
                'url' => '/data',
                'name' => 'Data',
                'icon' => 'pie_chart',
                'is_active' => true,
                'children' => [[
                    'url' => '/region',
                    'name' => 'Region',
                    'icon' => 'arrow_forward',
                    'is_active' => true,
                    'children' => [],
                ], [
                    'url' => '/sub-region',
                    'name' => 'Sub Region',
                    'icon' => 'arrow_forward',
                    'is_active' => true,
                    'children' => [],
                ], [
                    'url' => '/organisasi',
                    'name' => 'Organisasi',
                    'icon' => 'arrow_forward',
                    'is_active' => true,
                    'children' => [],
                ], [
                    'url' => '/korlap',
                    'name' => 'Korlap',
                    'icon' => 'arrow_forward',
                    'is_active' => true,
                    'children' => [],
                ], [
                    'url' => '/relawan',
                    'name' => 'Relawan',
                    'icon' => 'arrow_forward',
                    'is_active' => true,
                    'children' => [],
                ],],
            ],
            // Peserta
            [
                'url' => '/peserta',
                'name' => 'Peserta',
                'icon' => 'group',
                'is_active' => true,
                'children' => [[
                    'url' => '/hadir',
                    'name' => 'Hadir',
                    'icon' => 'arrow_forward',
                    'is_active' => true,
                    'children' => [],
                ]],
            ],
            // Rekap Peserta
            [
                'url' => '/rekap-peserta',
                'name' => 'Rekap Peserta',
                'icon' => 'groups',
                'is_active' => true,
                'children' => [],
            ],
            // logout
            [
                'url' => '/auth/logout',
                'name' => 'Logout',
                'icon' => 'logout',
                'is_active' => true,
                'children' => [],
            ],


        ]);

        $no = 1;

        foreach ($menus->all() as $menu) {
            $parent = MenuService::createMenu($menu);

            if (isset($menu['children'])) {

                $no_2 = 1;

                foreach ($menu['children'] as $child) {
                    $child['order_no'] = $no_2;
                    $child['parent_id'] = $parent->id;
                    $child['url'] = $parent->url . $child['url'];


                    MenuService::createMenu($child);

                    $no_2++;
                }
            }

            $no++;
        }
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function ____run()
    {
        $menus = collect([
            [
                'url' => '/home',
                'name' => 'Dashboard',
                'icon' => 'dashboard',
                'is_active' => true,
                'children' => [],
            ],
            [
                'url' => '/settings',
                'name' => 'Settings',
                'icon' => 'settings',
                'is_active' => true,
                'children' => [],
            ],
            [
                'url' => '/auth/logout',
                'name' => 'Logout',
                'icon' => 'logout',
                'is_active' => true,
                'children' => [],
            ],
        ]);


        $no = 1;

        foreach ($menus->all() as $menu) {
            $menu['order_no'] = $no;
            $parent = MenuService::createMenu($menu);

            if (isset($menu['children'])) {

                $no_2 = 1;
                foreach ($menu['children'] as $child) {
                    $child['order_no'] = $no_2;
                    $child['parent_id'] = $parent->id;
                    MenuService::createMenu($child);

                    $no_2++;
                }
            }

            $no++;
        }
    }
}
