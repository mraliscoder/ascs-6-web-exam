<?php

if (isset($_GET["logout"])) {
    setcookie("user", "", time() - 200, "/");
    header("Location: /login.php");
    exit;
}

if (!isset($_COOKIE['user'])) {
    header('Location: /login.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Главная</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
        <h2 class="text-2xl font-bold text-center mb-6 text-gray-800">Привет, <?php echo $_COOKIE["user"] ?></h2>
                
        <p class="text-center text-gray-600 text-sm mt-6">
            <a href="/index.php?logout=true" class="text-blue-600 hover:text-blue-700 font-medium">Выйти из аккаунта</a>
        </p>
    </div>
</body>
</html>