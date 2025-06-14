<div class="container-fluid p-4">
  <div class="row mb-4">
    <div class="col-md-6">
      <h2 class="h3 mb-0">Liste des Augmentations</h2>
    </div>
    <div class="col-md-6">
      <div class="input-group">
        <input wire:model.live="search" type="text" class="form-control" placeholder="Rechercher...">
        <span class="input-group-text"><i class="fas fa-search"></i></span>
      </div>
    </div>
  </div>

  <div class="card">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-striped table-hover">
          <thead>
            <tr>
              <th>Employé</th>
              <th>Montant</th>
              <th>Date</th>
              <th>Motif</th>
              <th>Nouveau Salaire</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse($augmentations as $augmentation)
            <tr>
              <td>{{ $augmentation->personne->nom }}</td>
              <td>{{ number_format($augmentation->valeur, 2) }} </td>
              <td>{{ $augmentation->date_aug}}</td>
              <td>{{ $augmentation->motif }}</td>
              <td>{{ number_format($augmentation->nouveau_salaire, 2) }}</td>
              <td>
                <button wire:click="edit({{ $augmentation->id }})" class="btn btn-sm btn-primary me-2">
                  <i class="fas fa-edit"></i> Modifier
                </button>
                <button wire:click="delete({{ $augmentation->id }})" class="btn btn-sm btn-danger"
                  onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette augmentation ?')">
                  <i class="fas fa-trash"></i> Supprimer
                </button>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="5" class="text-center">Aucune augmentation trouvée</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <div class="mt-4">
    {{ $augmentations->links() }}
  </div>

  <!-- Modal d'édition -->
  @if($showEditModal)
  <div class="modal fade show" style="display: block;" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Modifier l'augmentation</h5>
          <button type="button" class="btn-close" wire:click="closeModal"></button>
        </div>
        <div class="modal-body">
          <form wire:submit.prevent="update">
            <div class="mb-3">
              <label class="form-label">Montant</label>
              <input type="number" step="0.01" wire:model="valeur" class="form-control">
              @error('valeur') <span class="text-danger">{{ $message}}</span> @enderror
            </div>
            <div class="mb-3">
              <label class="form-label">Type Augmentation</label>
              <select class="form-select" wire:model="type">
                <option value="fixe">Montant fixe (DH)</option>
                <option value="pourcentage">Pourcentage (%)</option>
              </select>
              @error('type') <span class="text-danger">{{ $message}}</span> @enderror
            </div>
            <div class="mb-3">
              <label class="form-label">Date</label>
              <input type="text" id="date_aug" wire:model="date_aug" class="form-control">
              @error('date_aug') <span class="text-danger">{{ $message}}</span> @enderror
            </div>
            <div class="mb-3">
              <label class="form-label">Motif</label>
              <textarea wire:model="motif" class="form-control"></textarea>
              @error('motif') <span class="text-danger">{{ $messag }}</span> @enderror
            </div>
            <div class="text-end">
              <button type="button" class="btn btn-secondary me-2" wire:click="closeModal">Annuler</button>
              <button type="submit" class="btn btn-primary">Enregistrer</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <div class="modal-backdrop fade show"></div>
  @endif
</div>
@script()
<script>
  $(document).ready(function(){
    flatpickr("#date_aug", {
      dateFormat: "d/m/Y",
      onChange: function(selectedDates, dateStr) {
        $wire.set('date_aug', dateStr);
      }
    });
  })
</script>
@endscript