            <fieldset class="mb-3">
              <legend class="form-label">Assign Roles:</legend>
              <div>
                @foreach ($roles as $role)
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="checkbox" id="role_{{ $role->id }}" value="{{ $role->id }}" wire:model="newUserRoles">
                  <label class="form-check-label" for="role_{{ $role->id }}">{{ $role->name }}</label>
                </div>
                @endforeach
              </div>
              @error('newUserRoles') <div class="text-danger mt-1">{{ $message}}</div> @enderror
            </fieldset> 