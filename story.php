<?php
require_once "core/init.php";
if (!loggedIn()) {
    Redirect::to(url_for('login'));
}
$user = $LoadFromUser->getUserDataFromSession();
$storyIdForUser = null;

if (Input::exists('GET')) {
    if (isset($_GET['storyId']) && !empty($_GET['storyId'])) {
        $storyIdForUser = escape($_GET['storyId']);
    }

    if ($LoadFromUser->checkStoryExist($storyIdForUser) === false) {
        Redirect::to(url_for('404'));
    }
}
$title = "Stories • Instagram";
$keywords = "Instagram, Share and capture world's moments, share, capture, messages,create stories";
require "shared/header.php";
?>
<div class="page-story" style="background-color:#1b1d20;">
    <div class="u-p-id" data-userid="<?php echo $user->user_id; ?>" data-profileid=""></div>
    <div class="story_container">
        <a href="<?php echo url_for('index') ?>" class="site-logo ui-brand">
            <img src="<?php echo url_for('images/logo/insta_white.png'); ?>" alt="Instagram"
                title="Instagram">
        </a>
        <div data-slide="slide" class="slide">
            <div class="slide-items">
                <?php $LoadFromUser->statusData($storyIdForUser); ?>
            </div>
            <div class="slide-nav">
                <div class="slide-thumbs"></div>
                <button class="slide-prev">Previous</button>
                <button class="slide-next">Next</button>
            </div>
        </div>
    </div>
</div>
</div>
<script src="<?php echo url_for('js/slide-stories.js'); ?>"></script>