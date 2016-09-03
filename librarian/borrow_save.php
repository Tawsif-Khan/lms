<?php
include './session.php';
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
$now = time();
$user_query = mysql_query("select * from borrow LEFT JOIN member ON borrow.member_id = member.member_id
								LEFT JOIN borrowdetails ON borrow.borrow_id = borrowdetails.borrow_id
								LEFT JOIN book on borrowdetails.book_id =  book.book_id  where borrow.member_id=68
                                                                and borrowdetails.borrow_status = 'pending'
								ORDER BY borrow.borrow_id DESC 
								  ")or die(mysql_error());
while ($row = mysql_fetch_array($user_query)) {
    $your_date = strtotime($row['due_date']);
    $datediff = $now - '2016/06/01';//$your_date;
    if ($row['borrow_status'] == 'pending' && $datediff >= 0) {
        echo $fine = floor($datediff / (60 * 60 * 24)) * 10;
        if ($fine > 0) {
            $_SESSION['error'] = 1;
            if (isset($_REQUEST['type'])) {
                header('location:advancedRequestList.php');
            } else
                header("location:borrow.php");
        }
    }
}

mysql_query("insert into borrow (member_id,date_borrow,due_date) values ('$member_id',NOW(),'$due_date')")or die(mysql_error());
$query = mysql_query("select * from borrow order by borrow_id DESC")or die(mysql_error());
$row = mysql_fetch_array($query);
$borrow_id = $row['borrow_id'];



$N = count($id);
for ($i = 0; $i < $N; $i++) {
    mysql_query("UPDATE book SET borrowCount=borrowCount+1 WHERE book_id=$id[$i]");
    mysql_query("insert borrowdetails (book_id,borrow_id,borrow_status) values('$id[$i]','$borrow_id','requested')")or die(mysql_error());
}

send_message_for_permission($member_id, $borrow_id);



if (isset($_REQUEST['type'])) {
    header('location:advancedRequestList.php');
} else
    header("location:borrow.php");
?>
	


