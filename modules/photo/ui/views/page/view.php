<?php

use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\web\NotFoundHttpException;

?>

<div class="wrapper">
    <h1>Fantastic Photogallery!</h1>
    <div class="wrap-for-link-back">
    <?php if ($offsetBack>=0): ?>
            <a class="link-show-more-back">Show previous categories</a>
    <?php endif; ?>
    </div>
    <div id="category-wrap">
        <?php if ($categories): ?>

            <?php foreach ($categories as $category): ?>

                    <div class="category category-masonry">
                        <a href="<?= Url::toRoute(['page/category', 'slug' => $category->slug]); ?>">
                            <img class="small-image"
                                 src="<?= ($category->getNumberOnStatus($category->slug) != 0) ? $category->getFolder() . $category->getImagesOnStatus($category->slug)[$category->getNumberOnStatus($category->slug) - 1]->getImage($category->getImagesOnStatus($category->slug)[$category->getNumberOnStatus($category->slug) - 1]->id) : $category->getFolder() . 'no-photo.jpg' ?>"
                                 width="220px" height alt="">
                            <div class="category-title">
                                <?= $category->title ?> (<?= $category->getNumberOnStatus($category->slug) ?>)
                            </div>
                        </a>
                    </div>

            <?php endforeach; ?>
        <?php else: ?>
            <? throw new NotFoundHttpException('Page not found'); ?>
        <?php endif; ?>
    </div>

    <div class="wrap-for-link">
        <a href="#" class="link-show-more">Show-more...</a>
    </div>
    <img id="waiting-img" src="<?= $category->getFolder() . 'wait.gif' ?>" alt="">
    <p id="user-status"><?php echo $userStatus; ?></p>
    <p id="offset"><?= $newOffset ?></p>
    <p id="offset-back"><?= $offsetBack ?></p>
    <p id="pages-number"><?= $pagesNumber ?></p>
</div>
