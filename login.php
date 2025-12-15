<?php
if (isset($_POST['username']) && isset($_POST['password'])) {
    require_once 'db.php';

    header('Content-Type: application/json');

    $username = mb_strtolower($_POST['username']);
    $password = $_POST['password'];

    $pass = hash('sha512', $password);
    
    $checkIfUserExists = mysqli_query($link, "SELECT username FROM users WHERE username='$username' AND password='$pass'");

    if (mysqli_num_rows($checkIfUserExists) > 0) {
        // case insensitive, поэтому чтобы получить то что именно записано в бд можно получить так
        $realUsername = mysqli_fetch_array($checkIfUserExists)["username"];
        setcookie("user", $realUsername, time()+(60*60*24), "/");
        die(json_encode([ "success" => true, "user" => $realUsername ]));
    }

    die(json_encode([ "error" => "Неправильный логин или пароль" ]));
}

if (isset($_COOKIE['user'])) {
    header('Location: /');
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Авторизация</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
        <h2 class="text-2xl font-bold text-center mb-6 text-gray-800">Привет!</h2>
        
        <div class="bg-red-500 text-white p-3 mb-3 hidden" id="error_text">Aboba</div>

        <form id="submitform">
            <div class="mb-4">
                <label for="username" class="block text-gray-700 text-sm font-medium mb-2">Логин</label>
                <input 
                    type="text" 
                    id="username" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                    placeholder="admin"
                    required
                >
            </div>
            
            <div class="mb-6">
                <label for="password" class="block text-gray-700 text-sm font-medium mb-2">Пароль</label>
                <input 
                    type="password" 
                    id="password" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                    placeholder="••••••••"
                    required
                >
            </div>
            
            <button 
                type="submit" 
                class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition duration-200 font-medium mb-3"
            >
                Войти
            </button>
        </form>
        
        <p class="text-center text-gray-600 text-sm mt-6">
            Нет аккаунта? 
            <a href="/register.php" class="text-blue-600 hover:text-blue-700 font-medium">Регистрация</a>
        </p>
    </div>

    <script>
        const showError = (text) => {
            document.getElementById("error_text").classList.remove('hidden');
            document.getElementById("error_text").innerText = text;
        };

        document.getElementById('submitform').addEventListener("submit", (e) => {
            e.preventDefault();

            const username = e.target.username.value;
            const password = e.target.password.value;

            const fd = new FormData();
            fd.append('username', username);
            fd.append('password', password);

            fetch(`/login.php`, {
                method: "POST",
                body: fd
            })
                .then(d => d.json())
                .then(d => {
                    if (d.success) {
                        window.location = "/";
                    } else {
                        showError(d.error);
                    }
                })
        });
    </script>
</body>
</html>