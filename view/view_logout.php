<?php      
    session_start();
    session_destroy(); //�R��������session

    header("Location:../");
    exit();

    //echo json_encode(array());
       
?>