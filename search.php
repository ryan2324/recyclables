<?php 
    include 'config.php';
    if(isset($_POST['search'])){
        $query = "SELECT * FROM post WHERE title LIKE '%$_POST[search]%'";
        $res = mysqli_query($connection, $query);
        $post = mysqli_fetch_all($res, MYSQLI_ASSOC);
        echo json_encode($post);
    }