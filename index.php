<?php
    session_start();
    include('header.php');    
    include('db.php');
    define('FIZTBL', 'fizClient');

    $conn = DB::getInstance();
        
    ini_set('error_reporting', E_ALL);
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);

    ?>
    <link rel="stylesheet" href="css/modal.css" type="text/css"/> 
    <script src="script/actions.js"></script>
    <script src="script/pageacts.js"></script>
    <?php

    ///////////////////////////////////////////////////////////
/*     $conn = DB::getInstance();
    $strUserAdd = "INSERT INTO `users`(`LOGIN`, `PASS`, `NAME`, `EMAIL`) VALUES (:LOGIN, :PASS, :NAME, :EMAIL)";  
    $arrUserAdd = array(":LOGIN" => "web2022", ":PASS" => password_hash("12345", PASSWORD_BCRYPT), ":NAME" => "Vladimir", ":EMAIL" => "vladimir@mail.com");        
    $query = $conn->prepare($strUserAdd);
    $query->execute($arrUserAdd);  */  
    //////////////////////////////////////////////////////////

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
                    updatePage();              
                });
            </script>
        <?php   
    }

    if (isset($_POST['auth_but_btn'])) {
        if (empty($_POST['log_inp']) || empty($_POST['pass_inp'])){
            ?>
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    openModal('Заполните корректно поле Логин и Пароль');
                });
            </script>
            <?php
        }
        else {
            $strCheck = "SELECT `ID_USER`, `PASS`, `NAME` FROM `users` WHERE LOGIN = :LOGIN";
            $arrCheck = array(":LOGIN" => $_POST['log_inp']);
            $query = $conn->prepare($strCheck);
            $query->execute($arrCheck); 
            $row = $query->fetch();
            if(!$row) { 
                ?>
                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        openModal('Проверьте правильность ввода полей Логин и Пароль');
                    });
                </script>
                <?php                
            }
            else {
                if (password_verify($_POST['pass_inp'], $row['PASS'])) {
                    $_SESSION['ID_USER'] = $row['ID_USER'];
                    $_SESSION['NAME'] = $row['NAME'];
                    $_SESSION['TBL'] = FIZTBL;
                ?>
                    <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            openModal('Здравствуйте, <?=json_encode($row['NAME'])?>. Вы успешно вошли в систему');
                            updatePage();                         
                        });
                    </script>
                <?php                    
                } else {
                ?>
                    <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            openModal('Проверьте правильность ввода полей Логин и Пароль');
                        });
                    </script>
                <?php   
                }
            }

        }
    }
?>

<title>"Электронный помощник адвоката: Главная"</title>
<link rel="stylesheet" href="css/index.css" type="text/css"/>

<main class="main_content">
    <div class="main_start_block">
        <img class="img_main" src="img/jus.jpg" alt="Электронный помощник адвоката">
        <div class="btn_cont">
            <form action="" method="post">
                <input disabled="disabled" type="submit" class="btn_clients btn" name="button_clients" value="Клиенты">
            </form>
            <form action="" method="post">
                <input disabled="disabled" type="submit" class="btn_cases btn" name="button_cases" value="Дела">
            </form>
            <form action="" method="post">
                <input disabled="disabled" type="submit" class="btn_docs btn" name="button_docs" value="Документы">
            </form>
            <form action="" method="post">
                <input disabled="disabled" type="submit" class="btn_events btn" name="button_events" value="События">
            </form>
        </div>        
    </div>
</main>

<?php
include('footer.php');
?>
