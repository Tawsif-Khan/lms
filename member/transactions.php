<?php include('session.php'); ?>
<?php include('header.php'); ?>
<?php include('navbar_borrow.php'); ?>

<?php

 $response['borrows'] = array();
    $response['books'] = array();
    $borrow_id = array();
    $borrow_date = array();
    $due_date = array();
    $member_id = $_SESSION['id'] ;

    $borrowQuery = mysql_query("SELECT * FROM borrow WHERE member_id='$member_id'");
    if ($borrowQuery) {
        while ($borrowRow = mysql_fetch_array($borrowQuery)) {
            $borrow_id[] = $borrowRow['borrow_id'];
            $borrow_date[] = $borrowRow['date_borrow'];
            $due_date[] = $borrowRow['due_date'];
        }
    }
	$i = 0;
	if(isset($_REQUEST['borrow_status'])){
		$status = " AND borrow_status='".$_REQUEST['borrow_status']."'";
	}else
		$status = "";
		
    foreach ($borrow_id as $value) {
    
        $query = mysql_query("SELECT * FROM borrowdetails WHERE borrow_id='$value'".$status);
        if ($query) {
            while ($bookIdRow = mysql_fetch_array($query)) {
                $bookQuery = mysql_query("SELECT * FROM book WHERE book_id=" . $bookIdRow['book_id'] . "");
                if ($bookQuery) {
                    while ($row = mysql_fetch_array($bookQuery)) {
                        $data = array();
                        $data['book_title'] = $row['book_title'];
                        //$data['category'] = $row['category_id'];
                        $data['author'] = $row['author'];
                        $data['book_copies'] = $row['book_copies'];
                        $data['book_publication'] = $row['book_pub'];
                        $data['publisher_name'] = $row['publisher_name'];
                        $data['ISBN'] = $row['isbn'];
                        $data['date_added'] = explode(' ',$row['date_added'])[0];
                        $data['status'] = $row['status'];
                        $data['book_id'] = $row['book_id'];
                        
                        $borrowData = array();
                        $borrowData['date_borrow'] = explode(' ',$borrow_date[$i])[0];
                        $borrowData['due_date'] = explode(' ',$due_date[$i])[0];
                        $borrowData['date_return'] = explode(' ',$bookIdRow['date_return'])[0];
                        $borrowData['borrow_status'] = $bookIdRow['borrow_status'];
                        
                        array_push($response['books'], $data);
                        array_push($response['borrows'], $borrowData);
                    }
                    $response['success'] = 1;
                }
            }
        }
        $i++;
    }



