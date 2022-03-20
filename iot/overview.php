<?php include("wsdatabase.php"); ?>
<!DOCTYPE html>
<html>
    <head>
        <title>Overzicht</title>
        <link rel="stylesheet" href="style.css"/>
    </head>

    <body id="overview">
        <a href="workshop.php">Aanmelden</a>
        <h1>Aanmeldingsoverzicht</h1>
        <h3>Aanmeldingen 23 maart</h3>
        <?php 
            $query1 = "SELECT * FROM applicants WHERE date='23 maart 2022'";
            $stm = $conn->prepare($query1);
            if($stm->execute()){
                $data = $stm->fetchAll(PDO::FETCH_OBJ);

                foreach($data as $app) {
                    echo " ".$app->applicant_id." / ". 
                    " ".$app->name." / ". 
                    " ".$app->salutation." / ". 
                    " ".$app->gender." / ". 
                    " ".$app->address." / ". 
                    " ".$app->zipcode." / ". 
                    " ".$app->residence." / ". 
                    " ".$app->phonenumber." / ". 
                    " ".$app->email." / ". 
                    " ".$app->date." / ". 
                    " ".$app->amount." / ". 
                    " ".$app->cost." / "."<br>";
                }
            }
        ?>

        <h3>Aanmeldingen 15 maart</h3>
        <?php
        $query2 = "SELECT * FROM applicants WHERE date='15 maart 2022'";
        $stm = $conn->prepare($query2);
        if($stm->execute()){
            $data = $stm->fetchAll(PDO::FETCH_OBJ);

            foreach($data as $app) {
                echo " ".$app->applicant_id." / ". 
                " ".$app->name." / ". 
                " ".$app->salutation." / ". 
                " ".$app->gender." / ". 
                " ".$app->address." / ". 
                " ".$app->zipcode." / ". 
                " ".$app->residence." / ". 
                " ".$app->phonenumber." / ". 
                " ".$app->email." / ". 
                " ".$app->date." / ". 
                " ".$app->amount." / ". 
                " ".$app->cost." / "."<br>";
            }
        } 

        ?>
        <?php
            //geeft het totale aantal aanmelders in de database voor 15 maart 2022
            $query15maart = "SELECT SUM(amount) as totaal FROM applicants WHERE date='15 maart 2022'";
            $stm = $conn->prepare($query15maart);
            if($stm->execute()) {
                $data15maart = $stm->fetch(PDO::FETCH_OBJ);
                ?>  <hr>
        <?php
                echo "Totale aanmeldingen 15 maart => ".$data15maart->totaal."<br/>";
            } else echo "query15maart niet succesvol uitgevoerd";
            //geeft het totale aantal aanmelders in de database voor 23 maart 2022
            $query23maart = "SELECT SUM(amount) as totaal FROM applicants WHERE date='23 maart 2022'";
            $stm = $conn->prepare($query23maart);
            if($stm->execute()) {
                $data23maart = $stm->fetch(PDO::FETCH_OBJ);
                    echo "Totale aanmeldingen 23 maart => ".$data23maart->totaal;
            } else echo "query23maart niet succesvol uitgevoerd";
        
        ?>
    </body>
</html>