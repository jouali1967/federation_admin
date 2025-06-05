<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Gestion des Rôles</h2>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">Retour au Dashboard</a>
    </div>

    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    <div class="card mb-4">
        <div class="card-header">Créer un nouveau rôle</div>
        <div class="card-body">
            <form wire:submit.prevent="createRole">
                <div class="mb-3">
                    <label for="newRoleName" class="form-label">Nom du rôle</label>
                    <input type="text" class="form-control" id="newRoleName" wire:model="newRoleName">
                    @error('newRoleName') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <button type="submit" class="btn btn-primary">Créer</button>
            </form>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Rôle</th>
                    <th>Permissions</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($roles as $role)
                    <tr>
                        <td>{{ $role->name }}</td>
                        <td>{{ $role->permissions->pluck('name')->implode(', ') }}</td>
                        <td>
                            <button class="btn btn-primary btn-sm" wire:click="editRole({{ $role->id }})">
                                Éditer les permissions
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if($selectedRole)
        @livewire('admin.edit-role-permissions-modal', ['role' => $selectedRole, 'allPermissions' => $permissions], key($selectedRole->id))
    @endif
</div>
