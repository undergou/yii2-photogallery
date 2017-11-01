<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Image */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Categories', 'url' => ['/photo/admin/category/']];
$this->params['breadcrumbs'][] = ['label' => $category['title'], 'url' => ['category/view', 'id' => $category['id']]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="image-view">
    <?php if(Yii::$app->session->hasFlash('success')):?>
        <div class="alert alert-success">
            <?php echo Yii::$app->session->getFlash('success');?>
        </div>
    <?php endif; ?>

    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('Create new image', ['/photo/admin/image/create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'author',
            'category',
            'title',
            'date',
            'status',
        ],
    ]) ?>

</div>
