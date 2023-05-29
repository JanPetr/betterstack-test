<?php

$app = require "../core/app.php";

// Create new instance of user
$user = new User($app->db);

$errors = validateForm($_POST);
if (sizeof($errors) > 0) {
    // Redirect back to index
    $query = http_build_query(array('errors' => $errors));
    header('Location: index.php?'.$query);
    die();
}

// Insert it to database with POST data
$user->insert(array(
    'name' => $_POST['name'],
    'email' => $_POST['email'],
    'city' => $_POST['city'],
    'phone_number' => $_POST['phone-number'],
));

// Redirect back to index
header('Location: index.php');

function validateForm($data)
{
    $errors = array();

    // Check CSRF token
    if ($_POST['token'] !== $_SESSION['token']) {
        $errors['csrf'] = 'Invalid CSRF token';
    }

    if (empty($data['name'])) {
        $errors['name'] = 'Name is required';
    }

    if (empty($data['email'])) {
        $errors['email'] = 'E-mail is required';
    }

    // validate e-mail format
    if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'E-mail is not valid, correct format is `email@email.com`';
    }

    if (empty($data['city'])) {
        $errors['city'] = 'City is required';
    }

    if (empty($data['phone-number'])) {
        $errors['phone-number'] = 'Phone number is required';
    }

    return $errors;
}
