<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     */


     public function create($car_id)
     {
         try {
             // Récupérer les données de la voiture à partir de la base de données
             $car = Car::find($car_id);
             
             // Si la voiture n'est pas trouvée, rediriger vers un autre formulaire
             if (!$car) {
                 return redirect()->route('reservation.create', ['car_id' => 1]); // Exemple : redirige vers une voiture par défaut (id=1)
             }
     
             // Récupérer l'identity_number à partir de la requête ou de l'input du formulaire
             $identityNumber = request()->input('identity_card_number');
     
             // Vérifier si identity_number existe et est déjà associé à une réservation
             if ($identityNumber) {
                 $existingReservation = Reservation::where('identity_card_number', $identityNumber)->first();
     
                 // Si une réservation existe pour ce identity_number, on passe les données à la vue pour afficher le formulaire pré-rempli
                 if ($existingReservation) {
                     return view('reservation.edit', [
                         'reservation' => $existingReservation,
                         'car' => $car,
                     ]);
                 }
             }
     
             // Retourner la vue avec les données nécessaires
             return view('reservation.create', compact('car', 'identityNumber'));
     
         } catch (\Exception $e) {
            dd($e->getMessage());
             // Gérer l'exception (affichage d'un message d'erreur générique)
             return redirect()->route('home')->with('error', 'Une erreur est survenue. Veuillez réessayer plus tard.');
         }
     }
     
    /*************/
    
    
    
    /***************/
    /*public function checkCIN($cin)
    {
        $user = User::where('cin', $cin)->first();
        if ($user) {
            return response()->json(['exists' => true, 'user' => $user]);
        } else {
            return response()->json(['exists' => false]);
        }
    }*/
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $car_id)
{
    try {
        // Validation des champs
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'delivery_time' => 'required|date_format:H:i', // Validation pour Delivery Time
            'return_time' => 'required|date_format:H:i',   // Validation pour Return Time
            'nationality' => 'required|string|max:255',
            'identity_card_number' => 'required|string|max:255',
            'driver_license_number' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'mobile_number' => 'required|string|max:255',
        ]);

        // Récupération de la voiture
        $car = Car::findOrFail($car_id);

        // Vérifier la disponibilité de la voiture pendant la période demandée
        $startDate = new \Carbon\Carbon($request->input('start_date'));
        $endDate = new \Carbon\Carbon($request->input('end_date'));
        $deliveryTime = $request->input('delivery_time');
        $returnTime = $request->input('return_time');

        // Convertir l'heure en format Carbon
        $deliveryTime = \Carbon\Carbon::createFromFormat('H:i', $deliveryTime);
        $returnTime = \Carbon\Carbon::createFromFormat('H:i', $returnTime);

        // Rechercher une réservation existante pendant la période demandée
        $existingReservation = Reservation::where('car_id', $car->id)
            ->where(function ($query) use ($startDate, $endDate, $deliveryTime, $returnTime) {
                // Vérifier si les dates de réservation se chevauchent
                $query->where(function ($query) use ($startDate, $endDate) {
                        $query->where('start_date', '<=', $endDate)
                              ->where('end_date', '>=', $startDate);
                    })
                    ->orWhere(function ($query) use ($deliveryTime, $returnTime) {
                        // Vérifier si les horaires de livraison et retour se chevauchent
                        $query->where('delivery_time', '<=', $returnTime)
                              ->where('return_time', '>=', $deliveryTime);
                    });
            })
            ->exists();

            if ($existingReservation) {
                // Si une réservation existe, rediriger vers le formulaire
                return redirect()->route('cars')->with('error', 'La voiture est déjà réservée pour cette période.');
            }

        // Récupérer les fichiers de la galerie
        $gallery = [];
        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $file) {
                // Enregistrer chaque image dans le répertoire 'gallery'
                $path = $file->store('gallery', 'public');
                // Ajouter le chemin de l'image au tableau
                $gallery[] = $path;
            }
        }

        // Calcul de la durée et du prix total
        $days = $startDate->diffInDays($endDate);
        $pricePerDay = $car->price_per_day;
        $totalPrice = $days * $pricePerDay;

                // Créer une instance de réservation
                $reservation = new Reservation();
                $reservation->car_id = $car->id;
                $reservation->first_name = $request->input('first_name');
                $reservation->last_name = $request->input('last_name');
                $reservation->start_date = $request->input('start_date');
                $reservation->end_date = $request->input('end_date');
                $reservation->delivery_time = $request->input('delivery_time');
                $reservation->return_time = $request->input('return_time');
                $reservation->nationality = $request->input('nationality');
                $reservation->identity_card_number = $request->input('identity_card_number');
                $reservation->driver_license_number = $request->input('driver_license_number');
                $reservation->address = $request->input('address');
                $reservation->mobile_number = $request->input('mobile_number');
                $reservation->gallery = json_encode($gallery);
                $reservation->days = $days;
                $reservation->price_per_day = $pricePerDay;
                $reservation->total_price = $totalPrice;
                $reservation->status = 'active';
                $reservation->payment_method = 'on_site';
                $reservation->payment_status = 'pending';
        
                // Sauvegarder la réservation
                $reservation->save();

        // Retourner une réponse ou rediriger l'utilisateur
        return redirect()->route('home')->with('success', 'Réservation créée avec succès');
    } catch (\Exception $e) {
        dd($e->getMessage());
        return redirect()->route('reservations.create', ['car_id' => $car_id]);
                         //->with('error', 'Une erreur s\'est produite : ' . $e->getMessage());
    }
}
    


    /**
     * Display the specified resource.
     */
    public function show(Reservation $reservation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reservation $reservation)
    {
        //
    }

    // Edit and Update Payment status
    public function editPayment(Reservation $reservation)
    {
        $reservation = Reservation::find($reservation->id);
        return view('admin.updatePayment', compact('reservation'));
    }

    public function updatePayment(Reservation $reservation, Request $request)
    {
        $reservation = Reservation::find($reservation->id);
        $reservation->payment_status = $request->payment_status;
        $reservation->save();
        return redirect()->route('adminDashboard');
    }

    // Edit and Update Reservation Status
    public function editStatus(Reservation $reservation)
    {
        $reservation = Reservation::find($reservation->id);
        return view('admin.updateStatus', compact('reservation'));
    }

    public function updateStatus(Reservation $reservation, Request $request)
    {
        $reservation = Reservation::find($reservation->id);
        $reservation->status = $request->status;
        $car = $reservation->car;
        if($request->status == 'Ended' || $request->status == 'Canceled' ){
            $car->status = 'Available';
            $car->save();
        }
        $reservation->save();
        return redirect()->route('adminDashboard');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reservation $reservation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reservation $reservation)
    {
        //
    }
}

