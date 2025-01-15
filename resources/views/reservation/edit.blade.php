@extends('layouts.myapp')
@section('content')
    <div class="mx-auto max-w-screen-xl bg-white rounded-md p-6 m-8">
        <div class="flex justify-between md:flex-row flex-col">
            {{-- -------------------------------------------- left -------------------------------------------- --}}
            <div class="md:w-2/3  md:border-r border-gray-800 p-2">

                <h2 class=" ms-4 max-w-full font-car md:text-6xl text-4xl">{{ $car->brand }} {{ $car->model }}
                    {{ $car->engine }}
                </h2>

                <div class="flex items-end mt-8 ms-4">
                    <h3 class="font-car text-gray-500 text-2xl">Price:</h3>
                    <p>
                        <span
                            class=" text-3xl font-bold text-pr-400 ms-3 me-1 border border-pr-400 p-2 rounded-md">{{ $car->price_per_day }}
                            $</span>
                        <span
                            class="text-lg font-medium text-red-500 line-through">{{ intval(($car->price_per_day * 100) / (100 - $car->reduce)) }}
                            $</span>
                    </p>
                </div>

                <div class="flex items-center justify-around mt-10 me-10">
                    <div class="w-1/5 md:w-1/3 h-[0.25px] bg-gray-500 "> </div>
                    <p>Order Informations</p>
                    <div class="w-1/5 md:w-1/3 h-[0.25px] bg-gray-500 "> </div>

                </div>

                <div class="px-6 md:me-8">
                    <form action="{{ route('reservation.store', ['car_id' => $car->id]) }}" method="POST" enctype='multipart/form-data'>

                        @csrf
                        <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">

                            {{-- Champ pour Nom --}}
                            <div class="sm:col-span-3">
                                <label for="first_name" class="block text-sm font-medium leading-6 text-gray-900">First Name</label>
                                <div class="mt-2">
                                    <input type="text" name="first_name" id="first_name" value="{{ $reservation->first_name }}"
                                        class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-pr-400 sm:text-sm sm:leading-6">
                                </div>
                                @error('first_name')
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Champ pour Prénom --}}
                            <div class="sm:col-span-3">
                                <label for="last_name" class="block text-sm font-medium leading-6 text-gray-900">Last Name</label>
                                <div class="mt-2">
                                    <input type="text" name="last_name" id="last_name" value="{{ $reservation->last_name }}"
                                        class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-pr-400 sm:text-sm sm:leading-6">
                                </div>
                                @error('last_name')
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Champ pour Nationalité --}}
                            <div class="sm:col-span-full">
                                <label for="nationality" class="block text-sm font-medium leading-6 text-gray-900">Nationality</label>
                                <div class="mt-2">
                                    <input type="text" name="nationality" id="nationality" value="{{ $reservation->nationality }}"
                                        class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-pr-400 sm:text-sm sm:leading-6">
                                </div>
                                @error('nationality')
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Identity Card Number --}}
                            <div class="sm:col-span-3">
                                <label for="identity_card_number" class="block text-sm font-medium leading-6 text-gray-900">Identity Card Number</label>
                                <div class="mt-2">
                                    <input type="text" name="identity_card_number" id="identity_card_number" value="{{ $reservation->identity_card_number }}"
                                        class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-pr-400 sm:text-sm sm:leading-6">
                                </div>
                                @error('identity_card_number')
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Driver's License Number --}}
                            <div class="sm:col-span-3">
                                <label for="driver_license_number" class="block text-sm font-medium leading-6 text-gray-900">Driver's License Number</label>
                                <div class="mt-2">
                                    <input type="text" name="driver_license_number" id="driver_license_number"
                                        value="{{ $reservation->driver_license_number }}"
                                        class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-pr-400 sm:text-sm sm:leading-6">
                                </div>
                                @error('driver_license_number')
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Address --}}
                            <div class="sm:col-span-6">
                                <label for="address" class="block text-sm font-medium leading-6 text-gray-900">Address</label>
                                <div class="mt-2">
                                    <input type="text" name="address" id="address" value="{{ $reservation->address }}"
                                        class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-pr-400 sm:text-sm sm:leading-6">
                                </div>
                                @error('address')
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Mobile Number --}}
                            <div class="sm:col-span-full">
                                <label for="mobile_number" class="block text-sm font-medium leading-6 text-gray-900">Mobile Number</label>
                                <div class="mt-2">
                                    <input type="text" name="mobile_number" id="mobile_number" value="{{ $reservation->mobile_number }}"
                                        class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-pr-400 sm:text-sm sm:leading-6">
                                </div>
                                @error('mobile_number')
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- File Upload for ID Card and Driver License --}}
                            <div class="sm:col-span-full">
    <label for="gallery" class="block text-sm font-medium leading-6 text-gray-900">Upload ID Card and Driver License (Front & Back)</label>
    <div class="mt-2">
        <input 
            type="file" 
            name="gallery[]" 
            id="gallery" 
            accept="image/*" 
            multiple
            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-pr-400 sm:text-sm sm:leading-6">
        <small class="text-gray-500">You must select exactly 4 images.</small>
    </div>
    <div id="preview" class="mt-4 grid grid-cols-4 gap-4"></div>
    @error('gallery')
        <span class="text-red-500">{{ $message }}</span>
    @enderror
</div>


<script>
    const galleryInput = document.getElementById('gallery');
    const previewDiv = document.getElementById('preview');
    const form = document.querySelector('form'); // Assurez-vous que votre formulaire a bien une balise <form>

    // Validation à la sélection des fichiers
    galleryInput.addEventListener('change', function () {
        // Vide le contenu précédent de l'aperçu
        previewDiv.innerHTML = "";

        // Vérifie si exactement 4 fichiers sont sélectionnés
        if (galleryInput.files.length !== 4) {
            alert("Vous devez sélectionner exactement 4 images.");
            galleryInput.value = ""; // Réinitialise la sélection
            return;
        }

        // Affiche les noms des fichiers sélectionnés
        Array.from(galleryInput.files).forEach(file => {
            const fileNameDiv = document.createElement('div');
            fileNameDiv.textContent = file.name;
            fileNameDiv.className = "text-sm font-medium text-gray-700 text-center";
            previewDiv.appendChild(fileNameDiv);
        });
    });

    // Validation à la soumission du formulaire
    form.addEventListener('submit', function (e) {
        if (galleryInput.files.length !== 4) {
            e.preventDefault(); // Annule la soumission
            alert("Veuillez sélectionner exactement 4 images avant de soumettre.");
        }
    });
</script>
                            {{-- Date Inputs --}}
                            <div class="sm:col-span-full">
                                <label for="start_date" class="block text-sm font-medium leading-6 text-gray-900">Start Date</label>
                                <input type="date" id="start_date" name="start_date" class="w-full rounded-md" required>
                            </div>

                            <div class="sm:col-span-full">
                                <label for="end_date" class="block text-sm font-medium leading-6 text-gray-900">End Date</label>
                                <input type="date" id="end_date" name="end_date" class="w-full rounded-md" required>
                            </div>
                            <div class="sm:col-span-3">
                                <label for="delivery-time" class="block text-sm font-medium leading-6 text-gray-900">
                                    Delivery Time
                                </label>
                                <input 
                                    type="time" 
                                    id="delivery-time" 
                                    name="delivery_time" 
                                    class="w-full rounded-md border border-gray-300 py-1.5 px-3 shadow-sm focus:outline-none focus:ring-2 focus:ring-inset focus:ring-pr-400" 
                                    placeholder="Select Delivery Time"
                                    required
                                    onchange="syncReturnTime()"
                                />
                            </div>
                            <div class="sm:col-span-3">
                                <label for="return-time" class="block text-sm font-medium leading-6 text-gray-900">
                                    Return Time
                                </label>
                                <input 
                                    type="time" 
                                    id="return-time" 
                                    name="return_time" 
                                    class="w-full rounded-md border border-gray-300 py-1.5 px-3 shadow-sm focus:outline-none focus:ring-2 focus:ring-inset focus:ring-pr-400" 
                                    placeholder="Select Return Time"
                                    required
                                    readonly
                                />
                            </div>

                            <script>
                                function syncReturnTime() {
                                    // Synchroniser le temps de retour avec celui de la livraison
                                    var deliveryTime = document.getElementById('delivery-time').value;
                                    document.getElementById('return-time').value = deliveryTime;
                                }
                            </script>

                    </div>
                        

                        {{-- Submit Button --}}
                        <div class="pt-6">
                            <button type="submit"
                                class="inline-flex justify-center rounded-md border border-transparent bg-pr-400 py-2 px-4 text-sm font-medium text-white shadow-sm focus:outline-none focus:ring-2 focus:ring-pr-400 focus:ring-offset-2">
                                Submit
                            </button>
                        </div>

                    </form>
                </div>
            </div>

            {{-- -------------------------------------------- right -------------------------------------------- --}}

            <div class="md:w-1/3 flex flex-col justify-start items-center">
                <div class="relative mx-3 mt-3 flex h-[200px] w-3/4   overflow-hidden rounded-xl shadow-lg">
                    <img loading="lazy" class="h-full w-full object-cover" src="{{ $car->image }}" alt="product image" />
                    <span
                        class="absolute w-24 h-8 py-1 top-0 left-0 m-2 rounded-full bg-pr-400 px-2 text-center text-sm font-medium text-white">{{ $car->reduce }}
                        % OFF</span>
                </div>
                <p class=" ms-4 max-w-full font-car text-xl mt-3 md:block hidden">{{ $car->brand }} {{ $car->model }}
                    {{ $car->engine }}
                </p>
                <div class="mt-3 ms-4 md:block hidden">
                    <div class="flex items-center">
                        @for ($i = 0; $i < $car->stars; $i++)
                            <svg aria-hidden="true" class="h-4 w-4 text-pr-300" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                </path>
                            </svg>
                        @endfor
                        <span
                            class="mr-2 ml-3 rounded bg-pr-300 px-2.5 py-0.5 text-sm font-semibold">{{ $car->stars }}.0</span>
                    </div>
                </div>


                <div class=" w-full   mt-8 ms-8">
                    <p id="duration" class="font-car text-gray-600 text-lg ms-2">Estimated Duration: <span
                            class="mx-2 font-car text-md font-medium text-gray-700 border border-pr-400 p-2 rounded-md "> --
                            days</span>
                    </p>
                </div>

                <div class=" w-full   mt-8 ms-8">
                    <p id="total-price" class="font-car text-gray-600 text-lg ms-2">Estimated Price: <span
                            class="mx-2 font-car text-md font-medium text-gray-700 border border-pr-400 p-2 rounded-md "> --
                            TND</span>
                    </p>
                </div>
             
            </div>
        </div>

        @if (session('error'))
            <script>
                const Toast = Swal.mixin({
                    toast: true,
                    position: "top-end",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.onmouseenter = Swal.stopTimer;
                        toast.onmouseleave = Swal.resumeTimer;
                    }
                });
                Toast.fire({
                    icon: "error",
                    title: "{{ session('error') }}"
                });
            </script>
        @endif


    </div>
    

    <script>
    document.addEventListener("DOMContentLoaded", function () {
        // Calculating duration and total price when dates are selected
        document.getElementById('start_date').addEventListener('change', updateDurationAndPrice);
        document.getElementById('end_date').addEventListener('change', updateDurationAndPrice);

        function updateDurationAndPrice() {
            const startDate = new Date(document.getElementById('start_date').value);
            const endDate = new Date(document.getElementById('end_date').value);

            if (startDate && endDate && startDate <= endDate) {
                const duration = Math.ceil((endDate - startDate) / (1000 * 60 * 60 * 24));
                const pricePerDay = {{ $car->price_per_day }}; // Get this from the backend
                const totalPrice = duration * pricePerDay;

                document.getElementById('duration').textContent = `Estimated Duration: ${duration} days`;
                document.getElementById('total-price').textContent = `Estimated Price: ${totalPrice} $`;
            } else {
                document.getElementById('duration').textContent = 'Estimated Duration: -- days';
                document.getElementById('total-price').textContent = 'Estimated Price: -- $';
            }
        }
    });
</script>



@endsection
