<?php
    // $theme = '';
    // if(!empty($_COOKIE['theme']) && $_COOKIE['theme'] == 'light'){
    //     $theme = 'theme';
    // }
    $themeChoice = $_SESSION['user_theme'] ?? $_COOKIE['theme'] ?? null;
    $theme = '';
    if ($themeChoice == 'light') {
        $theme = 'theme';
    }
?>