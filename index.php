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


    
        <title>PodatniX - Twoje obliczanie podatku</title>
        
        
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="keywords" content="paliwo spalanie pojazdy licznik kalkulator baza danych"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrom=1"/>
        
        <link rel="stylesheet" href="css/style.css" type="text/css"/>
        
    </head>
    <body>
    <div class="container">
        
        <div class="header">
            PodatniX
        </div>
        <div class="main">
        
        
        <div class="well">
            <form action="count.php" method="post">
            <br/>
            <br/>
        
            <div class="form-group"> 
                 <label for="incomme">Podaj swoje przychody:</label>
                 <input type="number" class="form-control" id="incomme" 
                        value="0.00" min="0" name="incomme">
            </div>
            <div class="form-group"> 
                 <label for="incommeCosts">Podaj koszty uzyskania swoich dochodów:</label>
                 <input type="number" class="form-control" id="incommCosts" 
                        value="0.00" min="0" name="incommeCosts">
            </div>
            <div class="form-group"> 
                 <label for="social">Podaj koszty ubezpieczenia społecznego:</label>
                 <input type="number" class="form-control" id="social" 
                        value="0.00" min="0" name="social">
            </div>
            <div class="form-group"> 
                 <label for="health">Podaj koszty ubezpieczenia zdrowotnego:</label>
                 <input type="number" class="form-control" id="health" 
                        value="0.00" min="0" name="health">
            </div>
            <input type="submit" value="Oblicz" id="button" class="btn btn-info btn-lg"/>
            
            
            </form>
            
            <div id="result">
                dkjdgkdf
            </div>
            
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

  <?php   /*      
 <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Open Modal</button>
  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Modal Header</h4>
        </div>
        <div class="modal-body">
          <p>Some text in the modal.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>*/
  ?>