<div>
    @if($showModal)
    <div class="modal fade show" style="display: block;" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Éditer les permissions de {{ $role->name }}</h5>
                    <button type="button" class="btn-close" wire:click="closeModal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if($allPermissions && count($allPermissions) > 0)
                        @foreach($allPermissions as $permission)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox"
                                       wire:model.defer="selectedPermissions"
                                       value="{{ $permission->name }}"
                                       id="perm_{{ $role->id }}_{{ $permission->id }}">
                                <label class="form-check-label" for="perm_{{ $role->id }}_{{ $permission->id }}">
                                    {{ $permission->name }}
                                </label>
                            </div>
                        @endforeach
                    @else
                        <p>Aucune permission disponible.</p>
                    @endif
                    @error('selectedPermissions') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" wire:click="closeModal">Fermer</button>
                    <button type="button" class="btn btn-primary" wire:click="updateRolePermissions">Sauvegarder</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-backdrop fade show" style="display: block;"></div>
    @endif
</div> 