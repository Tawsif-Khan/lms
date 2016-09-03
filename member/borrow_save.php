<?php
 	include('dbcon.php');
 	include('../android_api/gcmEngine.php');
	
	
	if (!isset($_REQUEST['type'])) {
    $id = $_POST['selector'];
    $member_id = $_POST['member_id'];
    $due_date = $_POST['due_date'];

    if ($id == '') {
        header("location: borrow.php");
    } 
    

} else {
        $member_id = $_REQUEST['member_id'];
        $id[0] = $_REQUEST['book_id'];
        $due_date = Date('Y/m/d', strtotime("+7 days"));
     
    }
	


	mysql_query("insert into borrow (member_id,date_borrow,due_date) values ('$member_id',NOW(),'$due_date')")or die(mysql_error());
	$query = mysql_query("select * from borrow order by borrow_id DESC")or die(mysql_error());
	$row = mysql_fetch_array($query);
	$borrow_id  = $row['borrow_id']; 



$N = count($id);
for($i=0; $i < $N; $i++)
{
    mysql_query("UPDATE book SET borrowCount=borrowCount+1 WHERE book_id=$id[$i]");
	 mysql_query("insert borrowdetails (book_id,borrow_id,borrow_status) values('$id[$i]','$borrow_id','requested')")or die(mysql_error());
	
}

send_message_for_permission($member_id,$borrow_id);



if(isset($_REQUEST['type'])){
        header('location:advancedRequestList.php');
    }else
        header("location:borrow.php");
	?>
	

	
	