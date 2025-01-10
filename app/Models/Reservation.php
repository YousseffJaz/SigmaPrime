<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Reservation extends Model
{
    use HasFactory;

    // Nom de la table (si nécessaire)
    protected $table = 'reservations';

    //protected $dates = ['start_date', 'end_date']; // Assurez-vous que ces champs sont des dates

    protected $fillable = [
        'first_name', 
        'last_name', 
        'nationality', 
        'identity_number', 
        'drivers_license_number', 
        'address', 
        'mobile_number', 
        'gallery', 
        //'reservation_dates', 
        'delivery_time', 
        'return_time',
        'user_id', 
        'car_id', 
        'start_date', 
        'end_date', 
        'days', 
        'price_per_day', 
        'total_price', 
        'status', 
        'payment_method', 
        'payment_status'
    ];

    // Si vous utilisez des dates comme `delivery_time`, `return_time`, vous pouvez définir ces attributs comme des objets Carbon.
    protected $dates = [ 
        'delivery_time',
        'return_time',
        'start_date',
        'end_date',
    ];

    // Convertir la colonne `gallery` en tableau pour faciliter la gestion des images (stockées sous forme de JSON)
    protected $casts = [
        'gallery' => 'array',
    ];
    
    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    // app/Models/Reservation.php
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Méthode pour obtenir les images de la galerie et générer les liens
    public function getGalleryLinksAttribute()
    {
        // Si la galerie contient des images, générer les liens
        if ($this->gallery && count($this->gallery) > 0) {
            return array_map(function ($image) {
                return asset('storage/' . $image); // Lien vers le dossier storage
            }, $this->gallery);
        }

        return [];
    }
  
}