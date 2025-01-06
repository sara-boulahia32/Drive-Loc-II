<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Drive & Loc - Votre Aventure Commence Ici</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&family=Roboto+Slab:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        .title-font {
            font-family: 'Roboto Slab', serif;
        }

        .card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
        }

        .car-image {
            transition: transform 0.5s ease-in-out;
        }

        .card:hover .car-image {
            transform: scale(1.1) rotate(-2deg);
        }

        .cta-button {
            transition: background-color 0.3s, transform 0.2s, box-shadow 0.2s;
        }
        .cta-button:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }

         .nav-link {
            position: relative;
            padding-bottom: 2px; /* Space for the underline */

        }
         .nav-link::after {
            content: '';
            position: absolute;
            left: 50%;
            bottom: 0;
            width: 0;
            height: 2px; /* Underline thickness */
            background-color: #ffd700; /* Gold color */
            transition: width 0.4s ease, left 0.4s ease; /* Animate width and left position */
        }

        .nav-link:hover::after {
            width: 100%;
            left:0;

        }
        .hero-overlay{
            background: linear-gradient(155deg, #fef9c3 10%, transparent 40%);

        }


    </style>
</head>
<body class="bg-gray-50">

    <nav class="bg-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="#" class="flex items-center py-2">
                        <span class="text-yellow-500 text-3xl font-bold title-font">Drive & Loc</span>
                    </a>
                </div>
                <div class="hidden md:flex space-x-6 items-center">
                    <a href="#" class="text-gray-700 hover:text-yellow-500 nav-link">Accueil</a>
                    <a href="#" class="text-gray-700 hover:text-yellow-500 nav-link">Véhicules</a>
                    <a href="#" class="text-gray-700 hover:text-yellow-500 nav-link">Services</a>
                    <a href="login.html" class="inline-flex items-center px-6 py-2 border border-yellow-500 text-yellow-500 rounded-full hover:bg-yellow-500 hover:text-white transition duration-300">
                        Connexion
                    </a>
                </div>

            </div>
        </div>
    </nav>

    <section class="relative py-20  bg-cover bg-no-repeat bg-center" style="background-image: url('https://images.unsplash.com/photo-1529369602768-5557a55555f2?q=80&w=2076&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D')">
       <div class="absolute inset-0 hero-overlay"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center">
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-white title-font mb-4">Trouvez la Voiture Parfaite pour <span class="text-yellow-500">Votre Prochaine Aventure</span></h1>
                <p class="text-lg sm:text-xl text-white mb-8">Explorez notre sélection variée et réservez en toute simplicité.</p>

                <div class="bg-white/90 p-6 rounded-2xl shadow-xl backdrop-blur-sm">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                             <label for="pickup-date" class="block text-sm font-medium text-gray-700">Date de début</label>
                            <input type="date" id="pickup-date" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-yellow-500 focus:border-yellow-500 sm:text-sm">
                        </div>
                         <div>
                            <label for="return-date" class="block text-sm font-medium text-gray-700">Date de fin</label>
                            <input type="date" id="return-date" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-yellow-500 focus:border-yellow-500 sm:text-sm">
                        </div>

                        <div class="md:col-span-1">
                             <label for="car-type" class="block text-sm font-medium text-gray-700">Type de Véhicule</label>
                            <select id="car-type" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-yellow-500 focus:border-yellow-500 sm:text-sm">
                                <option>Citadine</option>
                                <option>Berline</option>
                                <option>SUV</option>
                                <option>Sportive</option>
                            </select>
                        </div>
                    </div>
                     <button class="mt-6 w-full cta-button bg-yellow-500 text-white font-bold py-3 px-6 rounded-full focus:outline-none">
                        Rechercher
                    </button>
                </div>
            </div>
        </div>
    </section>

    <section class="py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl sm:text-4xl font-bold text-gray-800 title-font text-center mb-12">Découvrez Notre Gamme</h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Car Card 1 -->
                <div class="card bg-white rounded-xl shadow-lg overflow-hidden">
                    <div class="relative overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1583121274602-3e2820c69888?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Citadine" class="car-image w-full h-64 object-cover">
                    </div>

                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-gray-800">Citadine Économique</h3>
                        <p class="text-gray-600 mb-3">Parfaite pour la ville et les petits budgets.</p>
                        <div class="flex justify-between items-center">
                            <span class="text-yellow-500 font-bold text-lg">Dès 35€/jour</span>
                             <button class="cta-button bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-5 rounded-full focus:outline-none">Réserver</button>
                        </div>
                    </div>
                </div>

                <!-- Car Card 2 -->
               <div class="card bg-white rounded-xl shadow-lg overflow-hidden">
                    <div class="relative overflow-hidden">
                         <img src="https://images.unsplash.com/photo-1503376780353-7e6692767b70?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Berline" class="car-image w-full h-64 object-cover">
                    </div>

                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-gray-800">Berline Confort</h3>
                        <p class="text-gray-600 mb-3">Idéale pour les longs trajets avec style.</p>
                         <div class="flex justify-between items-center">
                            <span class="text-yellow-500 font-bold text-lg">Dès 60€/jour</span>
                            <button class="cta-button bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-5 rounded-full focus:outline-none">Réserver</button>
                        </div>
                    </div>
                </div>

                <!-- Car Card 3 -->
                <div class="card bg-white rounded-xl shadow-lg overflow-hidden">
                   <div class="relative overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1555353540-64580b51c258?q=80&w=1970&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="SUV" class="car-image w-full h-64 object-cover">
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-gray-800">SUV Familial</h3>
                        <p class="text-gray-600 mb-3">Espace et sécurité pour toute la famille.</p>
                         <div class="flex justify-between items-center">
                            <span class="text-yellow-500 font-bold text-lg">Dès 80€/jour</span>
                            <button class="cta-button bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-5 rounded-full focus:outline-none">Réserver</button>
                        </div>
                    </div>
                </div>
            </div>
             <div class="text-center mt-10">
                <a href="#" class="cta-button inline-block bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-3 px-8 rounded-full">Voir tous les véhicules</a>
            </div>
        </div>
    </section>

    <footer class="bg-gray-800 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p>&copy; 2024 Drive & Loc. Tous droits réservés.</p>
        </div>
    </footer>

</body>
</html>