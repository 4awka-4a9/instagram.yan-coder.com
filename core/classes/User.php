<?php

class User
{

    private $pdo;

    public function __construct()
    {
        $this->pdo = Database::connect();
    }

    public function getUserDataFromSession()
    {

        if (isset($_SESSION['user_id'])) {
            $userid = $_SESSION['user_id'];
            $stmt = $this->pdo->prepare("SELECT * FROM users WHERE user_id = :USER_ID");
            $stmt->bindParam(":USER_ID", $userid);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_OBJ);
        }

    }

    public function search($search)
    {

        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE `username` LIKE ? OR `fullname` LIKE ? OR `email` LIKE ?");

        $stmt->bindValue(1, $search . "%", PDO::PARAM_STR);
        $stmt->bindValue(2, $search . "%", PDO::PARAM_STR);
        $stmt->bindValue(3, $search . "%", PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_OBJ);

    }

    public function generate_filename($length)
    {

        $array = array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
        $text = "";

        for ($x = 0; $x < $length; $x++) {

            $random = rand(0, 61);
            $text .= $array[$random];
        }

        return $text;
    }

    public function getDetails($get_id, $what)
    {

        $stmt = $this->pdo->prepare("SELECT $what FROM users WHERE user_id = :USER_ID");
        $stmt->bindParam(":USER_ID", $get_id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_OBJ);

        return $row->$what;

    }

    public function uploadStory($file, $userid)
    {

        $fileInfo = getimagesize($file['tmp_name']);
        $fileName = $file['name'];
        $fileTmp = $file['tmp_name'];
        $fileSize = $file['size'];
        $errors = $file['error'];

        $ext = explode('.', $fileName);
        $ext = strtolower(end($ext));

        $allowed = array("image/png", "image/jpeg", "image/jpg", "image/webp");

        if (in_array($fileInfo['mime'], $allowed)) {

            $path_directory = $_SERVER['DOCUMENT_ROOT'] . "/instagram.yan-coder.com/media/stories/" . $userid;

            if (!file_exists($path_directory)) {
                mkdir($path_directory, 0777, true);
            }

            $folder = "media/stories/" . $userid . "/" . $this->generate_filename(15). ".jpg";
            $file = $_SERVER['DOCUMENT_ROOT'] . "/instagram.yan-coder.com/" . $folder;

            if ($errors === 0) {

                move_uploaded_file($fileTmp, $file);
                return $folder;

            }

        }

    }

    public function createStory($userid, $image) {

        $datetime = date('Y-m-d  H:i:s');

        $stmt = $this->pdo->prepare("INSERT INTO stories (user_id, story_img, createdAt) VALUES (:userid, :story, :createdAt)");
        $stmt->bindParam(':userid', $userid, PDO::PARAM_INT);
        $stmt->bindParam(':story', $image, PDO::PARAM_STR);
        $stmt->bindParam(':createdAt', $datetime);

        $stmt->execute();

        return $this->pdo->lastInsertId();

    }

    public function checkStoryExist($userid)
    {
        $stmt = $this->pdo->prepare('SELECT * from stories WHERE user_id=:userid AND createdAt >=now() - INTERVAL 1 DAY');
        $stmt->bindParam(":userid", $userid, PDO::PARAM_INT);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function statusData($userid)
    {
        $stmt = $this->pdo->prepare('SELECT * from stories s LEFT JOIN users u ON s.user_id=u.user_id WHERE s.user_id=:userid AND createdAt >=now() - INTERVAL 1 DAY ORDER BY story_id DESC');
        $stmt->bindParam(":userid", $userid, PDO::PARAM_INT);
        $stmt->execute();
        $statusData = $stmt->fetchAll(PDO::FETCH_OBJ);
        if ($stmt->rowCount() > 0) {
            foreach ($statusData as $user) {
                echo '<img src="' . url_for($user->story_img) . '" alt="Story of ' . $user->fullName . '">';
            }
        }
    }

}