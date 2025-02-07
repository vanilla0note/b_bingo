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

    //02.資料庫連線
	require_once('../Conn/PHP_Conn.php'); 
	$database = set_database() ; //資料庫名稱
    $link = create_connection() ;                    
?>


<!DOCTYPE html>
<html>
<head>

<meta charset="UTF-8">
<title>2024年歲末聯歡 抽獎活動（兌獎專區）</title>

<link rel="stylesheet" href="../css/main.css">
<link rel="stylesheet" href="../css/view/fast.css">

</head>
<body>

<header id="page-header">
    <h1>2024年歲末聯歡 抽獎活動（兌獎專區）</h1>
    <h2><a href="view.php" target="_parent">回到首頁</a></h2>
</header>

<div id="page-main">
    <div id="result">        
        <!--
        <div class="bingo_no">第 1 人</div>
        <div class="bingo_name">T00899&nbsp;王大明</div>
            -->
            
        <div class="bingo_title"><b>人數</b></div>
        <div class="bingo_title"><b>員工代號</b></div>
        <div class="bingo_title"><b>姓名</b></div>   
        <div class="bingo_title"><b>部門</b></div>
        <div class="bingo_title"><b>年資</b></div>
        <div class="bingo_title2"><b>得獎情況</b></div>         
            
            
        <?php
        $sql= "SELECT COUNT(*) FROM `everyone1` " ;
        $result = execute_sql($database, $sql, $link) ;
        $sum = mysql_result($result,0,0) ;

        //逐筆顯示
        $sql = "SELECT * FROM `everyone1` order by id ASC";
	    $result = execute_sql($database, $sql, $link) ;

        for ($i=0 ; $i<$sum ; $i++){
            echo "<div class='bingo_content'>". ( $i + 1 ) ."</div>" ;
            echo "<div class='bingo_content'>".mysql_result($result,$i,"id2")."</div>" ;
            echo "<div class='bingo_content'>".mysql_result($result,$i,"name")."</div>" ;
            echo "<div class='bingo_content'>".mysql_result($result,$i,"dep")."</div>" ;
            echo "<div class='bingo_content'>".mysql_result($result,$i,"year")."</div>" ;

            $temp = explode( "-", mysql_result($result,$i,"bingo") );
            switch ( $temp[0] ){
                case "b0a":   $bingo_str1 = "董事長獎" ;  break ;
                case "b01":   $bingo_str1 = "頭獎"     ;  break ;
                case "b02":   $bingo_str1 = "貳獎"     ;  break ;
                case "b03":   $bingo_str1 = "參獎"     ;  break ;
                case "b04":   $bingo_str1 = "肆獎"     ;  break ;
                case "b04a":  $bingo_str1 = "肆獎Ａ"   ;  break ;
                case "b04b":  $bingo_str1 = "肆獎Ｂ"   ;  break ;
                case "b05":   $bingo_str1 = "５獎"     ;  break ;
                case "b05a":  $bingo_str1 = "５獎Ａ"   ;  break ;
                case "b05b":  $bingo_str1 = "５獎Ｂ"   ;  break ;
                case "b06":   $bingo_str1 = "６獎"     ;  break ;
                case "b07":   $bingo_str1 = "７獎"     ;  break ;
                case "b08":   $bingo_str1 = "８獎"     ;  break ;
                case "b09":   $bingo_str1 = "９獎"     ;  break ;
                case "b10":   $bingo_str1 = "１０獎"   ;  break ;
                case "b70":   $bingo_str1 = "加碼獎"   ;  break ;
                default:      $bingo_str1 = ""         ;  break ;
            }

            if      ( $bingo_str1 != "") $bingo_str2 = " 第 ".$temp[1]." 人" ;
            else if ( $bingo_str1 == "") $bingo_str2 = mysql_result($result,$i,"bingo") ;
            echo "<div class='bingo_content2'>".$bingo_str1.$bingo_str2."</div>" ;
        }

        $sql= "SELECT COUNT(*) FROM `everyone1` WHERE bingo LIKE '不可抽獎'" ;
        $result = execute_sql($database, $sql, $link) ;
        $bingo_no = mysql_result($result,0,0) ;

        $sql= "SELECT COUNT(*) FROM `everyone1` WHERE bingo <> '不可抽獎' AND bingo <> ''" ;
        $result = execute_sql($database, $sql, $link) ;
        $bingo = mysql_result($result,0,0) ;

        echo "<div class='bingo_index'>總抽獎人數：".$sum."</div>";
        echo "<div class='bingo_index'>已經中獎人數：".$bingo."</div>";
        echo "<div class='bingo_index'>不能抽獎人數：".$bingo_no."</div>";

        ?>
                
    </div>

</div>

</body>
</html>