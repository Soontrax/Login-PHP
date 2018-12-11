<?php
    include ('server.php');
?>
<!DOCTYPE html>
<html>
    <head>
        <title>User Registration</title>
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <body>
        <div class="header">
            <h2>Login</h2>
        </div>

        <form method="post" action="login.php">
            <!--Display errors here-->
            <?php include ('errors.php'); ?>
            <div class="input-group">
                <label>Username</label>
                <input type="text" name="username" value="<?php
                       if (isset($_COOKIE["nombre"])) {
                           echo ($_COOKIE["nombre"]);
                       } else {
                           echo ""; 
                       }
                ?>">
            </div>

            <div class="input-group">
                <label>Password</label>
                <input type="password" name="password">
            </div>
            
            <input type="checkbox" name="guardar_usuario"> Recordar usuario

            <div class="input-group">
                <button type="submit" name="login" class="btn">Login</button>
            </div>
            
            <p>
                ¿Aún no eres miembro? <a href="register.php">Click</a>
            </p>

        </form>
    </body>
</html>