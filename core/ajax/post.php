<?php
require_once "../init.php";
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
if (Input::exists()) {
    if (!empty($_FILES['postImage'])) {
        $postImage = $_FILES['postImage'];
        $userid = h($_POST['user_id']);
        $post = escape($_POST['post']);

        $user = $LoadFromUser->getUserDataFromSession();

        if ($userid == $user->user_id) {
            $postImagePath = $LoadFromUser->uploadPost($postImage, $userid);
            $LoadFromPost->createPosts($userid, $postImagePath, $post);

            $LoadFromPost->posts($user->user_id,10);
        }
    }
}
