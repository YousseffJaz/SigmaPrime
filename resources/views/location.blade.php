@extends('layouts.myapp')
@section('content')
    <div class="mx-auto max-w-screen-xl ">
        <div class="flex md:flex-row flex-col justify-around  items-center px-6 pt-6">
            <div class="md:m-12 p-6 md:w-1/2">
                <img loading="lazy" src="/images/shop1.png" alt="shop image">
            </div>
            <div class=" relative md:m-12 m-6 md:w-1/2 md:p-6">

            <p>Bienvenue dans notre magasin de location de voitures, idéalement situé en plein cœur de la ville. Notre magasin,
                 à un emplacement privilégié, vous offre un accès facile et constitue un point central pour tous vos besoins en location de voitures.
                  Que vous soyez un résident local ou un voyageur explorant la région, nous sommes faciles à trouver.</p>
            <br>
            <p>Notre magasin est stratégiquement situé près des principaux hubs de transport, tels que les aéroports,
                 les gares et les terminaux de bus, ce qui rend la prise en charge et la restitution de votre véhicule de location extrêmement pratiques. 
                 À votre arrivée, notre personnel accueillant vous recevra chaleureusement, 
                 garantissant un processus de location fluide et efficace du début à la fin.</p>

            </div>

        </div>
        <div class="flex md:flex-row flex-col justify-around  items-center px-6 pt-6">

            <div class="md:m-12 p-6 md:w-1/2 md:order-last ">
                <img loading="lazy" src="/images/shop_2.jpg" alt="shop image">
            </div>

            <div class=" relative md:m-12 m-6 md:w-1/2 md:p-6">
            <p>Situé dans un quartier animé, notre magasin est entouré de diverses commodités et attractions.
                 Vous trouverez une variété de restaurants, de cafés et de centres commerciaux à une courte distance,
                  parfaits pour prendre un repas ou faire des courses avant ou après votre expérience de location de voiture.</p>
            <br>
            <p>Avec un grand espace de stationnement disponible à notre emplacement, vous pouvez facilement entrer,
                 garer votre propre véhicule et repartir avec votre voiture de location en toute simplicité. Nous privilégions votre commodité, 
                 et notre emplacement est conçu pour minimiser toute gêne ou retard, vous permettant de vous concentrer sur votre voyage à venir.</p>

            </div>


        </div>
        <div class=" p-3 mb-8">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3464.9188930414984!2d-8.984100424763344!3d29.722108575087578!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xdb6b1b1966dcdef%3A0x2bf9c55ec4ef96f9!2sIsta%20Tafraout!5e0!3m2!1sen!2sma!4v1686498234799!5m2!1sen!2sma"
                class="w-full h-96" allowfullscreen="" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>

    </div>
@endsection
