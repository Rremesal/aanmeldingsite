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
            //als er op de login-knop wordt geklikt...
            if (isset($_POST['btnLogin'])) {
                //...check of de inputs leeg zijn, zoja, herlaad de login pagina
                if (empty($_POST['username'] || empty($_POST['password']))) {
                    header("Location: login.php");
                }
                //...check of de gebruikersnaam gelijk is aan 'gebruiker én wachtwoord  gelijk is aan 'welkom123'
                //en ga naar de workshop pagina
                if ($_POST['username'] == "gebruiker" && $_POST['password'] == "welkom123" ) {
                    header("Location: workshop.php");
                }
                
                //stop de inloggegevens in een sessie
                $_SESSION['username'] = $_POST['username'];
                $_SESSION['password'] = $_POST['password'];
            }
        ?>

    </body>
</html>