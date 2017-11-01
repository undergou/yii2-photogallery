<?php
    $pdo = new PDO("mysql:host=localhost;dbname=photo", "photo", "p0o9i8u7y6");

    $offset = $_POST['offset'];
    $userStatus = $_POST['userStatus'];
    $categoryTitle = $_POST['categoryTitle'];
switch($userStatus){
    case 'admin':
    $sql = "SELECT * FROM image WHERE category='".$categoryTitle."' LIMIT 2 OFFSET ". $offset;
    break;
    case 'guest':
    $sql = "SELECT * FROM image WHERE status='guest' AND category='".$categoryTitle."' LIMIT 2 OFFSET ". $offset;
    break;
    case 'user':
    $sql = "SELECT * FROM image WHERE category='".$categoryTitle."' AND status='guest' OR status='user' LIMIT 2 OFFSET ". $offset;
    break;
}

    $images = $pdo->query("$sql");
    $i = 0;

    foreach($images as $image) {

        echo '<div class="image-in-category"><img class="small-image" alt="'.$image['title'].'" src="/images/photogallery/'. $image['id'] .$image['extension'] .'" width="220px" onclick="showFullImage(\'block\', this)"></div>';
        $i++;
    }
    if($i==0){
        echo '1';
    }

 ?>
