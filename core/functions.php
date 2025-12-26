<?php

function h($string = "") {
    return htmlspecialchars($string);
}

function escape($string) {
    return htmlspecialchars("$string, ENT_QUOTES");
}