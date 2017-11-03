<?php
use yii\helpers\Url;
use yii\widgets\LinkPager;
 ?>

<div class="wrapper">
    <h1>Fantastic Photogallery!</h1>

    <div id="category-wrap">
        <?php foreach ($categories as $category): ?>
            <div class="category category-masonry">
                <a href="<?= Url::toRoute(['page/category', 'slug'=>$category->slug]); ?>">
                 <img class="small-image" src="<?= ($category->getNumberOnStatus($category->slug) != 0) ? $category->getFolder(). $category->getImagesOnStatus($category->slug)[$category->getNumberOnStatus($category->slug)-1]->getImage($category->getImagesOnStatus($category->slug)[$category->getNumberOnStatus($category->slug)-1]->id) : $category->getFolder().'no-photo.jpg' ?>"  width="220px" height alt="">
                <div class="category-title">
                    <?= $category->title ?> (<?= $category->getNumberOnStatus($category->slug) ?>)
                </div>
                </a>
            </div>

        <?php endforeach; ?>
    </div>
    <ul id="pagination-ul">
        <?php for($i=1; $i<=$pagesNumber; $i++): ?>
        <li><a class="hidden-link" href="<?= Url::toRoute(['/photo/ui/page/view', 'id'=>$i]); ?>">View</a></li>
        <?php endfor; ?>
    </ul>
    <div class="wrap-for-link">
        <a href="#" class="link-show-more">Show-more...</a>
    </div>
    <img id="waiting-img" src="<?= $category->getFolder(). 'wait.gif' ?>" alt="">
    <p id="user-status"><?php echo $userStatus; ?></p>
    <p id="offset">6</p>
    <p id="pages-number"><?= $pagesNumber ?></p>
</div>
