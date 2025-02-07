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
        
    $sql= "SELECT COUNT(*) FROM `{$datatable}` WHERE `id` != ''" ;
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
                <div id="bingo_go1-2"><b>最新得獎：
                    <?php
                        if ( $after == 0 )                        
                            echo "尚未抽出" ;
                        else if ( $after > 0 ){
                            $sql = "SELECT * FROM `{$datatable}` WHERE no = '$after' " ;                            
                            $result = execute_sql($database, $sql, $link) ;
                            echo mysql_result($result,0,2)."&nbsp;&nbsp;".mysql_result($result,0,3) ;
                        }
                    ?>
                    </b></div>
            </div>
            <div id="bingo_go2">
                <button type='button' onmousedown='getScrollPosition("<?php echo $datatable ?>")' onclick='form_run("<?php echo $datatable ?>")' id='myBtn'>進行抽獎</button>        
                <div id="msg">抽獎中… 請稍候！</div>
            </div>
        </form>
        <br/><hr/>

        <!--<div class="bingo_total">
            <div class="bingo_name">T00899<br/>王大明</div>
            <div class="bingo_no">第 7 人</div><br/>
        </div>-->

        <?php        

        $sql = "SELECT * FROM `{$datatable}` order by no DESC";
        $result = execute_sql($database, $sql, $link) ;
        
        for ($i=0 ; $i<$sum ; $i++){

            //有抽出再顯示
            if( mysql_result($result,$i,1) != "" ){            
                echo "<div class='bingo_total'>";
                    echo "<div class='bingo_name'><div class='bingo_name-1'>".mysql_result($result,$i,4)."</div><div class='bingo_name-2'>".mysql_result($result,$i,3)."</div></div>";
                    echo "<div class='bingo_no'>第 ".mysql_result($result,$i,0)." 人&nbsp;&nbsp;".mysql_result($result,$i,2)."&nbsp;</div>";
                echo "</div>";  
            }
        }        
        
        ?>
       
    </div>

</div>


    <!-- c -->
    <script src="../javascript/lott/lott_c.js"></script>


</body>
</html>