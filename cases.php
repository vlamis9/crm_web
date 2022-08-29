<?php    
//header('Content-type: text/html; charset=utf-8');
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1); 

include('header.php');
require_once('db.php');

?>
<title>Клиенты</title>

<link rel="stylesheet" href="css/style.css" type="text/css"/> 
<link rel="stylesheet" href="css/clients.css">
<link rel="stylesheet" href="css/modal.css" type="text/css"/> 
<link rel="stylesheet" href="css/cases.css" type="text/css"/> 
<script src="script/constants.js"></script>
<script src="script/pageacts.js"></script>

<script src="script/modal.js"></script>
<style>body{background: linear-gradient(180deg, #86D6E1 0%, rgba(255, 255, 255, 0) 100%);}</style>

<main class="main_content">
<?php

if (!isset($_SESSION['ID_USER'])) {
    ?>
        <script>
            document.addEventListener('DOMContentLoaded', function () {                
                window.location.href = "index.php";               
            });
        </script>
    <?php   
}

if (isset($_POST['leave_but'])){
    $_SESSION = array();
    ?>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                window.location.href = "index.php";                  
            });
        </script>
    <?php   
}

if (isset($_SESSION['ID_USER'])) {
    ?>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                updatePage(true, false);              
            });
        </script>
    <?php   
}

$key = array_keys($_POST, 'Новое дело');
if ($key){ 
    createOrEditCase();    
}

$key = array_keys($_POST, 'Сохранить');
if ($key){ 
    $pieces = explode("-", array_shift($key));      
    $idCase = array_pop($pieces); //get 'new' or existing idCase    
    addCase($idCase);    
}

$key = array_keys($_POST, 'Отмена');
if ($key){ 
    echo "<meta http-equiv='refresh' content='0'>";      
}

$key = array_keys($_POST, 'Удалить');
if ($key){
    $pieces = explode("-", array_shift($key));
    $idCase = array_pop($pieces);      
    delCase($idCase);
}

$key = array_keys($_POST, 'Редактировать');
if ($key){
    $pieces = explode("-", array_shift($key));    
    $idCase = array_pop($pieces);      
    createOrEditCase($idCase);
}

function delCase($idCase){
    $conn = DB::getInstance();
    $query = $conn->prepare("DELETE FROM `casesTable` WHERE `ID_CASE` = $idCase");
    $query->execute();   
}

function addCase($idCase = null){    
    $conn = DB::getInstance();
    $query = null;
    if (is_numeric($idCase)){} //update existing case
    else { //insert new case
        $statementStartsWith = "INSERT INTO casesTable (";
        $statement = "";
        $_POST['ID_CLIENT'] = $_POST['id_name_client_select'];
        unset($_POST['id_name_client_select']);
        unset($_POST['btn-submit-new']);          
        foreach ($_POST as $key => $value) {            
            $statement .= "$key, ";
            $_POST[$key] = (empty($value) ? null : $value); 
        }    
        $statement = substr($statement, 0, -2).")"; //cut off last ", "
        $statementParams = preg_replace('/\w+/', ':$0', $statement); //add ':' for params
        $statement = $statementStartsWith . $statement . " VALUES (" . $statementParams;  
        $query = $conn->prepare($statement);
        $query->execute($_POST);
        echo "<meta http-equiv='refresh' content='0'>";     
    }
}

function createOrEditCase($idCase = null){
    ?>
    <script>
        let elemToAppendAfter = null;
        document.addEventListener('DOMContentLoaded', function () {
            //remove actions buttons while editing
            const contBut = document.querySelectorAll(".but-act-cases");
            if (contBut){
                for(let el of contBut) {               
                el.remove();
                } 
            }                      
            //if no data in DB about cases  
            let el = document.querySelector('.empty-cases');               
            if (el) {
                el.remove(); 
            }
        });
    </script> 
    <?php    
    if ($idCase){ // case of existing client
        ?>  <script>
            document.addEventListener('DOMContentLoaded', function () { 
                const tableName = '.casesTable';                
                let el = document.querySelector(tableName);
                const idCase = <?=json_encode($idCase)?>;
                //save only one row of editing client to show 
                const classToFind = "tr-"+idCase;                
                const idRow = el.querySelectorAll(`[class^=${classToFind}]`); //find needed row startsWith tr-idCase
                //console.log(idRow[0].className);
                el.querySelectorAll(`tr:not(.${idRow[0].className})`).forEach(n => n.remove()); 
                let containerCase = document.createElement('div');
                containerCase.classList.add("contCaseForm");
                let elemsToCreate = caseFormCreateStr;
                containerCase.innerHTML += elemsToCreate;                
                el.parentNode.insertBefore(containerCase, el.nextSibling);    // ins aft 
                const clNameRow = el.querySelector("." + idRow[0].className);                
                //set name of client in form field and client category in form field
                //val of client category is from table on create rows                
                setCaseFormStartValsExisting(clNameRow.cells[0].textContent, idRow[0].className.split('-')[3]);      
            });
        </script> 
        <?php
        $strToFillForm = "SELECT * FROM `casesTable` WHERE  `ID_CASE` = $idCase";  
        $conn = DB::getInstance();
        $query = $conn->prepare($strToFillForm);
        $query->execute(); 
        $list = $query->fetch();
        
        unset($list['ID_CASE']);  
        unset($list['ID_CLIENT']);
        ?> 
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const result = <?=json_encode($list)?>;
                for (let elem in result){                    
                    document.querySelector('.' + elem).value = result[elem];                                                
                }
                let butSave = document.querySelector('.' + 'btn-submit');
                butSave.name += <?=json_encode("-$idCase")?>; 
         });
        </script>       
    <?php
    } 
    else { // new case
    ?>  <script> 
            document.addEventListener('DOMContentLoaded', function () {
                const tableName = '.casesTable';                
                let el = document.querySelector(tableName);                               
                if (el) el.remove(); //if table view exist                    
                            
                let newCaseForm = document.createElement('div');
                newCaseForm.classList.add("newCaseForm");
                newCaseForm.innerHTML += `<p>Добавление нового дела</p>`;
                newCaseForm.innerHTML += caseFormCreateStr;
                let elemToAppendAfter = document.querySelector('.searchCase');
                elemToAppendAfter.parentNode.insertBefore(newCaseForm, elemToAppendAfter.nextSibling);
                let butSave = document.querySelector('.btn-submit');
                butSave.name += '-new'; 
                <?php if (!isset($_SESSION['cl-full-names'])) getClientsFullNames(); ?>
                setCaseFormStartValsNew(<?=json_encode($_SESSION['cl-full-names'])?>, <?=json_encode($_SESSION['id-clType'])?>);
            });
        </script>
    <?php 
    }
}

function getClientsFullNames(){
    $namesArrYur = array();
    $namesArrFiz = array();
    $statementGetFiz = "SELECT `ID_FIZ`, `SURNAME`, `NAME`, `MIDDLE` FROM fizClient WHERE 1";
    $statementGetYur = "SELECT `ID_YUR`, `OPF`, `COMPANY`, `OGRN` , `INN` FROM yurClient WHERE 1";
    $conn = DB::getInstance();    
    $query = $conn->prepare($statementGetFiz);                         
    $query->execute();
    $listClFiz  = $query->fetchAll(PDO::FETCH_ASSOC);
    $query = $conn->prepare($statementGetYur);                         
    $query->execute();
    $listClYur  = $query->fetchAll(PDO::FETCH_ASSOC);    
    //get key-value arr id => not null company, opf...
    foreach($listClYur as $subArray){
        $keyToSet = $subArray['ID_YUR'];
        $namesArrFiz[$keyToSet] = "";
        unset($subArray['ID_YUR']);
        $namesArrFiz[$keyToSet] = (implode(' ', array_diff($subArray, array('', null))));      
    } 
    //get key-value arr id => not null name, surname...
    foreach($listClFiz as $subArray){        
        $keyToSet = $subArray['ID_FIZ'];
        $namesArrYur[$keyToSet] = "";
        unset($subArray['ID_FIZ']);
        $namesArrYur[$keyToSet] = (implode(' ', array_diff($subArray, array('', null))));        
    }    
    $_SESSION['cl-full-names'] = $namesArrFiz + $namesArrYur;;      
}

function updateCasesView($idClient = null, $searchResArrIds = null){
    $conn = DB::getInstance();
    if ($idClient) {} //show cases of this client
    else { //show all cases
        $user = $_SESSION['ID_USER'];
        $statement = "SELECT ID_MIX, CLIENT_TYPE FROM mixClients WHERE ID_USERCL =  $user";
        $query = $conn->prepare($statement);                         
        $query->execute();
        $listCl  = $query->fetchAll(PDO::FETCH_ASSOC); 
        foreach ($listCl as $subarray) {
            $_SESSION['id-clType'][$subarray['ID_MIX']] = $subarray['CLIENT_TYPE'];         
        }   
        $listCases = array();
        if(empty($listCl)) { ?> 
            <div class="empty-clients"> Отсутствуют клиенты для которых можно создать дело. 
                                        Необходимо вначале добавить клиента
            </div>
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const newCaseBtn = document.querySelector('.btn-new-case');
                    newCaseBtn.disabled = true;
                });
            </script> 
            <?php
        }
        else 
        {
            $statement = "SELECT ID_CASE, ID_CLIENT, CLIENTSTATUS, CASECAT,
                                 CASEDATE, CONTRACTNUM, CONTRACTSUM, PAYDATE, MAINPOINT, CASEPARTS 
                                 FROM casesTable WHERE ID_CLIENT IN ";
            $in  = str_repeat('?,', count($listCl) - 1) . '?'; 
            $statement .= "($in)"; 
            $idS = array();
            foreach($listCl as $subArray){                
                $idS[] = $subArray['ID_MIX']; 
            }            
            $query = $conn->prepare($statement);                         
            $query->execute($idS); 
            $listCases = $query->fetchAll(PDO::FETCH_ASSOC); //get all cases
            //get clients name
            getClientsFullNames(); 
            if(empty($listCases)) 
            { ?> 
                <div class="empty-cases"> Отсутствуют дела в производстве
                </div>
              <?php
            }
            else 
            {                                              
                ?>    
                <table class="casesTable">
                        <caption>Все дела</caption>
                        <thead>
                            <tr>
                                <th>Клиент</th>                            
                                <th>Статус клиента</th>
                                <th>Категория дела</th>
                                <th>Дата дела</th>
                                <th>Номер. дог.</th> 
                                <th>Сумма дог.</th>
                                <th>Дата оплаты</th>
                                <th>Суть дела</th>
                                <th>Участники дела</th>                        
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($listCases as $row): ?> 
                            <?php $clientTypeKey = array_search($row['ID_CLIENT'], array_column($listCl, 'ID_MIX')); 
                                  //$_SESSION['id-clType'][$row['ID_CLIENT']] = $listCl[$clientTypeKey]['CLIENT_TYPE']; 
                            ?>                     
                            <tr class="tr-<?=$row['ID_CASE']?>-<?=$row['ID_CLIENT']?>-<?=$listCl[$clientTypeKey]['CLIENT_TYPE']?>"> 
                                <td><?php echo $_SESSION['cl-full-names'][$row['ID_CLIENT']]; ?></td> <!-- mixed name -->                        
                                <td><?php echo $row['CLIENTSTATUS']; ?></td>
                                <td><?php echo $row['CASECAT']; ?></td>
                                <td><?php echo date('d.m.y H:i:s', strtotime($row['CASEDATE'])); ?></td>
                                <td><?php echo $row['CONTRACTNUM']; ?></td>
                                <td><?php echo $row['CONTRACTSUM']; ?></td>
                                <td><?php echo date('d.m.y H:i:s', strtotime($row['PAYDATE'])); ?></td>
                                <td><?php echo $row['MAINPOINT']; ?></td>
                                <td><?php echo $row['CASEPARTS']; ?></td>
                                <td>
                                    <div class="but-act-cases">
                                        <form action="#" method="post">
                                            <input type="submit" class="btn-edit-case" name="btn-edit-case-<?=$row['ID_CASE']?>" value="Редактировать" />
                                            <input type="submit" class="btn-del-case" name="btn-del-case-<?=$row['ID_CASE']?>" value="Удалить" onclick="return confirm('Вы уверены, что хотите удалить клиента? \n Данное действие нельзя будет отменить!');" />
                                        </form>
                                    </div>                         
                                </td>
                            </tr>
                        <?php endforeach; ?>    
                        </tbody>
                    </table> 
                    <?php
            }
        }            
    }
}

?> 

<div class="greetCl">
    <h3>Клиенты пользователя <?=$_SESSION['NAME']?></h3>
</div>

<div class="actions_cont">
    <div class="cases-actions">
        <form action="#" method="post">
            <input type="submit" class="btn-new-case btn" name="btn-new-case" value="Новое дело">
        </form>    
    </div>
    <div class="searchCase">
        <form action="#" method="post">
            <input type="search" name="search-case" id="searchCaseInp">
            <input type="submit" name="but-search-case" id="searchCaseBut" value="Поиск">
        </form> 
    </div>      
</div>

<?php

updateCasesView();

?>

</main>

<?php
include('footer.php');
?>
