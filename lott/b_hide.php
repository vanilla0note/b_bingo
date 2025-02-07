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


    //02.資料庫連線與確定資料表
    if ( !isset($_GET["table"]) ){
        header("Location:http://www.c-are-us.org.tw/");
        exit();
    }
    else{
	    require_once('../Conn/PHP_Conn.php'); 
	    $database = set_database() ;
        $datatable = $_GET["table"] ; ; //資料表名稱    
        $link = create_connection() ;

    }
    

    //03.判斷要抽出總共幾位、已經抽出
    $sql= "SELECT COUNT(*) FROM `{$datatable}`" ;
    $result = execute_sql($database, $sql, $link) ; 
    $sum =  mysql_result($result,0,0); //總共要抽出幾位
        
    $sql= "SELECT COUNT(*) FROM `{$datatable}` WHERE id != ''" ;
    $result = execute_sql($database, $sql, $link) ; 
    $after =  mysql_result($result,0,0);     //已經抽出幾位

    /// test //////
    //echo "<br/><br/><br/>";
    //echo "總共要抽出 = ".$sum."<br/>";    
    //echo "已經抽出 = ".$after."<br/>";    
    //echo "<br/>";
    ////////////////    
        
?>


<!DOCTYPE html>
<html>
<head>

<meta charset="UTF-8">
<title>2024年歲末聯歡 抽獎活動</title>

<link rel="stylesheet" href="../css/main.css">
<link rel="stylesheet" href="../css/lott/lott_bingo.css">

</head>
<body>

<header id="page-header">
    <h1>2024年歲末聯歡 抽獎活動</h1>
    <h2><a href="lott.php" target="_parent">回到首頁</a></h2>
</header>

<div id="page-main">
    <div id="result">  
        <form method="post" action="" name="myForm1">    
            <div id="bingo_title"><img src="../img/<?php echo $datatable ?>.png"/></div>
            <div id="bingo_go1">
                <div id="bingo_go1-1">應抽出： <?php echo $sum ?> 人 &nbsp;&nbsp;&nbsp;已抽出： <?php echo $after ?> 人</div>
                <!--<div id="bingo_go1-2"></div>-->
            </div>
            <div id="bingo_go2">
                <button type='button' onclick='form_run("<?php echo $datatable ?>")' id='myBtn'>進行抽獎</button>        
                <div id="msg">抽獎中… 請稍候！</div>
            </div>
        </form>
        <br/><hr/>

        <!--<div class="bingo_total">
            <div class="bingo_name">T00899<br/>王大明</div>
            <div class="bingo_no">第 7 人</div><br/>
        </div>-->

        <?php

        $sql = "SELECT * FROM `{$datatable}` order by no ASC";
        $result = execute_sql($database, $sql, $link) ;

        for ($i=0 ; $i<$sum ; $i++){

            $r =  mt_rand(1,4) ;
            switch ($r){
                case 1 :  $winning_text = "是你嗎？得到這個獎？" ; break ;
                case 2 :  $winning_text = "各位觀眾！請揭曉……"     ; break ;
                case 3 :  $winning_text = "誰是今晚幸運的人？"     ; break ;
                case 4 :  $winning_text = "是誰？拿走這個獎？"     ; break ;
                default:  $winning_text = "今晚大獎，準備公布…"     ; break ;
            }



            //有抽出再顯示
            if( mysql_result($result,$i,"id") != "" ){
                $myid =  substr( mysql_result($result,$i,"id2") , -1 ) ;
                switch( (int)($myid)%2 ){
                    case 0:
                           $str = "抽出來的這個人，員工代號是<font style='font-size:70px;'>偶數</font>";
                        break;
                    case 1:
                           $str = "抽出來的這個人，員工代號是<font style='font-size:70px;'>奇數</font>";
                           break;
                }
                echo "<div class='bingo_total2'>";
                    echo "<div id='bingo_txt' class='bingo_txt'>".$str."</div>";
                    echo "<div id='bingo_click".mysql_result($result,$i,"no")."' class='bingo_click'><font class='click_txt' onclick='myclick(".mysql_result($result,$i,"no").");'>（點我揭曉）</font></div>";
                    echo "<div id='bingo_time".mysql_result($result,$i,"no")."' class='bingo_time'>".$winning_text."</div>";
                    echo "<div id='bingo_ans".mysql_result($result,$i,"no")."' class='bingo_ans'>".mysql_result($result,$i,"id2")."&nbsp;".mysql_result($result,$i,"name")."</div>";
                echo "</div>";
            }
        }


        ?>
       
    </div>

</div>


    <!-- b -->
    <script src="../javascript/lott/lott_b.js"></script>


</body>
</html>