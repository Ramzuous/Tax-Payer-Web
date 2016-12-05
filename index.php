<?php
session_start();

if((isset($_SESSION['loged'])) && ($_SESSION['loged']==true)){
        header('Location: adminpanel.php');
        exit();//opuszczanie skryptu
        }
        
        require_once 'connect.php';

    $connection = new mysqli($host, $db_user, $db_password, $db_name);
 
    /*if(isset($_POST['postincomme']) && isset($_POST['postincommeCosts']) && 
            isset($_POST['postsocial']) && isset($_POST['posthealth'])){*/
  if(isset($_POST['incomme'])){  

    try{
        
        function setProcent($value){
            
            $result = $value*100;
            $result = $result.'%';
            return $result;
            
        }
        
        function getTaxFreePayment($id, $connection){
            
            $result = $connection->query("SELECT * FROM freetaxvalue WHERE idfreetaxvalue = '$id'");
            $row = $result->fetch_assoc();
            
            $value = $row['freePay'];
            
            $result->free();
            
            return $value;
        }

        $line = 0.0;  
        $prog=0.0;
        
            $incomme = $_POST['incomme'];
            $incommeCosts = $_POST['incommeCosts'];
            $social = $_POST['social'];
            $health = $_POST['health'];
        
/*
        $incomme = $_POST['postincomme'];
        $incommeCosts = $_POST['postincommeCosts'];
        $social = $_POST['postsocial'];
        $health = $_POST['posthealth'];
        */
        //echo $incomme.'<br/>'.$incommeCosts.'<br/>'.$social.'<br/>'.$health.'<br/>';
        
        $payment = $incomme - $social - $incommeCosts;
        
        //echo $payment.'<br/>';
        
        $result = $connection->query("SELECT * FROM taxes");
        
        $allTaxesRows = $result->num_rows;
        
        //echo $allTaxesRows;
        
        $countDatas = 0;
        
        for($i=1; $i<=$allTaxesRows; $i++){
            
            
            $result = $connection->query("SELECT * FROM taxes WHERE flagT=1 AND "
                    . "idtaxes='$i'");
            
            $row = $result->fetch_assoc();
            
            $values[$countDatas] = $row['value'];
            $guaranteedAmount[$countDatas] = $row['guaranteedAmount'];
            $downPayment[$countDatas] = $row['downPayment'];
            $maxPayment[$countDatas] = $row['maxPayment'];
            $freeTaxPayId[$countDatas] = $row['freetaxvalue_idfreetaxvalue'];
            //echo $values[$countDatas];
            $result->free();
            $countDatas++;
            
        }

        
        for($j=0; $j<$countDatas; $j++){
           /* echo $values[$j].' '.$guaranteedAmount[$j].' '.$downPayment[$j].' '
                    .$maxPayment[$j].' '.$freeTaxPayId[$j].'</br/>';*/
            
            
            if ($maxPayment[$j] >= $payment && $downPayment[$j] < $payment)
                    {//progresja - pośrednie podatki
                        $prog = ($guaranteedAmount[$j] + ($payment - $downPayment[$j] -
                        getTaxFreePayment($freeTaxPayId[$j], $connection)) * $values[$j]) - $health;
                        $taxProg = $values[$j];
                    }
                    else if ($maxPayment[$j] == 0 && $downPayment[$j] == 0)
                    {//liniowy podatek
                        $line = ($guaranteedAmount[$j] + ($payment - $downPayment[$j] -
                        getTaxFreePayment($freeTaxPayId[$j], $connection)) * $values[$j]) - $health;
                        $taxLine = $values[$j];
                    }
                    else if($maxPayment[$j]==0 && $downPayment[$j] != 0 && $payment>$downPayment[$j])
                    {//progresja - najwyższa stawka
                        $prog = ($guaranteedAmount[$j] + ($payment - $downPayment[$j] -
                        getTaxFreePayment($freeTaxPayId[$j], $connection)) * $values[$j]) - $health;
                        $taxProg = $values[$j];
                    }

                    if ($prog < 0)
                    {
                        $prog = 0;
                    }

                    if ($line < 0)
                    {
                        $line = 0;
                    }

        }
        
        $prog = round($prog);
        $line = round($line);
        
        if ($prog < $line)
        {
            //echo $prog.'<br/>';
            //echo $taxProg;
            $resultValue = $prog;
            $resultTax = setProcent($taxProg);
            
        }
        else if($prog > $line)
        {
            $resultValue = $line;
            $resultTax = setProcent($taxLine);
            //echo $line.'<br/>';
            //echo $taxLine;
            
        }
        else
        {
            $resultValue = $prog;
            $resultTax = setProcent($taxProg);
            //echo $prog.'<br/>';
            //echo $taxProg;
            
        }        
        
        
        
    }catch(Exception $e){
        echo $e;
    }
  }
            /*} else {
                echo 'brak danych';
}*/

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
        <script type="text/javascript" src="js/counts.js"></script>
        
    </head>
    <body>
    <div class="container">
        
        <div class="header">
            PodatniX
        </div>
        <div class="main">
        
        
        <div class="well">
            <form  method="post" >
                <!--  action="count.php" -->
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
            <input type="submit" value="Oblicz" id="button" class="btn btn-info btn-lg"
                  />
            <!--  onclick="showResult(incomme.value, incommeCosts.value, 
                               social.value, health.value)"-->
            
            </form>
            <br/>
            <br/>
           
            
            <div id="result">
                
                <?php 
                    if(isset($resultValue) && isset($resultTax)){
                        
                        echo ' <div class="panel panel-default">
                       <div class="panel-body">
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
                
                    /*if(isset($_SESSION['resultValue']) && isset($_SESSION['resultTax'])){
                    
                    echo $_SESSION['resultValue'].'<br/>';
                    echo $_SESSION['resultTax'];
                    }*/
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