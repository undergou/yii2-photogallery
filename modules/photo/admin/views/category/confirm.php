<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<div class="article-index">

    <h1>What to do with images of this category?</h1>
    <?= Html::button('Move to another category', ['class' => 'btn btn-success', 'id' => 'move-images']) ?>
    <?= Html::a('Delete all images with category', ['delete', 'id' => $model->id], [
        'class' => 'btn btn-danger',
        'data' => [
            'confirm' => 'Are you sure you want to delete this category with all images?',
            'method' => 'post',
        ],
    ]) ?>
    <br><br>

    <div id="form-to-move" style="display:none">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'title')->dropDownList($categories, ['id'=>'list']) ?>
        <div class="form-group">
            <?= Html::submitButton('Move', ['class' =>'btn btn-success']) ?>
        </div>
    <?php ActiveForm::end(); ?>
    </div>
    </div>
