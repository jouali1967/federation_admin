<div>
    <h2 class="mb-4">Tableau de bord</h2>
    @role('admin')
    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Utilisateurs</h5>
                    <p class="card-text">Total des utilisateurs : {{ \App\Models\User::count() }}</p>
                    <a href="{{ route('admin.users') }}" class="btn btn-primary">Gérer les utilisateurs</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Rôles</h5>
                    <p class="card-text">Total des rôles : {{ Spatie\Permission\Models\Role::count() }}</p>
                    <a href="{{ route('admin.roles') }}" class="btn btn-primary">Gérer les rôles</a>
                </div>
            </div>
        </div>
        {{-- Vous pouvez ajouter d'autres cartes ou informations ici si nécessaire --}}
    </div>
    @endrole
</div>
