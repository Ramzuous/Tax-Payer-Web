<?php
   
    require_once 'connect.php';

    $connection = new mysqli($host, $db_user, $db_password, $db_name);

    function getTaxFreePayment($id, $connection){
            
            $result = $connection->query("SELECT * FROM freetaxvalue WHERE idfreetaxvalue = '$id'");
            $row = $result->fetch_assoc();
            
            $value = $row['freePay'];
            
            $result->free();
            
            return $value;
        }
        
        function setProcents($value){
            
            $result = 100*$value;
            $result=$result.'%';
            
            return $result;
        }
        
       
            
        $result = $connection->query("SELECT * FROM taxes");
        
        $allTaxesRows = $result->num_rows;
        
        //echo $allTaxesRows;
        
        $countDatas = 0;
        
        for($i=1; $i<=$allTaxesRows; $i++){
            
            
            $result = $connection->query("SELECT * FROM taxes WHERE flagT=1 AND "
                    . "idtaxes='$i'");
            
            $row = $result->fetch_assoc();
            
            $idtaxes[$countDatas] = $row['idtaxes'];
            $values[$countDatas] = $row['value'];
            $guaranteedAmount[$countDatas] = $row['guaranteedAmount'];
            $downPayment[$countDatas] = $row['downPayment'];
            $maxPayment[$countDatas] = $row['maxPayment'];
            $flagT[$countDatas] = $row['flagT'];
            $freeTaxPayId[$countDatas] = $row['freetaxvalue_idfreetaxvalue'];

            $result->free();
            $countDatas++;
            
        }
        
        $countDatas2 = 0;
        for($i=1; $i<=$allTaxesRows; $i++){
            
            
            $result = $connection->query("SELECT * FROM taxes WHERE idtaxes='$i'");
            
            $row = $result->fetch_assoc();
            
            $idtaxes2[$countDatas2] = $row['idtaxes'];
            $values2[$countDatas2] = $row['value'];
            $guaranteedAmount2[$countDatas2] = $row['guaranteedAmount'];
            $downPayment2[$countDatas2] = $row['downPayment'];
            $maxPayment2[$countDatas2] = $row['maxPayment'];
            $flagT2[$countDatas2] = $row['flagT'];
            $freeTaxPayId2[$countDatas2] = $row['freetaxvalue_idfreetaxvalue'];

            $result->free();
            $countDatas2++;
            
        }
        
        $countDatas3 = 0;
        $countDatas32 = 0;
        for($i=1; $i<=$allTaxesRows; $i++){
            
            
            $result = $connection->query("SELECT * FROM taxes WHERE flagT=0 AND "
                    . "idtaxes='$i'");
            
            $row = $result->fetch_assoc();
            
            $idtaxes3[$countDatas3] = $row['idtaxes'];
            $values3[$countDatas3] = $row['value'];
            $guaranteedAmount3[$countDatas3] = $row['guaranteedAmount'];
            $downPayment3[$countDatas3] = $row['downPayment'];
            $maxPayment3[$countDatas3] = $row['maxPayment'];
            $flagT3[$countDatas3] = $row['flagT'];
            $freeTaxPayId3[$countDatas3] = $row['freetaxvalue_idfreetaxvalue'];

            $result->free();
            
            if($idtaxes3[$countDatas3]!=NULL){
                $idtaxes32[$countDatas32] = $idtaxes3[$countDatas3];
                $countDatas32++;
            }
            
            $countDatas3++;

            
        }
        
        
        
        $result = $connection->query("SELECT * FROM freetaxvalue");
        
        $allFreeRows = $result->num_rows;
        
        //echo $allTaxesRows;
        
        $countDatasFree = 0;
        
        for($i=1; $i<=$allFreeRows; $i++){
            
            
            $result = $connection->query("SELECT * FROM freetaxvalue WHERE idfreetaxvalue='$i'");
            
            $row = $result->fetch_assoc();
            
            $idfreePay[$countDatasFree] = $row['idfreetaxvalue'];
            $freePay[$countDatasFree] = $row['freePay'];
            //echo   $freePay[$countDatasFree].'<br/>';
            $result->free();
            $countDatasFree++;
            
        }
            
        
        


if(isset($_POST['incomme'])){
    try{
        
        
        
        $line = 0.0;  
        $prog=0.0;

        if(isset($_POST['incomme'])){
            $incomme = $_POST['incomme'];
        } else {
            $incomme = 0.00;
        }
        
        if(isset($_POST['incommeCosts'])){
            $incommeCosts = $_POST['incommeCosts'];
        } else {
            $incommeCosts = 0.00;
        }
        
        if(isset($_POST['social'])){
            $social = $_POST['social'];
        } else {
            $social = 0.00;
        }
        if (isset($_POST['health'])){
            $health = $_POST['health'];
        } else {
            $health = 0.00;
        }
        
        $payment = $incomme - $social - $incommeCosts;
        
        //echo $payment.'<br/>';
        
        

        
        for($j=0; $j<$countDatas; $j++){
            
            
            if ($maxPayment[$j] >= $payment && $downPayment[$j] < $payment)
                    {//progresja - pośrednie podatki
                        $prog = ($guaranteedAmount[$j] + ($payment - $downPayment[$j] -
                        getTaxFreePayment($freeTaxPayId[$j], $connection)) * $values[$j]) - $health;
                        $taxProg = setProcents($values[$j]);
                    }
                    else if ($maxPayment[$j] == 0 && $downPayment[$j] == 0)
                    {//liniowy podatek
                        $line = ($guaranteedAmount[$j] + ($payment - $downPayment[$j] -
                        getTaxFreePayment($freeTaxPayId[$j], $connection)) * $values[$j]) - $health;
                        $taxLine = setProcents($values[$j]);
                    }
                    else if($maxPayment[$j]==0 && $downPayment[$j] != 0 && $payment>$downPayment[$j])
                    {//progresja - najwyższa stawka
                        $prog = ($guaranteedAmount[$j] + ($payment - $downPayment[$j] -
                        getTaxFreePayment($freeTaxPayId[$j], $connection)) * $values[$j]) - $health;
                        $taxProg = setProcents($values[$j]);
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

                $resultValue = $prog;
                $resultTax = $taxProg;


            }
            else if($prog > $line)
            {
                $resultValue = $line;
                $resultTax = $taxLine;

            }
            else
            {
                $resultValue = $prog;
                $resultTax = $taxProg;


            }     

        }catch(Exception $e){
            echo $e;
        }
        
        $connection->close();
    }

?>
