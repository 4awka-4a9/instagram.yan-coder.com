<?php
require_once "core/init.php";
if (!loggedIn()) {
    Redirect::to('login.php');
}
$user = $LoadFromUser->getUserDataFromSession();
$title = "Create Stories";
$keywords = "Seek, Share and capture world's moments, share, capture, messages,create stories";
require "shared/header.php";
?>
<div class="profile-user-id" data-userid="<?php echo $user->user_id ?>" data-profileid="<?php echo $user->user_id ?>"></div>
<?php require_once "global.header.php"; ?>
<style>
    body{
        overflow:hidden !important;
    }
</style>
<section class="story-container">
    <div class="left-part">
        <div class="story-header">
            <h2>Your Story</h2>
            <div class="story-header-wrapper">
                <div class="profile-image-wrapper" style="width: 58px;height:58px;">
                    <img src="<?php echo url_for($user->profileImage); ?>" alt="<?= $user->fullName; ?>" style="width:100%;height:100%;border-radius:50%;object-fit:cover;">
                </div>
                <h3 class="user-fullName"><?= $user->fullName; ?></h3>
            </div>
        </div>
        <div class="story-wrapper hidden">
            <section class="story-body hidden">
                <textarea name="textInput" placeholder="Start typing" id="textInput" cols="30" rows="10"></textarea>
                <div class="pick_font">
                    <div class="pick_font_btnn">
                        <span class="font_name">Clean</span>
                    </div>
                    <div class="font_list" style="display: none;">
                        <a id="clean_font">Clean</a>
                        <a id="simple_font">Simple</a>
                        <a id="bold_font">Bold</a>
                        <a id="neon_font">Neon</a>
                        <a id="italic_font">Italic</a>
                    </div>
                </div>
                <div class="story_backgrounds">
                    <span>Background</span>
                    <div class="stoy_bg_wrapper">

                        <?php
                        $images = glob('stories/*');
                        foreach ($images as $key => $value) {
                            echo '<div class="bg_story_select">
                                <img src="' . url_for($value) . '"/>
                        </div>';
                        }

                        ?>

                    </div>
                </div>
            </section>
            <footer class="story-footer">
                <button class="share-btn" id="share-btn">Share to Story</button>
            </footer>
        </div>
    </div>
    <div class="right-part">
        <div class="photo-container">
            <div class="p-c-a" style="position: relative;">
                <label for="imageUpload">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="1em" height="1em" class="a8c37x1j ms05siws hwsy1cff b7h9ocf4 n90h9ftp rgmg9uty b73ngqbp">
                        <g fill-rule="evenodd" transform="translate(-444 -156)">
                            <g>
                                <path d="m96.968 22.425-.648.057a2.692 2.692 0 0 1-1.978-.625 2.69 2.69 0 0 1-.96-1.84L92.01 4.32a2.702 2.702 0 0 1 .79-2.156c.47-.472 1.111-.731 1.774-.79l2.58-.225a.498.498 0 0 1 .507.675 4.189 4.189 0 0 0-.251 1.11L96.017 18.85a4.206 4.206 0 0 0 .977 3.091s.459.364-.026.485m8.524-16.327a1.75 1.75 0 1 1-3.485.305 1.75 1.75 0 0 1 3.485-.305m5.85 3.011a.797.797 0 0 0-1.129-.093l-3.733 3.195a.545.545 0 0 0-.062.765l.837.993a.75.75 0 1 1-1.147.966l-2.502-2.981a.797.797 0 0 0-1.096-.12L99 14.5l-.5 4.25c-.06.674.326 2.19 1 2.25l11.916 1.166c.325.026 1-.039 1.25-.25.252-.21.89-.842.917-1.166l.833-8.084-3.073-3.557z" transform="translate(352 156.5)" />
                                <path fill-rule="nonzero" d="m111.61 22.963-11.604-1.015a2.77 2.77 0 0 1-2.512-2.995L98.88 3.09A2.77 2.77 0 0 1 101.876.58l11.603 1.015a2.77 2.77 0 0 1 2.513 2.994l-1.388 15.862a2.77 2.77 0 0 1-2.994 2.513zm.13-1.494.082.004a1.27 1.27 0 0 0 1.287-1.154l1.388-15.862a1.27 1.27 0 0 0-1.148-1.37l-11.604-1.014a1.27 1.27 0 0 0-1.37 1.15l-1.387 15.86a1.27 1.27 0 0 0 1.149 1.37l11.603 1.016z" transform="translate(352 156.5)" />
                            </g>
                        </g>
                    </svg>
                    <span class="p-text">Create a photo story</span>
                </label>
                <input type="file" id="imageUpload" class="fileUpload">
            </div>
        </div>
        <div class="text-container">
            <div class="t-c-a">
                <span>Aa</span>
            </div>
            <div class="t-text">Create a text story</div>
        </div>
    </div>
    <div class="story-preview-container hidden">
        <div class="preview-container">
            <h2 class="preview-heading">Preview</h2>
            <div class="p-bg">
                <div class="p-rect">
                    <div class="p-rect-text">START TYPING</div>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="<?= url_for('js/jquery.js'); ?>"></script>
<script src="<?= url_for('js/story.js'); ?>"></script>