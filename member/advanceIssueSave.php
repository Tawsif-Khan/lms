<?php
include('dbcon.php');
//if (!isset($_REQUEST['type'])) {
    $id = $_POST['selector'];
   $member_id = $_REQUEST['member_id'];
    
    $N = count($id);
for($i=0; $i < $N; $i++)
{
    $query = mysql_query("INSERT INTO advanceIssue (book_id,member_id,issue_date,status) VALUES ($id[$i],$member_id,NOW(),'requested')");
    if($query)
        header('location:borrow.php');
}
    
//}