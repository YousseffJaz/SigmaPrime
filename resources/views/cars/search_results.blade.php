@extends('layouts.myapp')

@section('content')
    <div class="mx-auto max-w-screen-xl">
        <div class="mt-12">
            <h2 class="text-xl font-bold text-gray-600">Available Cars for {{ $dateTime->format('Y-m-d H:i A') }}</h2>

            @if ($cars->isEmpty())
                <p class="text-red-500">No cars are available for the selected date and time.</p>
            @else
                <div class="grid md:grid-cols-3 sm:grid-cols-2 gap-6 mt-6">
                    @foreach ($cars as $car)
                        <div class="bg-white shadow-md rounded-lg p-4 flex flex-col items-center">
                            <!-- Image section -->
                            <div class="w-32 h-32 mb-4">
                                <img loading="lazy" 
                                     src="{{ $car->image }}" 
                                     alt="Car image" 
                                     class="w-full h-full object-cover rounded-md">
                            </div>

                            <!-- Car details section -->
                            <div class="text-center">
                                <h3 class="text-gray-900 font-semibold text-lg">{{ $car->brand }} {{ $car->model }}</h3>
                                <p class="text-sm text-gray-600">{{ $car->engine }}</p>
                                <p class="text-sm text-gray-600 mt-2">{{ $car->description }}</p>
                                <p class="text-sm text-gray-600 mt-2">Price per day: <strong>${{ $car->price_per_day }}</strong></p>
                                <p class="text-sm text-gray-600">Quantity: {{ $car->quantité }}</p>
                                <p class="text-sm text-gray-600">Status: {{ $car->status }}</p>
                                <p class="text-sm text-gray-600">Discount: {{ $car->reduce }}%</p>
                                <p class="text-sm text-gray-600">Stars: {{ $car->stars }} / 5</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection
