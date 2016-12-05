<?php

session_start();

if ((!isset($_POST['login'])) || (!isset($_POST['pass']))){
    header('Location: index.php');
    exit();
	}

require_once 'connect.php';

    $conection = new mysqli($host, $db_user, $db_password, $db_name);
    
    if($conection->connect_errno!=0){
        echo"Error: ".$conection->connect_errno;
    }else {

        $log = $_POST['login'];
        $pass = $_POST['pass'];
        
        ///////////////////////////////////////////
        //zabezpiecznie przed sql injection
        $log = htmlentities($log, ENT_QUOTES, "UTF-8");
        
     
     
        if($result = $conection->query(
                sprintf("SELECT * FROM admins WHERE "
                . "login = '%s'",
                mysqli_real_escape_string($conection, $log))))
        {
        ////////////////////// ////////////////////////////   
            $howManyUsers = $result->num_rows;
            
            if($howManyUsers>0){
                
                $row = $result->fetch_assoc();
                
                if(password_verify($pass, $row['password'])){
                
                    $_SESSION['loged'] = true;//
                
                    $_SESSION['idadmins'] = $row['idadmins'];//pobieranie Id użytkownika
                    $_SESSION['login'] = $row['login'];
                    $_SESSION['pass'] = $row['password'];
                    
                
                    unset($_SESSION['error']);
                
                    $result->free();
                    
                    header('Location: adminpanel.php');
                     
                } else {
					$_SESSION['error'] = '<span class="error">Nieprawidłowy '
                        . 'e-mail lub hasło!</span>';
						
			header('Location: admin.php');
                }
                
            }else{
                $_SESSION['error'] = '<span class="error">Nieprawidłowy '
                        . 'e-mail lub hasło!</span>';
			echo 'bląd';			
                header('Location: admin.php');
                }
            }
        
        $conection->close();
    }       
?>