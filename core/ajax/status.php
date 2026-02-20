<?php
require_once "../init.php";
if (Input::exists()) {

    if (isset($_POST['userid']) && !empty($_POST['userid'])) {

        $userid = escape($_POST['userid']);
        $image = $_FILES['status'];
        $folder = $LoadFromUser->uploadStory($image, $userid);

        $user = $LoadFromUser->getUserDataFromSession();

        if ($userid == $user->user_id) {

            $story_id = $LoadFromUser->createStory($userid, $folder);

            echo json_encode(array('userid'=>$userid,'username'=>$user->username));

        }

    }

}