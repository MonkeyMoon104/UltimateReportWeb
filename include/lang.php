<?php
$translations = require __DIR__ . '/../util/lang_global.php';

function __($key) {
    global $translations;
    if (isset($translations[$key])) {
        return $translations[$key];
    }
    return $key;
}
