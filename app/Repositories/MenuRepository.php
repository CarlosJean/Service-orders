<?php

namespace App\Repositories;

use App\Models\Menu;
use App\Models\Role;
use App\Models\Submenu;
use Illuminate\Support\Facades\DB;

class MenuRepository
{
    
    public static function submenusByRole()
    {
        //Find current logged user´s id
        $userId = auth()->id();
        
        //Find user´s role
        $role = Role::where('id', $userId)
        ->first();

        //Array to store menus and submenus information
        $submenusByRole = array();

        $currentMenuName = '';
        foreach ($role->submenus as $submenu) {

            $newSubmenu = array('name' => $submenu->name);

            $isNewMenu = ($currentMenuName != $submenu->menu->name);
            if ($isNewMenu) {

                $menu = array(
                    'name' => $submenu->menu->name, 
                    'icon' => $submenu->menu->icon
                );

                $newArray = array(
                    'menu' => $menu,
                    'submenus' => array($newSubmenu)
                );

                array_push($submenusByRole, $newArray);
            } else {
                $lastIndex = count($submenusByRole) - 1;
                array_push($submenusByRole[$lastIndex]['submenus'], $newSubmenu);
            }

            $currentMenuName = $submenu->menu->name;
        }

        return $submenusByRole;
    }
}