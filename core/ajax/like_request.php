<?php
require_once "../init.php";
if (Input::exists()) {
    if (isset($_POST['like']) && !empty($_POST['like'])) {
        $likeID=escape($_POST['like']);
        $userid=escape($_POST['userid']);
        if($userid==$_SESSION['user_id']) {
            $LoadFromPost->post_like($likeID);
            echo $LoadFromPost->simpleGetPostLikes($likeID);
        }

    }

    
}