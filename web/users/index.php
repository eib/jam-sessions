<?php
Auth::ensureLoggedIn(); #TODO: Move to a directory-based setting/config option

$user = Auth::getUser();

Templates::display('users/index.html', ['user' => $user]);
