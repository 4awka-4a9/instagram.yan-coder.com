<?php

require_once "core/init.php";

if (!loggedIn()) {
    Redirect::to('login.php');
}

$user = $LoadFromUser -> getUserDataFromSession();

$user_id = $_SESSION['user_id'];
require "shared/header.php";

?>

<div class="profile-user-id" data-userid="<?php echo $user -> $user_id ?>" data-profileid="<?php echo $user -> user_id ?>"></div>
<?php require_once "global.header.php"; ?>
<script src="js/common.js"></script>
<script src="js/jquery.js"></script>