<?php
session_start();
require_once('../database/db.php');
require_once('../classes/utilisateur.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $db = dataBase::getInstance()->getConnection();
    $utilisateur = Utilisateur::authenticate($db, $email, $password);

    if ($utilisateur) {
        $_SESSION['user_id'] = $utilisateur->getId();
        $_SESSION['user_role'] = $utilisateur->getRole();

        if ($utilisateur->getRole() == 'admin') {
            header("Location: dashboard.php");
        } else {
            header("Location: vehicule.php");
        }
        exit();
    } else {
        $error = "Invalid email or password.";
    }
}
?>



<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login Form - Tailwind CSS</title>
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
  <div class="w-full md:w-1/2 bg-black flex flex-col justify-center items-center px-4 md:px-16">
    <div class="text-white text-2xl font-bold mb-8">
      <span class="uppercase">Ferrari</span>
    </div>

    <div class="w-full max-w-md">
        <h2 class="text-white text-2xl font-bold mb-6 uppercase">Please Log In</h2>

        <form method="post" action="login.php" class="space-y-4">
          <div>
            <label for="email" class="block text-sm font-medium text-gray-400">Email</label>
            <input type="text" id="email" name="email" placeholder="John Doe" required
                   class="w-full px-4 py-2 mt-1 bg-zinc-800 border border-zinc-700 text-white placeholder-gray-500 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500">
          </div>
          <div>
            <label for="password" class="block text-sm font-medium text-gray-400">Password</label>
            <input type="password" id="password" name="password" placeholder="••••••••••" required
                   class="w-full px-4 py-2 mt-1 bg-zinc-800 border border-zinc-700 text-white placeholder-gray-500 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500">
          </div>

          <div>
            <input type="submit" value="Log In"
                   class="w-full px-4 py-2 bg-red-600 text-white text-lg font-medium rounded-md cursor-pointer hover:bg-red-700 transition">
          </div>

           <button class="w-full flex items-center justify-center gap-2 px-4 py-2 bg-white text-black text-sm font-medium rounded-md cursor-pointer hover:bg-gray-100 transition">
            <svg class="w-5 h-5" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M43.6114 24.4854C43.6114 22.9154 43.4914 21.4554 43.1914 20.0854H24.3314V27.8754H34.9714C34.5114 30.3554 33.3114 32.4154 31.5314 33.8954V38.9654H37.8214C41.4814 35.6354 43.6114 30.5554 43.6114 24.4854Z" fill="#4285F4"/>
                <path d="M24.3318 44.0002C29.7018 44.0002 34.1318 42.2202 37.8218 38.9702L31.5318 33.9002C29.7718 35.0802 27.5718 35.7802 25.2018 35.7802C21.3918 35.7802 18.1218 33.3402 16.8518 30.1302H10.2818V35.3802C12.8818 39.9902 18.1518 44.0002 24.3318 44.0002Z" fill="#34A853"/>
                <path d="M16.8514 30.1298C16.0014 29.0098 15.4814 27.6498 15.4814 26.1998C15.4814 24.7498 16.0314 23.4198 16.8514 22.2998V17.0498H10.2814C9.04136 19.5898 8.33136 22.8298 8.33136 26.1998C8.33136 29.5698 9.04136 32.8098 10.2814 35.3798L16.8514 30.1298Z" fill="#FBBC05"/>
                <path d="M24.3314 16.6196C27.3214 16.6196 29.8014 17.7096 31.4314 19.2796L37.9714 12.7396C34.1214 9.71961 29.7014 8.08961 24.3314 8.08961C18.1514 8.08961 12.8814 12.0996 10.2814 16.7096L16.8514 22.2996C18.1214 19.0896 21.3914 16.6196 24.3314 16.6196Z" fill="#EA4335"/>
            </svg>

            Continue with Google</button>

          <div class="text-sm text-gray-400 text-center">
            <a href="forgot_password.php" class="hover:underline">Forgot password?</a>
            <span class="mx-2">|</span>
            <a href="register.php" class="hover:underline">Sign up</a>
          </div>
        </form>

        <div class="absolute bottom-4 right-4 text-xs text-gray-500">
            Memberstack
        </div>
    </div>
  </div>
</body>
</html>