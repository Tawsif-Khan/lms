<?php
include './session.php';
include('dbcon.php');

    $borrow_details_id = $_REQUEST['borrow_details_id'];
    $status = $_REQUEST['status'];
    $query = mysql_query("UPDATE borrowdetails SET borrow_status = '$status' WHERE borrow_details_id='$borrow_details_id'");

    header('location:notifications.php');