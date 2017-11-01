<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Categories';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php if(Yii::$app->session->hasFlash('error-extension')):?>
    <div class="alert alert-danger">
        <?php echo Yii::$app->session->getFlash('error-extension');?>
    </div>
<?php endif; ?>
<?php if(Yii::$app->session->hasFlash('success-move')):?>
    <div class="alert alert-success">
        <?php echo Yii::$app->session->getFlash('success-move');?>
    </div>
<?php endif; ?>
<?php if(Yii::$app->session->hasFlash('success-deleted')):?>
    <div class="alert alert-success">
        <?php echo Yii::$app->session->getFlash('success-deleted');?>
    </div>
<?php endif; ?>

<div class="category-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Category', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Create Image', ['/photo/admin/image/create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
                [
                  'attribute' => 'title',
                  'format' => 'raw',
                  'value' => function($model){
                    return Html::a($model->title,['view', 'id' => $model->id]);
                  },
                ],
            'count',
            'slug',
            // 'status',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}{delete}',
                'buttons' => [
                    'update' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                                    'title' => Yii::t('app', 'update'),
                        ]);
                    },
                    'delete' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                                    'title' => Yii::t('app', 'delete'),
                                    'data-method'=> 'post',
                        ]);
                    }
                ],
                'urlCreator' => function ($action, $model, $key, $index) {
                          if ($action === 'delete') {
                              $url = Url::toRoute(['confirm', 'id' => $key]);
                              return $url;
                      }
                      if ($action === 'update') {
                          $url = Url::toRoute(['update', 'id' => $key]);
                          return $url;
                  }
                      }
            ],
        ],
    ]);
    ?>
</div>
