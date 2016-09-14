<?php

if (Auth::isLoggedIn()) {
    $template = 'index.loggedIn.html';
    $data = ['user' => Auth::getUser()];
} else {
    $template = 'index.anonymous.html';
    $data = NULL;
}

Templates::display($template, $data);
