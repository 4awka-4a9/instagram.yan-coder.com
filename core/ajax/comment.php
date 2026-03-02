<?php
require_once "../init.php";
if (Input::exists()) {
    if (!empty($_POST['comment']) && isset($_POST['comment'])) {
       $comment=escape($_POST['comment']);
       $commentOn=escape($_POST['commentOn']);
       $commentBy=escape($_POST['commentBy']);

     $LoadFromPost->createComment($comment,$commentOn,$commentBy);
     echo $LoadFromPost->getComments($commentOn);
    }
}