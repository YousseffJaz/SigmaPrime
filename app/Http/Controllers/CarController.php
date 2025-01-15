<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\Reservation;
use Carbon\Carbon;


class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cars = Car::latest()->paginate(8);
        return view('admin.cars', compact('cars'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.createCar');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'brand' => 'required',
            'model' => 'required',
            'engine' => 'required',
            'quantity' => 'required',
            'price_per_day' => 'required',
            'status' => 'required',
            'reduce' => 'required',
            'stars' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg'
        ]);

        $car = new Car;
        $car->brand = $request->brand;
        $car->model = $request->model;
        $car->engine = $request->engine;
        $car->quantity = $request->quantity;
        $car->price_per_day = $request->price_per_day;
        $car->status = $request->status;
        $car->reduce = $request->reduce;
        $car->stars = $request->stars;

        if ($request->hasFile('image')) {
            $imageName = $request->brand . '-' . $request->model . '-' . $request->engine . '-' . Str::random(10) . '.' . $request->file('image')->extension();
            $image = $request->file('image');
            $path = $image->storeAs('images/cars', $imageName);
            $car->image = '/'.$path;
        }
        $car->save();

        return redirect()->route('cars.index');
    }

    /**
     * Display the specified resource.
     */
    /*public function show(Car $car)
    {
        //
    }*/

    public function show($id)
{
    // Récupérer la voiture par son ID
    $car = Car::findOrFail($id);

    // Passer la variable $car à la vue
    return view('reservation.create', compact('car'));
}



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Car $car)
    {
        $car = Car::findOrFail($car->id);
        return view('admin.updateCar', compact('car'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Car $car)
    {
        $request->validate([
            'brand' => 'required',
            'model' => 'required',
            'engine' => 'required',
            'quantity' => 'required',
            'price_per_day' => 'required',
            'status' => 'required',
            'reduce' => 'required',
            'stars' => 'required',
            
        ]);

        $car = Car::findOrFail($car->id);

        $car->brand = $request->brand;
        $car->model = $request->model;
        $car->engine = $request->engine;
        $car->quantity = $request->quantity;
        $car->price_per_day = $request->price_per_day;
        $car->status = $request->status;
        $car->reduce = $request->reduce;
        $car->stars = $request->stars;

        if ($request->hasFile('image')) {

            $filename = basename($car->image);
            Storage::disk('local')->delete('images/cars/' . $filename);
            $car->delete();

            $imageName = $request->brand . '-' . $request->model . '-' . $request->engine . '-' . Str::random(10) . '.' . $request->file('image')->extension();
            $image = $request->file('image');
            $path = $image->storeAs('images/cars', $imageName);
            $car->image = $path;
        }
        $car->save();

        return redirect()->route('cars.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Car $car)
    {
        $car = Car::findOrFail($car->id);
        
        // Check if the car has any active reservations
        $activeReservations = $car->reservations()->where('status', 'Active')->count();
        
        if ($activeReservations > 0) {
            // Prevent deletion and return with error message
            return redirect()->route('cars.index')->with('error', 'Cannot delete car with active reservations.');
        }
        
        // Delete inactive reservations
        $car->reservations()->where('status', '!=', 'Active')->delete();
        
        // if ($car->image) {
        //     // Get the filename from the image path
        //     $filename = basename($car->image);

        //     // Delete the image file from the storage
        //     Storage::disk('local')->delete('images/cars/' . $filename);
        // }
        
        $car->delete();

        return redirect()->route('cars.index')->with('success', 'Car deleted successfully.');
    }

    public function search(Request $request)
    {
        //dd($request->all());
        try {
            // Valider les données saisies
            $request->validate([
                'date' => 'required|date|after_or_equal:today', // Assurez-vous que la date n'est pas dans le passé
                'time' => 'required|date_format:H:i', // Valider le format de l'heure (HH:MM)
            ]);
    
            // Récupérer la date et l'heure choisies
            $date = $request->input('date');
            $time = $request->input('time');
            
            // Créer un objet Carbon combinant la date et l'heure
            $dateTime = Carbon::createFromFormat('Y-m-d H:i', "$date $time");
    
            // Rechercher les voitures qui ne sont pas réservées pour cette date et heure spécifiques
            $cars = Car::whereDoesntHave('reservations', function ($query) use ($dateTime) {
                $query->where(function ($query) use ($dateTime) {
                    // Vérifier si la réservation chevauche avec la date et l'heure choisies
                    $query->where('start_date', '<=', $dateTime)
                        ->where('end_date', '>=', $dateTime);
                })
                ->orWhere(function ($query) use ($dateTime) {
                    // Vérifier si la voiture est déjà réservée avec des horaires de livraison et de retour
                    $query->where('delivery_time', '<=', $dateTime)
                        ->where('return_time', '>=', $dateTime);
                })
                ->orWhere(function ($query) use ($dateTime) {
                    // Vérifier les réservations du même jour mais après l'heure de return_time
                    $query->whereDate('end_date', '=', $dateTime->toDateString())  // Le même jour
                        ->where('return_time', '>=', $dateTime->format('H:i')); // L'heure choisie est après return_time
                });
            })->get();

           
    
            // Retourner les résultats de la recherche à la vue
            return view('cars.search_results', [
                'cars' => $cars,
                'dateTime' => $dateTime,
            ]);
            
        } catch (\Exception $e) {
            // Enregistrer l'erreur dans le fichier de log
            dd($e->getMessage());
          

            // Retourner une vue d'erreur avec un message approprié
            return redirect()->route('cars.index')->with('error', 'An error occurred while processing your search. Please try again later.');
        }
    }

    


}
