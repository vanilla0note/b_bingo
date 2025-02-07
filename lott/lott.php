<?php
    //01.權限判斷
    session_start(); //啟動Session

    /////// test ///////
    //echo "<br/><br/><br/><br/><br/>";
    //echo "\$_SESSION['bingo2024_auth']變數值：".$_SESSION['bingo2024_auth']."<br/>";
    ///////////////////

    if ( $_SESSION['bingo2024_auth'] != "careus-TP" ){
        header("Location:http://www.c-are-us.org.tw/");
        exit();
    }

	require_once('../Conn/PHP_Conn.php'); 
	$database = set_database() ; 
    $link = create_connection() ; 


    //02.計算一般員工抽獎資訊
    $sql= "SELECT COUNT(*) FROM `everyone1` " ; //一般員工資料表 
    $result = execute_sql($database, $sql, $link) ; 
    $b_sum = mysql_result($result,0,0) ;  //總抽獎人數
    $sql= "SELECT COUNT(*) FROM `everyone1` WHERE `bingo` <> '不可抽獎' AND `bingo` <> ''" ;
    $result = execute_sql($database, $sql, $link) ; 
    $b_bingo = mysql_result($result,0,0) ;  //已經中獎人數 


    //03.計算庇護員工抽獎資訊
    $sql= "SELECT COUNT(*) FROM `everyone2` " ; //庇護員工資料表 
    $result = execute_sql($database, $sql, $link) ; 
    $c_sum = mysql_result($result,0,0) ;  //總抽獎人數
    $sql= "SELECT COUNT(*) FROM `everyone2` WHERE `bingo` <> '不可抽獎' AND `bingo` <> ''" ;
    $result = execute_sql($database, $sql, $link) ; 
    $c_bingo = mysql_result($result,0,0) ;  //已經中獎人數 

        
?>


<!DOCTYPE html>
<html>
<head>

<meta charset="UTF-8">
<title>2024年歲末聯歡 抽獎活動</title>

<link rel="stylesheet" href="../css/main.css">
<link rel="stylesheet" href="../css/lott/lott.css">

</head>
<body>

<header id="page-header">
    <h1>2024年歲末聯歡 抽獎活動</h1>
</header>

<div id="page-main">
    <br/>

    <div id="result_inn">

        <div id="result_inn01">
            <b>一般員工　即時抽獎資訊</b><br/>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;參與抽獎人數：<?php echo $b_sum ?>　　已經中獎人數：<?php echo $b_bingo ?>　尚未中獎人數：<?php echo ($b_sum - $b_bingo) ?><br/>
            <br/>
            <b>庇護員工　即時抽獎資訊</b><br />
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;參與抽獎人數：<?php echo $c_sum ?>　　已經中獎人數：<?php echo $c_bingo ?>　尚未中獎人數：<?php echo ($c_sum - $c_bingo) ?><br />
        </div>
    </div>

    <br/>

    <div id="result01">

        <h2>一般員工抽獎區 <a href="#result02"><img src ="../img/bottom_link.png"></a></h2>
              
        <a href="b_hide.php?table=b01" target="_parent"><div id='bingo_total_b01' class='bingo_total_all'></div></a>

        <a href="b_display.php?table=b02" target="_parent"><div id='bingo_total_b02' class='bingo_total_all'></div></a>
        <a href="b_display.php?table=b03" target="_parent"><div id='bingo_total_b03' class='bingo_total_all'></div></a>
        <a href="b_display.php?table=b04" target="_parent"><div id='bingo_total_b04' class='bingo_total_all'></div></a>

        <a href="b_raise.php?table=b70" target="_parent"><div id='bingo_total_b70' class='bingo_total_all'></div></a>
        
    </div>

    <br/>

    <div id="result02">

        <h2>庇護員工抽獎區 <a href="#top"><img src="../img/top_link.png" /></a></h2>

        <a href="c_display.php?table=c01" target="_parent"><div id='bingo_total_c01' class='bingo_total_all'></div></a>

    </div>

    <br/>

</div>


</body>
</html>