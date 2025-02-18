<?php

include_once "dbh.class.php";

class Friend extends DBH {
    protected function requestFriend($id, $friend_id) {
        // INSERT INTO friends (user_id, friend_id, status) VALUES (1, 2, 'pending');
        $sql = "INSERT INTO friends (user_id, friend_id) VALUES (?, ?);";
        $stmt = $this->connect()->prepare($sql);

        if (!$stmt->execute([$id, $friend_id])) {
            $stmt = null;
            header("location: ?error=stmt_failed");
            exit();
        }

        $stmt = null;
    }

    protected function getFriendRequests(int $id) {
        // SELECT * FROM friends WHERE friend_id = 1 AND status = 'pending';
        $sql = "SELECT * FROM friends WHERE friend_id = ? AND status = 'pending';";
        $stmt = $this->connect()->prepare($sql);

        if (!$stmt->execute([$id])) {
            $stmt = null;
            header("location: ?error=stmt_failed");
            exit();
        }
        
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt = null;
        return $result;
    }
}