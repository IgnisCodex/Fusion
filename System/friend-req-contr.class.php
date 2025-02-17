<?php

include "friend.class.php";

class FriendRequestController extends Friend {
    private $mID;
    private $mFriendID;

    // (from, to)
    public function __construct(int $id, ?int $friendID = null) {
        $this->mID = $id;
        $this->mFriendID = $friendID;
    }

    public function request() {
        $this->requestFriend($this->mID, $this->mFriendID);
    }

    public function get() {
        return $this->getFriendRequests($this->mID);
    }

    // public function remove() {
    //     $this->removeFriend($this->mID, $this->mFriendID);
    // }

    // Error Handlers
}