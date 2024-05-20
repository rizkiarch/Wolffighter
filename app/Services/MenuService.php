<?php

namespace App\Services;

use App\Models\Menu;
use App\Models\User;
use Illuminate\Support\Collection;

class MenuService
{
    public $items = [];

    public function __construct(
        public ?User $user
    ) {
        $this->makeMenu();
    }

    public static function createMenu($data)
    {
        unset($data['children']);
        return Menu::firstOrCreate($data);
    }

    private function makeMenu()
    {
        $this->items = Menu::with(['children', 'children.children'])
            ->where('is_active', true)
            ->where('parent_id', 0)
            ->orderBy('order_no')
            ->get();
    }

    public function get()
    {
        return $this->items;
    }
}
