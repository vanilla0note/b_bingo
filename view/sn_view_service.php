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
        $id2 = $_POST["myckeck_sn"];
        $code = $_POST["myckeck_code"];
        $datatable = "everyone".$code ;


        //03.搜尋及修改領獎狀態
        $sql = "SELECT * FROM `{$datatable}`  WHERE `id2` = '$id2'" ;
        $result = execute_sql($database, $sql, $link) ;
        $row = mysql_fetch_array($result);

        //傳回null代表沒有符合
        if ( $row == null ) $bingo_state = "無此員工" ;
        else{
            $bingo = mysql_result($result,0,"bingo");

            if      ( $bingo == "" )         $bingo_state = "尚未中獎" ;
            else if ( $bingo == "不可抽獎" ) $bingo_state = "不可抽獎" ;
            else {
                switch ( substr($bingo,0,4) ){
                    case "b0a-": $bingo_state = "董事長獎"   ;  break ;
                    case "b01-": $bingo_state = "頭獎"       ;  break ;
                    case "b02-": $bingo_state = "貳獎"       ;  break ;
                    case "b03-": $bingo_state = "參獎"       ;  break ;
                    case "b04-": $bingo_state = "肆獎"       ;  break ;
                    case "b04a": $bingo_state = "肆獎Ａ"     ;  break ;
                    case "b04b": $bingo_state = "肆獎Ｂ"     ;  break ;
                    case "b05-": $bingo_state = "５獎"       ;  break ;
                    case "b05a": $bingo_state = "５獎Ａ"     ;  break ;
                    case "b05b": $bingo_state = "５獎Ｂ"     ;  break ;
                    case "b06-": $bingo_state = "６獎"       ;  break ;
                    case "b07-": $bingo_state = "７獎"       ;  break ;
                    case "b08-": $bingo_state = "８獎"       ;  break ;
                    case "b09-": $bingo_state = "９獎"       ;  break ;
                    case "b10-": $bingo_state = "１０獎"     ;  break ;
                    case "b70-": $bingo_state = "加碼獎"     ;  break ;

                    case "c01-": $bingo_state = "庇護壹獎"   ;  break ;
                    case "c02-": $bingo_state = "庇護貳獎"   ;  break ;
                    case "c02a": $bingo_state = "庇護貳獎Ａ" ;  break ;
                    case "c02b": $bingo_state = "庇護貳獎Ｂ" ;  break ;
                    case "c03-": $bingo_state = "庇護參獎"   ;  break ;
                    case "c70-": $bingo_state = "憨兒加碼獎" ;  break ;

                    case "d69-": $bingo_state = "憨兒工讀" ;  break ;

                    default: $bingo_state = "查詢錯誤";  break ;
                }

            }
        }


        //04.回傳執行結果
        echo json_encode(array(
            'bingo_result'  => $bingo_state,

        ));

    }

?>