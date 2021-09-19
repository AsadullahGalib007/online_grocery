<?php include('../config/constants.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendor log in</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
    <div class="login">
    <h1 class="text-center">LOGIN</h1>
    <br><br>
            <?php 
                if(isset($_SESSION['login']))
                {
                    echo $_SESSION['login'];
                    unset($_SESSION['login']);
                }

                if(isset($_SESSION['no-login-message']))
                {
                    echo $_SESSION['no-login-message'];
                    unset($_SESSION['no-login-message']);
                }
            ?>
            <br><br>

            <!-- Login Form Starts HEre -->
            <form action="" method="POST" class="text-center border">
            Username: <br>
            <input type="text" name="username" placeholder="Enter Username"><br><br>

            Password: <br>
            <input type="password" name="password" placeholder="Enter Password"><br><br>

            <input type="submit" name="submit" value="Login" class="btn-primary">
            <br><br>
            </form>
            <!-- Login Form Ends HEre -->
    </div>
</body>
</html>

<?php 

    //CHeck whether the Submit Button is Clicked or NOt
    if(isset($_POST['submit']))
    {
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        var_dump($username);        
        $raw_password = md5($_POST['password']);
        $password = mysqli_real_escape_string($conn, $raw_password);

        //2. SQL to check whether the user with username and password exists or not
        $sql = "SELECT tbl_vendor.id FROM tbl_vendor WHERE username='$username' AND password='$password'";
        //3. Execute the Query
        $res = mysqli_query($conn, $sql);
        $result = mysqli_fetch_row($res);
        $id = $result['0'];
        //4. COunt rows to check whether the user exists or not
        $count = mysqli_num_rows($res);
        if($count==1)
        {
            //User AVailable and Login Success
            $_SESSION['login'] = "<div class='success'>Login Successful.</div>";
            $_SESSION['user'] = $username; //TO check whether the user is logged in or not and logout will unset it
            $_SESSION['id'] = $id;
            //REdirect to HOme Page/Dashboard
            header('location:'.SITEURL.'vendor/');
        }
        else
        {
            //User not Available and Login FAil
            $_SESSION['login'] = "<div class='error text-center'>Username or Password did not match.</div>";
            //REdirect to HOme Page/Dashboard
            header('location:'.SITEURL.'vendor/login.php');
        }


    }

?>