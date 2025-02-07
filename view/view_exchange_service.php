<?php  
    if( !isset($_SESSION) ) session_start();  
    header('Content-Type: application/json; charset=UTF-8'); //設定資料類型為 json，編碼 utf-8

    //如果是 POST 才會執行
    if ($_SERVER['REQUEST_METHOD'] == "POST") {     

        //01.資料庫連線
        require_once('../Conn/PHP_Conn.php'); 
        $database = set_database() ;
        $link = create_connection() ; 


        //02.篩選條件組合成查詢語法
        $datatable = $_POST["myckeck_table_val"];
        $no        = $_POST["myckeck_no_val"];


        //03.搜尋及修改領獎狀態
        $sql = "SELECT * FROM `{$datatable}` WHERE `no` = '$no'" ;
        $result = execute_sql($database, $sql, $link) ; 

        $ordering_target = mysql_result($result,0,"ordering");

        if ( $ordering_target == "" ){
            $sql = "UPDATE `{$datatable}` SET `ordering` = 'OK' WHERE `no` = '$no'" ;
            $result = execute_sql($database, $sql, $link);
                
            $ordering_state = "OK" ; //已經變成為OK
        }
        else if ( $ordering_target == "OK" ){
            $sql = "UPDATE `{$datatable}` SET `ordering` = '' WHERE `no` = '$no'" ;
            $result = execute_sql($database, $sql, $link);

            $ordering_state = "nodata" ; //已經變成無資料
        }


        //04.回傳執行結果
        echo json_encode(array(
            'myno'  => $no,
            'myordering_state' => $ordering_state,

        ));

    }

?>