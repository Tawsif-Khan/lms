<?php
include './session.php';
include('header.php');
include('dbcon.php');
include './navbar_notification.php';
$member_id = $_SESSION['id'];

$getBorrow = mysql_query("SELECT * FROM borrow WHERE member_id=$member_id");
?>

<div class="container">
    <div class="margin-top">
        <div class="row">
            <div class="alert alert-info">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong><i class="icon-user icon-large"></i>&nbsp;Are you going to borrow this books? </strong>
            </div>
            <table cellpadding="0" cellspacing="0" border="0" class="table" id="example">

                <thead>
                    <tr>
                        <th>Book title</th>  
                        <th>Author</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    if (mysql_num_rows($getBorrow) > 0) {
                        while ($result = mysql_fetch_array($getBorrow)) {
                            $query = mysql_query("SELECT * FROM borrowdetails WHERE borrow_id='" . $result['borrow_id'] . "' AND borrow_status='requested'");
                            if (mysql_num_rows($query) > 0) {
                                while ($row = mysql_fetch_array($query)) {

                                    $book_query = mysql_query("SELECT * FROM book WHERE book_id='" . $row['book_id'] . "'");
                                    if ($book_query) {

                                        while ($book = mysql_fetch_array($book_query)) {
                                            ?>
                                            <tr class="del<?php echo $id ?>">


                                                <td><?php echo $book['book_title']; ?></td>
                                                <td><?php echo $book['author']; ?></td>
                                                <td><a href="responseRequest.php?borrow_details_id=<?php echo $row['borrow_details_id']; ?>&status=pending">Yes</a>
                                                    &nbsp;&nbsp;<a href="responseRequest.php?borrow_details_id=<?php echo $row['borrow_details_id']; ?>&status=declined">No</a> </td> 



                                            </tr>
                                            <?php
                                        }
                                    }
                                }
                            }
                        }
                    }
                    ?>
                </tbody>
            </table>	
        </div>
    </div>
</div>
<script>


    $(".uniform_on").change(function () {
        var max = 3;
        if ($(".uniform_on:checked").length == max) {

            $(".uniform_on").attr('disabled', 'disabled');
            alert('3 Books are allowed per borrow');
            $(".uniform_on:checked").removeAttr('disabled');

        } else {

            $(".uniform_on").removeAttr('disabled');
        }
    })


</script>	