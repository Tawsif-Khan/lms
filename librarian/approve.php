<?php include './dbcon.php'; 

$id = $_REQUEST['id'];

$query = mysql_query("UPDATE advanceIssue SET status='approved' WHERE id=$id");

if($query){
    header('location:borrow_save.php?member_id='.$_REQUEST['member_id'].'&type=fromAdvance&book_id='.$_REQUEST['book_id']);
}



?>
