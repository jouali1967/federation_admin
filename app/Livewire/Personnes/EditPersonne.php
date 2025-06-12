<?php

namespace App\Livewire\Personnes;

use Livewire\Component;
use App\Models\Personne;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Validate;
use Illuminate\Validation\ValidationException;

class EditPersonne extends Component
{
  public $personne;
  #[Validate('required', message: 'Le nom est obligatoire.')]
  #[Validate('regex:/^[A-Z0-9\s]+$/', message: 'Le nom doit contenir uniquement des majuscules, des chiffres et des espaces.')]
  public $nom;
  #[Rule('required', message: 'Le prenom est obligatoire.')]
  #[Rule('regex:/^[A-Z0-9\s]+$/', message: 'Le prenom doit contenir uniquement des majuscules, des chiffres et des espaces.')] 
  public $prenom;
  #[Rule('required', message: 'N° telephone est obligatoire.')]
  #[Rule('numeric', message: 'Le numéro de téléphone ne doit contenir que des chiffres.')]  
  public $phone;
  #[Rule('required', message: 'Le champ adresse est obligatoire.')]
  #[Rule('regex:/^[a-zA-Z0-9\s]+$/', message: 'Adresse doit contenir uniquement des majuscules, des chiffres et des espaces.')] 
  public $adresse;
  #[Rule('required', message: "La date d'embauche est obligatoire.")]
  #[Rule('date_format:d/m/Y', message: "Le format de la date doit être JJ/MM/AAAA.")]
  public $date_embauche;
  #[Rule('required', message: "La date naissance est obligatoire.")]
  #[Rule('date_format:d/m/Y', message: "Le format de la date doit être JJ/MM/AAAA.")]
  public $date_nais;
  #[Rule('required', message: 'Sexe est obligatoire')]

  public $sexe;
  #[Rule('required', message: 'Situation famille est obligatoire')]

  public $sit_fam;
  #[Rule('nullable|email', message: [
    'email' => 'Format email non valide'
])]
  public $email;
  #[Rule('required', message: 'Fonction est obligatoire')]

  public $fonction;
  #[Rule('required', message: 'Banque est obligatoire')]

  public $banque;
  #[Rule('required|numeric|digits:24')]
  // #[Rule('integer', message: 'doit contenir que des entiers numeriques')]
  // #[Rule('digits:24', message: 'doit contenir 24 chiffres')]

  public $num_compte;
  #[Rule('required|numeric|min:0|decimal:0,2')]
  public $salaire_base;
#[Rule('required', message: 'Le champ cin est obligatoire.')]
#[Rule('regex:/^[A-Z0-9\s]+$/', message: 'Le cin doit contenir uniquement des majuscules, des chiffres et des espaces.')] 

  public $cin;
  #[Rule('required', message: 'Categorieest obligatoire')]
  public $categ;
public function messages(){
  return[
    'num_compte.required'=>'obligatoire',
    'num_compte.numeric'=>'entiers',
    'num_compte.digits'=>'24 chiffres',
    'salaire_base.required' => 'Le salaire de base est obligatoire',
    'salaire_base.numeric' => 'Le salaire de base doit être un nombre',
    'salaire_base.min' => 'Le salaire de base doit être positif',
    'salaire_base.decimal' => 'Le salaire de base doit avoir au maximum 2 chiffres après la virgule'
  ];
}

  public function mount($id)
  {
    $this->personne = Personne::findOrFail($id);
    $this->nom = $this->personne->nom;
    $this->prenom = $this->personne->prenom;
    $this->phone = $this->personne->phone;
    $this->adresse = $this->personne->adresse;
    $this->date_embauche = $this->personne->date_embauche;
    $this->date_nais = $this->personne->date_nais;
    $this->sexe = $this->personne->sexe;
    $this->sit_fam = $this->personne->sit_fam;
    $this->email = $this->personne->email;
    $this->fonction = $this->personne->fonction;
    $this->banque = $this->personne->banque;
    $this->num_compte = $this->personne->num_compte;
    $this->salaire_base = $this->personne->salaire_base;
    $this->cin = $this->personne->cin;
    $this->categ = $this->personne->categ;
  }


  public function save()
  {
    $validatedData = $this->validate();
    $this->personne->update($validatedData);
    $this->redirect(route('personnes.index'), navigate: true);
  }

  public function render()
  {
    return view('livewire.personnes.edit-personne');
  }
}
