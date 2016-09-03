<?php

include('dbcon.php');
if (isset($_POST['submit'])) {
    $book_title = $_POST['book_title'];
    $category_id = $_POST['category_id'];
    $author = $_POST['author'];


//first check if account number is already register or not...
    $accno = rand(9999999999, 99999999999);
    $accno = strlen($accno) != 10 ? substr($accno, 0, 10) : $accno;
  
    $images = uploadProductImage('pdf','pdfs/');
    $thumbnail = $images['image'];



    mysql_query("insert into pdf_books (book_title,author,category_id,url)
 values('$book_title','$author','$category_id','$thumbnail')")or die(mysql_error());


    header('location:add_PDF_books.php');
}

function uploadProductImage($inputName, $uploadDir) {
    $image = $_FILES[$inputName];
    $imagePath = '';
    $thumbnailPath = '';

    // if a file is given
    if (trim($image['tmp_name']) != '') {
        $ext = substr(strrchr($image['name'], "."), 1); //$extensions[$image['type']];
        // generate a random new file name to avoid name conflict
        $imagePath = md5(rand() * time()) . ".$ext";

        

        // make sure the image width does not exceed the
        // maximum allowed width

        
            $result = move_uploaded_file($image['tmp_name'], $uploadDir . $imagePath);
        

        if ($result) {
            // create thumbnail
            $thumbnailPath = md5(rand() * time()) . ".$ext";

            // create thumbnail failed, delete the image
            if (!$result) {
                unlink($uploadDir . $imagePath);
                $imagePath = $thumbnailPath = '';
            } else {
                $thumbnailPath = $result;
            }
        } else {
            // the product cannot be upload / resized
            $imagePath = $thumbnailPath = '';
        }
    }

    return array('image' => $imagePath, 'thumbnail' => $thumbnailPath);
}

?>	