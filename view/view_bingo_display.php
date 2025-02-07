<?php
    //01.權限判斷
    session_start(); //啟動Session

    /// test /////
    //echo "<br/><br/><br/><br/><br/>";
    //echo "\$_SESSION['bingo2024_auth']變數值：".$_SESSION['bingo2024_auth']."<br/>";
    //////////////

    if ( $_SESSION['bingo2024_auth'] != "careus-TB" ){
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
    
    //03.判斷有幾位得獎者
    $sql= "SELECT COUNT(*) FROM `{$datatable}`" ;
    $result = execute_sql($database, $sql, $link) ; 
    $sum =  mysql_result($result,0,0);  

?>


<!DOCTYPE html>
<html>
<head>

<meta charset="UTF-8">
<title>2024年歲末聯歡 抽獎活動（兌獎專區）</title>

<!-- jQuery -->    
<script src='../jquery/jquery-1.12.4.min.js'></script>
<script src='../jquery/jquery-ui-1.12.1.js'></script>
<script src='../jquery/jquery.blockUI.js'></script>
<link rel='stylesheet' href='../jquery/jquery-ui-1.12.1.css'>
<script type='text/javascript' src='../jquery/jquery.cookie.js'></script>

<link rel="stylesheet" href="../css/main.css">
<link rel="stylesheet" href="../css/view/view_bingo.css">

</head>
<body>

<header id="page-header">
    <h1>2024年歲末聯歡 抽獎活動（兌獎專區）</h1>
    <h2><a href="view.php" target="_parent">回到首頁</a></h2>
</header>

<div id="page-main">
    <div id="result">    
        <div id="bingo_title"><img src="../img/<?php echo $datatable ?>.png"  width="980px"></div>
        <hr/>
        
        <!--
        <div class="bingo_no">第 1 人</div>
        <div class="bingo_name">T00899&nbsp;王大明</div>
            -->
            
        <div class="bingo_no"><b>人次</b></div>
        <div class="bingo_name"><b>中獎姓名</b></div>
        <div class="bingo_ordering"><b>領取紀錄</b></div>        
            
            
        <?php
        
        $sql = "SELECT * FROM `{$datatable}` order by no ASC";
        $result = execute_sql($database, $sql, $link) ;
        
        for ($i=0 ; $i<$sum ; $i++){
        
            $no = mysql_result($result,$i,"no") ;
        
            if ( mysql_result($result,$i,"ordering") == "" && mysql_result($result,$i,"name") != ""){
                echo "<div id='no_".mysql_result($result,$i,"no")."'       class='bingo_no'>第 ".mysql_result($result,$i,"no")." 人</div>";
                echo "<div id='name_".mysql_result($result,$i,"no")."'     class='bingo_name'>".mysql_result($result,$i,"id2")."&nbsp;&nbsp;".mysql_result($result,$i,"name")."</div>";            
                echo "<div id='ordering_".mysql_result($result,$i,"no")."' class='bingo_ordering'><div id='exchange_".mysql_result($result,$i,"no")."' class='exchange_online' onclick=view_exchange('".$datatable."','".$no."')>尚未領取</div></div>";                      
            }
            else if ( mysql_result($result,$i,"ordering") == "OK" && mysql_result($result,$i,"name") != ""){
                echo "<div id='no_".mysql_result($result,$i,"no")."'       class='bingo2_no'>第 ".mysql_result($result,$i,"no")." 人</div>";
                echo "<div id='name_".mysql_result($result,$i,"no")."'     class='bingo2_name'>".mysql_result($result,$i,"id2")."&nbsp;&nbsp;".mysql_result($result,$i,"name")."</div>";            
                echo "<div id='ordering_".mysql_result($result,$i,"no")."' class='bingo2_ordering'><div id='exchange_".mysql_result($result,$i,"no")."' class='exchange_offline' onclick=view_exchange('".$datatable."','".$no."')>已領取</div></div>";                      
            }
            else{
                echo "<div class='bingo_no'>第 ".mysql_result($result,$i,0)." 人</div>";
                echo "<div class='bingo_name'>&nbsp;</div>";            
                echo "<div class='bingo_ordering'>&nbsp;</div>";            
            }

        }        
        
        ?>
                
    </div>

    <script src='../javascript/view/view_bingo.js'></script>

</div>

</body>
</html>