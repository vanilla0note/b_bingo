<?php
    //01. 登錄資訊
    $id = $_POST["id"] ;
    $pw = sha1($_POST["pw"]) ; //SHA1加密

    //////////// test //////////// 
    echo "<br/>";
    echo "帳號=".$id."<br/>";
    echo "密碼=".$pw."<br/>";
    /////////////////////////////

    //02. 資料庫連線
    require_once('Conn/PHP_Conn.php'); 
    $database = set_database() ;
    $link = create_connection() ;

    //03.讀取資料庫進行登入
    $sql = "SELECT * FROM `b2024-admin` WHERE `id` = '{$id}' AND `pw` = '{$pw}'" ;
    $result = execute_sql($database, $sql, $link) ;    
    $row = mysql_fetch_array($result);

    //傳回null代表帳號密碼沒有符合
    if ( $row == null ){
        header("Location:external.php");
        exit();
    } 
    else if ( $row != null ){
        $name = mysql_result($result,0,"id");
        
        //// test //////
        echo "name = " . $name."<br/>";
        ////////////
    } 


    //04.登入帳號 LOG檔紀錄
    $iipp = $_SERVER["REMOTE_ADDR"];
    date_default_timezone_set('Asia/Taipei'); 
    $now_date = date("Y-m-d H:i:s") ;
    $sql = "INSERT INTO `login_log` (`auto_key`,`login_name`,`login_database`,`iipp`,`now_date`) Values
                                    ('','$name','$database','$iipp','$now_date')";           
    $result = execute_sql("b2024_bingo", $sql, $link);

    
    //05. 寫入Session
    session_start(); //啟動Session
    $_SESSION['bingo2024_name'] = $name ; 
        
    ////// test /////
    //echo "\$_SESSION['bingo2024_name']變數值：".$_SESSION['bingo2024_name']."<br/>";
    //////////////
                
    switch($name){
        case "vanilla0note":
        case "chris":
        case "careus-T":
                $_SESSION['bingo2024_auth'] = "careus-T" ;
                header("Location:sendai/sendai.php");   //系統後台
                break;

        case "careus-TP":
                $_SESSION['bingo2024_auth'] = "careus-TP" ;
                header("Location:lott/lott.php");       //抽獎前台
                break;

        case "careus-TB":
                $_SESSION['bingo2024_auth'] = "careus-TB" ;
                header("Location:view/view.php");       //兌獎前台
                break;



    }

    session_write_close();

    //06. 關閉資料庫連線
    mysql_close($link);
       
?>