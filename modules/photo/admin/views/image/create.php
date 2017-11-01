<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Image */

$this->title = 'Create Image';
$this->params['breadcrumbs'][] = ['label' => 'Categories', 'url' => ['/photo/admin/category']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?php if(Yii::$app->session->hasFlash('error-null')):?>
    <div class="alert alert-danger">
        <?php echo Yii::$app->session->getFlash('error-null');?>
    </div>
<?php endif; ?>
<div class="image-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'categories' => $categories,
        'watermarks' => $watermarks,
        'status' => $status,
    ]) ?>

</div>
