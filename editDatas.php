<?php

require_once 'connect.php';

$connection = new mysqli($host, $db_user, $db_password, $db_name);

$idadmin = $_SESSION['idadmins'];

function getIdFreePayment($freePay, $connection){
    
    $result = $connection->query("SELECT * FROM freetaxvalue WHERE freePay='$freePay'");
    $row = $result->fetch_assoc();
            
    $id = $row['idfreetaxvalue'];
            
    $result->free();
            
    return $id;
}

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

if(isset($_POST['getIdTax']) && isset($_POST['editValue'])){
    
    $idTaxEdit = $_POST['getIdTax'];
    $editValue = $_POST['editValue'];
    
    $connection->query("UPDATE taxes SET value='$editValue' WHERE idtaxes='$idTaxEdit'");
    
}

if(isset($_POST['getIdTax']) && isset($_POST['editGuaranteedAmount'])){
    
    $idTaxEdit = $_POST['getIdTax'];
    $editGuaranteedAmount = $_POST['editGuaranteedAmount'];
    
    $connection->query("UPDATE taxes SET guaranteedAmount='$editGuaranteedAmount' "
            . "WHERE idtaxes='$idTaxEdit'");
    
}

if(isset($_POST['getIdTax']) && isset($_POST['editDownPayment'])){
    
    $idTaxEdit = $_POST['getIdTax'];
    $editDownPayment = $_POST['editDownPayment'];
    
    $connection->query("UPDATE taxes SET downPayment='$editDownPayment' "
            . "WHERE idtaxes='$idTaxEdit'");
    
}

if(isset($_POST['getIdTax']) && isset($_POST['editMaxPayment'])){
    
    $idTaxEdit = $_POST['getIdTax'];
    $editMaxPayment = $_POST['editMaxPayment'];
    
    $connection->query("UPDATE taxes SET maxPayment='$editMaxPayment' "
            . "WHERE idtaxes='$idTaxEdit'");
    
}

if(isset($_POST['getIdTax']) && isset($_POST['editFreePay'])){
    
    $idTaxEdit = $_POST['getIdTax'];
    $editFreePay = $_POST['editFreePay'];
    
    $idFreePay = getIdFreePayment($editFreePay, $connection);
    
    $connection->query("UPDATE taxes SET freetaxvalue_idfreetaxvalue='$idFreePay' "
            . "WHERE idtaxes='$idTaxEdit'");
    
}

if(isset($_POST['getIdTaxDel'])){
    
    $idTaxDel = $_POST['getIdTaxDel'];
    
     $connection->query("UPDATE taxes SET flagT=0 "
            . "WHERE idtaxes='$idTaxDel'");
    
}

$connection->close();

?>
