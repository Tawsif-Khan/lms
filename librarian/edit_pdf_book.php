<?php include('header.php'); ?>
<?php include('session.php'); ?>
<?php include('navbar_books.php'); ?>
<?php $get_id = $_GET['id']; ?>
<div class="container">
    <div class="margin-top">
        <div class="row">	
            <div class="span12">	
                <?php
                $query = mysql_query("select * from pdf_books LEFT JOIN category on category.category_id  = pdf_books.category_id where pdf_id='$get_id'")or die(mysql_error());
                $row = mysql_fetch_array($query);
                $category_id = $row['category_id'];
                ?>
                <div class="alert alert-info"><i class="icon-pencil"></i>&nbsp;Edit PDF Books</div>
                <p><a class="btn btn-info" href="books.php"><i class="icon-arrow-left icon-large"></i>&nbsp;Back</a></p>
                <div class="addstudent">
                    <div class="details">Please Enter Details Below</div>	
                    <form class="form-horizontal" method="POST" action="update_pdf_book.php" enctype="multipart/form-data">

                        <div class="control-group">
                            <label class="control-label" for="inputEmail">Book_title:</label>
                            <div class="controls">
                                <input type="text" class="span4" id="inputEmail" name="book_title" value="<?php echo $row['book_title']; ?>" placeholder="book_title" required>
                                <input type="hidden" id="inputEmail" name="id" value="<?php echo $get_id; ?>" placeholder="book_title" required>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="inputPassword">Category:</label>
                            <div class="controls">
                                <select name="category_id">
                                    <option value="<?php echo $category_id; ?>"><?php echo $row['classname']; ?></option>
                                    <?php
                                    $query1 = mysql_query("select * from category where category_id != '$category_id'")or die(mysql_error());
                                    while ($row1 = mysql_fetch_array($query1)) {
                                        ?>
                                        <option value="<?php echo $row1['category_id']; ?>"><?php echo $row1['classname']; ?></option>
<?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="inputPassword">Author:</label>
                            <div class="controls">
                                <input type="text" class="span4" id="inputPassword" name="author" value="<?php echo $row['author']; ?>" placeholder="author" required>
                            </div>
                        </div>


                        <div class="control-group">
                            <div class="controls">
                                <button name="submit" type="submit" class="btn btn-success"><i class="icon-save icon-large"></i>&nbsp;Update</button>
                            </div>
                        </div>
                    </form>				
                </div>		
            </div>	
        </div>
    </div>
</div>
<?php include('footer.php') ?>