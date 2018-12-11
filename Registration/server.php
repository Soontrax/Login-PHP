<?php

session_start();

$username = "";
$email = "";
$errors = array();
//Connection to the database

$db = mysqli_connect('localhost', 'root', '12345', 'registration');

//Check connection
if (mysqli_connect_errno()) {
    echo 'Failed to connect to the database' . mysqli_connect_errno();
}

//If the register button clicked

if (isset($_POST['register'])) {
    //El metodo mysqli_real_escape_string escapa de caracteres especiales osea que el usuario no puede poner
    //*#_ //etc....
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $password1 = mysqli_real_escape_string($db, $_POST['password_1']);
    $password2 = mysqli_real_escape_string($db, $_POST['password_2']);

    //We check if the input are completed 
    if (empty($username)) {
        array_push($errors, "Falta rellenar username");
    }

    if (empty($email)) {
        array_push($errors, "Falta rellenar email");
    }

    if (empty($password1)) {
        array_push($errors, "Falta rellenar password");
    }

    if ($password1 != $password2) {
        array_push($errors, "Las dos contraseñas no coinciden");
    }

    //If the are no errors save information to database
    if (count($errors) == 0) {
        //We encrypt the password for segurity;
        $password = md5($password1);
        $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";

        mysqli_query($db, $sql);
        $_SESSION['username'] = $username;
        $_SESSION['success'] = "You are now logged in";
        header('location: login.php');
    }
}



if (isset($_POST['login'])) {

    $username = mysqli_real_escape_string($db, $_POST['username']);
    $password = mysqli_real_escape_string($db, $_POST['password']);


    //We check if the input are completed 
    if (empty($username)) {
        array_push($errors, "Falta rellenar username");
    }

    if (empty($password)) {
        array_push($errors, "Falta rellenar password");
    }

    if (isset($_POST['guardar_usuario'])) {
        setcookie("nombre", $username, time() + 3600);
    }

    if (count($errors) == 0) {
        $password = md5($password);
        $query = "SELECT * FROM users WHERE username = '$username' AND password ='$password'";
        $result = mysqli_query($db, $query);
        if (mysqli_num_rows($result) == 1) {
            $_SESSION['username'] = $username;
            $_SESSION['success'] = "Ahora te has conectado como " . $username;
            header('location: index.php'); //redirigimos al usuario a la página que queremos llevarlos 
        } else {
            array_push($errors, "La combinacion de usuario y contraseña no coinciden");
        }
    }
}

//Cuando el usuario le ha dado a logout
if (isset($_GET['logout'])) {
    If (isset($_COOKIE[session_name()])) {
        setcookie( session_name(), "", time()-3600, "/");
        unset($_COOKIE[session_name()]);
    }
    session_unset(); // o bien
    $_SESSION = array();
    session_destroy();

    session_destroy(); //Para eliminar la información del login con 
    session_unset(); //Para eliminar la información del servidor sobre el login
    unset($_SESSION['username']);
    header('location: login.php'); //Cuando le de a logout lo redirigimos a la página de login
}
?>