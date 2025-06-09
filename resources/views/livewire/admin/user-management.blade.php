<div class="container">
  <div class="row align-items-center mb-4">
    <div class="col-md-4">
      <button wire:click="openCreateUserModal" id="btnnew" class="btn btn-primary">Nouveau Utilisateur</button>
    </div>
    <div class="col-md-4 text-center">
      <h2 class="mb-0">Gestion des Utilisateurs</h2>
    </div>
    <div class="col-md-4 text-end">
      <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">Retour au Dashboard</a>
    </div>
  </div>

  @if (session()->has('message'))
  <div class="alert alert-success">
    {{ session('message') }}
  </div>
  @endif

  {{-- Modal de création d'utilisateur --}}
  @if($showCreateUserModal)
  <div class="modal fade show" style="display: block;" tabindex="-1" role="dialog"
    aria-labelledby="createUserModalLabel" aria-hidden="false">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <form wire:submit.prevent="createUser">
          <div class="modal-header">
            <h5 class="modal-title" id="createUserModalLabel">Créer un nouvel utilisateur</h5>
            <button type="button" class="btn-close" wire:click="closeCreateUserModal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label for="newName" class="form-label">Nom</label>
              <input type="text" class="form-control @error('newName') is-invalid @enderror" id="newName"
                wire:model.defer="newName">
              @error('newName') <span class="invalid-feedback">{{ $message}}</span> @enderror
            </div>
            <div class="mb-3">
              <label for="newEmail" class="form-label">Email</label>
              <input type="email" class="form-control @error('newEmail') is-invalid @enderror" id="newEmail"
                wire:model.defer="newEmail">
              @error('newEmail') <span class="invalid-feedback">{{ $message}}</span> @enderror
            </div>
            <div class="mb-3">
              <label for="newPassword" class="form-label">Mot de passe</label>
              <input type="password" class="form-control @error('newPassword') is-invalid @enderror" id="newPassword"
                wire:model.defer="newPassword">
              @error('newPassword') <span class="invalid-feedback">{{ $message}}</span> @enderror
            </div>
            <div class="mb-3">
              <label for="newPassword_confirmation" class="form-label">Confirmer le mot de passe</label>
              <input type="password" class="form-control" id="newPassword_confirmation"
                wire:model.defer="newPassword_confirmation">
            </div>
            <hr>
            <div wire:ignore class="mb-3">
              <label for="newUserRolesSelect" class="form-label">Assign Roles:</label>
              <select wire:model="newUserRoles" id="newUserRolesSelect" class="form-select" multiple>
                @foreach ($roles as $role)
                <option value="{{ $role->id }}">{{ $role->name }}</option>
                @endforeach
              </select>
              @error('newUserRoles') <div class="text-danger mt-1">{{ $message}}</div> @enderror
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" wire:click="closeCreateUserModal">Fermer</button>
            <button type="submit" class="btn btn-primary">Sauvegarder</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <div class="modal-backdrop fade show" style="display: @if($showCreateUserModal) block @else none @endif;"></div>
  @endif
  {{-- Fin Modal de création --}}

  {{-- Modal for editing user --}}
  @if($showEditUserModal)
  <div class="modal fade show" style="display: block;" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel"
    aria-hidden="false">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <form wire:submit.prevent="updateUser">
          <div class="modal-header">
            <h5 class="modal-title" id="editUserModalLabel">Modifier l'utilisateur</h5>
            <button type="button" class="btn-close" wire:click="closeEditUserModal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label for="editingUserName" class="form-label">Nom</label>
              <input type="text" class="form-control @error('editingUserName') is-invalid @enderror"
                id="editingUserName" wire:model.defer="editingUserName">
              @error('editingUserName') <span class="invalid-feedback">{{ $message}}</span> @enderror
            </div>
            <div class="mb-3">
              <label for="editingUserEmail" class="form-label">Email</label>
              <input type="email" class="form-control @error('editingUserEmail') is-invalid @enderror"
                id="editingUserEmail" wire:model.defer="editingUserEmail">
              @error('editingUserEmail') <span class="invalid-feedback">{{ $message}}</span> @enderror
            </div>
            <div class="mb-3">
              <label for="editingUserPassword" class="form-label">Nouveau mot de passe (laisser vide pour ne pas
                changer)</label>
              <div class="input-group">
                <input type="password" class="form-control @error('editingUserPassword') is-invalid @enderror"
                  id="editingUserPassword" wire:model.defer="editingUserPassword">
                <button class="btn btn-outline-secondary" type="button"
                  onclick="togglePasswordVisibility(this, 'editingUserPassword')">
                  <i class="bi bi-eye"></i>
                </button>
              </div>
              @error('editingUserPassword') <span class="invalid-feedback d-block">{{ $message}}</span> @enderror
            </div>
            <div class="mb-3">
              <label for="editingUserPassword_confirmation" class="form-label">Confirmer le nouveau mot de passe</label>
              <div class="input-group">
                <input type="password" class="form-control" id="editingUserPassword_confirmation"
                  wire:model.defer="editingUserPassword_confirmation">
                <button class="btn btn-outline-secondary" type="button"
                  onclick="togglePasswordVisibility(this, 'editingUserPassword_confirmation')">
                  <i class="bi bi-eye"></i>
                </button>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" wire:click="closeEditUserModal">Fermer</button>
            <button type="submit" class="btn btn-primary">Sauvegarder les modifications</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <div class="modal-backdrop fade show" style="display: @if($showEditUserModal) block @else none @endif;"></div>
  @endif
  {{-- End of edit user modal --}}

  <div class="table-responsive">
    <table class="table table-striped table-bordered tabele-sm">
      <thead>
        <tr>
          <th>Nom</th>
          <th>Email</th>
          <th>Rôles</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach($users as $user)
        <tr>
          <td>{{ $user->name }}</td>
          <td>{{ $user->email }}</td>
          <td>{{ $user->roles->pluck('name')->implode(', ') }}</td>
          <td>
            <button class="btn btn-primary btn-sm" wire:click="editUser({{ $user->id }})">
              Éditer les rôles
            </button>
            <button class="btn btn-secondary btn-sm" wire:click="openEditUserModal({{ $user->id }})">
              Modifier
            </button>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  @if($selectedUser)
  <div class="modal fade show" style="display: block;">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Éditer les rôles de {{ $selectedUser->name }}</h5>
          <button type="button" class="btn-close" wire:click="closeModal"></button>
        </div>
        <div class="modal-body">
          @foreach($roles as $role)
          <div class="form-check">
            <input class="form-check-input" type="checkbox" wire:model="selectedRoles" value="{{ $role->name }}"
              id="role_{{ $role->id }}">
            <label class="form-check-label" for="role_{{ $role->id }}">
              {{ $role->name }}
            </label>
          </div>
          @endforeach
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" wire:click="closeModal">
            Fermer
          </button>
          <button type="button" class="btn btn-primary" wire:click="updateUserRoles">
            Sauvegarder
          </button>
        </div>
      </div>
    </div>
  </div>
  <div class="modal-backdrop fade show"></div>
  @endif
  @script()
  <script>
    $(document).ready(function(){
      function loadJavascript() {
        const newUserRolesSelect = $('#newUserRolesSelect');
        if (newUserRolesSelect.length) {
          if (newUserRolesSelect.hasClass("select2-hidden-accessible")) {
            newUserRolesSelect.select2('destroy');
          }
          newUserRolesSelect.select2({
          dropdownParent: newUserRolesSelect.closest('.modal-body'),
          placeholder: 'Select roles' // Optional: adds a placeholder
        }).on('change', function() {
            $wire.set('newUserRoles', $(this).val());
          });
        }
      }
      loadJavascript(); // Initialise au chargement de la page
      Livewire.hook('morphed', () => {
        loadJavascript(); // Réinitialise après un DOM morph (submit, update)
      });
      Livewire.on('userManagementModalOpened', () => {
          loadJavascript();
      });
    })
  </script>
  @endscript

  @push('scripts')
  <script>
    function togglePasswordVisibility(button, fieldId) {
      const field = document.getElementById(fieldId);
      const icon = button.querySelector('i');
      if (field.type === 'password') {
        field.type = 'text';
        icon.classList.remove('bi-eye');
        icon.classList.add('bi-eye-slash');
      } else {
        field.type = 'password';
        icon.classList.remove('bi-eye-slash');
        icon.classList.add('bi-eye');
      }
    }
  </script>
  @endpush
</div>