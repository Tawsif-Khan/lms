<?php include './dbcon.php'; ?>
<?php include('header.php'); ?>
<?php include('nav_advanceRequestList.php'); ?>
<?php 

$query = mysql_query("SELECT *,TIMEDIFF(NOW(),issue_date) as days FROM advanceIssue WHERE status='requested'");
?>

<div class="container">
    <div class="margin-top">
        <div class="row">	
            <div class="span12">		
                <div class="alert alert-info"><strong>Advance Requested Books</strong></div>
<table class="table table-striped">
    <thead>
    <th>Issue Date</th>
    <th>User ID</th>
    <th>Full Name ID</th>
    <th>Book Title</th>
    <th>Author</th>
    </thead>
<?php
if($query){
    while ($row = mysql_fetch_array($query)){
         $time = $row['days'];
        $hours = explode(':', $time);
        if($hours[0]<=48){
            $memberQuery = mysql_query("SELECT * FROM member  WHERE member_id='".$row['member_id']."'");
            $bookQuery = mysql_query("SELECT * FROM book WHERE book_id='".$row['book_id']."'");
            $memberRow = mysql_fetch_array($memberQuery);
            $bookRow = mysql_fetch_array($bookQuery);
            ?>
    <tr>
        <td>
            <?php echo $row['issue_date'];?>
        </td>
        <td>
            <?php echo $memberRow['userId'];?>
        </td>
        <td>
            <?php echo $memberRow['firstname'].' '.$memberRow['lastname'];?>
        </td>
        <td>
            <?php echo $bookRow['book_title'];?>
        </td>
        <td>
            <?php echo $bookRow['author'];?>
        </td>
        <td>
            <a href="approve.php?id=<?php echo $row['id'];?>&member_id=<?php echo $row['member_id'];?>&book_id=<?php echo $row['book_id'];?>">Approve</a>
        </td>
    </tr>
<?php
        }
    }
}

?>
</table>
            </div>
        </div>
    </div>
</div>

</body>
</html>
<?php include('../footer.php') ?>