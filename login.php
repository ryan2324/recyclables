<?php
    $errorInput = ['emailErr' =>'', 'passwordErr' => ''];
    include 'config.php';
    session_start();
    if(isset($_POST['submit'])){
        try{
            if(empty($_POST['email'])){
                $errorInput['emailErr'] = 'please type your email address';
            }
            if(empty($_POST['password'])){
                $errorInput['passwordErr'] = "please type your password";
            }
            if(!array_filter($errorInput)){
                $query = "SELECT * FROM user WHERE email = '$_POST[email]'";
                $result = mysqli_query($connection, $query);
                $user = mysqli_fetch_all($result, MYSQLI_ASSOC);
                if(!array_filter($user)){
                    $errorInput['emailErr'] = 'email address does not exist';
                    throw new Exception("user does not exist");
                }
                if(!password_verify($_POST['password'], $user[0]['password'])){
                    $errorInput['passwordErr'] = "password doesn't match";
                    throw new Exception("password doesn't match");
                }else{
                    $_SESSION['userId'] = $user[0]['user_id'];
                    
                    header('location: index.php');
                    exit;
                }
            }
        }catch(Exception $e){
        }
        
    }
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./styles/login.css">
</head>
<body>
    <main >
        <div class="hero-img-container">
            <img src="./assets/hero-img.png" alt="">
        </div>
        <form action="login.php" method="post">
            <p class="title">Recyclables</p>
            <input type="email" name="email" placeholder="email">
            <p class="errorInput"><?php echo $errorInput['emailErr'] ?></p>
            <input type="password" name="password" placeholder="password">
            <p class="errorInput"><?php echo $errorInput['passwordErr'] ?></p>
            <input type="submit" name="submit" value="Log In">
            <a href="signup.php" class="create-account">Create Account</a>
            <p class="forgotpw">Forgot Password?</p>
        </form>
    </main>
    <?php include './footer.php' ?>
</body>
</html>