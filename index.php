<?php

require_once "core/init.php";

if (!loggedIn()) {
    Redirect::to('login.php');
}

$user = $LoadFromUser->getUserDataFromSession();

$user_id = $_SESSION['user_id'];
require "shared/header.php";

?>

<div class="profile-user-id" data-userid="<?php echo $user->$user_id ?>" data-profileid="<?php echo $user->user_id ?>"></div>
<?php require_once "global.header.php"; ?>

<main class="mainContainer">
    <section class="contentContainer">

        <div class="content">LEFT</div>
        <aside class="side-menu">

            <div class="side-menu__user-profile">

                <a href="<?php echo url_for('profile/' . $user->username); ?>" target="_blank"
                    class="side-menu__user-avatar">
                    <img src="<?php echo url_for($user->profileImage); ?>" alt="Photo Of <?php echo $user->fullName ?>">
                </a>

                <div class="side-menu__user-info">

                    <a href="<?php echo url_for('profile/' . $user->username); ?>" target="_blank"
                        clas="side-menu__user-avatar">
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

        </aside>

    </section>
</main>

<?php require_once "global.header.php"; ?>
<script src="js/jquery.js"></script>
<script src="js/common.js"></script>
<script src="js/follow.js"></script>