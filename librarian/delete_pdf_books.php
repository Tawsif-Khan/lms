<?php
include('dbcon.php');
$id=$_GET['id'];
mysql_query("delete from pdf_books where pdf_id='$id'")or die(mysql_error());
header('location:pdf_books.php');
?>