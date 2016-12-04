<?php
   
    require_once 'connect.php';

    $connection = new mysqli($host, $db_user, $db_password, $db_name);
    
    try{
        

        
        function getTaxFreePayment($id, $connection){
            
            $result = $connection->query("SELECT * FROM freetaxvalue WHERE idfreetaxvalue = '$id'");
            $row = $result->fetch_assoc();
            
            $value = $row['freePay'];
            
            $result->free();
            
            return $value;
        }




        $incomme = $_POST['incomme'];
        $incommeCosts = $_POST['incommeCosts'];
        $social = $_POST['social'];
        $health = $_POST['health'];
        
        //echo $incomme.'<br/>'.$incommeCosts.'<br/>'.$social.'<br/>'.$health;
        
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
            
            $result->free();
            $countDatas++;
        }

        
        
        for($j=0; $j<$countDatas; $j++){
            /*echo $values[$j].' '.$guaranteedAmount[$j].' '.$downPayment[$j].' '
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
        
        if ($prog < $line)
        {
            echo $prog.'<br/>';
            echo $taxProg;
        }
        else if($prog > $line)
        {
            echo $line.'<br/>';
            echo $taxLine;
        }
        else
        {
            echo $prog.'<br/>';
            echo $taxProg;
        }
        
        
        
    }catch(Exception $e){
        echo $e;
    }

    


?>
