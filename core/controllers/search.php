<?php

global $getFromU;
include '../init.php';
if(isset($_POST['search']) && !empty($_POST['search'])){
    $search = $getFromU->checkInput($_POST['search']);
    $result = $getFromU->search($search);
    if(!empty($result)){

        //user intafaces for the result below

        foreach ($result as $user) {
            // some HTML codes
        }

    }
}