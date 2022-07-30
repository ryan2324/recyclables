<?php
    session_start();
    $currentTime = date('Y-m-d h:i:s', time());
    include 'config.php';
    try{
        $param = [];
        parse_str($_SERVER['QUERY_STRING'], $param);
        $queryPost = "SELECT post.post_id, post.title, post.description, post.views, post.date_posted, post.author_id, post.post_img_path, user.first_name, user.last_name, user.profile_img FROM post JOIN user ON post.author_id = user.user_id WHERE post_id = $param[id]";
        $postQueryRes = mysqli_query($connection, $queryPost);
        $post = mysqli_fetch_all($postQueryRes, MYSQLI_ASSOC);
        $queryViews = "UPDATE post SET views = {$post[0]["views"]}  + 1  WHERE post_id = $param[id]";
        $viewsQueryRes = mysqli_query($connection, $queryViews);
        $queryComments = "SELECT comment.comment_id, comment.comment, comment.date_posted, user.first_name, user.last_name, user.profile_img FROM comment JOIN user ON comment.author_id = user.user_id WHERE post_id = {$param['id']}";
        $commentQueryRes = mysqli_query($connection, $queryComments);
        $comments = mysqli_fetch_all($commentQueryRes, MYSQLI_ASSOC);
    }catch(Exception $e){
        echo $e;
    }
    
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./styles/thread.css">
</head>
<body>
    <?php include './header.php'?>
    <main>
    <div class="divider">
        <div class="postContainer">
            <p class="title"><?php echo $post[0]['title'] ?></p>
            <p class="description"><?php echo $post[0]['description'] ?></p>
            <?php
                if($post[0]['post_img_path']){
                    echo "<div class='imgContainer'>
                            <img src={$post[0]['post_img_path']} alt=''>
                        </div>";
                }
               
            ?>
            <div class="infoContainer">
                <p><?php echo $post[0]['first_name'].' '.$post[0]['last_name'] ?></p>
                <p><?php 
                    $date = $post[0]['date_posted'];
                    $formatedDate = getdate(date('U', strtotime($post[0]['date_posted'])));
                    echo "$formatedDate[weekday] at $formatedDate[hours]:$formatedDate[minutes]";
                ?></p>
            </div>
        </div>
        <div class="commentsContainer">
            <p class="title">Comments</p>
            <form action="thread.php?id=<?php echo $param['id'] ?>" method="post">
                <textarea name="comment" id=""  rows="2" placeholder="add comment"></textarea>
                <input id="submitBtn" type="submit" name="submit" value="comment">
            </form>
            <?php
                array_map(function ($comment){
                    $commentPostedOn = getdate(strtotime($comment['date_posted']));
                    echo "<div class='commentContainer'>
                            <div class='commentAuthor'>
                                <img src='' alt=''>
                                <p class='name'>{$comment['first_name']} {$comment['last_name']}</p>
                                <p>{$commentPostedOn['weekday']} at {$commentPostedOn['hours']}:{$commentPostedOn['minutes']}</p>
                            </div>
                            <div class='comment'>
                                <p>{$comment['comment']}</p>
                            </div>
                        </div>";
                }, $comments); 
                
            ?>
        </div>
    </div>
        <?php include './newPostSection.php'?>
    </main>
    <?php 
        if(isset($_POST['submit']) && !empty($_POST['comment'])){
            if(empty($_SESSION['userId'])){
                header('location: login.php');
                exit;
            }
            $queryViews = "INSERT INTO comment(comment, date_posted, post_id, author_id) VALUES('{$_POST['comment']}', '$currentTime', {$post[0]['post_id']}, {$_SESSION['userId']})";
            $viewsQueryRes = mysqli_query($connection, $queryViews);
            header("location: thread.php?id={$param['id']}");
            exit;
        }
        include './footer.php';
    ?>
</body>
</html>