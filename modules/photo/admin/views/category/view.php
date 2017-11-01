<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Category */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['confirm', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('Create Image', ['/photo/admin/image/create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
            'image',
            'status',

            [
          'class' => 'yii\grid\ActionColumn',
          'header' => 'Actions',
          'template' => '{view}{update}{delete}',
          'buttons' => [
            'view' => function ($url, $model) {
                $newUrl = str_replace('/category', '/image', $url);
                return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $newUrl, [
                            'title' => Yii::t('app', 'view'),
                ]);
            },

            'update' => function ($url, $model) {
                $newUrl = str_replace('/category', '/image', $url);
                return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $newUrl, [
                            'title' => Yii::t('app', 'update'),
                ]);
            },
            'delete' => function ($url, $model) {
                $newUrl = str_replace('/category', '/image', $url);
                return Html::a('<span class="glyphicon glyphicon-trash"></span>', $newUrl, [
                            'title' => Yii::t('app', 'delete'),
                            'data-method'=> 'post',
                            'data-confirm'=>'Are you sure you want to delete this item?',
                ]);
            }

          ],
          ],
        ],
    ]); ?>


</div>
