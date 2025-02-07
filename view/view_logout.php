<?php      
    session_start();
    session_destroy(); //刪除全部的session

    header("Location:../");
    exit();

    //echo json_encode(array());
       
?>