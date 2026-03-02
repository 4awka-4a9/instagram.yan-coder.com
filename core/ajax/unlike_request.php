<?php
require_once "../init.php";
if (Input::exists()) {
    if (isset($_POST['unlike']) && !empty($_POST['unlike'])) {
        $unlikeID=escape($_POST['unlike']);
        $userid=escape($_POST['userid']);
        if($userid==$_SESSION['user_id']) {
            $LoadFromPost->post_unlike($unlikeID);
            echo $LoadFromPost->simpleGetPostLikes($unlikeID);
        }

    }

    
}