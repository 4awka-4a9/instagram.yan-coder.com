<?php
require_once "../init.php";
if (Input::exists()) {

    if (isset($_POST['followID']) && !empty($_POST['followID'])) {

        $follow = escape($_POST['followID']);

        echo $LoadFromFollow -> follow($follow);

    }

    if (isset($_POST['unfollowID']) && !empty($_POST['unfollowID'])) {

        $unfollowID = escape($_POST['unfollowID']);
        $LoadFromFollow -> unfollow($unfollowID);

    }

}