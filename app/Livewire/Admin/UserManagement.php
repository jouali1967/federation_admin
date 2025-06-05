<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserManagement extends Component
{
    public $users;
    public $roles;
    public $selectedUser;
    public $selectedRoles = [];

    // Propriétés pour le formulaire de création
    public $newName = '';
    public $newEmail = '';
    public $newPassword = '';
    public $newPassword_confirmation = '';
    public $newUserRoles = []; // Sera un tableau d'ID de rôles
    public bool $showCreateUserModal = false;

    public function mount()
    {
        $this->users = User::with('roles')->get();
        $this->roles = Role::all(); // S'assurer que les rôles sont chargés pour le formulaire de création
    }

    public function editUser($userId)
    {
        $this->selectedRoles = []; // Reset before loading
        $this->selectedUser = User::find($userId);
        if ($this->selectedUser) {
            $this->selectedRoles = $this->selectedUser->roles->pluck('name')->toArray();
        } else {
            $this->selectedRoles = []; // Ensure it's reset if user not found
            // Optionally, flash an error message if user not found
            // session()->flash('error', 'Utilisateur non trouvé.');
        }
    }

    public function updateUserRoles()
    {
        if ($this->selectedUser) {
            $this->validate([
                'selectedRoles' => 'nullable|array',
                'selectedRoles.*' => 'string|exists:roles,name'
            ]);
            $this->selectedUser->syncRoles($this->selectedRoles);
            session()->flash('message', 'Rôles mis à jour avec succès.');
            $this->selectedUser = null;
            $this->selectedRoles = [];
            $this->users = User::with('roles')->get(); // Refresh users list
        }
    }

    public function closeModal()
    {
        $this->selectedUser = null;
        $this->selectedRoles = [];
    }

    // Méthodes pour le modal de création d'utilisateur
    public function openCreateUserModal()
    {
        $this->resetCreateUserForm();
        $this->showCreateUserModal = true;
        $this->dispatch('userManagementModalOpened');
    }

    public function closeCreateUserModal()
    {
        $this->showCreateUserModal = false;
        $this->resetCreateUserForm();
    }

    public function resetCreateUserForm()
    {
        $this->newName = '';
        $this->newEmail = '';
        $this->newPassword = '';
        $this->newPassword_confirmation = '';
        $this->newUserRoles = [];
        $this->resetErrorBag(); // Réinitialise les erreurs de validation pour le formulaire de création
    }

    public function createUser()
    {
        $validatedData = $this->validate([
            'newName' => 'required|string|max:255',
            'newEmail' => 'required|string|email|max:255|unique:users,email',
            ////'newPassword' => ['required', 'string', Password::min(8)->mixedCase()->numbers()->symbols(), 'confirmed'],
            'newPassword' => ['required', 'string', Password::min(8), 'confirmed'],
            'newUserRoles' => 'nullable|array',
            'newUserRoles.*' => 'exists:roles,id', // Valider que chaque ID de rôle existe
        ]);
        $user = User::create([
            'name' => $validatedData['newName'],
            'email' => $validatedData['newEmail'],
            'password' => Hash::make($validatedData['newPassword']),
        ]);

        if (!empty($validatedData['newUserRoles'])) {
            // Fetch Role models based on the provided IDs
            $rolesToSync = Role::whereIn('id', $validatedData['newUserRoles'])->get();
           
            $user->syncRoles($rolesToSync); // Use syncRoles with Role models
        } else {
            // If newUserRoles is empty, ensure all roles are detached
            $user->syncRoles([]);
        }

        session()->flash('message', 'Utilisateur créé avec succès.');
        $this->closeCreateUserModal();
        $this->users = User::with('roles')->get(); // Rafraîchir la liste des utilisateurs
    }

    public function render()
    {
        return view('livewire.admin.user-management')
               ->layout('layouts.admin');
    }
}