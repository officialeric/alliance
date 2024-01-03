<?php


global $getFromU, $getFromD;
include '../init.php';

if(isset($_POST['comment']) && !empty($_POST['comment'])){
    $comment = $getFromU->checkInput($_POST['comment']);
    $user_id = $_SESSION['user_id'];
    $dropID = $_POST['drop_id'];

    $getFromU->create('comments', array('comment' => $comment, 'commentOn' => $dropID, 'commentBy' => $user_id));

    $comments = $getFromD->comments($dropID);

    foreach ($comments as $comment) {
        //some HTML code
    }
}
?>