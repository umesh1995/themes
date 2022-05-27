<?php
// define('WP_USE_THEMES', false);  
require_once('../../../../wp-load.php');
the_post();

$data = json_encode($_POST, true);
$response = array();
$response['data'] = $data;
$response['status'] = 'success';

//Need registration.php for data validation
$username = sanitize_text_field($form_data['username']);
$email = sanitize_text_field($form_data['email']);
$phone = sanitize_text_field($form_data['phone']);
$business_name = sanitize_text_field($form_data['business_name']);
$business_address = sanitize_text_field($form_data['business_address']);
$business_type = sanitize_text_field($form_data['business_type']);
$password = sanitize_text_field($form_data['password']);

//Put the Validation Here. Check for blanks, etc.

//Create the user
$user_pass = wp_generate_password(); //Why are we using this? The user will already have a password.
$username = sanitize_text_field($form_data['username']);
$email = sanitize_text_field($form_data['email']);
$phone = sanitize_text_field($form_data['phone']);
$business_name = sanitize_text_field($form_data['business_name']);
$business_address = sanitize_text_field($form_data['business_address']);
$business_type = sanitize_text_field($form_data['business_type']);
$password = sanitize_text_field($form_data['password']);

//Create the usersword();
$user = array(
    'user_login' => $username,
    'user_pass' => $password,   
    'user_email' => $email,
    'phone_number' => $phone,
    'password' => $password,
    'business_name' => $business_name,
    'business_address' => $business_address,
    'business_type' => $business_type,
    'role' => 'Vendor'
);
$user_id = wp_insert_user($user);

json_encode($response, true);
print_r($response);
