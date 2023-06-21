<?php

namespace App\Repositories;

use App\Models\Role;

class MenuRepository
{

    public static function submenusByRole()
    {
        //Find current logged user´s id
        $userId = auth()->id();

        //Find user´s role id
        $employeeRepository  = new EmployeeRepository();
        $roleId = $employeeRepository->employeeByUserId($userId)['roleId'];

        //Find user´s role
        $role = Role::find($roleId);

        //Array to store menus and submenus information
        $submenusByRole = array();

        $currentMenuName = '';
        $submenus = $role->submenus
            ->sortBy(['menu_id', 'order']);

        foreach ($submenus as $submenu) {

            $newSubmenu = array(
                'name' => $submenu->name,
                'icon' => $submenu?->icon,
                'url' => $submenu?->url ?? '/'
            );

            $isNewMenu = ($currentMenuName != $submenu->menu?->name);

            if ($isNewMenu || $submenu->menu?->name == null) {

                $menu = array(
                    'name' => $submenu->menu?->name,
                    'icon' => $submenu->menu?->icon,
                    'url' => $submenu?->url ?? '/'
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

            $currentMenuName = $submenu->menu?->name;
        }

        return $submenusByRole;
    }
}
