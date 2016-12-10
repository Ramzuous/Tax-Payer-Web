

<?php
session_start();

if(!isset($_SESSION['loged'])){
        header('Location: index.php');
        exit();
    }

    require_once 'getDatas.php';
    require_once 'insertDatas.php';
    require_once 'editDatas.php';
    
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="keywords" content="paliwo spalanie pojazdy licznik kalkulator baza danych"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrom=1"/>

        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <!-- Bootstrap -->
        <link href="css/bootstrap.min.css" rel="stylesheet">     
        <script src="js/jquery.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="js/bootstrap.min.js"></script>

        <title>PodatniX - panel administracyjny</title>
                
        <link rel="stylesheet" href="css/style.css" type="text/css"/>
        <script type="text/javascript" src="js/getDatas.js"></script>
        
    </head>
    <body>
        <div class="container">
        
            <div class="header">
                PodatniX - panel administracyjny
            </div>
            <nav class="navbar navbar-default">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <a class="navbar-brand" href="index.php">PodatniX</a>
                    </div>
                    <ul class="nav navbar-nav">
                        <li><a href="#addTax" data-toggle="modal">Dodaj stawkę podatku</a></li>
                        <li><a href="#editTax" data-toggle="modal">Edytuj stawkę podatkową</a></li>
                        <li><a href="#addFreePay" data-toggle="modal">Dodaj kwotę wolną</a></li>
                        <li><a href="#editFreePayment" data-toggle="modal">Edytuj kwotę wolną</a></li>
                        <li><a href="#reactiveTax" data-toggle="modal">Aktywuj próg</a></li>
                        <li><a href="#addAdmin" data-toggle="modal">Dodaj administratora</a></li>
                        <li><a href="#editAdmin" data-toggle="modal">Edytuj swoje konto</a></li>
                        <li><a href="logout.php">Wyloguj się</a></li>
                    </ul>
                </div>
            </nav>
        
        <div class="main">
        <!-- modals -->
            
        <!--dodawanie podatków-->
            <div class="modal fade" id="addTax" role="dialog">
                <div class="modal-dialog">
                  
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">Dodaj stawkę podatkową</h4>
                    </div>
                    <div class="modal-body">
                        <form method="post">
                            <div class="form-group"> 

                                 <label for="value">Podaj stawkę podatku:</label>
                                 <input type="number" class="form-control" id="value" name="value"
                                        value="0.00" min="0" step="0.01" max="1">
                            </div>
                            <div class="form-group"> 

                                 <label for="guaranteedAmount">Podaj podstawę podatkową:</label>
                                 <input type="number" class="form-control" id="guaranteedAmount" 
                                        name="guaranteedAmount" value="0.00" min="0"  step="0.01">
                            </div>
                            <div class="form-group"> 

                                 <label for="downPayment">Podaj dolną granicę podatku:</label>
                                 <input type="number" class="form-control" id="downPayment" 
                                        name="downPayment" value="0.00" min="0"  step="0.01">
                            </div>
                            <div class="form-group"> 

                                 <label for="maxPayment">Podaj górną granicę podatku:</label>
                                 <input type="number" class="form-control" id="maxPayment" 
                                        name="maxPayment" value="0.00" min="0"  step="0.01">
                            </div>
                            <div class="form-group"> 

                                 <label for="freePay">Przypisz kwotę wolną od podatku:</label>
                                 <select class="form-control" id="freePayValue" name="freePayValue">
                                     <?php 
                                     for($i=0; $i<$countDatasFree; $i++){
                                         echo'<option>'.$freePay[$i].'</option>';
                                     }
                                     ?>
                                 </select>
                            </div>
                            <input type="submit" value="Dodaj" class="btn btn-info btn-lg"/>
                        </form>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Zamknij</button>
                    </div>
                  </div>
                </div>
            </div>
        
         <div class="modal fade" id="addFreePay" role="dialog">
                <div class="modal-dialog">
                  
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">Dodaj kwotę wolną</h4>
                    </div>
                    <div class="modal-body">
                        <form method="post">
                            <div class="form-group"> 

                                 <label for="freePayment">Podaj kwotę wolną:</label>
                                 <input type="number" class="form-control" id="freePayment" 
                                        name="freePayment" value="0.00" min="0" step="0.01">
                            </div>
                            
                            <input type="submit" value="Dodaj" class="btn btn-info btn-lg"/>
                        </form>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Zamknij</button>
                    </div>
                  </div>
                </div>
            </div>
        
            <div class="modal fade" id="addAdmin" role="dialog">
                <div class="modal-dialog">
                  
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">Dodaj administratora</h4>
                    </div>
                    <div class="modal-body">
                        <form method="post">
                            <div class="form-group"> 

                                 <label for="addLogin">Podaj login:</label>
                                 <input type="text" class="form-control" id="addLogin" 
                                        name="addLogin">
                            </div>
                             <div class="form-group"> 
                                 <label for="addPass">Podaj hasło:</label>
                                 <input type="password" class="form-control" id="addPass" 
                                        name="addPass">
                            </div>
                            <input type="submit" value="Dodaj" class="btn btn-info btn-lg"/>
                        </form>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Zamknij</button>
                    </div>
                  </div>
                </div>
            </div>
            
             <div class="modal fade" id="editAdmin" role="dialog">
                <div class="modal-dialog">
                  
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">Edytuj swoje konto</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group"> 
                                 <label><?php echo 'Obecny Login: '. $_SESSION['login']; ?></label>
                            </div>
                        <form method="post">
                            <div class="form-group"> 
                                 <label for="editLogin">Podaj nowy login:</label>
                                 <input type="text" class="form-control" id="editLogin" 
                                        name="editLogin">
                            </div>
                            <input type="submit" value="Edytuj login" class="btn btn-info btn-sm"/>
                        </form>
                        <br/>
                        <br/>
                        <form method="post">
                             <div class="form-group"> 
                                 <label for="editPass">Podaj nowe hasło:</label>
                                 <input type="password" class="form-control" id="editPass" 
                                        name="editPass">
                            </div>
                            <input type="submit" value="Edytuj hasło" class="btn btn-info btn-sm"/>
                        </form>
                        
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Zamknij</button>
                    </div>
                  </div>
                </div>
            </div>
        
            <div class="modal fade" id="editFreePayment" role="dialog">
                <div class="modal-dialog">
                  
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">Edytuj kwotę wolną od podatku</h4>
                    </div>
                    <div class="modal-body">
                        <form method="post">
                            <div class="form-group"> 
                                 <label for="freePayForEdit">Wybierz kwotę wolną do edycji:</label>
                                 <select class="form-control" id="freePayForEdit" name="freePayForEdit">
                                     <?php 
                                     for($i=0; $i<$countDatasFree; $i++){
                                         echo'<option>'.$freePay[$i].'</option>';
                                     }
                                     ?>
                                 </select>
                            </div>
                            <div class="form-group"> 
                                 <label for="editFreePaymentValue">Podaj nową kwotę wolną:</label>
                                 <input type="number" class="form-control" id="editFreePaymentValue" 
                                        name="editFreePaymentValue" min="0" step="0.01">
                            </div>
                            <input type="submit" value="Edytuj kwotę wolną" class="btn btn-info btn-lg"/>
                        </form>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Zamknij</button>
                    </div>
                  </div>
                </div>
            </div>
            
            <div class="modal fade" id="reactiveTax" role="dialog">
                <div class="modal-dialog">
                  
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">Aktywuj ponownie kwotę podatkową</h4>
                    </div>
                    <div class="modal-body">
                        <form method="post">
                            <div class="form-group"> 
                                 <label for="idTaxForReactive">Wybierz id podatku do reaktywacji:</label>
                                 <select class="form-control" id="idTaxForReactive" name="idTaxForReactive">
                                     <?php 
                                     for($i=0; $i<$countDatas32; $i++){
                                         echo'<option>'.$idtaxes32[$i].'</option>';
                                     }
                                     ?>
                                 </select>
                            </div>
                            
                            <input type="submit" value="Aktywuj ponownie" class="btn btn-info btn-lg"/>
                        </form>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Zamknij</button>
                    </div>
                  </div>
                </div>
            </div>
        
            <div class="modal fade" id="editTax" role="dialog">
                <div class="modal-dialog">
                  
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">Edytuj podatek</h4>
                    </div>
                    <div class="modal-body">
                            <div class="form-group"> 
                                 <button type="button" class="btn btn-info btn-lg" 
                                         data-toggle="modal" data-target="#editValueModal">
                                     Edytuj stawkę podatku</button>
                        
                            </div>
                            <div class="form-group"> 
                                   <button type="button" class="btn btn-info btn-lg" 
                                         data-toggle="modal" data-target="#editGuaranteedAmountModal">
                                       Edytuj podstawę podatkową</button>
                            </div>
                            <div class="form-group"> 
                                <button type="button" class="btn btn-info btn-lg" 
                                         data-toggle="modal" data-target="#editDownPaymentModal">
                                       Edytuj dolną granicę podatku</button>
                            </div>
                            <div class="form-group"> 
                                <button type="button" class="btn btn-info btn-lg" 
                                         data-toggle="modal" data-target="#editMaxPaymentModal">
                                       Edytuj górną granicę podatku</button>

                            </div>
                            <div class="form-group"> 
                                <button type="button" class="btn btn-info btn-lg" 
                                         data-toggle="modal" data-target="#editFreePayModal">
                                       Przypisz inną kwotę wolną</button>
                            </div>
                             <div class="form-group"> 
                                <button type="button" class="btn btn-danger btn-lg" 
                                         data-toggle="modal" data-target="#deleteTaxModal">
                                       Usuń podatek</button>
                            </div>
                            

                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Zamknij</button>
                    </div>
                  </div>
                </div>
            </div>
                
            <div class="modal fade" id="editValueModal" role="dialog">
                <div class="modal-dialog">
                  
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">Edytuj stawkę podatkową</h4>
                    </div>
                    <div class="modal-body">                        
                        <form method="post">
                            <div class="form-group"> 

                                <label for="getIdTax">Wybierz podatek do edycji:</label>
                                 <select class="form-control" id="getIdTax" name="getIdTax">
                                     <?php 
                                     for($i=0; $i<$countDatas1; $i++){
                                         echo'<option>'.$idtaxes1[$i].'</option>';
                                     }
                                     ?>
                                 </select>
                            </div>
                           
                            <div class="form-group"> 

                                 <label for="editValue">Podaj nową stawkę podatku:</label>
                                 <input type="number" class="form-control" id="editValue" name="editValue"
                                        value="0.00" min="0" step="0.01" max="1">
                            </div>
                            <input type="submit" value="Edytuj" class="btn btn-info btn-lg"/>
                        </form>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Zamknij</button>
                    </div>
                  </div>
                </div>
            </div>
        
            <div class="modal fade" id="editGuaranteedAmountModal" role="dialog">
                <div class="modal-dialog">
                  
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">Edytuj podstawę podatkową</h4>
                    </div>
                    <div class="modal-body">                        
                        <form method="post">
                            <div class="form-group"> 

                                <label for="getIdTax">Wybierz podatek do edycji:</label>
                                 <select class="form-control" id="getIdTax" name="getIdTax">
                                     <?php 
                                     for($i=0; $i<$countDatas1; $i++){
                                         echo'<option>'.$idtaxes1[$i].'</option>';
                                     }
                                     ?>
                                 </select>
                            </div>
                           
                            <div class="form-group"> 

                                 <label for="editGuaranteedAmount">Podaj nową podstawę podatkową:</label>
                                 <input type="number" class="form-control" id="editGuaranteedAmount" 
                                        name="editGuaranteedAmount" value="0.00" min="0"  step="0.01">
                            </div>
                            <input type="submit" value="Edytuj" class="btn btn-info btn-lg"/>
                        </form>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Zamknij</button>
                    </div>
                  </div>
                </div>
            </div>
                            
           <div class="modal fade" id="editDownPaymentModal" role="dialog">
                <div class="modal-dialog">
                  
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">Edytuj dolną granicę podatku</h4>
                    </div>
                    <div class="modal-body">                        
                        <form method="post">
                            <div class="form-group"> 

                                <label for="getIdTax">Wybierz podatek do edycji:</label>
                                 <select class="form-control" id="getIdTax" name="getIdTax">
                                     <?php 
                                     for($i=0; $i<$countDatas1; $i++){
                                         echo'<option>'.$idtaxes1[$i].'</option>';
                                     }
                                     ?>
                                 </select>
                            </div>
                           
                            <div class="form-group"> 
                                <label for="editDownPayment">Podaj nową, górną granicę podatku:</label>
                                 <input type="number" class="form-control" id="editDownPayment" 
                                        name="editDownPayment" value="0.00" min="0"  step="0.01">
                            </div>
                            <input type="submit" value="Edytuj" class="btn btn-info btn-lg"/>
                        </form>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Zamknij</button>
                    </div>
                  </div>
                </div>
            </div>
        
            
                                 
           <div class="modal fade" id="editMaxPaymentModal" role="dialog">
                <div class="modal-dialog">
                  
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">Edytuj górną granicę podatku</h4>
                    </div>
                    <div class="modal-body">                        
                        <form method="post">
                            <div class="form-group"> 

                                <label for="getIdTax">Wybierz podatek do edycji:</label>
                                 <select class="form-control" id="getIdTax" name="getIdTax">
                                     <?php 
                                     for($i=0; $i<$countDatas1; $i++){
                                         echo'<option>'.$idtaxes1[$i].'</option>';
                                     }
                                     ?>
                                 </select>
                            </div>
                           
                            <div class="form-group"> 
                                <label for="editMaxPayment">Podaj nową, górną granicę podatku:</label>
                                 <input type="number" class="form-control" id="editMaxPayment" 
                                        name="editMaxPayment" value="0.00" min="0"  step="0.01">
                               
                            </div>
                            <input type="submit" value="Edytuj" class="btn btn-info btn-lg"/>
                        </form>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Zamknij</button>
                    </div>
                  </div>
                </div>
            </div> 
            
            <div class="modal fade" id="editFreePayModal" role="dialog">
                <div class="modal-dialog">
                  
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">Przypisz nową kwotę wolną</h4>
                    </div>
                    <div class="modal-body">                        
                        <form method="post">
                            <div class="form-group"> 

                                <label for="getIdTax">Wybierz podatek do edycji:</label>
                                 <select class="form-control" id="getIdTax" name="getIdTax">
                                     <?php 
                                     for($i=0; $i<$countDatas1; $i++){
                                         echo'<option>'.$idtaxes1[$i].'</option>';
                                     }
                                     ?>
                                 </select>
                            </div>
                           
                            <div class="form-group"> 
                                 <label for="editFreePay">Przypisz nową kwotę wolną od podatku:</label>
                                 <select class="form-control" id="editFreePay" name="editFreePay">
                                     <?php 
                                     for($i=0; $i<$countDatasFree; $i++){
                                         echo'<option>'.$freePay[$i].'</option>';
                                     }
                                     ?>
                                 </select>
                               
                            </div>
                            <input type="submit" value="Edytuj" class="btn btn-info btn-lg"/>
                        </form>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Zamknij</button>
                    </div>
                  </div>
                </div>
            </div> 
        
            <div class="modal fade" id="deleteTaxModal" role="dialog">
                <div class="modal-dialog">
                  
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">Usuń dany podatek</h4>
                    </div>
                    <div class="modal-body">                        
                        <form method="post">
                            <div class="form-group"> 
                                <label for="getIdTaxDel">Wybierz podatek do usunięcia:</label>
                                 <select class="form-control" id="getIdTaxDel" name="getIdTaxDel">
                                     <?php 
                                     for($i=0; $i<$countDatas1; $i++){
                                         echo'<option>'.$idtaxes1[$i].'</option>';
                                     }
                                     ?>
                                 </select>
                            </div>
                            <input type="submit" value="Usuń" class="btn btn-danger btn-lg"/>
                        </form>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Zamknij</button>
                    </div>
                  </div>
                </div>
            </div>     
        
            <div class="well" id="tables">
                <div id="tax-table" class="table-responsive">
                    <label for="taxtable">Stawki podatku (flagT: 1-aktywny, 0-nieaktywny)</label>
                    <table class="table table-striped table-bordered" id="taxtable">
                        <thead>
                          <tr>
                            <th>idtaxes</th>
                            <th>value</th>
                            <th>guaranteedAmount</th>
                            <th>downPayment</th>
                            <th>maxPayment</th>
                            <th>flagT</th>
                            <th>freetaxvalue_idfreetaxvalue</th>
                          </tr>
                        </thead>
                        <tbody>
                            <?php 
                            for($i=0; $i<$countDatas2; $i++){
                            echo '<tr>    
                                    <td>'.$idtaxes2[$i].'</td>
                                    <td>'.$values2[$i].'</td>
                                    <td>'.$guaranteedAmount2[$i].'</td>
                                    <td>'.$downPayment2[$i].'</td>
                                    <td>'.$maxPayment2[$i].'</td>
                                    <td>'.$flagT2[$i].'</td>
                                    <td>'.$freeTaxPayId2[$i].'</td>
                                </tr>';
                            }
                            ?>                     
                        </tbody>
                     </table>
                </div>
                <div  id="free-table" class="table-responsive">
                    <label for="freetable">Kwoty wolne od podatku:</label>
                    <table class="table table-striped table-bordered" id="freetable">
                        <thead>
                          <tr>
                            <th>idfreetaxvalue</th>
                            <th>freePay</th>
                          </tr>
                        </thead>
                        <tbody>
                            
                            <?php 
                            for($i=0; $i<$countDatasFree; $i++){
                                echo '<tr>
                                    <td>'.$idfreePay[$i].'</td>
                                    <td>'.$freePay[$i].'</td>
                                </tr>';
                            }
                            ?>

                        </tbody>
                     </table>
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
