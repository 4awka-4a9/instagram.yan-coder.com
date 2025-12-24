<?php

if (!isset($title)) {
    $title = "Instagram";
    $keywords = "Instagram, Share and capture world's moments, share, capture, share,home";
}
$desc = "Instagram lets you capture, follow, like and share world's moments in a better way and tell your story with photos, messages, posts and everything in between";


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title; ?></title>
    <meta name="keywords" content="<?= $keywords ?>">
    <meta name="description" content="<?= $desc ?>">
    <meta name="author" content="yan-coder">
    <link rel="shortcut icon" href="/instagram_clone/images/favicon/instagram.ico" type="image/x-icon">
    <link rel="stylesheet" href="/instagram_clone/css/register.css">
</head>
<body>