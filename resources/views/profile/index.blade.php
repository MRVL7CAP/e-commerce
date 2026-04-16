@extends('layout')

@section('title', 'Profil')

@section('body')
    <div class="max-w-6xl mx-auto p-6 space-y-6">
        <div class="card bg-base-100 shadow-lg">
            <div class="card-body">
                <h1 class="text-2xl font-bold mb-4">Mon profil</h1>

                <form method="POST" action="{{ route('profile.update') }}" class="space-y-6">
                    @csrf
                    @method('PATCH')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="label">
                                <span class="label-text">Nom</span>
                            </label>
                            <input name="name" type="text" value="{{ old('name', $user->name) }}"
                                class="input input-bordered w-full" required />
                            @error('name')
                                <p class="text-sm text-error mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="label">
                                <span class="label-text">Email</span>
                            </label>
                            <input name="email" type="email" value="{{ old('email', $user->email) }}"
                                class="input input-bordered w-full" required />
                            @error('email')
                                <p class="text-sm text-error mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid md:grid-cols-2 gap-4">
                        <div class="border rounded-lg p-4 bg-base-200">
                            <h2 class="text-lg font-semibold mb-3">Adresse de facturation</h2>
                            <div class="space-y-4">
                                <div>
                                    <label class="label"><span class="label-text">Adresse</span></label>
                                    <input name="billing_address" type="text"
                                        value="{{ old('billing_address', optional($billing)->address) }}"
                                        class="input input-bordered w-full" />
                                </div>
                                <div>
                                    <label class="label"><span class="label-text">Ville</span></label>
                                    <input name="billing_city" type="text"
                                        value="{{ old('billing_city', optional($billing)->city) }}"
                                        class="input input-bordered w-full" />
                                </div>
                                <div>
                                    <label class="label"><span class="label-text">Code postal</span></label>
                                    <input name="billing_zip" type="text"
                                        value="{{ old('billing_zip', optional($billing)->zip) }}"
                                        class="input input-bordered w-full" />
                                </div>
                                <div>
                                    <label class="label"><span class="label-text">Pays</span></label>
                                    <input name="billing_country" type="text"
                                        value="{{ old('billing_country', optional($billing)->country) }}"
                                        class="input input-bordered w-full" />
                                </div>
                            </div>
                        </div>

                        <div class="border rounded-lg p-4 bg-base-200">
                            <h2 class="text-lg font-semibold mb-3">Adresse de livraison</h2>
                            <div class="space-y-4">
                                <div>
                                    <label class="label"><span class="label-text">Adresse</span></label>
                                    <input name="shipping_address" type="text"
                                        value="{{ old('shipping_address', optional($shipping)->address) }}"
                                        class="input input-bordered w-full" />
                                </div>
                                <div>
                                    <label class="label"><span class="label-text">Ville</span></label>
                                    <input name="shipping_city" type="text"
                                        value="{{ old('shipping_city', optional($shipping)->city) }}"
                                        class="input input-bordered w-full" />
                                </div>
                                <div>
                                    <label class="label"><span class="label-text">Code postal</span></label>
                                    <input name="shipping_zip" type="text"
                                        value="{{ old('shipping_zip', optional($shipping)->zip) }}"
                                        class="input input-bordered w-full" />
                                </div>
                                <div>
                                    <label class="label"><span class="label-text">Pays</span></label>
                                    <input name="shipping_country" type="text"
                                        value="{{ old('shipping_country', optional($shipping)->country) }}"
                                        class="input input-bordered w-full" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Enregistrer les informations</button>
                </form>
            </div>
        </div>

        <div class="card bg-base-100 shadow-lg">
            <div class="card-body">
                <h2 class="text-2xl font-bold mb-4">Mes commandes</h2>

                @if($orders->isEmpty())
                    <p class="text-sm text-base-content/70">Aucune commande disponible pour le moment.</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="table table-zebra w-full">
                            <thead>
                                <tr>
                                    <th>Commande</th>
                                    <th>Date</th>
                                    <th>Total</th>
                                    <th>Statut</th>
                                    <th>Facture</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $order)
                                    <tr>
                                        <td>#{{ $order->id }}</td>
                                        <td>{{ $order->created_at->format('d/m/Y') }}</td>
                                        <td>{{ number_format($order->total_amount, 2, ',', ' ') }} €</td>
                                        <td>{{ ucfirst($order->status) }}</td>
                                        <td>
                                            <a href="{{ route('profile.invoice', $order) }}" class="btn btn-sm btn-secondary">
                                                Télécharger
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>

        <div class="card bg-base-100 shadow-lg">
            <div class="card-body">
                <h2 class="text-2xl font-bold mb-4">Supprimer mon compte</h2>
                <p class="mb-4 text-sm text-base-content/70">Cette action est irréversible.</p>
                <form method="POST" action="{{ route('profile.destroy') }}" class="space-y-4">
                    @csrf
                    @method('DELETE')
                    <div>
                        <label class="label"><span class="label-text">Mot de passe</span></label>
                        <input name="password" type="password" class="input input-bordered w-full" required>
                        @error('password')
                            <p class="text-sm text-error mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-error">Supprimer le compte</button>
                </form>
            </div>
        </div>
    </div>
@endsection
