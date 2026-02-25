<?php

require_once "core/init.php";

if (!loggedIn()) {
    Redirect::to('login.php');
}

$user = $LoadFromUser->getUserDataFromSession();

$user_id = $_SESSION['user_id'];
require "shared/header.php";

?>

<div class="profile-user-id" data-userid="<?php echo $user->user_id ?>" data-profileid="<?php echo $user->user_id ?>">
</div>
<?php require_once "global.header.php"; ?>

<main class="mainContainer">
    <section class="contentContainer">

        <div class="content">
            <div class="stories">

                <button class="stories__left-button stories--button" style="display: none;">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                        <path fill="#fff"
                            d="M256 504C119 504 8 393 8 256S119 8 256 8s248 111 248 248-111 248-248 248zM142.1 273l135.5 135.5c9.4 9.4 24.6 9.4 33.9 0l17-17c9.4-9.4 9.4-24.6 0-33.9L226.9 256l101.6-101.6c9.4-9.4 9.4-24.6 0-33.9l-17-17c-9.4-9.4-24.6-9.4-33.9 0L142.1 239c-9.4 9.4-9.4 24.6 0 34z">
                        </path>
                    </svg>
                </button>

                <div class="stories__content">

                    <button class="story story--has-story">
                        <div class="story__avatar">
                            <div class="story__border">
                                <svg width="64" height="64" xmlns="http://www.w3.org/2000/svg">
                                    <circle r="31" cy="32" cx="32" />
                                    <defs>
                                        <linearGradient y2="0" x2="1" y1="1" x1="0" id="--story-gradient">
                                            <stop offset="0" stop-color="#f09433" />
                                            <stop offset="0.25" stop-color="#e6683c" />
                                            <stop offset="0.5" stop-color="#dc2743" />
                                            <stop offset="0.75" stop-color="#cc2366" />
                                            <stop offset="1" stop-color="#bc1888" />
                                        </linearGradient>
                                    </defs>
                                </svg>
                            </div>

                            <a href="<?php echo url_for('create/story'); ?>" class="story__picture plus_icon">
                                <img src="<?php echo url_for('images/story.png'); ?>" alt="">
                            </a>

                        </div>

                        <span class="story__user">Create Story</span>

                    </button>

                    <a href="<?php echo url_for('stories/' . $user->username . '/' . $user->user_id); ?>"
                        class="story story--has-story">
                        <div class="story__avatar">
                            <div class="story__border">
                                <svg width="64" height="64" xmlns="http://www.w3.org/2000/svg">
                                    <circle r="31" cy="32" cx="32" />
                                    <defs>
                                        <linearGradient y2="0" x2="1" y1="1" x1="0" id="--story-gradient">
                                            <stop offset="0" stop-color="#f09433" />
                                            <stop offset="0.25" stop-color="#e6683c" />
                                            <stop offset="0.5" stop-color="#dc2743" />
                                            <stop offset="0.75" stop-color="#cc2366" />
                                            <stop offset="1" stop-color="#bc1888" />
                                        </linearGradient>
                                    </defs>
                                </svg>
                            </div>

                            <div class="story__picture">
                                <img src="<?php echo url_for($user->profileImage); ?>"
                                    alt="Photo of <?php echo $user->fullName; ?>">
                            </div>

                        </div>

                        <span class="story__user"><?php echo $user->username; ?></span>

                    </a>

                </div>

                <button class="stories__right-button stories--button" style="display: unset;">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                        <path fill="#fff"
                            d="M256 8c137 0 248 111 248 248S393 504 256 504 8 393 8 256 119 8 256 8zm113.9 231L234.4 103.5c-9.4-9.4-24.6-9.4-33.9 0l-17 17c-9.4 9.4-9.4 24.6 0 33.9L285.1 256 183.5 357.6c-9.4 9.4-9.4 24.6 0 33.9l17 17c9.4 9.4 24.6 9.4 33.9 0L369.9 273c9.4-9.4 9.4-24.6 0-34z">
                        </path>
                    </svg>
                </button>

            </div>
        </div>
        <section class="posts">
            <?php $LoadFromPost->posts($user->user_id, 10); ?>
        </section>

        <aside class="side-menu">

            <div class="side-menu__user-profile">

                <a href="<?php echo url_for('profile/' . $user->username); ?>" target="_blank"
                    class="side-menu__user-avatar">
                    <img src="<?php echo url_for($user->profileImage); ?>" alt="Photo Of <?php echo $user->fullName ?>">
                </a>

                <div class="side-menu__user-info">

                    <a href="<?php echo url_for('profile/' . $user->username); ?>" target="_blank">
                        <?php echo $user->username; ?>
                    </a>

                    <span><?php echo $user->fullName; ?></span>

                </div>

                <button class="side-menu__user-button">Switch</button>

            </div>

            <div class="side-menu__suggestions-section">
                <div class="side-menu__suggestions-header">

                    <h2>Suggestions for you</h2>

                    <button>See All</button>

                </div>

                <div class="side-menu__suggestions-content">
                    <?php $LoadFromFollow->whoToFollow($user->user_id); ?>
                </div>

            </div>

            <div class="side-menu__footer">

                <div class="side-menu__footer-links">
                    <ul class="side-menu__footer-list">

                        <li class="side-menu__footer-item">
                            <a href="#" class="side-menu__footer-link">About</a>
                        </li>
                        <li class="side-menu__footer-item">
                            <a href="#" class="side-menu__footer-link">Help</a>
                        </li>
                        <li class="side-menu__footer-item">
                            <a href="#" class="side-menu__footer-link">Press</a>
                        </li>
                        <li class="side-menu__footer-item">
                            <a href="#" class="side-menu__footer-link">API</a>
                        </li>
                        <li class="side-menu__footer-item">
                            <a href="#" class="side-menu__footer-link">Jobs</a>
                        </li>
                        <li class="side-menu__footer-item">
                            <a href="#" class="side-menu__footer-link">Privacy</a>
                        </li>
                        <li class="side-menu__footer-item">
                            <a href="#" class="side-menu__footer-link">Terms</a>
                        </li>
                        <li class="side-menu__footer-item">
                            <a href="#" class="side-menu__footer-link">Locations</a>
                        </li>
                        <li class="side-menu__footer-item">
                            <a href="#" class="side-menu__footer-link">Top Accounts</a>
                        </li>
                        <li class="side-menu__footer-item">
                            <a href="#" class="side-menu__footer-link">Hashtag</a>
                        </li>
                        <li class="side-menu__footer-item">
                            <a href="#" class="side-menu__footer-link">Language</a>
                        </li>
                        <li class="side-menu__footer-item">
                            <a href="#" class="side-menu__footer-link"></a>
                        </li>

                    </ul>
                </div>

                <span class="side-menu__footer-copyright">
                    &copy; <?php echo date('Y') ?> instagram from facebook
                </span>

            </div>

        </aside>

    </section>
</main>

<?php include_once "shared/post_modal.php"; ?>

<script src="js/jquery.js"></script>
<script src="js/common.js?v=2"></script>
<script src="js/follow.js?v=2"></script>