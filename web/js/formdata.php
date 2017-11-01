<?php
    $pdo = new PDO("mysql:host=localhost;dbname=photo", "photo", "p0o9i8u7y6");

    $offset = $_POST['offset'];
    $userStatus = $_POST['userStatus'];
switch($userStatus){
    case 'admin':
    $sql = "SELECT * FROM category LIMIT 6 OFFSET ". $offset;
    break;
    case 'guest':
    $sql = "SELECT * FROM category WHERE status='guest' LIMIT 6 OFFSET ". $offset;
    break;
    case 'user':
    $sql = "SELECT * FROM category WHERE status='guest' OR status='user' LIMIT 6 OFFSET ". $offset;
    break;
}

    class Data{
        public $img;
        public $link;
        public $title;
        public $end;
    }

    $categories = $pdo->query("$sql");
    $i = 0;
    $array = array();
    foreach($categories as $category) {

        $lastImageSql = "SELECT * FROM image WHERE category='".$category["title"]."' ORDER BY id DESC LIMIT 1";
        $lastImage = $pdo->query("$lastImageSql")->fetchAll();

        $object = new Data();
        $object->img = '<img class="small-image" src="images/photogallery/'. (($category['count'] != 0) ? $lastImage[0]['id'].$lastImage[0]['extension'] : 'no-photo.jpg').'" width="220px" height>';
        $object->link = '<a href="page/category/'.$category['slug'].'">';
        $object->title = '<div class="category-title">'.$category["title"].' ('.$category["count"].')</div>';
        // $resp = '<div class="category"><a href="page/category/'.$category['slug'].'"><img src="images/photogallery/'. (($category['count'] != 0) ? $lastImage[0]['image'] : 'no-photo.jpg').'" width="220px">
        // <div class="category-title">'.$category["title"].' ('.$category["count"].')</div></a></div>';
        array_push($array, $object);
        $i++;
    }

    if($i==0){
        $object = new Data();
        $object->end = 1;
        array_push($array, $object);
    }
    echo json_encode($array);

 ?>
