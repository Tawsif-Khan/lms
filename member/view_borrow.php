<?php include('session.php'); ?>
<?php include('header.php'); ?>
<?php include('navbar_borrow.php'); ?>

<?php
$now = time(); // or your date as well
echo $member_id = $_SESSION['id'];
?>

<div class="container">
    <div class="margin-top">
        <div class="row">	
            <div class="span12">		
                <div class="alert alert-info">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>Borrowed Books</strong></div>
                <!--<div class="dataTables_wrapper" id="example_wrapper">-->

                    <table cellpadding="0" cellspacing="0" border="0" class="table table-striped" id="example">

                        <thead>
                            <tr>
                                <th>Book title</th>                               
                                <th>Date Borrow</th>                                 
                                <th>Due Date</th>                       
                                <th>Date Returned</th>
                                <th>Fine</th>
                                <th>Borrow Status</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php 
                            $user_query = mysql_query("select * from borrow
								LEFT JOIN borrowdetails ON borrow.borrow_id = borrowdetails.borrow_id
								LEFT JOIN book on borrowdetails.book_id =  book.book_id 
                                                                WHERE borrow.member_id = $member_id
								ORDER BY borrow.borrow_id DESC 
								  ")or die(mysql_error());
                            
                            
                            while ($row = mysql_fetch_array($user_query)) {
                                $id = $row['borrow_id'];
                                $book_id = $row['book_id'];
                                $borrow_details_id = $row['borrow_details_id'];
                                ?>
                                <tr class="del<?php echo $id ?>">

                                    <td><?php echo $row['book_title']; ?></td>
                                    <td><?php echo $row['date_borrow']; ?></td>
                                    <td><?php echo $row['due_date']; ?> </td>
                                    <td><?php echo $row['date_return']; ?> </td>
                                    <td style="color:red;"><?php
                                        $your_date = strtotime($row['due_date']);
                                        $datediff = $now - $your_date;
                                        if ($row['borrow_status'] == 'pending' && $datediff >= 0)
                                            echo floor($datediff / (60 * 60 * 24)) * 10;
                                        ?> </td>
                                    <td style="color: <?php if($row['borrow_status'] == 'requested')echo 'blue';
                                    else if($row['borrow_status'] == 'pending')
                                        echo 'red';
                                    else echo 'green';?>"><?php 
                                    echo $row['borrow_status']; ?></td>
                                    
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>

                <!--</div>-->
            </div>		

            <script>//
//                $(".uniform_on").change(function () {
//                    var max = 3;
//                    if ($(".uniform_on:checked").length == max) {
//
//                        $(".uniform_on").attr('disabled', 'disabled');
//                        alert('3 Books are allowed per borrow');
//                        $(".uniform_on:checked").removeAttr('disabled');
//
//                    } else {
//
//                        $(".uniform_on").removeAttr('disabled');
//                    }
//                })
            </script>		
        </div>
    </div>
</div>
<?php include('../footer.php') ?>