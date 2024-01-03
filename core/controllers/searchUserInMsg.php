<?php

global $getFromU;
include '../init.php';
if(isset($_POST['search']) && !empty($_POST['search'])){
    $user_id = $_SESSION['user_id'];
    $search  = $getFromU->checkInput($_POST['search']);
    $result  = $getFromU->search($search);

    //User interface for the result

    foreach ($result as $user) {
        if($user->user_id != $user_id){
            //some HTML code
        }
    }

}
?>