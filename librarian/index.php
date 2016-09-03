<?php
session_start();
//Check whether the session variable SESS_MEMBER_ID is present or not
if (!isset($_SESSION['id']) || (trim($_SESSION['id']) == '')) {

    $session_id = $_SESSION['id'];
    include('dbcon.php');
    if (isset($_POST['submit'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
        $result = mysql_query($query) or die(mysql_error());
        $num_row = mysql_num_rows($result);
        $row = mysql_fetch_array($result);
        if ($num_row > 0) {
            header('location:dashboard.php');
            $_SESSION['id'] = $row['user_id'];
        } else {
            ?>
            <div class="alert alert-danger">Access Denied</div>		
            <?php
        }
    }
}
?>
<?php include('header.php'); ?>
<?php include('navbar.php'); ?>
<div class="container">
    <div class="margin-top">
        <div class="row">	
            <div class="span12">
                <div class="sti">
                    
                </div>
                <div class="login">
                    <div class="log_txt">
                        <p><strong>Please Enter the Details Below..</strong></p>
                    </div>
                    <form class="form-horizontal" method="POST">
                        <table class="table-hover">
                            <tr>
                                <td>
                                    <label class="control-label" for="inputEmail">Username</label>
                                </td><td>     
                                    <input class="form-control" type="text" name="username" id="username" placeholder="Username" required>

                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label class="control-label" for="inputPassword">Password</label>
                                </td>
                                <td >    <input class="form-control" type="password" name="password" id="password" placeholder="Password" required/>

                                </td>
                            </tr>
                            <tr >
                                <td></td>
                                <td  style="">
                                   
                                   <button id="login" name="submit" type="submit" class="btn-primary form-control btn"><i class="icon-signin icon-large"></i>&nbsp;Login</button>
                                        
                                </td>
                            </tr>
                        </table>

                    </form>

                </div>
            </div>		
        </div>
    </div>
</div>
<?php include('footer.php') ?>