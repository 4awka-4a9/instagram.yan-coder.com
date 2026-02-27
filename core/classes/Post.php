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
      echo '<article class="post">
            <div class="post__header">
               <div class="post__profile">
                <a href="' . url_for('profile/' . $post->username) . '" class="post__avatar">
                      <img src="' . url_for($post->profileImage) . '" alt="' . $post->fullName . '">
                </a>
                <a href="' . url_for('profile/' . $post->username) . '" class="post__user">
                   ' . $post->username . '
                </a>
               </div>
              ' . (($post->postedBy == $userid) ? ' <button  class="post__more-options deleteContainer" title="Post Delete" data-postid="' . $post->post_id . '" data-userid="' . $userid . '">
              <svg width="30" viewBox="0 0 24 24" aria-hidden="true" fill="rgb(244, 33, 46)">
                 <g>
                   <path d="M20.746 5.236h-3.75V4.25c0-1.24-1.01-2.25-2.25-2.25h-5.5c-1.24 0-2.25 1.01-2.25 2.25v.986h-3.75c-.414 0-.75.336-.75.75s.336.75.75.75h.368l1.583 13.262c.216 1.193 1.31 2.027 2.658 2.027h8.282c1.35 0 2.442-.834 2.664-2.072l1.577-13.217h.368c.414 0 .75-.336.75-.75s-.335-.75-.75-.75zM8.496 4.25c0-.413.337-.75.75-.75h5.5c.413 0 .75.337.75.75v.986h-7V4.25zm8.822 15.48c-.1.55-.664.795-1.18.795H7.854c-.517 0-1.083-.246-1.175-.75L5.126 6.735h13.74L17.32 19.732z"></path>
                   <path d="M10 17.75c.414 0 .75-.336.75-.75v-7c0-.414-.336-.75-.75-.75s-.75.336-.75.75v7c0 .414.336.75.75.75zm4 0c.414 0 .75-.336.75-.75v-7c0-.414-.336-.75-.75-.75s-.75.336-.75.75v7c0 .414.336.75.75.75z"></path>
                 </g>
               </svg>
          </button>' : '') . '
              
            </div>
            <div class="post__content">
                <div class="post__medias">
                  <img class="post__media" src="' . url_for($post->postImage) . '" alt="Post Content">
                </div>
              </div>
              <div class="post__footer">
                <div class="post__buttons">
                  <button class="post__button like-button" data-postid="' . $post->post_id . '">
                  <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M11.4995 21.2609C11.1062 21.2609 10.7307 21.1362 10.4133 20.9001C8.2588 19.3012 3.10938 15.3239 1.81755 12.9143C0.127895 9.76543 1.14258 5.72131 4.07489 3.89968C5.02253 3.31177 6.09533 3 7.18601 3C8.81755 3 10.3508 3.66808 11.4995 4.85726C12.6483 3.66808 14.1815 3 15.8131 3C16.9038 3 17.9766 3.31177 18.9242 3.89968C21.8565 5.72131 22.8712 9.76543 21.186 12.9143C19.8942 15.3239 14.7448 19.3012 12.5902 20.9001C12.2684 21.1362 11.8929 21.2609 11.4995 21.2609ZM7.18601 4.33616C6.34565 4.33616 5.5187 4.57667 4.78562 5.03096C2.43888 6.49183 1.63428 9.74316 2.99763 12.2819C4.19558 14.5177 9.58639 18.6242 11.209 19.8267C11.3789 19.9514 11.6158 19.9514 11.7856 19.8267C13.4082 18.6197 18.799 14.5133 19.997 12.2819C21.3603 9.74316 20.5557 6.48738 18.209 5.03096C17.4804 4.57667 16.6534 4.33616 15.8131 4.33616C14.3425 4.33616 12.9657 5.04878 12.0359 6.28696L11.4995 7.00848L10.9631 6.28696C10.0334 5.04878 8.6611 4.33616 7.18601 4.33616Z" fill="var(--text-dark)" stroke="var(--text-dark)" stroke-width="0.6"></path>
                </svg>
                  </button>
                  <button class="post__button comment-btn">
                    <svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                      <path fill-rule="evenodd" clip-rule="evenodd" d="M21.2959 20.8165L20.2351 16.8602C20.1743 16.6385 20.2047 16.3994 20.309 16.1907C21.2351 14.3342 21.5438 12.117 20.9742 9.80402C20.2003 6.67374 17.757 4.16081 14.6354 3.33042C13.7833 3.10869 12.9442 3 12.1312 3C6.29665 3 1.74035 8.47365 3.31418 14.5647C4.04458 17.3819 7.05314 20.2992 9.88344 20.9861C10.6486 21.173 11.4008 21.26 12.1312 21.26C13.7006 21.26 15.1701 20.8557 16.4614 20.1601C16.6049 20.0818 16.7657 20.0383 16.9222 20.0383C17.0005 20.0383 17.0787 20.047 17.157 20.0688L21.009 21.0991C21.0307 21.1035 21.0525 21.1078 21.0699 21.1078C21.2177 21.1078 21.3351 20.9687 21.2959 20.8165ZM19.0178 17.1863L19.6178 19.4253L17.4831 18.8558C17.3005 18.8079 17.1135 18.7819 16.9222 18.7819C16.557 18.7819 16.1875 18.8775 15.8571 19.0558C14.6963 19.6818 13.4441 19.9992 12.1312 19.9992C11.4834 19.9992 10.8269 19.9166 10.1791 19.7601C7.78354 19.1775 5.14453 16.6037 4.53586 14.2473C3.90111 11.7865 4.40109 9.26057 5.90536 7.31719C7.40964 5.3738 9.6791 4.26081 12.1312 4.26081C12.8529 4.26081 13.5876 4.35646 14.3137 4.5521C16.9961 5.26511 19.0786 7.39544 19.7525 10.1084C20.2264 12.0213 20.0308 13.9299 19.183 15.6298C18.9395 16.1168 18.8787 16.6689 19.0178 17.1863Z" fill="var(--text-dark)" stroke="var(--text-dark)" stroke-width="0.7"></path>
                    </svg>
                  </button>
                  <button class="post__button ">
                    <svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                      <path fill-rule="evenodd" clip-rule="evenodd" d="M22.8555 3.44542C22.6978 3.16703 22.3962 3 22.0714 3L2.91369 3.01392C2.52859 3.01392 2.19453 3.25055 2.05997 3.60781C1.96254 3.86764 1.98574 4.14603 2.11565 4.37338C2.16669 4.45689 2.23165 4.53577 2.31052 4.60537L9.69243 10.9712L11.4927 20.5338C11.5623 20.9096 11.8499 21.188 12.2304 21.2483C12.6062 21.3086 12.9774 21.1323 13.1723 20.8029L22.8509 4.35018C23.0179 4.06715 23.0179 3.72381 22.8555 3.44542ZM4.21748 4.39194H19.8164L10.4255 9.75089L4.21748 4.39194ZM12.6248 18.9841L11.1122 10.948L20.5171 5.58436L12.6248 18.9841Z" fill="var(--text-dark)" stroke="var(--text-dark)" stroke-width="0.3"></path>
                    </svg>
                  </button>
    
                  <button class="post__button post__button--align-right bkmrk" data-postid="' . $post->post_id . '" id="bkmrk">
                  <svg aria-label="Save" class="_ab6-" color="#262626" fill="#262626" height="24" role="img" viewBox="0 0 24 24" width="24"><polygon fill="none" points="20 21 12 13.44 4 21 4 3 20 3 20 21" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></polygon></svg>
                   
                  </button>
                </div>
                <div class="post__infos">
                <div class="post__likes"> 
                      Be first to like this
                </div>
                <span class="comment-lists cursor-pointer"  data-postid="' . $post->post_id . '" data-userid="' . $userid . '" data-postedby="' . $post->postedBy . '">
                
                </span>
                <span class="post__date-time">' . $this->timeAgoForPost($post->postedOn) . '</span>
                
              </div>
                <form class="postForm">
                    <span class="cursor-pointer">
                      <svg aria-label="Emoji" color="#262626" fill="#262626" height="24" role="img" viewBox="0 0 24 24" width="24"><path d="M15.83 10.997a1.167 1.167 0 101.167 1.167 1.167 1.167 0 00-1.167-1.167zm-6.5 1.167a1.167 1.167 0 10-1.166 1.167 1.167 1.167 0 001.166-1.167zm5.163 3.24a3.406 3.406 0 01-4.982.007 1 1 0 10-1.557 1.256 5.397 5.397 0 008.09 0 1 1 0 00-1.55-1.263zM12 .503a11.5 11.5 0 1011.5 11.5A11.513 11.513 0 0012 .503zm0 21a9.5 9.5 0 119.5-9.5 9.51 9.51 0 01-9.5 9.5z"></path></svg>
                    </span>
                    <input class="flex-auto p-1 ml-10 text-sm outline-none border-none bg-transparent comment" type="text" placeholder="Add a comment...">
                    <button type="submit" class="text-sm font-semibold cursor-pointer text-primary-blue comment-save" data-postid="' . $post->post_id . '" data-userid="' . $userid . '">Post</button>
                  </form>
              </div>
        </article>';
    }
  }

  public function createComment($comment, $commentOn, $commentBy)
  {
    $datetime = date('Y-m-d H:i:s');


    $stmt = $this->pdo->prepare("INSERT INTO comment (commentBy,commentOn,comment,commentAt) VALUES (:commentBy,:commentOn,:comment,:commentAt)");
    $stmt->bindParam(':commentBy', $commentBy);
    $stmt->bindParam(':comment', $comment);
    $stmt->bindParam(':commentOn', $commentOn);
    $stmt->bindParam(":commentAt", $datetime);

    $stmt->execute();

    return $this->pdo->lastInsertId();
  }

  public function timeAgoForPost($time_ago)
  {
    $time_ago = strtotime($time_ago) ? strtotime($time_ago) : $time_ago;
    $time = time() - $time_ago;

    switch ($time):
      // seconds
      case $time <= 60;
        return ($time == 1) ? "Just now" : $time . " secs ago";
      // minutes
      case $time >= 60 && $time < 3600;
        return (round($time / 60) == 1) ? '1 min' : round($time / 60) . ' minutes ago';
      // hours
      case $time >= 3600 && $time < 86400;
        return (round($time / 3600) == 1) ? '1 hour' : round($time / 3600) . ' hours ago';
      // days
      case $time >= 86400 && $time < 604800;
        return (round($time / 86400) == 1) ? '1 day' : round($time / 86400) . ' days ago';
      // weeks
      case $time >= 604800 && $time < 2600640;
        return (round($time / 604800) == 1) ? '1 week' : round($time / 604800) . ' weeks';
      // months
      case $time >= 2600640 && $time < 31207680;
        return (round($time / 2600640) == 1) ? '1 month' : round($time / 2600640) . ' months';
      // years
      case $time >= 31207680;
        return (round($time / 31207680) == 1) ? '1 year' : round($time / 31207680) . ' years';

    endswitch;
  }
}