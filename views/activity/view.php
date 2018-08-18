<?php

use app\models\helpers\DataHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Activity */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Activities', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$script = <<< JS
    $(document).ready(function(){
        $(".close_btn").click(function(){
            $("#right_panel").toggle("slow");
        });
    });
JS;
$this->registerJs($script, yii\web\View::POS_END);
?>
<div class="activity-view">

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
    </p>

    <div class="row row-flex">
        <?php
        /**
         * @var $activity \app\models\Activity
         */
        $activity = $model; ?>
            <div class="col-sm-4 col-xs-12 col-md-3 col-lg-3">
                <div class="thumbnail" style="background: <?= $activity->color;?>;">
                    <div class="image"><img data-src="holder.js/100%x200" alt="<?= $activity->title;?>" src="<?= $activity->getPictureUrl();?>" data-holder-rendered="true" style="height: 200px; width: 100%; display: block;"></div>
                    <div class="caption" style="background: <?= $activity->color;?>;">
                        <?php if(!empty($activity->mark)):?>
                            <div class="thumbnail_mark"><?= $activity->mark;?></div>
                        <?php endif;?>
                        <div class="thumbnail_favorite"><a class="btn btn-default btn-circle glyphicon glyphicon-heart" role="button"></a></div>
                        <h4><?= $activity->title;?></h4>
                        <div class="thumbnail_adress"><?= $activity->adress->title;?></div>
                    </div>
                    <div class="thumbnail_footer"><p><span class="thumbnail_date"><?= DataHelper::renderDate($activity->date_start,$activity->date_end);?></span><a class="btn btn-default btn-circle pull-right glyphicon glyphicon-play close_btn" role="button"></a></div>
                </div>
            </div>

            <div id="right_panel" class="col-sm-8 col-xs-12 col-md-9 col-lg-9 thumbnail_description" style="display: none;">
            <!-- <div class="thumbnail_close_right_panel pull-right"><span class="close" aria-hidden="true">x</span></div> -->
                <button type="button" class="close close_btn" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><?= $activity->title;?></h4>
                <p><?= $activity->description;?></p>
            </div>

    </div>

</div>
