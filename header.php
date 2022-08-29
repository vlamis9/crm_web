<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">    
    <link rel="stylesheet" href="css/header.css" type="text/css"/>
</head>

    <header class="header">
        <div class="heading">
            <div class="logo_cont">
                <span class="main_text_head">Электронный помощник адвоката</span>               
            </div>
            <div class="to_main_cont">
                <button class="to_main_btn" name="to_main_btn">На главную</button>
            </div>
            <div class="auth_cont">
                <form class="auth_form" action="" method="post">
                    <div class="login">
                        <label class="loglabel" for="log_inp">Логин</label>
                        <input maxlength="50" class="log_inp" name="log_inp" title="Введите свой логин" />
                    </div>
                    <div class="pass">
                        <label class="passlabel" for="pass_inp">Пароль</label>
                        <input type="password" autocomplete maxlength="50" class="pass_inp" name="pass_inp" title="Введите свой пароль" />
                    </div>                    
                    <input type="submit" class="auth_but_btn" name="auth_but_btn" value="Войти" />
                </form>
            </div>
        </div>
        <hr class="hr_header">        
    </header>  
    
    
