<?php

class Follow
{

    private $pdo;
    private $user;

    public function __construct()
    {
        $this->pdo = Database::connect();
    }

    public function whoToFollow($user_id)
    {

        $stmt = $this->pdo->prepare(
            "SELECT * FROM users 
            WHERE user_id != :user_id AND 
            `user_id` NOT IN 
            (SELECT `receiver` FROM follow 
            WHERE sender = :user_id) 
            ORDER BY rand() LIMIT 5"
        );
        $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_OBJ);

        if (!empty($data)) {

            foreach ($data as $user) {
                echo '<div class="side-menu__suggestion">

                        <a href="' . url_for('profile/' . $user->username) . '"
                            class="user-avatar">
                            <img src="' . url_for($user->profileImage) . '"
                                alt="Photo Of ' . $user->fullName . '">
                        </a>

                        <div class="side-menu__suggestion-info">

                            <a href="' . url_for('profile/' . $user->username) . '" target="_blank"
                                class="side-menu__user-avatar">
                                ' . $user->username . '
                            </a> 

                            <span>'.$this->peopleMightKnow($user->user_id).'</span>

                        </div>

                        <button class="side-menu__suggestion-button follow-btn follwo" data-follow="' . $user->user_id . '" data-userid="' . $user_id . '">Follow</button>

                    </div>';
            }

        }

    }

    public function isFollowing($get)
    {

        if (isset($_SESSION['user_id'])) {

            $user_id = $_SESSION['user_id'];
            $stmt = $this->pdo->prepare("SELECT receiver FROM follow WHERE sender = :user_id AND receiver = :get LIMIT 1");
            $stmt->execute(array(":userid" => $user_id, ":get" => $get));

            if ($stmt->rowCount() != 0 || $stmt->rowCount() != null) {
                return true;
            } else if ($stmt->rowCount() === 0) {
                return false;
            }

        }

    }

    public function follow($otherid)
    {

        $user_id = $_SESSION['user_id'];

        if ($this->isFollowing($otherid) == false) {

            $stmt = $this->pdo->prepare("INSERT INTO follow (sender, receiver, status, followOn) VALUES (:sender, :receiver, :status, now())");
            $stmt->execute(array(":sender" => $user_id, ":receiver" => $otherid, ":status" => 1));

            return "ok";

        }

    }

    public function unfollow($otherid)
    {

        $user_id = $_SESSION['user_id'];

        if ($this->isFollowing($otherid)) {

            $stmt = $this->pdo->prepare("DELETE FROM follow WHERE sender  = :sender AND receiver = :receiver LIMIT 1");
            $stmt->execute(array(":sender" => $user_id, ":receiver" => $otherid));

        }

    }

    public function peopleMightKnow($otherid)
    {

        if (isset($_SESSION['user_id'])) {
            
            $user_id = $_SESSION['user_id'];
            $this->user = new User();
            $first = array();
            $second = array();
            $third = array();
            $fourth = array();
            $final = array();

            $stmt = $this->pdo->prepare("SELECT sender FROM follow WHERE receiver = :otherid");
            $stmt->execute(array(":otherid" => $otherid));

            while($row = $stmt->fetch(PDO::FETCH_OBJ)) {

                $first[] = $row->sender;

            }

            $mine = $this->pdo->prepare("SELECT receiver FROM follow WHERE receiver = :sender");
            $mine->execute(array(":sender" => $user_id));

            while($row = $mine->fetch(PDO::FETCH_OBJ)) {

                $second[] = $row->receiver;

            }

            $other = $this->pdo->prepare("SELECT sender FROM follow WHERE receiver = :me");
            $other->execute(array(":me" => $otherid));

            while($row = $other->fetch(PDO::FETCH_OBJ)) {

                $third[] = $row->sender;

            }

            foreach($first as $key => $value) {

                if (in_array($value, $second)) {
                    $final[] = $value;
                }

            }

            $other = array_reverse($final);

            foreach($other as $key => $value) {
                
                array_unshift($fourth, $value);

            }

            $count = count($final);

            if ($count == 0) {

                if (count($third) != 0) {

                    if ($third[0] == $other) {
                        return("Follows you");
                    }

                }

            }
            else if ($count == 1) {
                return "Followed by ".nameShortener($this->user->getDetails($fourth[0], "username"), 20);
            }

        }

    }

}