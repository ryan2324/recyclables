<?php
    $firstName = $lastName = $email = $password = $confirmPw =  "";
    $errorInput = ['firstNameErr' =>'', 'lastNameErr' =>'', 'emailErr' =>'', 'passwordErr' =>'', 'confirmPwErr' => ''];
    $dbError = '';
    try{
        include 'config.php';
    }catch(Exception $e){
        $dbError = $e->getMessage();
    }
    if(isset($_POST['submit'])){
        //validate user input
        $query = "SELECT * FROM user WHERE email = '$_POST[email]'";
        $result = mysqli_query($connection, $query);
        $existingUser = mysqli_fetch_all($result, MYSQLI_ASSOC);
        if(empty($_POST['fName'])){
            $errorInput['firstNameErr'] = 'first name cannot be empty';
        }elseif(strlen($_POST['fName']) < 3){
            $errorInput['firstNameErr'] = 'first name must be 3 characters long';
        }else{
            $firstName = $_POST['fName'];
        }
        if(empty($_POST['lName'])){
            $errorInput['lastNameErr'] = 'last name cannot be empty';
        }elseif(strlen($_POST['lName']) < 3){
            $errorInput['lastNameErr'] = 'last name must be 3 characters long';
        }else{
            $lastName = $_POST['lName'];
        }
        if(empty($_POST['email'])){
            $errorInput['emailErr'] = 'email cannot be empty';
        }elseif(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
            $errorInput['emailErr'] = 'please input valid email address';
        }elseif(array_filter($existingUser)){
            $errorInput['emailErr'] = 'email address already exist';
        }else{
            $email = $_POST['email'];
        }
        if(empty($_POST['password'])){
            $errorInput['passwordErr'] = 'password cannot be empty';

        }elseif(strlen($_POST['password']) < 8){
            $errorInput['passwordErr'] = 'password must be 8 characters long';
        }
        if(empty($_POST['confirmPassword'])){
            $errorInput['confirmPwErr'] = 'please retype password to confirm';
        }elseif($_POST['confirmPassword'] != $_POST['password']){
            $errorInput['confirmPwErr'] = "password doesn't match";
        }
        
        if(!array_filter($errorInput) && !$dbError){
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $query = "INSERT INTO user(first_name, last_name, email, password) VALUES('$firstName', '$lastName', '$email', '$password')";
            try{
                $result = mysqli_query($connection, $query);
                if($result){
                    header('location: login.php');
                    exit;
                }
            }catch(Exception $e){
            }
            
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
    <link rel="stylesheet" href="./styles/signup.css">
</head>
<body>
    <main >
        <div class="hero-img-container">
            <img src="./assets/hero-img.png" alt="">
        </div>
        <form action="signup.php" method="post">
            <p class="title">Recyclables</p>
            <div class="nameInputContainer">
                <input type="text" name="fName" placeholder="first name" value="<?php echo $firstName ?>">
                <p class="errorInput" id="fNameErr"><?php echo $errorInput['firstNameErr'] ?></p>
                <input type="text" name="lName" placeholder="last name" value="<?php echo $lastName ?>">
                <p class="errorInput" id="lNameErr"><?php echo $errorInput['lastNameErr'] ?></p>
            </div>
            <input type="email" name="email" placeholder="email" value="<?php echo $email ?>">
            <p class="errorInput"><?php echo $errorInput['emailErr'] ?></p>
            <input type="password" name="password" placeholder="password">
            <p class="errorInput"><?php echo $errorInput['passwordErr'] ?></p>
            <input type="password" name="confirmPassword" placeholder="confirm password">
            <p class="errorInput"><?php echo $errorInput['confirmPwErr'] ?></p>
            <input type="submit" name="submit" value="Sign Up">
            <a href="login.php" class="login-account">LogIn Your Account</a>
            <p class="forgotpw">Forgot Password?</p>
        </form>
    </main>
    <?php include './footer.php' ?>
</body>
</html>