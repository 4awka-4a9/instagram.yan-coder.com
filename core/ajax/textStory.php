<?php
require_once "../init.php";
if (Input::exists()) {
    if (isset($_POST['userid']) && !empty($_POST['userid'])) {
        $userid = escape($_POST['userid']);
        $text = wordwrap($_POST['storyText'], 26, "\n", true);
        $background = $_POST['background'];
        $font_name = $_POST['font'];

        $countLines = strlen($text) / 26;

        $img = imagecreatefromjpeg($background);
        $color = imagecolorallocate($img, 255, 255, 255);

        if ($font_name == 'Bold') {
            $font = $_SERVER['DOCUMENT_ROOT'] . "/instagram.yan-coder.com/fonts/bold.ttf";
        } else if ($font_name == "Italic") {
            $font = $_SERVER['DOCUMENT_ROOT'] . "/instagram.yan-coder.com/fonts/italic.ttf";
        } else if ($font_name == 'Neon') {
            $font = $_SERVER['DOCUMENT_ROOT'] . "/instagram.yan-coder.com/fonts/neon.ttf";
        } else if ($font_name == "Simple") {
            $font = $_SERVER['DOCUMENT_ROOT'] . "/instagram.yan-coder.com/fonts/simple.ttf";
        } else {
            $font = $_SERVER['DOCUMENT_ROOT'] . "/instagram.yan-coder.com/fonts/clean.ttf";
        }

        $angle = 0;
        $font_size = 24;

        $width = imagesx($img);
        $height = imagesy($img);

        //Get center coordinates of image
        $centerX = $width / 2;
        $centerY = $height / 2;

        //get size of text
        list($left, $bottom, $right,,, $top) = imageftbbox($font_size, $angle, $font, $text);

        //Determine offset of text
        $left_offset = ($right - $left) / 2;
        $top_offset = ($bottom - $top) / 2;

        //generate coordinates
        $x = $centerX - $left_offset;
        $y = $centerY + $top_offset;
        $yy = $y - ($countLines * 50);

        //Add text to image
        imagettftext($img, $font_size, $angle, $x, $yy, $color, $font, $text);
        $path_directory = $_SERVER['DOCUMENT_ROOT'] . "/instagram.yan-coder.com/stories/" . $userid . "/";

        if (!file_exists($path_directory) && !is_dir($path_directory)) {
            mkdir($path_directory, 0777, true);
        }

        $path = $_SERVER['DOCUMENT_ROOT'] . "/instagram.yan-coder.com/stories/" . $userid . "/";
        $fileName = $LoadFromUser->generate_filename(15) . '.jpg';
        imagejpeg($img, $path . $fileName, 100);
        $img_path = "media/stories/" . $userid . "/" . $fileName;
        $user = $LoadFromUser->getUserDataFromSession();

        if ($userid == $user->user_id) {
            $story_id = $LoadFromUser->createStory($userid, $img_path);

            echo json_encode(array('userid' => $userid, 'username' => $user->username));
        }
    }
}