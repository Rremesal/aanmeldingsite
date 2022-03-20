<?php include("wsdatabase.php"); ?>
<!DOCTYPE HTML>
<html>
    <head>
        <title>Workshop IoT</title>
        <link rel="stylesheet" href="style.css"/>  <!--link naar het css-bestand -->  
    </head>
    
    <body>
        <a href="overview.php">Overzicht</a>
        <h1>Sign up</h1>
        
        
        
        <!--formulier waar gebruiker gegevens kan invullen --> 
        <div class="form">
            <form method="POST">
                <b>Naam:</b> <input type="text" name="naam"/> <br> 
               <b>Aanhef:</b> <input type="text" name="aanhef"/> <br>
               <b>Gender:</b> <input type="radio" name="radio1" value="man">Man
               <input type="radio" name="radio1" value="vrouw"/>Vrouw   
               <input type="radio" name="radio1" value="anders"/>Anders<br>  
               <b>Adres:</b> <input type="text" name="adres"/> <br>
               <b>Postcode:</b> <input type="text" name="postcode"/> <br>
               <b>Woonplaats:</b> <input type="text" name="woonplaats"/> <br>
               <b>Telefoonnr:</b> <input type="text" name="tel"/> <br>
               <b>Email:</b> <input type="text" name="email"/> <br>  
               <br>
               <hr>
                <?php 
                    //query die de waardes in de 'amount' kolom bij elkaar optelt wordt uitgevoerd
                    $query = "SELECT SUM(amount) as totaal FROM applicants WHERE date='15 maart 2022'";
                    $stm = $conn->prepare($query);
                    $stm->execute();
                    $data = $stm->fetch(PDO::FETCH_OBJ);
                    //als het totale aantal aanmeldingen lager is dan 20 laat de knop zien, anders geef de melding weer
                    if($data->totaal < 20) {
                ?>    <input type="radio", name="radiodatum", value="15 maart 2022"> 15 maart 2022 van 09:00 - 13:30 <br>
                <?php   
                    } else {
                        echo "er zijn geen plekken voor 15 maart meer"."<br/>";
                    }
                ?>
                <?php 
                    //query die de waardes in de 'amount' kolom bij elkaar optelt wordt uitgevoerd
                    $query = "SELECT SUM(amount) as totaal FROM applicants WHERE date='23 maart 2022'";
                    $stm = $conn->prepare($query);
                    $stm->execute();
                    $data = $stm->fetch(PDO::FETCH_OBJ);
                    //als het totale aantal personen (aanmelders) lager is dan 20 laat de knop zien, anders geef de melding weer
                    if($data->totaal < 20) {
                ?>    <input type="radio", name="radiodatum", value="23 maart 2022"> 23 maart 2022 van 13:00 - 17:30
                <?php   
                    } else {
                        echo "er zijn geen plekken voor 23 maart meer"."<br/>";
                    }
                ?>
                <br> 
                <br>
               <b>Aantal:</b> 
               <select name="aantal">
                   <option value="aantal"> aantal </option>
                   <option value="1" name="one"> 1 </option>
                   <option value="2" name="two"> 2 </option>
                   <option value="3" name="three"> 3 </option>
                   <option value="4" name="four"> 4 </option> 
                </select>
                <br>
                <br>
                
                <?php
                //query die de waardes van de kolom 'amount' bij elkaar optelt wordt uitvoerd
                $query = "SELECT SUM(amount) as totaal FROM applicants";
                $stm = $conn->prepare($query);
                if($stm->execute()) {
                    $data = $stm->fetch(PDO::FETCH_OBJ);
                    //als het totale aantal personen (aanmelders) groter is dan 40 laat de knop zien, anders 
                    //laat een uitgeschakelde knop zien
                    if($data->totaal >= 40) {
                        echo "<input type='submit' name='submitbutton' value='Aanmelden' disabled> ";
                    } else {
                ?>      <input type="submit" name="submitbutton" value="Aanmelden"> 
                <?php
                    }
                }
                ?>
            </form>
        </div>
        <hr>
        <?php
            $datalijst = array();
            session_start();
            echo "Je bent ingelogd als ".$_SESSION['username']." -> ".$_SESSION['password'];

            
            echo "<div class=post>";
                if (isset($_POST["submitbutton"])) {
                    //data uit formulier ophalen en in variabele stoppen
                    $name = $_POST['naam'];
                    $salutation = $_POST['aanhef'];
                    $gender = $_POST['radio1'];
                    $address = $_POST['adres'];
                    $zipcode = $_POST['postcode'];
                    $residence = $_POST['woonplaats'];
                    $phonenumber = $_POST['tel'];
                    $email = $_POST['email'];
                    $date = $_POST['radiodatum'];
                    $amount = $_POST['aantal'];
                    $cost = $_POST['aantal'] * 500;

                    if($date == "15 maart 2022") {
                        //query haalt alle gegevens waar de datum '15 maart 2022' is op
                        $maart15AmountQuery = "SELECT * FROM applicants WHERE date='$date'";
                        $stm = $conn->prepare($maart15AmountQuery);
                        
                        if($stm->execute()) {
                            //variabele die het aantal aanmeldingen in de database bijhoudt
                            $totaalAantal15maart = 0;
                            //stopt alle opgehaalde gegevens in een variabele
                            $data15maart = $stm->fetchAll(PDO::FETCH_OBJ);
                            //telt iedere aanmelding in de database 
                            foreach($data15maart as $aanmeldingen) {
                                $totaalAantal15maart += $aanmeldingen->amount;
                            }
                        } else echo "query mislukt";
                        //checkt of het aantal aanmeldingen in de database lager is dan 20 én 
                        //of het totaal aantal aanmeldingen + het door de gebruiker zojuist opgegeven aantal personen 
                        if($totaalAantal15maart < 20 && ($totaalAantal15maart + $amount) <= 20 ) {
                            //query opstellen met als waardes de gegevens uit het formulier    
                            $query3 = "INSERT INTO applicants (`name`,salutation,gender,`address`,zipcode,residence,phonenumber,email,`date`,amount,cost) VALUES".
                            "('$name', '$salutation', '$gender', '$address', '$zipcode' , '$residence', '$phonenumber', '$email' , '$date' , $amount, $cost)";
                            //query voorbereiden voor uitvoer
                            $stm15maart = $conn->prepare($query3);
                            //voert het statement uit en als deze succesvol is uitgevoerd toon melding op scherm, zo niet toon andere melding
                            if ($stm15maart->execute()){
                                echo "De gebruiker is opgeslagen","<br/>";
                            } else {
                                echo "Er is iets fout gegaan met het uitvoeren van de query15maart";
                            }
                        } else {
                            //geeft aan hoeveel plaatsen er nog over zijn als de gebruiker een aantal probeert wat over 20 personen zou gaan
                            $remaining = 20 - $totaalAantal15maart;
                            echo "Er zijn nog ".$remaining." plek(ken) over."."<br/>";
                        }
                    } else {
                        //query haalt alle gegevens waar de datum '15 maart 2022' is op
                        $maart23AmountQuery = "SELECT *  FROM applicants WHERE date='$date'";
                        $stm = $conn->prepare($maart23AmountQuery);

                        if($stm->execute()) {
                            //variabele die het aantal aanmeldingen in de database bijhoudt
                            $totaalAantal23maart = 0;
                            $data23maart = $stm->fetchAll(PDO::FETCH_OBJ);
                            //telt iedere aanmelding in de database 
                            foreach($data23maart as $aanmeldingen) {
                                $totaalAantal23maart += $aanmeldingen->amount;
                            }
                        } else echo "query mislukt";
                        //checkt of het aantal aanmeldingen in de database lager is dan 20 én 
                        //of het totaal aantal aanmeldingen + het door de gebruiker zojuist opgegeven aantal personen 
                        if($totaalAantal23maart < 20 && ($totaalAantal23maart + $amount) <= 20 ) {
                            //query opstellen met als waardes de gegevens uit het formulier    
                            $query3 = "INSERT INTO applicants (`name`,salutation,gender,`address`,zipcode,residence,phonenumber,email,`date`,amount,cost) VALUES".
                            "('$name', '$salutation', '$gender', '$address', '$zipcode' , '$residence', '$phonenumber', '$email' , '$date' , $amount, $cost)";
                            //query voorbereiden voor uitvoer
                            $stm23maart = $conn->prepare($query3);
                            //voert het statement uit en als deze succesvol is uitgevoerd toon melding op scherm, zo niet toon andere melding
                            if ($stm23maart->execute()){
                                echo "De gebruiker is opgeslagen","<br/>";
                            } else {
                                echo "Er is iets fout gegaan met het uitvoeren van de query15maart";
                            }
                        } else {
                            $remaining = 20 - $totaalAantal23maart;
                            echo "Er zijn nog ".$remaining." plek(ken) over."."<br/>";
                        }
                    }
                    
                    /*data wordt op scherm getoond d.m.v. <form method="POST">
                    en wordt ook toegevoegd aan de associative array 'datalijst'*/
                    echo "Data ontvangen d.m.v. POST:"."<br>";
                    echo "<br>";
                    
                    if (empty($_POST["naam"])) {
                        $datalijst['naam'] = "er is geen naam opgegeven";
                        echo "er is geen naam opgegeven";
                    } else {
                        echo "naam: ",$_POST["naam"], "<br>";
                        $datalijst['naam'] = $_POST['naam'];
                    }
                    if (empty($_POST["aanhef"])){
                        $datalijst['aanhef'] = "er is geen aanhef opgegeven";
                        echo "er is geen aanhef opgegeven", "<br>";
                    } else {
                        echo "aanhef: ",$_POST["aanhef"], "<br>";
                        $datalijst["aanhef"] = $_POST["aanhef"];
                    }
                    if (empty($_POST["radio1"])){
                        $datalijst['radio1'] = "er is geen geslacht opgegeven";
                        echo "er is geen geslacht opgegeven", "<br>";
                    } else {
                        echo "geslacht: ",$_POST["radio1"], "<br>";
                        $datalijst["radio1"] = $_POST["radio1"];
                    }
                    if (empty($_POST["adres"])){
                        $datalijst['adres'] = "er is geen adres opgegeven";
                        echo "er is geen adres opgegeven", "<br>";
                    } else {
                        echo "adres: ",$_POST["adres"], "<br>";
                        $datalijst["adres"] = $_POST["adres"];
                    }
                    if (empty($_POST["postcode"])) {
                        $datalijst['postcode'] = "er is geen postcode opgegeven";
                        echo "er is geen postcode opgegeven", "<br>";
                    } else {
                        echo "postcode: ",$_POST["postcode"], "<br>";
                        $datalijst["postcode"] = $_POST["postcode"];
                    }
                    if (empty($_POST["woonplaats"])) {
                        $datalijst['woonplaats'] = "er is geen woonplaats opgegeven";
                        echo "er is geen woonplaats opgegeven", "<br>";
                    } else {
                        echo "woonplaats: ",$_POST["woonplaats"], "<br>";
                        $datalijst["woonplaats"] = $_POST["woonplaats"];
                    }
                    if (empty($_POST["tel"])) {
                        $datalijst['tel'] = "er is geen telefoonnnummer opgegeven";
                        echo "er is geen telefoonnummer opgegeven", "<br>";
                    } else {
                        echo "tel: ",$_POST["tel"], "<br>";
                        $datalijst["tel"] = $_POST["tel"];
                    }
                    if (empty($_POST["email"])) {
                        $datalijst['email'] = "er is geen emailadres opgegeven";
                        echo "er is geen emailadres opgegeven", "<br>";
                    } else {
                        echo "email: ",$_POST["email"], "<br>";
                        $datalijst["email"] = $_POST["email"];
                    }
                    if (empty($_POST['radiodatum'])) {
                        $datalijst['radiodatum'] = "er is geen datum opgegeven";
                        echo "er is geen datum opgegeven", "<br>";
                    } else {
                        echo "datum: ",$_POST['radiodatum'], "<br>";
                        $datalijst['radiodatum'] = $_POST['radiodatum'];
                    }
                    if ($_POST["aantal"] == "aantal") {
                        $datalijst['aantal'] = "er is geen aantal opgegeven";
                        echo "er is geen aantal opgegeven", "<br>";
                    } else {
                        echo "aantal: ", $_POST["aantal"];
                        $datalijst["aantal"] = $_POST["aantal"];
                    }
                        echo "<br>","kosten: ", $cost;
                    
                    $datalijst['kosten'] = ($_POST['aantal'] * 500);
                }
            echo "</div>";
         
            //data wordt op het scherm getoond door met een foreach door 'datalijst' heen te lopen
            echo '<div class="lijst">';
                echo "Data ontvangen vanuit associative array: ", "<br>";
                echo "<br>";
                    
                foreach ($datalijst as $key => $value) {
                    if (array_key_exists($key,$datalijst)) {
                        echo $key.": ".$value."<br>";
                    }
                }
                
            echo "</div>";
        ?>
    </body>
</html>





