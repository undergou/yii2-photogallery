<?php
use yii\web\NotFoundHttpException;
 ?>
<div class="wrapper">
    <?php if($category): ?>

    <h1>Category: <?= $category->title?> </h1>
<div class="shadow" onclick="showFullImage('none')"></div>

    <div id="category-wrap-image">
<?php foreach ($images as $image): ?>
    <div class="image-in-category">
        <img class="small-image" src=" <?= '/'. $image->getPathImage($image->id) ?>"  width="220px" alt="<?= $image->title?>" onclick="showFullImage('block', this)">
    </div>
<?php endforeach; ?>
</div>
    <div id="fullimage-title"></div>
    <img id="arrow-left" src="<?= '/'.$category->getFolder(). 'arrow-left.png' ?>">
    <img id="arrow-right" src="<?= '/'.$category->getFolder(). 'arrow-right.png' ?>">
    <img id="fileclose" src="<?= '/'.$category->getFolder(). 'closefile.png' ?>" onclick="showFullImage('none')">
    <img id="fullImg" alt="">

    <div class="wrap-for-link-images">
        <a href="#" class="link-show-more-images">Show-more...</a>
    </div>
    <img id="waiting-img" src="../../images/photogallery/wait.gif" alt="">
    <p id="user-status"><?php echo $userStatus; ?></p>
        <p id="category-title-hidden"><?= $category->title?> </p>
<?php else: ?>
    <? throw new NotFoundHttpException('Page not found');?>
<?php endif; ?>
</div>

