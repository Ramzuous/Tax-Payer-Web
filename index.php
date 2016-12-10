<?php
session_start();

if((isset($_SESSION['loged'])) && ($_SESSION['loged']==true)){
        header('Location: adminpanel.php');
        exit();//opuszczanie skryptu
        }
    require_once 'getDatas.php';


?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrom=1"/>

        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <!-- Bootstrap -->
        <link href="css/bootstrap.min.css" rel="stylesheet">     
        <script src="js/jquery.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="js/bootstrap.min.js"></script>
        
        <title>PodatniX - Twoje obliczanie podatku</title>

        <link rel="stylesheet" href="css/style.css" type="text/css"/>
        
    </head>
    <body>
    <div class="container">
        
        <div class="header">
            PodatniX
        </div>
        <div class="main">
        
        
        <div class="well">
            <form method="post">
                
            <br/>
            <br/>
        
            <div class="form-group"> 
                 <label for="incomme">Podaj swoje przychody:</label>
                 <input type="number" class="form-control" id="incomme" name="incomme"
                        value="0.00" min="0">
            </div>
            <div class="form-group"> 
                 <label for="incommeCosts">Podaj koszty uzyskania swoich dochodów:</label>
                 <input type="number" class="form-control" id="incommeCosts" name="incommeCosts" 
                        value="0.00" min="0">
            </div>
            <div class="form-group"> 
                 <label for="social">Podaj koszty ubezpieczenia społecznego:</label>
                 <input type="number" class="form-control" id="social" name="social"
                        value="0.00" min="0">
            </div>
            <div class="form-group"> 
                 <label for="health">Podaj koszty ubezpieczenia zdrowotnego:</label>
                 <input type="number" class="form-control" id="health" name="health" 
                        value="0.00" min="0">
            </div>
            <input type="submit" value="Oblicz" id="countButton" class="btn btn-info btn-lg"/>

            
            </form>
            <br/>
            <br/>
           
            
            <div id="result">
                
                <?php 
                    if(isset($resultValue) && isset($resultTax)){
                        
                        echo ' <div class="panel panel-default">
                       <div class="panel-body">
                       <div class="form-group"> 
                            <label for="resultValue">Dochód:</label>
                            <div id="resultValue">'.$incomme.'</div>
                        </div>
                        <div class="form-group"> 
                            <label for="resultValue">Koszt uzyskania dochodu:</label>
                            <div id="resultValue">'.$incommeCosts.'</div>
                        </div>
                        <div class="form-group"> 
                            <label for="resultValue">Koszt ubezpieczenia społecznego:</label>
                            <div id="resultValue">'.$social.'</div>
                        </div>
                        <div class="form-group"> 
                            <label for="resultValue">Koszt ubezpieczenia zdrowotnego:</label>
                            <div id="resultValue">'.$health.'</div>
                        </div> 
                       <div class="form-group"> 
                            <label for="resultValue">Wartość podatku do zapłacenia:</label>
                            <div id="resultValue">'.$resultValue.'</div>
                        </div>
     
                        <div class="form-group"> 
                            <label for="resultTax">Kowta Podatku:</label>
                            <div id="resultTax">'.$resultTax.'</div>
                        </div>
                        </div>
                
                        </div>';
                        
                    }
                
                   
                ?>
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

