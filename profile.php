<?php

require_once "core/init.php";
if (!loggedIn()) {
    Redirect::to('login.php');
}

if (Input::exists('GET')) {
    if (isset($_GET['username'])) {
        $username = escape($_GET['username']);
        $profileId = $LoadFromUser->userIdByUsername($username);

        if (!$profileId) {
            Redirect::to(url_for('404'));
        }
    } else {
        $profileId = $_SESSION['user_id'];
    }
}

$user = $LoadFromUser->getUserDataFromSession();
$profileData = $LoadFromUser->getUserDataFromURL($profileId);
$title = $profileData->fullName . ' (@' . $profileData->username . ') / Instagram';
$keywords = "{$profileData->username},{$profileData->fullName},Instagram, Share and capture world's moments";
require "shared/header.php";

?>

<div class="profile-user-id" data-userid="<?php echo $user->user_id ?>" data-profileid="<?php echo $profileId; ?>"></div>
<?php require_once "global.header.php"; ?>
<main class="profileContainer">
    <div class="profile__header">
        <img class="profile__thumbnail" src="<?php echo url_for($profileData->profileImage); ?>" alt="Photo of <?php echo $profileData->fullName; ?>">
        <div class="profile__stats">
            <div class="profile__headline">
                <?php echo $profileData->fullName; ?>
            </div>
            <div class="profile__details">
                <p><span id="user__post" class="bold"><?php echo $LoadFromPost->postCount($profileData->user_id); ?></span> posts</p>
                <p><span id="user__followers" class="bold"><?php echo $LoadFromFollow->getFollowers($profileData->user_id); ?></span> followers</p>
                <p><span id="user__following" class="bold"><?php echo $LoadFromFollow->getFollowings($profileData->user_id); ?></span> following</p>
            </div>
        </div>
    </div>
    <div class="profile__posts">
        <?= $LoadFromPost->profilePosts($profileData->user_id); ?>
    </div>
</main>