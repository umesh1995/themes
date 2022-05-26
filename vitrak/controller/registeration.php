<?php
// define('WP_USE_THEMES', false);  
require_once('../../../../wp-load.php');
the_post();

$data = json_encode($_POST, true);
$response = array();
$response['data'] = $data;
$response['status'] = 'success';

//Need registration.php for data validation
$firstname = sanitize_text_field($form_data['firstname']);
$lastname = sanitize_text_field($form_data['lastname']);
$phonenumber = sanitize_text_field($form_data['phonenumber']);
$email = sanitize_text_field($form_data['email']);
$password = sanitize_text_field($form_data['password']);

//Put the Validation Here. Check for blanks, etc.

//Create the user
$user_pass = wp_generate_password(); //Why are we using this? The user will already have a password.
$firstname = sanitize_text_field($form_data['firstname']);
$lastname = sanitize_text_field($form_data['lastname']);
$phonenumber = sanitize_text_field($form_data['phonenumber']);
$email = sanitize_text_field($form_data['email']);
$password = sanitize_text_field($form_data['password']);

//Create the usersword();
$user = array(
    'user_login' => $phonenumber,
    'user_pass' => $password,
    'first_name' => $firstname,
    'last_name' => $lastname,
    'user_email' => $email,
    'phone_number' => $phonenumber,
    'password' => $password,
    'role' => 'customer'
);
$user_id = wp_insert_user($user);

json_encode($response, true);
print_r($response);
