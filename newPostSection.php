<?php 
    include 'config.php';
    try{
        $query = "SELECT * FROM post ORDER BY date_posted DESC LIMIT 10";
        $res = mysqli_query($connection, $query);
        $posts = mysqli_fetch_all($res, MYSQLI_ASSOC);
    }catch(Exception $e){

    }
?>
<div class="newPostsContainer">
        <p id="newPostTitle">New Posts</p>
        <div class="newPosts">
            <?php 
                array_map(function($post){
                    echo "<p data-post-id=$post[post_id] class='newPost'>$post[title]</p>";
                }, $posts)
            ?>
        </div>
    </div>