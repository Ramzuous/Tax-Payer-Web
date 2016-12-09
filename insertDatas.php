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


function checkDB($query, $connection){
    
        $checkRows = $connection->query($query);
        
        $howManyRows= $checkRows->num_rows;
        
        if($howManyRows!=0){
            return false;
            //echo 'W bazie już wpisano podaną warość!';
        } else {
            return true;
        }
    
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
        
        $valid = checkDB("SELECT * FROM taxes WHERE value='$value'", $connection);
        
        if($valid==true){

            $connection->query("INSERT INTO taxes(idtaxes, value, guaranteedAmount, "
                    . "downPayment, maxPayment, flagT, freetaxvalue_idfreetaxvalue) "
                    . "VALUES(NULL, '$value', '$guaranteedAmount', '$downPayment', "
                    . "'$maxPayment', '1', '$idFree')");
            
        } else {
            echo 'W bazie już wpisano podany podatek!';
        }

    }catch(Exception $e){
        echo $e;  
    }
}   

if(isset($_POST['freePayment'])){
    
    try{
        
        $valid=true;
        $freePayment = $_POST['freePayment'];
        
        $valid = checkDB("SELECT * FROM freetaxvalue WHERE freePay='$freePayment'", $connection);
        
        if($valid==true){

            $connection->query("INSERT INTO freetaxvalue (idfreetaxvalue, "
                    . "freePay) VALUES(NULL, '$freePayment')");
            
        } else {
            echo 'W bazie już wpisano podobną kwotę wolną!';
        }

    }catch(Exception $e){
        echo $e;  
    }
    
}

if(isset($_POST['addLogin']) && isset($_POST['addPass'])){
    
    try{
        
        $valid=true;
        $login = $_POST['addLogin'];
        $pass = $_POST['addPass'];
        
        $valid = checkDB("SELECT * FROM admins WHERE login='$login'", $connection);
        
        $pass_hash = password_hash($pass, PASSWORD_DEFAULT);
        
        if($valid==true){

            $connection->query("INSERT INTO admins (idadmins, "
                    . "login, password) VALUES(NULL, '$login', '$pass_hash')");
            
        } else {
            echo 'W bazie już istnieje dany administrator!';
        }

    }catch(Exception $e){
        echo $e;  
    }
    
}


$connection->close();
    



?>