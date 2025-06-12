<?php

namespace App\Livewire\Personnes;

use Livewire\Attributes\Validate;
use Livewire\Component;
use App\Models\Personne;
use Livewire\Attributes\Rule;
use Illuminate\Support\Facades\DB;

class CreatePersonne extends Component
{
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
  // protected $rules = [
  //   'nom' => 'required',
  //   'prenom' => 'required',
  //   'phone' => 'required|regex:/^[0-9]{10}$/',
  //   'adresse' => 'required',
  //   'date_embauche' => 'required|date_format:d/m/Y',
  //   'date_nais' => 'nullable|date_format:d/m/Y',
  //   'sexe' => 'required|in:M,F',
  //   'sit_fam' => 'required|in:M,C,D',
  //   'email' => 'nullable|email',
  //   'fonction' => 'required',
  //   'banque' => 'required',
  //   'num_compte' => 'required',
  //   'salaire_base' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/',
  //   'cin' => 'required|regex:/^[A-Z0-9]$/',
  //   'categ' => 'required|in:categorie1,categorie2,categorie3'
  // ];

  // protected $messages = [
  //   'nom.required' => 'Le nom est obligatoire',
  //   'prenom.required' => 'Le prénom est obligatoire',
  //   'phone.required' => 'Le téléphone est obligatoire',
  //   'phone.regex' => 'Le numéro de téléphone doit contenir 10 chiffres',
  //   'adresse.required' => 'L\'adresse est obligatoire',
  //   'date_embauche.required' => 'La date d\'embauche est obligatoire',
  //   'date_embauche.date_format' => 'La date d\'embauche doit être au format JJ/MM/AAAA',
  //   'date_nais.date_format' => 'La date de naissance doit être au format JJ/MM/AAAA',
  //   'sexe.required' => 'Le sexe est obligatoire',
  //   'sexe.in' => 'Le sexe doit être M ou F',
  //   'sit_fam.required' => 'La situation familiale est obligatoire',
  //   'sit_fam.in' => 'La situation familiale doit être M, C ou D',
  //   'email.email' => 'L\'email doit être une adresse email valide',
  //   'fonction.required' => 'La fonction est obligatoire',
  //   'banque.required' => 'La banque est obligatoire',
  //   'num_compte.required' => 'Le numéro de compte est obligatoire',
  //   'salaire_base.required' => 'Le salaire de base est obligatoire',
  //   'salaire_base.numeric' => 'Le salaire de base doit être un nombre',
  //   'salaire_base.regex' => 'Le salaire de base doit avoir au maximum 2 chiffres après la virgule',
  //   'cin.required' => 'Le CIN est obligatoire',
  //   'cin.regex' => 'Le CIN doit être alphanumérique et ne pas contenir de caractères spéciaux',
  //   'categ.required' => 'La catégorie est obligatoire',
  //   'categ.in' => 'La catégorie doit être l\'une des valeurs suivantes : categorie1, categorie2, categorie3'
  // ];

  // public function updated($propertyName)
  // {
  //   $this->validateOnly($propertyName);
  // }

  public function render()
  {
    /*$personnes = Personne::select('id','nom', 'prenom') // Manque l'ID !
    ->with('inscriptions:id,personne_id,num_cnss')
    ->withCount('enfants')
    ->get();
    foreach ($personnes as $personne) {
    $numCnss = $personne->inscriptions->first()->num_cnss ?? 'Non inscrit';
    echo $personne->nom . ' ' . $personne->prenom . ' - CNSS: ' . $numCnss . ' - Enfants: ' . $personne->enfants_count . PHP_EOL;
}*/
    /*$personnes = Personne::select('id','nom', 'prenom')
    ->with('inscriptions:id,personne_id,num_cnss')
    ->with(['declarations' => function ($query) {
        $query->select('id', 'personne_id', 'mont_dec', 'date_dec')
            ->whereRaw('YEAR(date_dec) = (SELECT YEAR(MAX(date_dec)) FROM declarations)')
            ->whereRaw('MONTH(date_dec) = (SELECT MONTH(MAX(date_dec)) FROM declarations)')
            ->orderBy('date_dec', 'desc');
            // Retiré le limit(1) temporairement
    }])
    ->withCount('enfants')
    ->get();
    dd($personnes);*/

    return view('livewire.personnes.create-personne');
  }
  public function save()
  {
    $validatedData = $this->validate();
      //dd($validatedData);
      Personne::create($validatedData);

      $this->reset();

  }
}
