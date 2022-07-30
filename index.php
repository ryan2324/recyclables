<?php
    session_start();
    $currentTime = getdate(time());
    $day = strlen($currentTime['mday']) == 1 ? '0'.$currentTime['mday'] : $currentTime['mday'];
    $month = strlen($currentTime['mon']) == 1 ? '0'.$currentTime['mon'] : $currentTime['mon'];
    $year = $currentTime['year'];
    $params = [];
    parse_str($_SERVER['QUERY_STRING'], $params );
    $postListTitle = '';
    include 'config.php';
    try{
        if(array_filter($params)){
            if($params['popular'] === 'day'){
                $postListTitle = 'Popular Today';
                $query = "SELECT post.post_id, post.title, post.description, post.date_posted, post.views, post.author_id, user.first_name, user.last_name, user.profile_img FROM post JOIN user ON post.author_id = user.user_id WHERE date_posted LIKE '____-__-$day %' ORDER BY post.views DESC";
            }elseif($params['popular'] === 'month'){
                $postListTitle = 'Popular This Month';
                $query = "SELECT post.post_id, post.title, post.description, post.date_posted, post.views, post.author_id, user.first_name, user.last_name, user.profile_img FROM post JOIN user ON post.author_id = user.user_id WHERE date_posted LIKE '____-$month-__ %' ORDER BY post.views DESC";
            }elseif($params['popular'] === 'year'){
                $postListTitle = 'Popular This Year';
                $query = "SELECT post.post_id, post.title, post.description, post.date_posted, post.views, post.author_id, user.first_name, user.last_name, user.profile_img FROM post JOIN user ON post.author_id = user.user_id WHERE date_posted LIKE '$year-__-__ %' ORDER BY post.views DESC";
            } 
        }else{
            $postListTitle = 'Popular This Month';
            $query = "SELECT post.post_id, post.title, post.description, post.date_posted, post.views, post.author_id, user.first_name, user.last_name, user.profile_img FROM post JOIN user ON post.author_id = user.user_id WHERE date_posted LIKE '____-$month-__ %' ORDER BY post.views DESC";
        } 
        
        $result = mysqli_query($connection, $query);
        $posts = mysqli_fetch_all($result, MYSQLI_ASSOC);
        
    }catch(Exception $e){
    }
    
?>  
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./styles/main.css">
</head>
<body>
<?php 
    include './header.php';
?>
<main class="main">
    <div class="popularPostsContainer">
        <div>
            <h1><?php echo $postListTitle ?></h1>
            <h4><?php echo count($posts) ?></h4>
        </div>
        <?php 
            array_map(function ($post){
                $datePosted = strtotime($post['date_posted']);
                $formatedDate = getdate( $datePosted);
                $profile = $post['profile_img'] ? "<img src={$post['profile_img']} alt=''>":"<i class='fa-solid fa-user'></i>";
                echo "
                <div data-post-id='$post[post_id]' class='post'>
                    <div class='postInfo'>
                        <div class='imgContainer'>
                            $profile
                        </div>
                        <div class='postAuthor'>
                            <p class='postName'>$post[first_name] $post[last_name]</p>
                            <p class='postTime'>$formatedDate[weekday] at $formatedDate[hours]:$formatedDate[minutes] </p>
                        </div>
                    </div>
                    <div class='postTxt'>
                        <p class='postTitle'>$post[title]</p>
                        <p class='postDesc'>$post[description]</p>
                    </div>
                    <div class='viewsContainer'><i class='fa-solid fa-eye'></i><p>$post[views]</p></div>
                </div>
                ";
            },$posts)
        ?>
        
    </div>
    <?php include './newPostSection.php'?>
    <button class="make-post-float-btn"><i class="fa-solid fa-pen-to-square"></i></button>
</main>
<?php 
    include './footer.php';
?>
</body>
</html>
