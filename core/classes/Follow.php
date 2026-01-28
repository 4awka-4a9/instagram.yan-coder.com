<?php

class Follow
{

    private $pdo;

    public function __construct()
    {
        $this->pdo = Database::connect();
    }

    public function whoToFollow($user_id)
    {

        $stmt = $this->pdo->prepare(
            "SELECT * FROM usera 
            WHERE user_id != :user_id AND 
            `user_id` NOT IN 
            (SELECT `receiver` FROM follow 
            WHERE sender = :user_id) 
            ORDER BY rand() LIMIT 5"
            );
        $stmt -> bindParam(":user_id", $user_id, PDO::PARAM_INT);
        $stmt -> execute();
        $data = $stmt -> fetchAll(PDO::FETCH_OBJ);

        if (empty($data)) {

            foreach($data as $user) {
                echo '<div class="side-menu__suggestion">

                        <a href="'.url_for('profile/' . $user->username).'"
                            class="user-avatar">
                            <img src="'.url_for($user->profileImage).'"
                                alt="Photo Of '.$user->fullName.'">
                        </a>

                        <div class="side-menu__suggestion-info">

                            <a href="'. url_for('profile/' . $user->username).'" target="_blank"
                                clas="side-menu__user-avatar">
                                '.$user->username.'
                            </a>

                        </div>

                        <button class="side-menu__suggestion-button follow-btn follwo">Follow</button>

                    </div>';
            }

        }

    }

}
;