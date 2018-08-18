<?php

/* @var $this yii\web\View */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use app\models\helpers\DataHelper;
use kartik\date\DatePicker;
use yii\helpers\Url;

$this->title = 'My Yii Application';
$script = <<< JS
function changeFavorite(idActivity, obj){
					if(!obj.hasClass("red")){
					    obj.addClass("red");
					}else{
					    obj.removeClass("red");
					}

					$.ajax({
						type: "GET",
						url: "/web/favorit/change?id="+ idActivity,
					}).done(function( msg ) {

					});
}
function toggleLPanel(id){
            $("div[id*='left_panel_id_']:not([id='left_panel_id_"+id+"'])").toggle("slow");
            $("#right_panel_id_"+id).toggle("slow");

        }
JS;
$this->registerJs($script, yii\web\View::POS_END);

?>

<style>
    .red{
        color: red;
    }
    </style>
<div class="site-index">

    <div class="jumbotron">
        <img src="https://www.gazeta-unp.ru/images/news_inside/mrot-v-ryazanskoy-oblasti-s-1-maya-2018-goda.jpg">
        <h2>Праздники и фестивали в рязанской области</h2>

        <p class="lead">Праздники и фестивали в рязанской области</p>

        <p><a class="btn btn-lg btn-success" href="http://www.yiiframework.com">Get started with Yii</a></p>
    </div>

    <div class="body-content">


        <?php $form = ActiveForm::begin([
            'action' => ['index'],
            'method' => 'get',
        ]); ?>


        <div class="row">
            <div class="col-md-3">
                <?php echo $form->field($searchModel, 'monthSearch')->dropDownList([
                    '01' => 'Январь',
                    '02' => 'Февраль',
                    '03' => 'Март',
                    '04' => 'Апрель',
                    '05' => 'Май',
                    '06' => 'Июнь',
                    '07' => 'Июль',
                    '08' => 'Август',
                    '09' => 'Сентябрь',
                    '10' => 'Октябрь',
                    '11' => 'Ноябрь',
                    '12' => 'Декабрь'
                ],['prompt' => 'Выберите месяц...'])->label(false); ?>
            </div>
            <div class="col-md-3">
                <?php echo $form->field($searchModel, 'placeSearch')->dropDownList([
                    1 => 'Рязанская область',
                ],['prompt' => 'Выберите место...'])->label(false); ?>
            </div>
            <div class="col-md-6">
                <?= Html::submitButton('<i class="glyphicon glyphicon-refresh"></i> Применить', ['class' => 'btn btn-primary']) ?>
                <?= Html::a(' Избранное', ['site/index?SearchActivity%5BisFaforite%5D=1'], ['class' => 'btn btn-danger glyphicon glyphicon-heart', 'role' => 'button']);?>

            </div>
        </div>
        <?php ActiveForm::end(); ?>
        <br>



        <div class="row row-flex">
        <?php
        /**
         * @var $activity \app\models\Activity
         */
        foreach($dataProvider->models as $activity):?>
            <div id="left_panel_id_<?= $activity->id;?>" class="col-sm-4 col-xs-12 col-md-3 col-lg-3">
                <div class="thumbnail" style="background: <?= $activity->getColor();?>;">
                    <div class="image"><img data-src="holder.js/100%x200" alt="<?= $activity->title;?>" src="<?= $activity->getPictureUrl();?>" data-holder-rendered="true" style="height: 200px; width: 100%; display: block;"></div>
                    <div class="caption">
                        <?php if(!empty($activity->mark)):?>
                            <div class="thumbnail_mark"><?= $activity->mark;?></div>
                        <?php endif;?>
                        <div class="thumbnail_favorite"><a href="<?= Url::to(['activity/update', 'id' => $activity->id]);?>" class="btn btn-default btn-circle glyphicon glyphicon-pencil" role="button"></a><a onClick="changeFavorite(<?= $activity->id;?>,$(this))" class="btn btn-default btn-circle glyphicon glyphicon-heart <?= $activity->isFavorite?'red':'';?>" role="button"></a></div>
                        <h4><?= $activity->title;?></h4>
                        <div class="thumbnail_adress"><?= $activity->adress->title;?></div>
                    </div>
                    <div class="thumbnail_footer"><p><span class="thumbnail_date"><?= DataHelper::renderDate($activity->date_start,$activity->date_end);?></span><a onclick="toggleLPanel(<?= $activity->id;?>)" class="btn btn-default btn-circle pull-right glyphicon glyphicon-play" role="button"></a></div>
                </div>
            </div>

            <div id="right_panel_id_<?= $activity->id;?>" class="col-sm-8 col-xs-12 col-md-9 col-lg-9 thumbnail_description" style="display: none;">
                <!-- <div class="thumbnail_close_right_panel pull-right"><span class="close" aria-hidden="true">x</span></div> -->
                <button type="button" onclick="toggleLPanel(<?= $activity->id;?>)" class="close close_btn" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><?= $activity->title;?></h4>
                <p><?= $activity->description;?></p>
            </div>
        <?php endforeach;?>
        </div>



    </div>
</div>

