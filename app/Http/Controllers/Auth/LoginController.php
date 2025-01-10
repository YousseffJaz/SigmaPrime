<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\User;
use App\Models\Car;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = RouteServiceProvider::HOME;

    protected function redirectTo()
    {
        if (Auth::check() && Auth::user()->role == 'admin') {
            return RouteServiceProvider::ADMIN;
        }
        return RouteServiceProvider::HOME;
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    public function enterCin($car_id){
        //$car_id = $request->input('car_id');
        //dd($car_id);
        return view('auth.login', ['car_id' => $car_id]);
        
    }


    public function login(Request $request)
{
    try {
        // Validation du champ CIN
        $request->validate([
            'identity_card_number' => 'required|string|max:255',
        ]);

        // Vérification de car_id dans l'URL
        $car_id = $request->input('car_id'); // Ou $request->input('car_id')

        // Ajout d'un message de débogage pour voir si car_id est récupéré
        //dd($car_id); // Cela vous permettra de voir si le car_id est bien récupéré

        // Vérification si car_id est présent
        if (!$car_id) {
            return back()->with('error', 'car_id est manquant.');
        }

        // Récupérer la voiture par car_id
        $car = Car::find($car_id); // Cherche la voiture par son ID

        if (!$car) {
            return back()->with('error', 'La voiture spécifiée est introuvable.');
        }

        // Recherche d'une réservation existante avec le CIN
        $identityNumber = $request->input('identity_card_number');
        $reservation = Reservation::where('identity_card_number', $identityNumber)->first();

        // Si une réservation existe, retourner le formulaire d'édition
        if ($reservation) {
            return view('reservation.edit', [
                'reservation' => $reservation,
                'car' => $car, // Passe la voiture à la vue
            ]);
        } else {
            // Si aucune réservation n'existe, afficher le formulaire de création
            return view('reservation.create', compact('car')); // Passe la voiture pour la création
        }
    } catch (\Exception $e) {
        return back()->withError('Une erreur est survenue. Veuillez réessayer plus tard.')->withInput();
    }
}


    

}



