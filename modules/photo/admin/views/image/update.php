<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Image */

$this->title = 'Update Image: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Categories', 'url' => ['/photo/admin/category/']];
$this->params['breadcrumbs'][] = ['label' => $category['title'], 'url' => ['category/view', 'id' => $category['id']]];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="image-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form_update', [
        'model' => $model,
        'categories' => $categories,
        'status' => $status,
    ]) ?>

</div>
