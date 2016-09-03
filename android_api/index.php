<?php

include '../dbcon.php';

function send_email($data) {
    $response = array();
    $to = $data['to'];
    $sub = $data['sub'];
    $message = 'Your current password is : '.$data['password'];
    $header = "From:support@hlbank.pro \r\n";
    $header .= "MIME-Version: 1.0\r\n";
    $header .= "Content-type: text/html\r\n";
    $retval = mail($to, $sub, $message, $header);

    if ($result) {
        $response['success'] = 1;
    } else {
        $response['success'] = 0;
    }
    
    return $response;
}


if (isset($_REQUEST['type']) && $_REQUEST['type'] == 'login') {
    $response = array();
    $response['success'] = 0;
    $member_id = $_REQUEST['member_id'];
    $userId = $_REQUEST['userId'];
    $pass = $_REQUEST['password'];
    $device_id = $_REQUEST['reg_id'];
    mysql_query("DELETE FROM devices WHERE device_id='$device_id'");
    mysql_query("INSERT INTO devices VALUES('','$member_id','$device_id')");

    $query = mysql_query("SELECT * FROM member WHERE userId='$userId' AND '$pass'");
    if ($query) {
        $row = mysql_fetch_array($query);
        if ($row['userId'] == $userId && $row['password'] == $pass) {
            $response['success'] = 1;
            $response['member_id'] = $row['member_id'];
            $response['fullname'] = $row['firstname'].' '.$row['lastname'];
        }
    }
} else if (isset($_REQUEST['type']) && $_REQUEST['type'] == 'getBooks') {
    $response = array();
    $response['success'] = 0;
    $response['books'] = array();
    $category = $_REQUEST['category'];

    $categoryQuery = mysql_query("SELECT * FROM category WHERE classname='$category'");
    if ($categoryQuery) {
        $categoryRow = mysql_fetch_array($categoryQuery);
        $categoryId = $categoryRow['category_id'];
    }

    $query = mysql_query("SELECT * FROM book WHERE category_id='$categoryId'");

    if ($query) {
        while ($row = mysql_fetch_array($query)) {
            $data = array();
            $data['book_id'] = $row['book_id'];
            $data['book_title'] = $row['book_title'];
            $data['category'] = $category;
            $data['author'] = $row['author'];
            $data['book_copies'] = $row['book_copies'];
            $data['book_publication'] = $row['book_pub'];
            $data['publisher_name'] = $row['publisher_name'];
            $data['ISBN'] = $row['isbn'];
            $data['date_added'] = $row['date_added'];
            $data['status'] = $row['status'];
             $data['summary'] = $row['summary'];

            array_push($response['books'], $data);
        }
        $response['success'] = 1;
    }
}else if (isset($_REQUEST['type']) && $_REQUEST['type'] == 'getPDFBooks') {
    $response = array();
    $response['success'] = 0;
    $response['books'] = array();
    $category = $_REQUEST['category'];

    $categoryQuery = mysql_query("SELECT * FROM category WHERE classname='$category'");
    if ($categoryQuery) {
        $categoryRow = mysql_fetch_array($categoryQuery);
        $categoryId = $categoryRow['category_id'];
    }

    $query = mysql_query("SELECT * FROM pdf_books WHERE category_id='$categoryId'");

    if ($query) {
        while ($row = mysql_fetch_array($query)) {
            //$id = $row['pdf_id'];
            
            $data = array();
            $data['book_title'] = $row['book_title'];
            $data['category'] = $category;

            array_push($response['books'], $row);
        }
        $response['success'] = 1;
    }
} else if (isset($_REQUEST['type']) && $_REQUEST['type'] == 'borrowedBooks') {
    $response = array();
    $response['success'] = 0;
    $response['borrows'] = array();
    $response['books'] = array();
    $borrow_id = array();
    $borrow_date = array();
    $due_date = array();
     $member_id = $_REQUEST['member_id'];

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
}else if (isset($_REQUEST['type']) && $_REQUEST['type'] == 'getNotifications') {
    $response = array();
    $response['success'] = 0;
    $response['books'] = array();
    $book_ids = array();
    $borrow_details_ids = array();
    $borrow_id = $_REQUEST['borrow_id'];
    $getDueDate = mysql_query("SELECT * FROM borrow WHERE borrow_id=$borrow_id");
    if($getDueDate){
        $row = mysql_fetch_array($getDueDate);
        $response['due_date'] = $row['due_date'];
    }

    $borrowQuery = mysql_query("SELECT * FROM borrowdetails WHERE borrow_id=$borrow_id AND borrow_status='requested'");
    if ($borrowQuery) {
        while ($borrowRow = mysql_fetch_array($borrowQuery)) {
             $book_ids[] = $borrowRow['book_id'];
        $borrow_details_ids[] = $borrowRow['borrow_details_id'];
        }
        $response['borrow_details_ids'] = $borrow_details_ids;
    }
    
    
    foreach ($book_ids as $value) {
        $query = mysql_query("SELECT * FROM book WHERE book_id='$value'");
        if ($query) {

            while ($row = mysql_fetch_array($query)) {
                $data = array();
                $data['book_title'] = $row['book_title'];
                //$data['category'] = $category;
                $data['author'] = $row['author'];
                $data['book_copies'] = $row['book_copies'];
                $data['book_publication'] = $row['book_pub'];
                $data['publisher_name'] = $row['publisher_name'];
                $data['ISBN'] = $row['isbn'];
                $data['date_added'] = $row['date_added'];
                $data['status'] = $row['status'];

                array_push($response['books'], $data);
            }
            $response['success'] = 1;
        }
    }
}else if (isset($_REQUEST['type']) && $_REQUEST['type'] == 'responseRequest') {
    $response = array();
    $response['success'] = 0;
    $borrow_details_id = $_REQUEST['borrow_details_id'];
    $status = $_REQUEST['status'];
    $query = mysql_query("UPDATE borrowdetails SET borrow_status = '$status' WHERE borrow_details_id='$borrow_details_id'");
    if ($query) {
        $response['success'] = 1;
    }
}else if (isset($_REQUEST['type']) && $_REQUEST['type'] == 'requestBook') {
    $book_id = $_REQUEST['book_id'];
    $member_id = $_REQUEST['member_id'];
    $query = mysql_query("INSERT INTO advanceIssue (book_id,member_id,issue_date,status) VALUES ('$book_id','$member_id',NOW(),'requested')");
    if($query)
    	$response['success'] = 1;
    	else
    	$response['success'] = 0;
}else if (isset($_REQUEST['type']) && $_REQUEST['type'] == 'changePassword') {
    $response = array();
    $pwd = $_REQUEST['password'];
    $id = $_REQUEST['id'];

    $sql = "UPDATE member SET password = '$pwd' WHERE member_id = $id";
    $result = dbQuery($sql);
    if ($result) {
        $response['success'] = 1;
    } else {
        $response['success'] = 0;
    }
} else if (isset($_REQUEST['type']) && $_REQUEST['type'] == 'forgotPassword') {
    
    $subject = "Library Password";
    $to = $_POST['email'];
    
    $query = mysql_query("SELECT * FROM member WHERE email='$email'");
    if($query){
        $row = mysql_fetch_array($query);
        
    }

    $mail_data = array('to' => $to, 'sub' => $subject, 'password' => $row['password']);
    $response = send_email($mail_data);
}

echo json_encode($response);
