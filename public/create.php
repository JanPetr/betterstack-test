<?php

$app = require "../core/app.php";

// Create new instance of user
$user = new User($app->db);

$errors = validateForm($_POST);
if ($errors != []) {
    if (isAjax()) {
        $_SESSION['token'] = generateCSRFToken();

        http_response_code(400);
        header('Content-Type: application/json');

        echo json_encode(array(
            'errors' => $errors,
            'token' => $_SESSION['token'],
        ));
        die();
    }

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

if (isAjax()) {
    $_SESSION['token'] = generateCSRFToken();

    header('Content-Type: application/json');
    echo json_encode(array(
        'success' => true,
        'token' => $_SESSION['token'],
    ));
    die();
}

// Redirect back to index
header('Location: index.php');

function validateForm($data)
{
    $errors = array();

    // Check CSRF token
    if ($_POST['token'] !== $_SESSION['token']) {
        $errors[] = 'Invalid CSRF token';
    }

    if (empty($data['name'])) {
        $errors[] = 'Name is required';
    }

    if (empty($data['email'])) {
        $errors[] = 'E-mail is required';
    }

    // validate e-mail format
    if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'E-mail is not valid, correct format is `email@email.com`';
    }

    if (empty($data['city'])) {
        $errors[] = 'City is required';
    }

    if (empty($data['phone-number'])) {
        $errors[] = 'Phone number is required';
    }

    return $errors;
}
