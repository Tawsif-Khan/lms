<?php

include('dbcon.php');
if (isset($_POST['submit'])) {
    $userId = $_POST['userId'];
    $password = $_POST['password'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $gender = $_POST['gender'];
    $address = $_POST['address'];
    $contact = $_POST['contact'];
    $type = $_POST['type'];
    $year_level = $_POST['year_level'];
    $email = $_POST['email'];

    $check = mysql_query("SELECT * FROM member WHERE email='$email'");
    if ($check)
        if (mysql_num_rows($check) > 0)
            header('location:add_member.php?error=This email id already exists.');
    $check = mysql_query("SELECT * FROM member WHERE userId='$userId'");
    if ($check)
        if (mysql_num_rows($check) > 0)
            header('location:add_member.php?error=This user id already exists.');

    $query = mysql_query("insert into member(userId,password,email,firstname,lastname,gender,address,contact,type,year_level) values('$userId','$password','$email','$firstname','$lastname','$gender','$address','$contact','$type','$year_level')");

    if ($query)
        header('location:member.php');
    
}
?>	