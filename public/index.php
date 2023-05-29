<?php

// Init app instance
$app = require "../core/app.php";

$_SESSION['token'] = generateCSRFToken();

// Get all users from DB, eager load all fields using '*'
$users = User::find($app->db,'*');

// Render view 'views/index.php' and pass users variable there
$app->renderView('index', array(
    'token' => $_SESSION['token'],
	'users' => $users,
    'errors' => array_key_exists('errors', $_GET) ? $_GET['errors'] : array()
));
