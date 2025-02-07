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
<link rel="stylesheet" href="../css/view/view.css">

</head>
<body>

<header id="page-header">
    <h1>2024年歲末聯歡 抽獎活動（兌獎專區）</h1>
    <h3><a href="view_logout.php" target="_parent"><font color="#000">登出系統</font></a></h3>
</header>

<div id="page-main">
    <br/>

    <div id="result00">
        <h2>快速查詢區</h2>
        <a href="fast1.php" target="_parent"><div id='bingo_total_fast1' class='bingo_total_all'></div></a>
        <a href="fast2.php" target="_parent"><div id='bingo_total_fast2' class='bingo_total_all'></div></a>
        <a href="fast3.php" target="_parent"><div id='bingo_total_fast3' class='bingo_total_all'></div></a>
                                             <div id='bingo_total_fast_search' class='bingo_total_all' onclick="sn_view();"></div>
    </div>

    <br/>

    <div id="result01">
        <h2>一般員工兌獎區</h2>
        <a href="view_bingo_display.php?table=b0a" target="_parent"><div id='bingo_total_b0a' class='bingo_total_all'></div></a>
        <a href="view_bingo_display.php?table=b01" target="_parent"><div id='bingo_total_b01' class='bingo_total_all'></div></a>
        <a href="view_bingo_display.php?table=b02" target="_parent"><div id='bingo_total_b02' class='bingo_total_all'></div></a>
        <a href="view_bingo_display.php?table=b03" target="_parent"><div id='bingo_total_b03' class='bingo_total_all'></div></a>
        <a href="view_bingo_display.php?table=b04a" target="_parent"><div id='bingo_total_b04a' class='bingo_total_all'></div></a>
        <a href="view_bingo_display.php?table=b04b" target="_parent"><div id='bingo_total_b04b' class='bingo_total_all'></div></a>
        <a href="view_bingo_display.php?table=b05a" target="_parent"><div id='bingo_total_b05a' class='bingo_total_all'></div></a>
        <a href="view_bingo_display.php?table=b05b" target="_parent"><div id='bingo_total_b05b' class='bingo_total_all'></div></a>
        <a href="view_bingo_display.php?table=b06" target="_parent"><div id='bingo_total_b06' class='bingo_total_all'></div></a>
        <a href="view_bingo_display.php?table=b07" target="_parent"><div id='bingo_total_b07' class='bingo_total_all'></div></a>
        <a href="view_bingo_raise.php?table=b70"   target="_parent"><div id='bingo_total_b70' class='bingo_total_all'></div></a>
    </div>

    <br/>

    <div id="result02">
        <h2>庇護員工兌獎區</h2>
        <a href="view_bingo_display.php?table=c01" target="_parent"><div id='bingo_total_c01' class='bingo_total_all'></div></a>
        <a href="view_bingo_display.php?table=c02a" target="_parent"><div id='bingo_total_c02a' class='bingo_total_all'></div></a>
        <a href="view_bingo_display.php?table=c02b" target="_parent"><div id='bingo_total_c02b' class='bingo_total_all'></div></a>
        <a href="view_bingo_display.php?table=c03" target="_parent"><div id='bingo_total_c03' class='bingo_total_all'></div></a>
        <a href="view_bingo_display.php?table=d69" target="_parent"><div id='bingo_total_d69' class='bingo_total_all'></div></a>
        <a href="view_bingo_raise.php?table=c70"    target="_parent"><div id='bingo_total_c70' class='bingo_total_all'></div></a>
    </div>

    <br />

    <script src="../javascript/view/view.js"></script>

</div>


</body>
</html>