<?php
global $getFromU;
if ($_SERVER['REQUEST_METHOD'] == "GET" && realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME'])) {
    header('Location: ../index.php');
}
if(isset($_POST['signup'])){
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $error = '';

    if(empty($username) or empty($password) or empty($email)){
        $error = 'All fields are required';
    }else {
        $email = $getFromU->checkInput($email);
        $username = $getFromU->checkInput($username);
        $password = $getFromU->checkInput($password);

        if(!filter_var($email)) {
            $error = 'Invalid email format';
        }else if(strlen($username) > 20){
            $error = 'Name must be between in 6-20 characters';
        }else if(strlen($password) < 5){
            $error = 'Password is too short';
        }else {
            if($getFromU->checkEmail($email) === true){
                $error = 'Email is already in use';
            }else {
                $user_id = $getFromU->create('users', array('email' => $email, 'password' => md5($password) , 'username' => $username, 'profileImage' => 'assets/images/defaultProfileImage.png', 'profileCover' => 'assets/images/defaultCoverImage.png'));
                $_SESSION['user_id'] = $user_id;
                header('Location: includes/signup.php?step=1');
            }
        }
    }
}
?>

