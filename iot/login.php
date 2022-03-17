<!DOCTYPE html>
<html>
    <head>
        <title>

        </title>
    </head>

    <body>
        <form method="POST">
            Gebruikersnaam: <input type="text" name="username"/><br>
            Wachtwoord: <input type="password" name="password"/><br>
            <input type="submit" name="btnLogin" value="Inloggen"/>
        </form>

        <?php
        session_start();

        if (isset($_POST['btnLogin'])) {
            if (empty($_POST['username'] || empty($_POST['password']))) {
                header("Location: login.php");
            }
            if ($_POST['username'] == "Raul" && $_POST['password'] == "welkom123" ) {
                header("Location: workshop.php");
            }
            

            $_SESSION['username'] = $_POST['username'];
            $_SESSION['password'] = $_POST['password'];
        }


        

        ?>

    </body>
</html>