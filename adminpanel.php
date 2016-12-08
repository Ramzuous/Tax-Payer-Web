

<?php
session_start();

if(!isset($_SESSION['loged'])){
        header('Location: index.php');
        exit();
    }

    require_once 'getDatas.php';
    require_once 'insertDatas.php';
    
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
                        <li><a href="#" data-toggle="modal">Edytuj stawkę podatkową</a></li>
                        <li><a href="#" data-toggle="modal">Dodaj kwotę wolną</a></li>
                        <li><a href="#" data-toggle="modal">Edytuj kwotę wolną</a></li>
                        <li><a href="#" data-toggle="modal">Aktywuj próg</a></li>
                        <li><a href="#" data-toggle="modal">Dodaj administratora</a></li>
                        <li><a href="#" data-toggle="modal">Edytuj swoje konto</a></li>
                        <li><a href="logout.php">Wyloguj się</a></li>
                    </ul>
                </div>
            </nav>
        
        <div class="main">
        <!-- modals -->
            <!-- Modal -->
            <div class="modal fade" id="addTax" role="dialog">
                <div class="modal-dialog">
                  <!-- Modal content-->
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
                                        value="0.00" min="0" step="0.1" max="1">
                            </div>
                            <div class="form-group"> 

                                 <label for="guaranteedAmount">Podaj podstawę podatkową:</label>
                                 <input type="number" class="form-control" id="guaranteedAmount" 
                                        name="guaranteedAmount" value="0.00" min="0">
                            </div>
                            <div class="form-group"> 

                                 <label for="downPayment">Podaj dolną granicę podatku:</label>
                                 <input type="number" class="form-control" id="downPayment" 
                                        name="downPayment" value="0.00" min="0">
                            </div>
                            <div class="form-group"> 

                                 <label for="maxPayment">Podaj górną granicę podatku:</label>
                                 <input type="number" class="form-control" id="maxPayment" 
                                        name="maxPayment" value="0.00" min="0">
                            </div>
                            <div class="form-group"> 

                                 <label for="freePay">Podaj górną granicę podatku:</label>
                                 <select class="form-control" id="freePayValue" name="freePayValue">
                                     <?php 
                                     for($i=0; $i<$countDatasFree; $i++){
                                         echo'<option>'.$freePay[$i].'</option>';
                                     }
                                     ?>
                                 </select>
                            </div>
                            <input type="submit" value="dodaj" class="btn btn-info btn-lg"/>
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
                            for($i=0; $i<$countDatas; $i++){
                            echo '<tr>    
                                    <td>'.$idtaxes[$i].'</td>
                                    <td>'.$values[$i].'</td>
                                    <td>'.$guaranteedAmount[$i].'</td>
                                    <td>'.$downPayment[$i].'</td>
                                    <td>'.$maxPayment[$i].'</td>
                                    <td>'.$flagT[$i].'</td>
                                    <td>'.$freeTaxPayId[$i].'</td>
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
