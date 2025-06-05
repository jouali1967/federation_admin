<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleManagement extends Component
{
    public $roles;
    public $permissions;
    public ?Role $selectedRole = null;
    public $newRoleName = '';

    protected $listeners = [
        'closeRoleEditModal' => 'closeModal',
        'permissionsUpdated' => 'refreshRoles'
    ];
    
    public function mount()
    {
        $this->roles = Role::with('permissions')->get();
        $this->permissions = Permission::all();
    }

    public function createRole()
    {
        $this->validate([
            'newRoleName' => 'required|min:3|unique:roles,name'
        ]);

        Role::create(['name' => $this->newRoleName]);
        $this->newRoleName = '';
        $this->refreshRoles();
        session()->flash('message', 'Rôle créé avec succès.');
    }

    public function editRole($roleId)
    {
        $this->selectedRole = Role::find($roleId);
    }

    public function closeModal()
    {
        $this->selectedRole = null;
    }

    public function refreshRoles()
    {
        $this->roles = Role::with('permissions')->get();
    }

    public function render()
    {
        return view('livewire.admin.role-management')
               ->layout('layouts.admin');
    }
}