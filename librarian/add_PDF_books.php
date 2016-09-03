<?php include('header.php'); ?>
<?php include('session.php'); ?>
<?php include('navbar_pdf_books.php'); ?>
<div class="container">
    <div class="margin-top">
        <div class="row">	
            <div class="span12">	

                <div class="alert alert-info">Add Books</div>
                <p><a href="pdf_books.php" class="btn btn-info"><i class="icon-arrow-left icon-large"></i>&nbsp;Back</a></p>
                <div class="addstudent">
                    <div class="details">Please Enter Details Below</div>		
                    <form class="form-horizontal" method="POST" action="pdf_books_save.php" enctype="multipart/form-data">



                        <div class="control-group">
                            <label class="control-label" for="inputEmail">Book_title:</label>
                            <div class="controls">
                                <input type="text" class="span4" id="inputEmail" name="book_title"  placeholder="Book Title" required>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="inputEmail">Author:</label>
                            <div class="controls">
                                <input type="text" class="span4" id="inputEmail" name="author"  placeholder="Author" required>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="inputPassword">Category</label>
                            <div class="controls">
                                <select name="category_id">
                                    <option></option>
                                    <?php
                                    $cat_query = mysql_query("select * from category");
                                    while ($cat_row = mysql_fetch_array($cat_query)) {
                                        ?>
                                        <option value="<?php echo $cat_row['category_id']; ?>"><?php echo $cat_row['classname']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label" for="inputEmail">Upload Book:</label>
                            <div class="controls">
                                <input type="file" class="span4" id="inputEmail" name="pdf"  placeholder="Upload Book" required>
                            </div>
                        </div>






                        <div class="control-group">
                            <div class="controls">
                                <button name="submit" type="submit" class="btn btn-success"><i class="icon-save icon-large"></i>&nbsp;Save</button>
                            </div>
                        </div>
                    </form>					
                </div>		
            </div>		
        </div>
    </div>
</div>
<?php include('../footer.php') ?>