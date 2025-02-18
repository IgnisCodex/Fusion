<?php

session_start();

if (isset($_POST['submit'])) {
    if (isset($_SESSION['user'])) {
    
        include "friend-req-contr.class.php";

        // FIXME: Hardcoded 2 for the friend request type
        $contr = new FriendRequestController($_SESSION['user']['id'], 2);
        $contr->request();
        header("location: /chat/@me?error=none&request=success");
    }

} else {
    // Invalid Request Redirection
    header("location: /chat/@me?error=invalid_request");
}