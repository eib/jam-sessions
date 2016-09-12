<?php

$data = [
    'logged_in' => Auth::isLoggedIn(),
    'user' => Auth::getUser()
];

Templates::display('index.html', $data);
