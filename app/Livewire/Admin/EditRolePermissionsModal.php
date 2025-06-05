<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class EditRolePermissionsModal extends Component
{
    public Role $role;
    public $allPermissions;
    public $selectedPermissions = [];
    public bool $showModal = false;

    protected $listeners = ['openModal' => 'open'];

    public function mount(Role $role, $allPermissions)
    {
        $this->role = $role;
        $this->allPermissions = $allPermissions;
        $this->selectedPermissions = $this->role->permissions->pluck('name')->toArray();
        $this->showModal = true; // S'affiche dès qu'il est monté avec un rôle
    }

    public function updateRolePermissions()
    {
        $this->validate([
            'selectedPermissions' => 'array',
        ]);

        $this->role->syncPermissions($this->selectedPermissions);
        session()->flash('message', 'Permissions mises à jour avec succès pour le rôle ' . $this->role->name);
        $this->dispatch('permissionsUpdated');
        $this->closeModal();
    }

    public function open(Role $role, $allPermissions)
    {
        $this->role = $role;
        $this->allPermissions = $allPermissions;
        $this->selectedPermissions = $this->role->permissions->pluck('name')->toArray();
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->dispatch('closeRoleEditModal');
    }

    public function render()
    {
        return view('livewire.admin.edit-role-permissions-modal');
    }
} 