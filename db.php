<?php
session_start();


ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1); 
define('DB_HOST', 'localhost');
define('DB_NAME', 'MyDB');
define('DB_USER', 'phpmyadmin');
define('DB_PASS', 'suukii999'); 
/* define('DB_HOST', 'localhost');
define('DB_NAME', 'x911753i_db');
define('DB_USER', 'x911753i_db');
define('DB_PASS', 'cznweb2022$');  */


/* define('SQL_ARR', array(
    "strUsers"  => "CREATE TABLE IF NOT EXISTS `MyDB`.`users` 
                 ( `ID_USER` INT NOT NULL AUTO_INCREMENT, 
                 `LOGIN` TINYTEXT NOT NULL ,
                 `PASS` TINYTEXT NOT NULL ,
                 `NAME` TINYTEXT NOT NULL , 
                 `EMAIL` TINYTEXT NOT NULL ,                   
                 PRIMARY KEY (`ID_USER`)) ENGINE = InnoDB;",
    "strMix"  => "CREATE TABLE IF NOT EXISTS `MyDB`.`mixClients` 
                 ( `ID_MIX` INT NOT NULL AUTO_INCREMENT, `ID_USERCL` INT NOT NULL, 
                 `CLIENT_TYPE` INT NOT NULL ,                    
                 PRIMARY KEY (`ID_MIX`),
                 CONSTRAINT `link_mixClients_users` 
                 FOREIGN KEY (`ID_USERCL`) REFERENCES `users`(`ID_USER`) 
                 ON DELETE NO ACTION ON UPDATE NO ACTION) ENGINE = InnoDB;",
    "strFiz"  => "CREATE TABLE IF NOT EXISTS `MyDB`.`fizClient` 
                 ( `ID_FIZ` INT NOT NULL , `SURNAME` TINYTEXT NULL , `NAME` TINYTEXT NULL , 
                 `MIDDLE` TINYTEXT NULL , `BIRTHDAY` DATE NULL , `TELM` TINYTEXT NULL , 
                 `EMAIL` TINYTEXT NULL , `PASSER` INT NULL , `PASNUM` INT NULL , 
                 `WHENIS` DATE NULL , `ISBYWHOM` TINYTEXT NULL , `PASCODE` TINYTEXT NULL , 
                 `TELW` TINYTEXT NULL , `IND` INT NULL , `CITY` TINYTEXT NULL , 
                 `STREET` TINYTEXT NULL , `BLD` TINYTEXT NULL , `CORP` TINYTEXT NULL , 
                 `FLAT` TINYTEXT NULL , `NOTES` MEDIUMTEXT NULL , `DACRORUP` DATETIME NOT NULL DEFAULT (CURRENT_TIMESTAMP) ,
                 PRIMARY KEY (`ID_FIZ`), 
                 CONSTRAINT `link_mixClients_fizClient` 
                 FOREIGN KEY (`ID_FIZ`) REFERENCES `mixClients`(`ID_MIX`) 
                 ON DELETE NO ACTION ON UPDATE NO ACTION, 
                 CONSTRAINT unique_id_fiz UNIQUE (ID_FIZ)) ENGINE = InnoDB;",
    "strYur"  => "CREATE TABLE IF NOT EXISTS `MyDB`.`yurClient` 
                 ( `ID_YUR` INT NOT NULL , `OPF` TINYTEXT NULL , `COMPANY` TINYTEXT NULL , 
                 `OGRN` INT NULL , `INN` INT NULL , `TEL` TINYTEXT NULL , 
                 `EMAIL` TINYTEXT NULL , `DELEGATE` TINYTEXT NULL , `SURDEL` TINYTEXT NULL , 
                 `NAMEDEL` TINYTEXT NULL , `MIDDEL` TINYTEXT NULL , `IND` INT NULL , 
                 `CITY` TINYTEXT NULL , `STREET` TINYTEXT NULL , `BLD` TINYTEXT NULL , 
                 `CORP` TINYTEXT NULL , `ROOM` TINYTEXT NULL , `DOC` TINYTEXT NULL , 
                 `REQS` TINYTEXT NULL , `BSURNAME` TINYTEXT NULL , `BNAME` TINYTEXT NULL , 
                 `BMIDDLE` TINYTEXT NULL , `NOTES` MEDIUMTEXT NULL , `DACRORUP` DATETIME NOT NULL DEFAULT (CURRENT_TIMESTAMP) ,
                 PRIMARY KEY (`ID_YUR`), 
                 CONSTRAINT `link_mixClients_yurClient` 
                 FOREIGN KEY (`ID_YUR`) REFERENCES `mixClients`(`ID_MIX`) 
                 ON DELETE NO ACTION ON UPDATE NO ACTION, 
                 CONSTRAINT unique_id_yur UNIQUE (ID_YUR)) ENGINE = InnoDB;",
    "strCase" => "CREATE TABLE IF NOT EXISTS `MyDB`.`casesTable` 
                  ( `ID_CASE` INT NOT NULL AUTO_INCREMENT, `ID_CLIENT` INT NOT NULL , 
                  `CLIENTSTATUS` INT NOT NULL , `CASECAT` INT NOT NULL , 
                  `CASEDATE` DATE NULL , `CONTRACTNUM` TINYTEXT NULL , 
                  `CONTRACTSUM` INT NULL , `MAINPOINT` TINYTEXT NULL , 
                  `CASEPARTS` TINYTEXT NULL , `RULESOFLAW` TINYTEXT NULL , 
                  `PAYDATE` DATE NULL , `NOTES` MEDIUMTEXT NULL , 
                  PRIMARY KEY (`ID_CASE`), 
                  CONSTRAINT `link_mixClients_cases` 
                  FOREIGN KEY (`ID_CLIENT`) REFERENCES `mixClients`(`ID_MIX`) 
                  ON DELETE CASCADE) ENGINE = InnoDB;",
    ) 
); */
define('DB_CHAR', 'utf8');

class DB
{
    protected static $instance = null;
       
    protected function __construct() {}
    protected function __clone() {}

    public static function getInstance()
    {
        if (self::$instance === null)
        {
            $optDb = array(
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => FALSE,
            );
            try {                
                self::$instance = new PDO("mysql:host=" .DB_HOST, DB_USER, DB_PASS, $optDb);
                /* $sql = "CREATE DATABASE IF NOT EXISTS " .DB_NAME;
                self::$instance->exec($sql);   */              
                $sql = "use " .DB_NAME;
                self::$instance->exec($sql);
                /* foreach(SQL_ARR as $query){
                    self::$instance->exec($query);;
                }  */               
            }
            catch(PDOException $e)
            {
                echo $sql . "<br>" . $e->getMessage();
            }             
        }
        return self::$instance;
    }
}

