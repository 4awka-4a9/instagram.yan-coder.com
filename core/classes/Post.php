<?php
class Post
{
  private $pdo, $user;

  public function __construct()
  {
    $this->pdo = Database::connect();
    $this->user = new User();
  }

  public function createPosts($userid, $image, $post)
  {
    $datetime = date('Y-m-d H:i:s');

    $stmt = $this->pdo->prepare("INSERT INTO posts (postedBy,post,postImage,postedOn) VALUES (:userid,:post,:image,:postedOn)");
    $stmt->bindParam(':userid', $userid, PDO::PARAM_INT);
    $stmt->bindParam(':post', $post);
    $stmt->bindParam(':image', $image);
    $stmt->bindParam(":postedOn", $datetime);

    $stmt->execute();

    return $this->pdo->lastInsertId();
  }

  public function postCount($userid)
  {
    $query = $this->pdo->prepare("SELECT post_id FROM posts WHERE postedBy=:userid");
    $query->execute(array(":userid" => $userid));
    $count = $query->rowCount();
    return $count;
  }
  
  public function posts($userid, $num)
  {
    $stmt = $this->pdo->prepare("SELECT * FROM posts p LEFT JOIN users u ON p.postedBy=u.user_id WHERE p.postedBy=:userid UNION SELECT * FROM posts p LEFT JOIN users u ON p.postedBy=u.user_id WHERE p.postedBy IN (SELECT follow.receiver FROM follow WHERE follow.sender=:userid) ORDER BY postedON DESC LIMIT :num");
    $stmt->bindParam(":userid", $userid, PDO::PARAM_INT);
    $stmt->bindParam(":num", $num, PDO::PARAM_INT);
    $stmt->execute();
    $posts = $stmt->fetchAll(PDO::FETCH_OBJ);
    foreach ($posts as $post) {
        echo $post->username;
    }
  }
}