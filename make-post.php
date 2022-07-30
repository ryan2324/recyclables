<?php
    session_start();
    $errorInput = ['title' =>'', 'description' =>'','image' =>''];
    $title = $description = "";
    $validExt = ['jpg', 'jpeg', 'png'];
    $currentTime = date('Y-m-d H:i:s', time());
    include 'config.php';
    if(isset($_POST['submit'])){
        if(empty($_POST['title'])){
            $errorInput['title'] = 'title cannot be empty';
        }else{
            $title = htmlspecialchars($_POST['title']);
        }
        if(empty($_POST['desc'])){
            $errorInput['description'] = 'description cannot be empty';
        }elseif(strlen($_POST['desc']) > 255){
            $errorInput['description'] = 'description must not exceed 255 characters';
            $description = htmlspecialchars($_POST['desc']);
        }else{
            $description = htmlspecialchars($_POST['desc']);
        }
        
        if($_FILES['img']['error'] === 0){
            $extension = explode('.',$_FILES['img']['name']);
            if(in_array($extension[1], $validExt)){
                if($_FILES['img']['size'] > 1048576){
                    $errorInput['image'] = 'image size must not exeed 1mb';
                }else{
                    $newImgName = strtolower(uniqid('img-', true).".$extension[1]");
                    move_uploaded_file($_FILES['img']['tmp_name'], "./uploads/posts/$newImgName");
                }
            }else{
                $errorInput['image'] = 'cannot upload of this file type';
            }
        }
        if(strlen($errorInput['title']) < 1 && strlen($errorInput['description']) < 1 && strlen($errorInput['image']) < 1 ){
            try{
                if($_FILES['img']['error'] === 0){
                    $query = "INSERT INTO post(title, description, date_posted, author_id, post_img_path) VALUES('$title', '$description', '$currentTime', '$_SESSION[userId]', './uploads/posts/$newImgName')";
                    $res = mysqli_query($connection, $query);
                }else{
                    $query = "INSERT INTO post(title, description, date_posted, author_id) VALUES('$title', '$description', '$currentTime', '$_SESSION[userId]')";
                    $res = mysqli_query($connection, $query);
                }
                header('location: index.php');
                exit;
            exit;
            }catch(Exception $e){
                echo $e->getMessage();
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
    <link rel="stylesheet" href="./styles/make-post.css">
</head>
<body>
    <?php include './header.php';
        if(empty($_SESSION['userId'])){
            header('location: login.php');
            exit;
        }
    ?>
    <main>
        <h1>Make a post</h1>
        <form action="make-post.php" method="post" enctype="multipart/form-data">
            <label for="title">Title</label>
            <input type="text" placeholder="title" name="title" value="<?php echo $title ?>">
            <p class="errorInput"><?php echo $errorInput['title']?></p>
            <label for="description">Question/Description</label>
            <div id="charCounterContainer"><p id="charCounter">0</p>/255</div>
            <textarea id="descInput" type="text" name="desc" placeholder="question/description" rows="5" ><?php echo $description ?></textarea>
            <p class="errorInput"><?php echo $errorInput['description']?></p>
            <label for="image"><i class="fa-solid fa-plus"></i>Attach photo</label>
            <input id="image" type="file" name="img">
            <p class="errorInput"><?php echo $errorInput['image']?></p>
            <input type="submit" name="submit" value="Post">
        </form>
    </main>
    <?php include './footer.php'?>
    <script src="https://kit.fontawesome.com/a4e4f824b7.js" crossorigin="anonymous"></script>
</body>
</html>