<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Drive & Loc</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Custom Styles & Animations (can be moved to a separate CSS file) */
        .category-card {
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        }
        .category-card:hover {
            transform: translateY(-5px) scale(1.05);
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
        }

        .vehicle-card {
             transition: all 0.3s ease-in-out;
        }
        .vehicle-card:hover {
            transform: scale(1.02);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.25);
        }
       .vehicle-card:hover .vehicle-image{
            transform: scale(1.1) rotate(2deg); /* Subtle rotation on hover */
        }

        .vehicle-image {
            transition: transform 0.4s ease-in-out; /* Transition for the image */
         }

        .cta-button {
            transition: background-color 0.3s ease, transform 0.2s ease;

        }
        .cta-button:hover {
            background-color: #f59e0b; /* Slightly darker shade on hover */
            transform: scale(1.05);
             box-shadow: 0 4px 8px rgba(0,0,0,0.3);
        }

         .bg-diagonal {
            background: linear-gradient(135deg, #fde047 0%, #fde047 48%, transparent 48%, transparent 52%, #171717 52%, #171717 100%);

        }


    </style>
</head>
<body class="font-sans bg-gray-100">

    <header class="bg-white shadow-md py-4">
        <div class="container mx-auto flex justify-between items-center px-4 md:px-6">
            <a href="#" class="text-2xl font-bold text-gray-800">Drive & Loc</a>
            <nav>
                <ul class="flex space-x-4 md:space-x-8">
                    <li><a href="#" class="text-gray-600 hover:text-yellow-500 transition duration-300">Catégories</a></li>
                    <li><a href="#" class="text-gray-600 hover:text-yellow-500 transition duration-300">À propos</a></li>
                    <li><a href="#" class="text-gray-600 hover:text-yellow-500 transition duration-300">Contact</a></li>

                     <li><a href="#" class="text-gray-600 hover:text-yellow-500 transition duration-300">Connexion</a></li>

                </ul>
            </nav>
        </div>
    </header>

    <main>
        <!-- Hero Section -->
       <section class="relative bg-diagonal  text-white  py-20 md:py-32">
    <div class="absolute inset-0  bg-cover bg-center opacity-30" style="background-image: url('https://images.unsplash.com/photo-1519641471654-76ce0107ad1b?q=80&w=2071&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D'); z-index: -1;"></div>
    <div class="container mx-auto text-center relative z-10">
        <h1 class="text-4xl md:text-6xl font-bold mb-4">Louez la voiture de vos rêves</h1>
        <p class="text-lg md:text-xl mb-8">Découvrez notre large sélection de véhicules pour toutes les occasions.</p>
        <a href="#" class="cta-button bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-3 px-8 rounded-full shadow-lg inline-block">Explorer les véhicules</a>
    </div>
</section>



        <!-- Categories Section -->
        <section class="py-16">
            <div class="container mx-auto px-4 md:px-6">
                <h2 class="text-3xl font-bold text-center text-gray-800 mb-12">Nos Catégories</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                    <!-- Category Card Example -->
                    <div class="category-card bg-white rounded-xl shadow-md overflow-hidden transform hover:scale-105 transition-transform duration-200 ease-in-out">
                        <img src="https://images.unsplash.com/photo-1594951755745-d65755839557?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Catégorie Citadine" class="w-full h-48 object-cover">
                        <div class="p-6">
                            <h3 class="text-xl font-semibold text-gray-700">Citadine</h3>
                            <p class="text-gray-500 mt-2">Parfaites pour la ville.</p>
                        </div>
                    </div>

                     <div class="category-card bg-white rounded-xl shadow-md overflow-hidden transform hover:scale-105 transition-transform duration-200 ease-in-out">
                        <img src="https://images.unsplash.com/photo-1571987840797-578755355577?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Catégorie SUV" class="w-full h-48 object-cover">
                        <div class="p-6">
                            <h3 class="text-xl font-semibold text-gray-700">SUV</h3>
                            <p class="text-gray-500 mt-2">Confort et espace.</p>
                        </div>
                    </div>

                     <div class="category-card bg-white rounded-xl shadow-md overflow-hidden transform hover:scale-105 transition-transform duration-200 ease-in-out">
                        <img src="https://images.unsplash.com/photo-1503736334956-4c8f8e92946d?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Catégorie Sportive" class="w-full h-48 object-cover">
                        <div class="p-6">
                            <h3 class="text-xl font-semibold text-gray-700">Sportive</h3>
                            <p class="text-gray-500 mt-2">Pour des sensations fortes.</p>
                        </div>
                    </div>

                     <div class="category-card bg-white rounded-xl shadow-md overflow-hidden transform hover:scale-105 transition-transform duration-200 ease-in-out">
                        <img src="https://images.unsplash.com/photo-1552519507-da3b142c6e3d?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Catégorie Berline" class="w-full h-48 object-cover">
                        <div class="p-6">
                            <h3 class="text-xl font-semibold text-gray-700">Berline</h3>
                            <p class="text-gray-500 mt-2">Élégance et performance.</p>
                        </div>
                    </div>

                </div>
            </div>
        </section>

       <!-- Featured Vehicles Section -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4 md:px-6">
        <h2 class="text-3xl font-bold text-center text-gray-800 mb-12">Véhicules en Vedette</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Vehicle Card Example -->
            <div class="vehicle-card bg-white rounded-lg shadow-lg overflow-hidden relative">
                <div class="relative overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1626668893629-2e6554555564?q=80&w=1974&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Nom du véhicule" class="vehicle-image w-full h-64 object-cover rounded-t-lg transform ">
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-semibold text-gray-800">Renault Clio</h3>
                    <p class="text-gray-600">Citadine | 5 places</p>
                    <p class="text-yellow-500 font-bold text-lg mt-2">45€ / jour</p>

                    <div class="mt-4 flex justify-between items-center">
                         <button class="cta-button bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Voir détails
                        </button>

                        <span class="text-sm text-gray-500">Disponible</span>

                    </div>
                </div>
            </div>

              <div class="vehicle-card bg-white rounded-lg shadow-lg overflow-hidden relative">
                <div class="relative overflow-hidden">
                <img src="https://images.unsplash.com/photo-1615459728695-5d9153495451?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Nom du véhicule" class="vehicle-image w-full h-64 object-cover rounded-t-lg transform ">
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-semibold text-gray-800">Peugeot 3008</h3>
                    <p class="text-gray-600">SUV | 5 places</p>
                    <p class="text-yellow-500 font-bold text-lg mt-2">70€ / jour</p>
                     <div class="mt-4 flex justify-between items-center">
                         <button class="cta-button bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Voir détails
                        </button>

                        <span class="text-sm text-gray-500">Disponible</span>

                    </div>
                </div>
            </div>

             <div class="vehicle-card bg-white rounded-lg shadow-lg overflow-hidden relative">
                <div class="relative overflow-hidden">
                 <img src="https://images.unsplash.com/photo-1542281286-9e0a16bb7366?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Nom du véhicule" class="vehicle-image w-full h-64 object-cover rounded-t-lg transform">
                </div>

                <div class="p-6">
                    <h3 class="text-xl font-semibold text-gray-800">Audi A3</h3>
                    <p class="text-gray-600">Berline | 5 places</p>
                    <p class="text-yellow-500 font-bold text-lg mt-2">85€ / jour</p>
                    <div class="mt-4 flex justify-between items-center">
                         <button class="cta-button bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Voir détails
                        </button>

                        <span class="text-sm text-gray-500">Disponible</span>

                    </div>
                </div>
            </div>
        </div>
         <div class="text-center mt-10">
            <a href="#" class="cta-button bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-3 px-8 rounded-full  inline-block">Voir tous les véhicules</a>
        </div>
    </div>
</section>

    </main>

    <footer class="bg-gray-800 text-white py-8 mt-12">
        <div class="container mx-auto text-center">
            <p>&copy; 2024 Drive & Loc. Tous droits réservés.</p>
        </div>
    </footer>

</body>
</html>