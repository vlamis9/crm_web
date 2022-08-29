<?php    
define('FIZ', 1);
define('YUR', 2);
define('MIXTBL', 'mixClients');
define('FIZTBL', 'fizClient');
define('YURTBL', 'yurClient');
define('IDF', 'ID_FIZ');
define('IDY', 'ID_YUR');

//header('Content-type: text/html; charset=utf-8');
 ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1); 

include('header.php');
require_once('db.php');

?>
<title>Клиенты</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="css/style.css" type="text/css"/> 
<link rel="stylesheet" href="css/clients.css">
<link rel="stylesheet" href="css/modal.css" type="text/css"/> 
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

if (!isset($_GET['selCl'])) {$_GET['selCl'] = FIZTBL;} //set startup value for clients view


function updateClientsFizView($searchResArrIds = null){
    $table = FIZTBL;

    $columns = array('DACRORUP', 'SURNAME', 'NAME');
    $column = isset($_GET['column']) && in_array($_GET['column'], $columns) ? $_GET['column'] : $columns[0];
    $sort_order = isset($_GET['order']) && strtolower($_GET['order']) == 'asc' ? 'ASC' : 'DESC';
    $up_or_down = str_replace(array('ASC','DESC'), array('up','down'), $sort_order); 
    $asc_or_desc = $sort_order == 'ASC' ? 'desc' : 'asc';
        
    $conn = DB::getInstance();
    $query = null;
    $idUser = $_SESSION['ID_USER'];
    
    
    $statement = "SELECT ID_FIZ, SURNAME, NAME, MIDDLE, BIRTHDAY, TELM, EMAIL, DACRORUP 
                  FROM fizClient WHERE ID_FIZ IN ";
    if ($searchResArrIds) //prepare view for search result
    {
        $in  = str_repeat('?,', count($searchResArrIds) - 1) . '?';
        $statement .= "($in) ORDER BY $column $sort_order"; 
        $params = array();
        foreach($searchResArrIds as $subArray){
            foreach($subArray as $val){
                $params[] = $val;
            }
        }        
        $query = $conn->prepare($statement);                         
        $query->execute($params);       
    } else { //all clients
        $statement .= "(SELECT ID_MIX FROM mixClients WHERE ID_USERCL = $idUser) ORDER BY $column $sort_order"; 
        $query = $conn->prepare($statement);                         
        $query->execute();
    }    

    $list = $query->fetchAll(PDO::FETCH_ASSOC); 
    if(empty($list)) { ?>
        <div class="empty-client">У вас еще нет записей о клиентах</div>
        <?php  }
    else { ?>       
        <table class="fizClient">
            <caption>Клиенты: Физические лица</caption>
            <thead>
                <tr> 
                    <th class="active">
                        <a href="?selCl=fizClient&column=SURNAME&order=<?php echo $asc_or_desc;?>">Фамилия
                            <i class="i-sort<?php echo $column == 'SURNAME' ? '-' . $up_or_down : '';?>">
                            ⇵                                                        
                            </i>
                        </a>
                    </th>                
                    <th class="active">
                        <a href="?selCl=fizClient&column=NAME&order=<?php echo $asc_or_desc;?>">Имя
                            <i class="i-sort<?php echo $column == 'NAME' ? '-' . $up_or_down : '';?>">
                            ⇵                                                       
                            </i>
                        </a>
                    </th>
                    <th>Отчество</th>
                    <th>Дата рождения</th>
                    <th>Телефон</th>
                    <th>Эл. почта</th>
                    <th class="active">
                        <a href="?selCl=fizClient&column=DACRORUP&order=<?php echo $asc_or_desc;?>">Дата создания или обн.
                            <i class="i-sort<?php echo $column == 'DACRORUP' ? '-' . $up_or_down : '';?>">
                            ⇵                                                        
                            </i>
                        </a>
                    </th>       
                    <th></th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($list as $row): ?>
                <tr class="tr-<?=$row['ID_FIZ']?>">
                    <td><?php echo $row['SURNAME'];?></td>
                    <td><?php echo $row['NAME'];?> </td>                    
                    <td><?php echo $row['MIDDLE']; ?></td>                    
                    <td><?php if (!empty($row['BIRTHDAY'])) echo date('d.m.y', strtotime($row['BIRTHDAY']));?></td>
                    <td><?php echo $row['TELM']; ?></td>
                    <td><?php echo $row['EMAIL']; ?></td>
                    <td><?php echo date('d.m.y H:i:s', strtotime($row['DACRORUP'])); ?></td>
                    
                    <td>
                        <div class="but-act-cl">
                            <form action="#" method="post">
                                <input type="submit" class="btn-editCl btn hidden" name="button-edit-ID_FIZ-fizClient-<?=$row['ID_FIZ']?>" value="Редактировать">
                                <input type="submit" class="btn-delCl btn hidden" name="button-del-ID_FIZ-fizClient-<?=$row['ID_FIZ']?>" value="Удалить" onclick="return confirm('Вы уверены, что хотите удалить клиента? \n Данное действие нельзя будет отменить!')">
                            </form>
                        </div>              
                    </td>
                </tr>
                <?php endforeach; ?>    
            </tbody>
        </table> 
    <?php }

    ?>            
    <script>    
        document.addEventListener('DOMContentLoaded', function () {
            document.getElementById('searchClBut').name = 'search-fizClient';        
        });
    </script>
    <?php
}

function updateClientsYurView($searchResArrIds = null){
    $table = YURTBL;
    
    $columns = array('DACRORUP', 'COMPANY');
    $column = isset($_GET['column']) && in_array($_GET['column'], $columns) ? $_GET['column'] : $columns[0];
    $sort_order = isset($_GET['order']) && strtolower($_GET['order']) == 'asc' ? 'ASC' : 'DESC';
    $up_or_down = str_replace(array('ASC','DESC'), array('up','down'), $sort_order); 
    $asc_or_desc = $sort_order == 'ASC' ? 'desc' : 'asc';
    
    $conn = DB::getInstance();
    $query = null;
    $idUser = $_SESSION['ID_USER'];

    $statement = "SELECT ID_YUR, OPF, COMPANY, OGRN, INN, TEL, EMAIL, DACRORUP 
                  FROM yurClient WHERE ID_YUR IN ";
    if ($searchResArrIds) //prepare view for search result
    {
        $in  = str_repeat('?,', count($searchResArrIds) - 1) . '?';
        $statement .= "($in) ORDER BY $column $sort_order"; 
        $params = array();
        foreach($searchResArrIds as $subArray){
            foreach($subArray as $val){
                $params[] = $val;
            }
        }        
        $query = $conn->prepare($statement);                         
        $query->execute($params);       
    } else { //all clients
        $statement .= "(SELECT ID_MIX FROM mixClients WHERE ID_USERCL = $idUser) ORDER BY $column $sort_order"; 
        $query = $conn->prepare($statement);                         
        $query->execute();
    }    
    $list = $query->fetchAll(PDO::FETCH_ASSOC); 
    if(empty($list)) { ?>
        <div class="empty-client">У вас еще нет записей о клиентах</div>
        <?php  }
    else { ?>        
        <table class="yurClient">
            <caption>Клиенты: Юридические лица</caption>
            <thead>
                <tr>
                    <th>ОПФ</th>
                    <th class="active">
                        <a href="?selCl=yurClient&column=COMPANY&order=<?php echo $asc_or_desc;?>">Наименование
                            <i class="i-sort<?php echo $column == 'COMPANY' ? '-' . $up_or_down : '';?>">
                            ⇵                                                        
                            </i>
                        </a>
                    </th>      
                    <th>ОГРН</th>
                    <th>ИНН</th>
                    <th>Телефон</th>
                    <th>Эл. почта</th>
                    <th class="active">
                        <a href="?selCl=yurClient&column=DACRORUP&order=<?php echo $asc_or_desc;?>">Дата создания или обн.
                            <i class="i-sort<?php echo $column == 'DACRORUP' ? '-' . $up_or_down : '';?>">
                            ⇵                                                        
                            </i>
                        </a>
                    </th>   
                    <th></th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($list as $row): ?>
                <tr class="tr-<?=$row['ID_YUR']?>">
                    <td><?php echo $row['OPF']; ?></td>
                    <td><?php echo $row['COMPANY']; ?></td>
                    <td><?php echo $row['OGRN']; ?></td>
                    <td><?php echo $row['INN']; ?></td>
                    <td><?php echo $row['TEL']; ?></td>
                    <td><?php echo $row['EMAIL']; ?></td>
                    <td><?php echo date('d.m.y H:i:s', strtotime($row['DACRORUP'])); ?></td>
                    <td>
                        <div class="but-act-cl">
                            <form action="#" method="post">
                                <input type="submit" class="btn-editCl btn hidden" name="button-edit-ID_YUR-yurClient-<?=$row['ID_YUR']?>" value="Редактировать">
                                <input type="submit" class="btn-delCl btn hidden" name="button-del-ID_YUR-yurClient-<?=$row['ID_YUR']?>" value="Удалить" onclick="return confirm('Вы уверены, что хотите удалить клиента? \n Данное действие нельзя будет отменить!');">
                            </form>
                        </div>                         
                    </td>
                </tr>
                <?php endforeach; ?>    
            </tbody>
        </table> 
    <?php } 
    
    ?>            
    <script>    
        document.addEventListener('DOMContentLoaded', function () {
            document.getElementById('searchClBut').name = 'search-yurClient';            
        });
    </script>
    <?php
}

function delClient($table, $idToDel, $fieldName){
    $conn = DB::getInstance();
    $query = $conn->prepare("DELETE FROM $table WHERE $fieldName = $idToDel");
    $query->execute(); 
    $query = $conn->prepare("DELETE FROM `mixClients` WHERE `ID_MIX` = $idToDel"); //!!! SET CONSTANT
    $query->execute(); 
    if(isset($_SESSION['id-clType'])) $_SESSION['id-clType'] = array(); 
    if(isset($_SESSION['id-clType'])) $_SESSION['cl-full-names'] = array();   
}

function checkForDuplicates($table) {
    $conn = DB::getInstance();
    $statement = ""; 
    $catCl = null;
    $str = "";
    $params = array(); 
    if  ($table == FIZTBL){ //check fiz needed attrs
        $catCl = IDF;        
        $arrFieldsToCheck = array("SURNAME", "NAME", "MIDDLE", "PASSER", "PASNUM");
        foreach ($arrFieldsToCheck as $field) { 
            $params[":$field"] = $_POST[$field];
            $str .= "$field <=> :$field AND "; //check for value is NULL
        }        
        $str = substr($str, 0, -4); //cut "AND "     
    }
    else { //check yur needed attrs        
        $catCl = IDY;        
        $arrFieldsToCheck = array("OGRN", "INN");
        if (empty($_POST[$arrFieldsToCheck[0]])){
            $str .= $arrFieldsToCheck[1] . " <=> :$arrFieldsToCheck[1]";
            $params[":$arrFieldsToCheck[1]"] = $_POST[$arrFieldsToCheck[1]];
        } 
        else if (empty($_POST[$arrFieldsToCheck[1]])){
            $str .= $arrFieldsToCheck[0] . " <=> :$arrFieldsToCheck[0]";
            $params[":$arrFieldsToCheck[0]"] = $_POST[$arrFieldsToCheck[0]];
        } 
        else {
            $str.= "$arrFieldsToCheck[0] <=> :$arrFieldsToCheck[0] OR $arrFieldsToCheck[1] <=> :$arrFieldsToCheck[1]";
            $params[":$arrFieldsToCheck[0]"] = $_POST[$arrFieldsToCheck[0]];
            $params[":$arrFieldsToCheck[1]"] = $_POST[$arrFieldsToCheck[1]];
        }
    }
    $statement =  "SELECT $catCl FROM $table WHERE ";
    $statement .= $str;    
    $query = $conn->prepare($statement);
    $query->execute($params);
    $list = $query->fetchAll(PDO::FETCH_ASSOC);    
    return(empty($list)); //true if no duplicates    
}


function createOrEditClient($table, $idClient = null){
    ?>
    <script>
        let elemToAppendAfter = null;
        document.addEventListener('DOMContentLoaded', function () {
            //set buttons clients disabled
            const tabLinks = document.querySelectorAll(".tabs__btn");
            for(let el of tabLinks) {                
                el.disabled = true;                
            }
            //remove actions buttons while editing
            const contBut = document.querySelectorAll(".but-act-cl");
            for(let el of contBut) {               
                el.remove();
            }           
            //if no data in DB about clients  
            let el = document.querySelector('.empty-client');               
            if (el) {
                elemToAppendAfter = el.previousElementSibling;
                el.remove(); 
            }
        });
    </script>
    <?php
    
    if ($idClient) { //existing client
    ?>  <script>
            document.addEventListener('DOMContentLoaded', function () { 
                const tableName = <?=json_encode(".$table")?>;                
                let el = document.querySelector(tableName);
                //save only one row of editing client to show                  
                const idRow = <?=json_encode("$idClient")?>;
                el.querySelectorAll("tr:not(.tr-" + idRow + ")").forEach(n => n.remove());
                let containerClient = document.createElement('div');
                containerClient.classList.add("contClientForm");
                let elemsToCreate = <?=json_encode($table)?> == <?=json_encode(FIZTBL)?> ?
                                    f_clientFormCreateStr : y_clientFormCreateStr;
                containerClient.innerHTML += elemsToCreate;                
                el.parentNode.insertBefore(containerClient, el.nextSibling);    // ins aft           
            });
        </script>        
    <?php
        $constant = 'constant'; 
        $strToFillForm = "SELECT * FROM $table WHERE {$constant($table == $constant('FIZTBL') ? 'IDF' : 'IDY')} = $idClient";  
        $conn = DB::getInstance();
        $query = $conn->prepare($strToFillForm);
        $query->execute(); 
        $list = $query->fetch();
        
        array_shift($list);  
        unset($list['DACRORUP']);
        ?> 
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const result = <?=json_encode($list)?>;
                const prefixToAdd = <?=json_encode($table)?> == <?=json_encode(FIZTBL)?> ? 'f_' : 'y_';
                for (let elem in result){                    
                    document.querySelector('.' + prefixToAdd + elem).value = result[elem];                                                
                }
                let butSave = document.querySelector('.' + prefixToAdd + 'btn-submit');
                butSave.name += <?=json_encode("-$idClient")?>;                   
        });
        </script>
        <?php
    }
    else { //new client
    ?>  <script> 
            document.addEventListener('DOMContentLoaded', function () {
                const tableName = <?=json_encode(".$table")?>;                
                let el = document.querySelector(tableName); 
                const elemToAppendAfter = (el ? el.previousElementSibling : document.querySelector('.searchCl'));               
                if (el) el.remove(); //if table view exist
                let newClStr = document.createElement('div');
                newClStr.classList.add("newClientString");
                newClStr.innerHTML += `<p>Добавление нового клиента</p>`;
                elemToAppendAfter.parentNode.insertBefore(newClStr, elemToAppendAfter.nextSibling);
                let containerClient = document.createElement('div');
                containerClient.classList.add("contClientForm");

                let elemsToCreate = null;
                let prefixBut = null;
                if (<?=json_encode($table)?> == <?=json_encode(FIZTBL)?>) { 
                    elemsToCreate = f_clientFormCreateStr; 
                    prefixBut = "f_"; //!!!! check needed or no !!!!!!!!!change in constants js set classname like name
                }   
                else {
                    elemsToCreate = y_clientFormCreateStr;
                    prefixBut = "y_"; //!!!! check needed or no
                }
                containerClient.innerHTML += elemsToCreate;                
                /* const main = document.querySelector('.main_content'); */
                //containerClient.style.order = 1;
                newClStr.parentNode.insertBefore(containerClient, newClStr.nextSibling);
                let butSave = document.querySelector('.' + prefixBut + 'btn-submit');
                butSave.name += '-new';                    
            });
        </script>
    <?php 
    } 
}

function addClientInfoToDB($idClient, $table){ //!!!! поменять местами параметры
    $conn = DB::getInstance();
    $query = null;
    if (is_numeric($idClient)){ //update info existing client
        $prefixToDel = null; 
        $catClient = null;
        if ($table == FIZTBL) {
            $prefixToDel = 'f_';
            $catClient = IDF;
        }
        else {
            $prefixToDel = 'y_';
            $catClient = IDY;
        }        
        $statement = "UPDATE $table SET ";        
        foreach ($_POST as $key => $value) {            
            $new_key = explode($prefixToDel, $key);                                
            if (!empty($new_key[1])) {            
                $statement .= "$new_key[1] = :$new_key[1], ";
                $_POST[$new_key[1]] = (empty($value) ? null : $value); 
            }
            unset($_POST[$key]); 
        }        
        $statement .= "DACRORUP = :DACRORUP";        
        $statement .= " WHERE $catClient = $idClient";        
        $_POST['DACRORUP'] = date('Y-m-d H:i:s'); //add current datetime of editing row       
        $query = $conn->prepare($statement);
        $query->execute($_POST);       
    } 
    else { //insert info new client
        $query = $conn->prepare("INSERT INTO " .MIXTBL. "(`CLIENT_TYPE`, `ID_USERCL`) VALUES (:type, :id)");
        $catClientToInsert = ($table == FIZTBL ? FIZ : YUR);        
        $query->bindParam(':type', $catClientToInsert, PDO::PARAM_INT);
        $query->bindParam(':id', $_SESSION['ID_USER'], PDO::PARAM_INT);
        $query->execute();
        $lastId = $conn->lastInsertId();
                
        $prefixToDel = null;
        $catClient = null;
        if ($table == FIZTBL) {          
            $prefixToDel = 'f_'; 
            $catClient = IDF;
        }
        else {      
            $prefixToDel = 'y_';
            $catClient = IDY; 
        } 
        $statementStartsWith = "INSERT INTO $table (";
        $statement = "";
        $_POST[$prefixToDel.$catClient] = $lastId;
        foreach ($_POST as $key => $value) {            
            $new_key = explode($prefixToDel, $key);                                
            if (!empty($new_key[1])) {            
                $statement .= "$new_key[1], ";
                $_POST[$new_key[1]] = (empty($value) ? null : $value); 
            }
            unset($_POST[$key]); 
        }       
        $statement = substr($statement, 0, -2).")";
        $statementParams = preg_replace('/\w+/', ':$0', $statement); //add ':' for params
        $statement = $statementStartsWith . $statement . " VALUES (" . $statementParams; 
        if (!checkForDuplicates($table)) {
            ?>
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const strToShow = `Клиент уже существует в базе.
                                       <br><br>
                                       Если вы уверены в необходимости добавления клиента, 
                                       отредактируйте информацию в записи 
                                       содержащей совпадение данных
                                       <br><br>
                                       Вы можете воспользоваться кнопкой
                                       <b> \"Поиск\"</b>`; 
                    openModal(strToShow);
                });
            </script>
            <?php
        }
        else {
            $query = $conn->prepare($statement);
            $query->execute($_POST);
            if(isset($_SESSION['id-clType'])) unset($_SESSION['id-clType']); 
            if(isset($_SESSION['id-clType'])) unset($_SESSION['cl-full-names']);  
        } 
    }       
    }    

function searchCl($table, $searchStr){ //remove code duplication TODO !!!
    $conn = DB::getInstance();
    if ($table == FIZTBL) {
        $catCl = IDF;
        $statement = "SELECT $catCl FROM $table WHERE ";
        $str = "";
        $arrFields = array("SURNAME", "NAME", "MIDDLE", "BIRTHDAY", "TELM", "EMAIL", "STREET", "NOTES"); 
        
        foreach ($arrFields as $field) { 
            $str .= "$field LIKE ? OR ";                       
        }         
        $str = substr($str, 0, -3); //cut last "OR " 
        $statement .= $str; 
        $searchArr = array_fill(0, count($arrFields), "%$searchStr%"); 
        $query = $conn->prepare($statement);
        $query->execute($searchArr);
        $list = $query->fetchAll(PDO::FETCH_ASSOC); 
        if ($list) {
            updateClientsFizView($list); //else not found msg TODO!!!!!!!!          
        
        }    
    }
    else {
        $catCl = IDY;
        $statement = "SELECT $catCl FROM $table WHERE ";
        $str = "";
        $arrFields = array("OPF", "COMPANY", "OGRN", "INN", "TEL", "EMAIL", "STREET", "NOTES");
        foreach ($arrFields as $field) { 
            $str .= "$field LIKE ? OR ";                       
        }         
        $str = substr($str, 0, -3); //cut last "OR " 
        $statement .= $str; 
        $searchArr = array_fill(0, count($arrFields), "%$searchStr%"); 
        $query = $conn->prepare($statement);
        $query->execute($searchArr);
        $list = $query->fetchAll(PDO::FETCH_ASSOC); 
        if ($list) {
            updateClientsYurView($list); //else not found msg TODO!!!!!!!!        
        }     
    }
}

$key = array_keys($_POST, 'Удалить');
if ($key){
    $pieces = explode("-", array_shift($key));    
    $idToDel = array_pop($pieces);
    $table = array_pop($pieces);
    $fieldName = array_pop($pieces);
    delClient($table, $idToDel, $fieldName);
}
$key = array_keys($_POST, 'Редактировать');
if ($key){
    $pieces = explode("-", array_shift($key));    
    $idClient = array_pop($pieces);
    $table = array_pop($pieces);    
    createOrEditClient($table, $idClient);
}
$key = array_keys($_POST, 'Новый клиент');
if ($key){    
    createOrEditClient($_GET['selCl']);
}

$key = array_keys($_POST, 'Сохранить');
if ($key){ 
    $pieces = explode("-", array_shift($key));      
    $idClient = array_pop($pieces); //get 'new' or existing idClient
    $table = array_pop($pieces); 
    addClientInfoToDB($idClient, $table);    
}

$key = array_keys($_POST, 'Поиск');
if ($key){
    $pieces = explode("-", array_shift($key));    
    $table = array_pop($pieces); 
    $searchStr = $_POST['search-client'];
    if (!empty($searchStr)) searchCl($table, $searchStr);
    else {
        ?>
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    window.location.href = "clients.php";              
                });
            </script>
        <?php      
    }
}

?>
<div class="greetCl">
    <h3>Клиенты пользователя <?=$_SESSION['NAME']?></h3>
</div>


<div class="actions_cont">
    <div class="clients-actions">
        <form action="#" method="post">
            <input type="submit" class="btn-new-cl btn" name="button-new-cl" value="Новый клиент">
        </form>    
    </div>
    <div class="contClientsSelectButs">
        <form action="#" method="get">
            <button type="submit" class="tabs__btn f_btn_sel" name="selCl" value="<?=FIZTBL?>">Физические лица</button>
            <button type="submit" class="tabs__btn y_btn_sel" name="selCl" value="<?=YURTBL?>">Юридические лица</button>
        </form>    
    </div>
    <div class="searchCl">
        <form action="#" method="post">
            <input type="search" name="search-client" id="searchClInp">
            <input type="submit" name="but-search-cl" id="searchClBut" value="Поиск">
        </form> 
    </div>      
</div>


<?php
if (!array_keys($_POST, 'Поиск')) {
    if ($_GET['selCl'] == FIZTBL) {updateClientsFizView();}
    else {updateClientsYurView();} 
}
 
?>

</main>
<?php
include('footer.php');
?>
