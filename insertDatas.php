<?php
    
require_once 'connect.php';

$connection = new mysqli($host, $db_user, $db_password, $db_name);

function getFreeId($freePayValue, $connection){
    
    $result = $connection->query("SELECT * FROM freetaxvalue WHERE freePay='$freePayValue'");
    
    $row = $result->fetch_assoc();
    
    $id = $row['idfreetaxvalue'];
    
    $result->free();
    
    return $id;
}

if(isset($_POST['value'])){

    try{
        
        $valid=true;
        $value=$_POST['value'];
        $guaranteedAmount=$_POST['guaranteedAmount'];
        $downPayment=$_POST['downPayment'];
        $maxPayment=$_POST['maxPayment'];
        $freePayValue=$_POST['freePayValue'];
        $idFree = getFreeId($freePayValue, $connection);
        
        $checkTaxes = $connection->query("SELECT * FROM taxes WHERE value='$value'");
        
        $howManyValues = $checkTaxes->num_rows;
        
        if($howManyValues!=0){
            $valid=false;
            echo 'W bazie już wpisano podobny podatek!';
        }
        
        if($valid==true){

            $connection->query("INSERT INTO taxes(idtaxes, value, guaranteedAmount, "
                    . "downPayment, maxPayment, flagT, freetaxvalue_idfreetaxvalue) "
                    . "VALUES(NULL, '$value', '$guaranteedAmount', '$downPayment', "
                    . "'$maxPayment', '1', '$idFree')");
            
        }

    }catch(Exception $e){
        echo $e;  
    }
}       
$connection->close();
    



?>