<?php


global $getFromU;
include '../init.php';

if(isset($_POST['comment']) && !empty($_POST['comment'])){
    $comment = $getFromU->checkInput($_POST['comment']);
    $user_id = $_SESSION['user_id'];
    $dropID = $_POST['drop_id'];

    $getFromU->create('comments', array('comment' => $comment, 'commentOn' => $dropID, 'commentBy' => $user_id));

    $comments = $getFromT->comments($dropID);
    $tweet = $getFromT->tweetPopup($dropID);

    foreach ($comments as $comment) {
        //some HTML code
    }
}
?>