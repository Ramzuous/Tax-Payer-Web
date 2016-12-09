<?php

require_once 'connect.php';

$connection = new mysqli($host, $db_user, $db_password, $db_name);

$idadmin = $_SESSION['idadmins'];

if(isset($_POST['editLogin'])){
    
    $newLogin = $_POST['editLogin'];

    $connection->query("UPDATE admins SET login='$newLogin' WHERE idadmins='$idadmin'");
    
}

if(isset($_POST['editPass'])){
    
    $newPass = $_POST['editPass'];
    $pass_hash_new = password_hash($newPass, PASSWORD_DEFAULT);

    $connection->query("UPDATE admins SET password='$pass_hash_new' WHERE idadmins='$idadmin'");
    
}

if(isset($_POST['editFreePaymentValue'])){
    
    $newFreePay = $_POST['editFreePaymentValue'];
    $actualFreePay = $_POST['freePayForEdit'];
    
    $result = $connection->query("SELECT * FROM freetaxvalue WHERE freePay='$actualFreePay'");
            
    $row = $result->fetch_assoc();
    
    $idFreePay = $row['idfreetaxvalue'];
    
    $result->free();
    
    $connection->query("UPDATE freetaxvalue SET freePay='$newFreePay' WHERE idfreetaxvalue='$idFreePay'");
}

if(isset($_POST['idTaxForReactive'])){
    
    $idTaxReactive = $_POST['idTaxForReactive'];
    
    $connection->query("UPDATE taxes SET flagT=1 WHERE idtaxes='$idTaxReactive'");
}


$connection->close();

?>
