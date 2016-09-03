<?php include('header.php'); ?>
<?php include('session.php'); ?>
<?php include('navbar_pdf_books.php'); ?>
<div class="container">
    <div class="margin-top">
        <div class="row">	
            <div class="span12">	
                <div class="alert alert-info">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong><i class="icon-user icon-large"></i>&nbsp;Books Table</strong>
                </div>
                
                <center class="title">
                    <h1>Books List</h1>
                </center>
                <table cellpadding="0" cellspacing="0" border="0" class="table  table-striped" id="example">
                    <div class="pull-right">
                        <a href="" onclick="window.print()" class="btn btn-info"><i class="icon-print icon-large"></i> Print</a>
                    </div>
                    <p><a href="add_PDF_books.php" class="btn btn-success"><i class="icon-plus"></i>&nbsp;Add Books</a></p>

                    <thead>
                        <tr>
                            <th>Acc No.</th>                                 
                            <th>Book Title</th> 
                            <th>Author</th>
                            <th>Category</th>
                            <th class="action">Action</th>		
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        $user_query = mysql_query("select * from pdf_books") or die(mysql_error());
                        while ($row = mysql_fetch_array($user_query)) {
                            $id = $row['pdf_id'];
                            $cat_id = $row['category_id'];

                            $cat_query = mysql_query("select * from category where category_id = '$cat_id'") or die(mysql_error());
                            $cat_row = mysql_fetch_array($cat_query);
                            ?>
                            <tr class="del<?php echo $id ?>">
                                <td><?php echo $row['pdf_id']; ?></td>
                                <td><?php echo $row['book_title']; ?></td>
                                <td><?php echo $row['author']; ?></td>
                                <td><?php echo $cat_row ['classname']; ?> </td>
                                <td><a href="pdfs/<?php echo $row['url']; ?>" target="_blank">Read</a></td>
    <?php include('toolttip_edit_delete.php'); ?>
                                <td class="action">
                                    <a rel="tooltip"  title="Delete" id="<?php echo $id; ?>" href="#delete_book<?php echo $id; ?>" data-toggle="modal"    class="btn btn-danger"><i class="icon-trash icon-large"></i></a>
    <?php include('delete_book_modal.php'); ?>
                                    <a  rel="tooltip"  title="Edit" id="e<?php echo $id; ?>" href="edit_pdf_book.php<?php echo '?id=' . $id; ?>" class="btn btn-success"><i class="icon-pencil icon-large"></i></a>

                                </td>

                            </tr>
<?php } ?>

                    </tbody>
                </table>


            </div>		
        </div>
    </div>
</div>
<?php include('footer.php') ?>