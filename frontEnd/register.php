<?php
require_once('../database/db.php');
require_once('../classes/utilisateur.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $db = dataBase::getInstance()->getConnection();
    $utilisateur = new Utilisateur($nom, $prenom, $email, $password);
    $utilisateur->save($db);

    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Register - Ferrari</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
  <script src="https://cdn.tailwindcss.com"></script>
    <style>
    /* Add a custom font if you want to match exactly */
    body {
      font-family: 'Arial', sans-serif; /* Replace with the actual font used in the image if known */
    }
  </style>
</head>
<body class="flex min-h-screen">
 <div class="w-1/2 relative hidden md:block">
    <img src="../img/car-63930_1280.jpg" alt="Ferrari" class="w-full h-full object-cover">  <!-- Replace with your actual Ferrari image -->
     <div class="absolute bottom-10 left-10 text-white">
        <h2 class="text-3xl font-bold">Journey Beyond</h2>
        <p class="text-sm mt-2">Explore the new Ferrari lineup.</p>
        <button class="mt-4 bg-white text-black px-6 py-2 rounded-md text-sm font-semibold hover:bg-gray-100">Explore</button>
    </div>
  </div>
  <div class="w-full md:w-1/2 bg-black flex flex-col justify-center items-center px-4 md:px-16 overflow-auto">
      <div class="text-white text-2xl font-bold mb-8">
        <span class="uppercase">Ferrari</span>
    </div>

    <div class="w-full max-w-md">
        <h2 class="text-white text-2xl font-bold mb-6 uppercase">Sign Up</h2>

        <form method="post" action="register.php" class="space-y-4">
          <div>
            <label for="nom" class="block text-sm font-medium text-gray-400">Last Name</label>
            <input type="text" id="nom" name="nom" placeholder="Doe" required
                   class="w-full px-4 py-2 mt-1 bg-zinc-800 border border-zinc-700 text-white placeholder-gray-500 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500">
          </div>
           <div>
            <label for="prenom" class="block text-sm font-medium text-gray-400">First Name</label>
            <input type="text" id="prenom" name="prenom" placeholder="John" required
                   class="w-full px-4 py-2 mt-1 bg-zinc-800 border border-zinc-700 text-white placeholder-gray-500 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500">
          </div>
          <div>
            <label for="email" class="block text-sm font-medium text-gray-400">Email</label>
            <input type="email" id="email" name="email" placeholder="john.doe@example.com" required
                   class="w-full px-4 py-2 mt-1 bg-zinc-800 border border-zinc-700 text-white placeholder-gray-500 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500">
          </div>
          <div>
            <label for="telephone" class="block text-sm font-medium text-gray-400">Phone Number</label>
            <input type="tel" id="telephone" name="telephone" placeholder="+1 234 567 890" required
                   class="w-full px-4 py-2 mt-1 bg-zinc-800 border border-zinc-700 text-white placeholder-gray-500 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500">
          </div>
          <div>
            <label for="adresse" class="block text-sm font-medium text-gray-400">Address</label>
            <input type="text" id="adresse" name="adresse" placeholder="123 Main St" required
                   class="w-full px-4 py-2 mt-1 bg-zinc-800 border border-zinc-700 text-white placeholder-gray-500 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500">
          </div>
          <div>
            <label for="date_naissance" class="block text-sm font-medium text-gray-400">Date of Birth</label>
            <input type="date" id="date_naissance" name="date_naissance" required
                   class="w-full px-4 py-2 mt-1 bg-zinc-800 border border-zinc-700 text-white placeholder-gray-500 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500">
          </div>
          <div>
            <label for="password" class="block text-sm font-medium text-gray-400">Password</label>
            <input type="password" id="password" name="password" placeholder="••••••••••" required
                   class="w-full px-4 py-2 mt-1 bg-zinc-800 border border-zinc-700 text-white placeholder-gray-500 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500">
          </div>
          <div>
            <label for="confirmpassword" class="block text-sm font-medium text-gray-400">Confirm Password</label>
            <input type="password" id="confirmpassword" placeholder="••••••••••" required
                   class="w-full px-4 py-2 mt-1 bg-zinc-800 border border-zinc-700 text-white placeholder-gray-500 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500">
          </div>


          <div>
            <input type="submit" value="Register"
                   class="w-full px-4 py-2 bg-red-600 text-white text-lg font-medium rounded-md cursor-pointer hover:bg-red-700 transition">
          </div>

          <div class="text-sm text-gray-400 text-center">
            Already have an account? <a href="login.php" class="hover:underline">Login</a>
          </div>
        </form>

        <div class="mt-4 text-xs text-gray-500 text-center"> <!-- Added text-center here -->
            Memberstack
        </div>
    </div>
  </div>
</body>
</html>