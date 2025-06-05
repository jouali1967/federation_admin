<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;

class NavLinkComposer
{
    protected $navLinks = [];

    public function __construct()
    {
        $allPermissions = Permission::all();

        foreach ($allPermissions as $permission) {
            $this->navLinks[] = [
                'label'      => Str::title(str_replace(['.', '_'], ' ', $permission->name)),
                'route'      => $permission->name,
                'permission' => $permission->name,
            ];
        }
    }

    /**
     * Bind data to the view.
     *
     * @param  \Illuminate\View\View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('navLinks', $this->navLinks);
    }
} 