<?php

namespace App\Livewire\Augmentations;

use Livewire\Component;
use App\Models\Personne;
use App\Models\Augmentation;
use Livewire\WithPagination;
use Livewire\Attributes\Rule;
use Illuminate\Support\Facades\Auth;

class ListAugmentation extends Component
{
  use WithPagination;

  public $personne_id;
  public $search = '';
  public $showEditModal = false;
  public $augmentationId;
  #[Rule('required|date_format:d/m/Y', message: 'La date de inscription est requise')]
  public $date_aug;

  #[Rule('required|numeric|min:0|decimal:0,2')]
  public $valeur;
  #[Rule('nullable', message: 'le motif est obligatoire.')]
  public $motif;
  #[Rule('required|in:fixe,pourcentage', message: 'le type est obligatoire.')]
  public $type = 'fixe';


  // public function updatingSearch()
  // {
  //     $this->resetPage();
  // }

  public function edit($id)
  {
    $augmentation = Augmentation::findOrFail($id);
    $this->augmentationId = $id;
    $this->valeur = $augmentation->valeur;
    $this->date_aug = $augmentation->date_aug;
    $this->motif = $augmentation->motif;
    $this->type = $augmentation->type;
    $this->personne_id = $augmentation->personne_id;
    $this->showEditModal = true;
  }

  public function update()
  {
    $this->validate();
    $personne = Personne::find($this->personne_id);
    $augmentation = Augmentation::findOrFail($this->augmentationId);
    $nouveau = $this->type === 'fixe'
      ? $augmentation->ancien_salaire + $this->valeur
      : $augmentation->ancien_salaire * (1 + $this->valeur / 100);
    $augmentation->update([
      'valeur' => $this->valeur,
      'date_aug' => $this->date_aug,
      'motif' => $this->motif,
      'nouveau_salaire' => $nouveau,
    ]);
    $personne->update(['salaire_base' => $nouveau]);
    $this->closeModal();
    session()->flash('message', 'Augmentation mise à jour avec succès.');
  }

  public function delete($id)
  {
    // $resul=Augmentation::first();
    // dd($resul);
    $augmentation = Augmentation::findOrFail($id);
    $personne_id=$augmentation->personne_id;
    $augmentation->delete();
    $employe=Personne::find($personne_id);
    $salaire_base_hist=$employe->salaire_base_hist;
    $personnes=Augmentation::where('personne_id',$personne_id)
                ->orderBy('id')->get();
    $mont_init=0;
    $tot_mont_aug=0;
    foreach ($personnes as $augmentation) {
      $augmentation->ancien_salaire =  $salaire_base_hist+$mont_init;
      $augmentation->nouveau_salaire = $augmentation->ancien_salaire + $augmentation->valeur;
      $mont_init=$augmentation->valeur;
      $tot_mont_aug += $augmentation->valeur;
      $augmentation->save();
    }

    $employe->update(['salaire_base' => $employe->salaire_base_hist + $tot_mont_aug]);

    session()->flash('message', 'Augmentation supprimée avec succès.');
  }

  public function closeModal()
  {
    $this->showEditModal = false;
    $this->reset(['valeur', 'date_aug', 'motif', 'augmentationId']);
  }

  public function render()
  {
    $augmentations = Augmentation::query()
      ->when($this->search, function ($query) {
        $query->whereHas('personne', function ($q) {
          $q->where('nom', 'like', '%' . $this->search . '%');
        })
          ->orWhere('motif', 'like', '%' . $this->search . '%');
      })
      ->with('personne')
      ->orderBy('id', 'desc')
      ->paginate(10);

    return view('livewire.augmentations.list-augmentation', [
      'augmentations' => $augmentations
    ]);
  }
}
