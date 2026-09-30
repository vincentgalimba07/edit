<?php

session_start();
    include "../../config/database.php";

//IF USER IS ALREADY LOGGED IN, SEND THEM TO CORRECT DASHBOARD
    if(!isset($_SESSION["role"]) || $_SESSION["role"] != "admin"){
    
        header("Location: ../../index.php");
        exit;
        
    }   

    $id = isset($_GET['id']) ? intval($_GET['id']) :0;
    //delete sql
    mysqli_query($conn, "DELETE FROM users WHERE id = $id AND role = 'student'");
    header("Location: index.php"); 
    exit;



?>