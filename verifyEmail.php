<?php
include('dbcon.php');
echo $member_id = $_REQUEST['id'];
$update = mysql_query("UPDATE member SET status='Active' WHERE member_id=$member_id");
echo mysql_error();
if($update)
echo "Email verified.";

