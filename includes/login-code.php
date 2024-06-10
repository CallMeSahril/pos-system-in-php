<?php

require 'config/function.php';

if (isset($_POST['loginBtn'])) {


    $email = validate($_POST['email']);
    $password = validate($_POST['password']);

    if ($email != '' && $password != '') {
        $query = "SELECT * FROM admins WHERE email='$email' LIMIT 1";
        $result = mysqli_query($conn, $query);
        if ($result) {

            if (mysqli_num_rows($result) == 1) {
            } else {
            }
        } else {
            redirect('login.php', 'Something Went Wrong');
        }
    } else {
        redirect('login.php', 'All fields are mandetory');
    }
}
