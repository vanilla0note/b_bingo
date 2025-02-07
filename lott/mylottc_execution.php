<?php
    //01.權限判斷
    session_start(); //啟動Session

    /// test /////
    //echo "<br/><br/><br/><br/><br/>";
    //echo "\$_SESSION['bingo2024_auth']變數值：".$_SESSION['bingo2024_auth']."<br/>";
    //////////////

    if ( $_SESSION['bingo2024_auth'] != "careus-TP" ){
        header("Location:http://www.c-are-us.org.tw/");
        exit();
    }

    //02.接值
    if ( !isset($_GET["table"]) ){
        $mytable = "notable" ;
        echo "<script charset='UTF8'>";
        echo "window.alert('程式發生錯誤！請洽資訊組！')";
        echo "</script>";
        echo "<script>";
        echo "location.href= 'lott.php';";
        echo "</script>";
        header("Location:http://www.c-are-us.org.tw/");
        exit();
    }
    else
        $mytable = $_GET["table"] ;

    /// test //////
    //echo "<br/>";
    //echo "mytable = ".$mytable."<br/>";
    //echo "<br/>";
    ////////////////


    //03.資料庫連線
	require_once('../Conn/PHP_Conn.php');
	$database = set_database() ; //資料庫名稱
    $link = create_connection() ;


    //04.判斷要總共抽出幾位、現在要抽出、還可不可以抽
    if ($mytable == "c70"){
        //加碼獎項
        $sql= "SELECT COUNT(*) FROM `{$mytable}` WHERE `acc` = 'true'" ;
        $result = execute_sql($database, $sql, $link) ;
        $sum =  mysql_result($result,0,0);  //總共要抽出

        $sql= "SELECT COUNT(*) FROM `{$mytable}` WHERE `id` = '' AND `acc` = 'true'" ;
        $result = execute_sql($database, $sql, $link) ;
        $last =  mysql_result($result,0,0); //還可以抽出
    }
    else {
        //其他獎項
        $sql= "SELECT COUNT(*) FROM `{$mytable}`" ;
        $result = execute_sql($database, $sql, $link) ;
        $sum =  mysql_result($result,0,0);  //總共要抽出

        $sql= "SELECT COUNT(*) FROM `{$mytable}` WHERE `id` = ''" ;
        $result = execute_sql($database, $sql, $link) ;
        $last =  mysql_result($result,0,0); //還可以抽出
    }

    if( $last == 0 ){
        echo "<script charset='UTF8'>";
        echo "window.alert('已經被抽完了！')";
        echo "</script>";
        echo "<script>";
        echo "location.href= 'lott.php';";
        echo "</script>";
        return;
    }
    else{
        $no = $sum - $last + 1 ;  //現在要抽出
    }

    /// test //////
    //echo "<br/>";
    //echo "總共要抽出 = ".$sum."<br/>";
    //echo "還可以抽出 = ".$last."<br/>";
    //echo "現在要抽出第 ".$no." 位<br/>";
    //echo "<br/>";
    ////////////////


    //05.取得隨機範圍

    switch($mytable){
        case "c01":
        case "c02":
        case "c02a":
        case "c02b":
        case "c03":
        case "c70":
        default:
                    //不限定抽獎資格時，讀取抽獎名單的總數量

                    $sql= "SELECT COUNT(*) FROM `everyone2`" ;
                    $result = execute_sql($database, $sql, $link) ;

                    $e_rand1 = 1 ;
                    $e_rand2 = mysql_result($result,0,0) ;
                    break;
    }

    /***********
    e_rand1 起始值 e_rand2 結束值
    ***********/

    /// test //////
    //echo "<br/>";
    //echo "e_rand1 = ".$e_rand1."<br/>";
    //echo "e_rand2 = ".$e_rand2."<br/>";
    //echo "<br/>";
    ////////////////


    //06.隨機抽獎 (若已經中獎則重抽)
    $now_bingo = "" ; //重置抽中獎項變數
    $now_bingo_count = 0 ;    //重置抽獎次數

    do{
        $now_bingo_count++ ;

        if( $now_bingo_count <= 100 ){
            $lottery = mt_rand($e_rand1,$e_rand2) ;

            $sql = "SELECT * FROM `everyone2` WHERE id = '{$lottery}'";
            $result = execute_sql($database, $sql, $link) ;

            $now_bingo = mysql_result($result,0,"bingo") ;
        }
        else if( $now_bingo_count > 100 ){
            $sql = "SELECT * FROM `everyone2` order by bingo ASC";
            $result = execute_sql($database, $sql, $link) ;

            $lottery = mysql_result($result,0,"id") ;
            $now_bingo = mysql_result($result,0,"bingo") ;

            if( $now_bingo != "" ){
                echo "<script charset='UTF8'>";
                echo "window.alert('全部的人都已經中獎了！')";
                echo "</script>";
                echo "<script>";
                echo "location.href= 'lott.php';";
                echo "</script>";
                return;
            }
        }

        /// test //////
        //echo "<br/><br/>";
        //echo "====這是在跑抽獎程式====<br/>";
        //echo "這是第 ".$now_bingo_count." 次跑抽獎<br/>" ;
        //echo "以下是第 ".$no." 位抽出結果<br/>";
        //echo "抽中號碼=".$lottery."<br/>";
        //echo "抽中號碼目前拿獎項=".$now_bingo."<br/>";
        //echo "<br/>";
        ////////////////
    }
    while( $now_bingo!="" );   //不等於代表有拿到獎項 繼續進入抽獎 (條件成立繼續執行迴圈)

    //抽中的人 資訊紀錄
    $id = $lottery ;
    $id2 = mysql_result($result,0,"id2") ;
    $name = mysql_result($result,0,"name") ;
    $dep = mysql_result($result,0,"dep") ;
    $bingo_txt = $mytable."-".$no ;

    /// test //////
    //echo "<br/>";
    //echo "====這是抽獎確定結果====<br/>";
    //echo "抽中號碼=".$id."<br/>";
    //echo "員工代號=".$id2."<br/>";
    //echo "員工姓名=".$name."<br/>";
    //echo "所屬部門=".$dep."<br/>";
    //echo "寫入獎項=".$bingo_txt."<br/>";
    //echo "一共跑了 ".$now_bingo_count." 次<br/>";
    //echo "<br/>";
    ////////////////

    //07.寫入everyone2資料表
    $sql = "UPDATE `everyone2` SET `bingo` ='{$bingo_txt}' WHERE `id` = '{$id}'" ;
    $result = execute_sql($database, $sql, $link);

    //08.寫入獎項資料表
    $sql = "UPDATE `{$mytable}` SET `id`='{$id}' , `id2`='{$id2}' , `name`='{$name}' , `dep`='{$dep}' , `ordering`='' WHERE `no`= '{$no}'" ;
    $result = execute_sql($database, $sql, $link);

    //09. 關閉資料庫連線
    //mysql_free_result($result);
    mysql_close($link);

    //10.緩衝時間
    sleep(1);

    //11. 網頁跳轉
    switch($mytable){
        case "c70":
            header("Location:c_raise.php?table=".$mytable);
            break;
        default:
            header("Location:c_display.php?table=".$mytable);
            break;
    }

?>

