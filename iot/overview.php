<!DOCTYPE html>
<html>
    <head>
        <title>Overzicht</title>
    </head>

    <body>
        <a href="workshop.php">Aanmelden</a>
        <h1>Aanmeldingsoverzicht</h1>

        <form method="POST">
            <input type="radio" name="radio1" value="15 maart"/>15 maart
            <input type="radio" name="radio1" value="23 maart"/>23 maart
            <input type="text" name="searchbar"/>
            <input type="submit" name="search" value="search"/>
        </form>
        <hr>
        <br>
        
    <?php
        include("wsdatabase.php");

        $query = "SELECT * FROM applicants order by date";

        $stm = $conn->prepare($query);

        if ($stm->execute()) {
            echo "query uitgevoerd!"."<br>";
        } else echo "query mislukt!";


        if (isset($_POST['search'])) {

            $radioValue = $_POST['radio1'];
                if(isset($radioValue)) {
                    $query = "SELECT * FROM applicants WHERE date LIKE '%$radioValue%'";

                    $stm = $conn->prepare($query);
                    $stm->execute();

                    $data = $stm->fetchAll(PDO::FETCH_OBJ);

                    foreach($data as $app) {
                        echo " ".$app->id." //". 
                        " ".$app->name." //". 
                        " ".$app->salutation." //". 
                        " ".$app->gender." //". 
                        " ".$app->address." //". 
                        " ".$app->zipcode." //". 
                        " ".$app->residence." //". 
                        " ".$app->phonenumber." //". 
                        " ".$app->email." //". 
                        " ".$app->date." //". 
                        " ".$app->amount." //". 
                        " ".$app->cost." //"."<br>";
                        
                    }
                } else {
                    $search = $_POST['searchbar'];
                    $query2 = "SELECT * FROM applicants WHERE name='$search'";
                    $stm = $conn->prepare($query2);
                    if($stm->execute()) {
                        $data = $stm->fetchAll(PDO::FETCH_OBJ);

                        foreach($data as $app) {
                            echo " ".$app->id." //". 
                            " ".$app->name." //". 
                            " ".$app->salutation." //". 
                            " ".$app->gender." //". 
                            " ".$app->address." //". 
                            " ".$app->zipcode." //". 
                            " ".$app->residence." //". 
                            " ".$app->phonenumber." //". 
                            " ".$app->email." //". 
                            " ".$app->date." //". 
                            " ".$app->amount." //". 
                            " ".$app->cost." //"."<br>";
                        }
                        
                    }
                        
                    
                    
                }

        
        } else {
            $data = $stm->fetchAll(PDO::FETCH_OBJ);

                foreach($data as $app) {
                    echo " ".$app->applicant_id." //". 
                    " ".$app->name." //". 
                    " ".$app->salutation." //". 
                    " ".$app->gender." //". 
                    " ".$app->address." //". 
                    " ".$app->zipcode." //". 
                    " ".$app->residence." //". 
                    " ".$app->phonenumber." //". 
                    " ".$app->email." //". 
                    " ".$app->date." //". 
                    " ".$app->amount." //". 
                    " ".$app->cost." //"."<br>";
                }

            $query3 = "SELECT SUM(amount) as totaal FROM applicants WHERE date='15 maart 2022'";
            $stm = $conn->prepare($query3);
            if($stm->execute()) {
                $data = $stm->fetchAll(PDO::FETCH_OBJ);
                foreach($data as $app) {
                    echo "Totale aanmeldingen 15 maart => ".$app->totaal."<br/>";
                }
            } else echo "query 3 niet succesvol uitgevoerd";

            $query4 = "SELECT SUM(amount) as totaal FROM applicants WHERE date='23 maart 2022'";
            $stm = $conn->prepare($query4);
            if($stm->execute()) {
                $data = $stm->fetchAll(PDO::FETCH_OBJ);
                foreach($data as $app) {
                    echo "Totale aanmeldingen 23 maart => ".$app->totaal;
                }
            } else echo "query 4 niet succesvol uitgevoerd";


            
            
        }
        
    

    ?>

    </table>



    </body>



</html>