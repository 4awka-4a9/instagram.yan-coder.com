<?php
require_once "../init.php";
if (Input::exists()) {
    if (isset($_POST['deletePost']) && !empty($_POST['deletePost'])) {
        $deleteID=escape($_POST['deletePost']);
        $userid=escape($_POST['postedBy']);

      
        $LoadFromPost->deletePost($deleteID,$userid);

        $LoadFromPost->posts($userid,10);
    }

    
}