<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SearchActivity */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="activity-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'description') ?>

    <?= $form->field($model, 'status_id') ?>

    <?= $form->field($model, 'adress_id') ?>

    <?php // echo $form->field($model, 'mark') ?>

    <?php // echo $form->field($model, 'color') ?>

    <?php // echo $form->field($model, 'picture_url') ?>

    <?php // echo $form->field($model, 'look_counter') ?>

    <?php // echo $form->field($model, 'owner_user_id') ?>

    <?php // echo $form->field($model, 'creator_user_id') ?>

    <?php // echo $form->field($model, 'modyfy_user_id') ?>

    <?php // echo $form->field($model, 'date_start') ?>

    <?php // echo $form->field($model, 'date_end') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
