<?php 
include('dbcon.php');
if (isset($_POST['submit'])){
$id=$_POST['id'];
$book_title=$_POST['book_title'];
$category_id=$_POST['category_id'];
$author=$_POST['author'];




mysql_query("update pdf_books set book_title='$book_title',category_id='$category_id',author='$author'
 where pdf_id='$id'")or die(mysql_error());
								
								
 header('location:pdf_books.php');
}
?>	