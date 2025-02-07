<?php
  header("Content-Type:text/html; charset=UTF8");

  // 建立連線
  function create_connection()
  {
    $link = mysql_connect("localhost", "root", "") or die("無法建立資料連接<br><br>" . mysql_error());
	  	
	//設定 UTF8或BIG5 格式  
    mysql_query("SET NAMES 'UTF8'");
	  		   	
    return $link;
  }

  // 設定資料庫
  function set_database()
  {
    $database = "b_bingo" ; 
	  		   	
    return $database;
  }
	
  function execute_sql($database, $sql, $link)
  {
    $db_selected = mysql_select_db($database, $link) or die("開啟資料庫失敗<br><br>" . mysql_error($link));
						 
    $result = mysql_query($sql, $link);
		
    return $result;
  }
?>