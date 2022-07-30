    <nav>
        <ul>
            <li id="logo"><a href="index.php"><img src="./assets/logo.png" alt=""></a>
            </li>
            <li id="brand"><a href="index.php">Recyclables</a></li>
            <li id="thread">Threads<i id="threadMenuBtn" class="fa-solid fa-caret-down">
                <ul id="threadsMenu">
                    <li id="today">Popular Today</li>
                    <li id="thisMonth">Popular This Month</li>
                    <li id="thisYear">Popular This Year</li>
                </ul>
            </i>
            </li>
            <li id="search">
                <input id="searchBar" type="text" name="search" placeholder="search">
                <div id="searchResultsContainer">
                </div>
            </li>
            <?php echo isset($_SESSION['userId']) ? '
                <li id="makePost"><a href="make-post.php">Make a Post</a></li>
                <li id="profile"><i id="profileIcon" class="fa-solid fa-user"></i>
                    <ul class="profileMenu">
                        <li id="profileLink"><div><i class="fa-solid fa-user"></i>Profile</div></li>
                        <li id="myPostLink"><div><i class="fa-solid fa-file-pen"></i>My Posts</div></li>
                        <li id="signout"><div><i class="fa-solid fa-arrow-right-from-bracket"></i>Signout</div></li>
                    </ul>
                </li>' : 
                '<li id="loginBtn"><a href="login.php">Login</a></li>
                <li id="signupBtn"><a href="signup.php">Signup</a></li>'
            ?>
            
        </ul>
    </nav>
