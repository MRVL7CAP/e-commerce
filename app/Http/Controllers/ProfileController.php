<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Address;
use App\Models\Order;
use App\Models\User;
use Dompdf\Dompdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        $user = User::query()->findOrFail(Auth::user()->id);

        $billing = $user->addresses()->where('type', 'billing')->first();
        $shipping = $user->addresses()->where('type', 'shipping')->first();
        $orders = $user->orders()->latest()->get();

        return view('profile.index', compact('user', 'billing', 'shipping', 'orders'));
    }

    public function update(ProfileUpdateRequest $request)
    {
        $user = User::query()->findOrFail(Auth::user()->id);

        $user->update($request->only(['name', 'email']));

        Address::updateOrCreate(
            ['user_id' => $user->id, 'type' => 'billing'],
            [
                'address' => $request->input('billing_address'),
                'city' => $request->input('billing_city'),
                'zip' => $request->input('billing_zip'),
                'country' => $request->input('billing_country'),
            ]
        );

        Address::updateOrCreate(
            ['user_id' => $user->id, 'type' => 'shipping'],
            [
                'address' => $request->input('shipping_address'),
                'city' => $request->input('shipping_city'),
                'zip' => $request->input('shipping_zip'),
                'country' => $request->input('shipping_country'),
            ]
        );

        return redirect()->route('profile.index')->with('success', 'Profil mis à jour.');
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'password' => ['required', 'string'],
        ]);

        $user = User::query()->findOrFail(Auth::user()->id);


        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => 'Le mot de passe est incorrect.'], 'userDeletion');
        }

        Auth::logout();
        $user->delete();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Compte supprimé.');
    }

    public function invoice(Order $order)
    {
        $user = Auth::user();

        if ($order->user_id !== $user->id) {
            abort(403);
        }

        $billing = json_decode($order->billing_address, true) ?? [];
        $shipping = json_decode($order->shipping_address, true) ?? [];

        $html = view('profile.invoice', compact('order', 'user', 'billing', 'shipping'))->render();

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return response($dompdf->output(), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', "attachment; filename=\"facture-{$order->id}.pdf\"");
    }
}
