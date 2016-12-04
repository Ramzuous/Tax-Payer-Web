<?php
session_start();

if((isset($_SESSION['loged'])) && ($_SESSION['loged']==true)){
        header('Location: adminpanel.php');
        exit();//opuszczanie skryptu
        }

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1">
           <?php  //<meta http-equiv="Refresh" content="60"/> ?>

            <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
            <!-- Bootstrap -->
            <link href="css/bootstrap.min.css" rel="stylesheet">     
            <script src="js/jquery.js"></script>
            <!-- Include all compiled plugins (below), or include individual files as needed -->
            <script src="js/bootstrap.min.js"></script>


    
        <title>PodatniX - zaloguj administratora</title>
        
        
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="keywords" content="paliwo spalanie pojazdy licznik kalkulator baza danych"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrom=1"/>
        
        <link rel="stylesheet" href="css/style.css" type="text/css"/>
        
    </head>
    <body>
    <div class="container">
        
        <div class="header">
            PodatniX - zaloguj administratora
        </div>
        <div class="main">
        
        
        <div class="well">
            <form action="loging.php" method="post">
            <br/>
            <br/>
        
            <div class="form-group"> 
                 <label for="login">Login:</label>
                 <input type="text" class="form-control" id="login"  name="login">
            </div>
            <div class="form-group"> 
                 <label for="pass">Hasło:</label>
                 <input type="password" class="form-control" id="pass" name="pass">
            </div>
            
            <input type="submit" value="Zaloguj się" id="button" class="btn btn-info btn-lg"/>
            
            </form>

            
        </div>
  
       </div>
       <div class="footer">
            <div class="footer1">
                PodatniX &copy; Prawa zastrzeżone
            </div>
            <div class="footer2">
                pdrozdz@onet.eu
            </div>
      
    </div>
        
        
    </div>
    </body>
</html>