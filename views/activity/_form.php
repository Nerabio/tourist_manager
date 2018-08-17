<?php

use app\models\helpers\DataHelper;
use app\models\User;
use kartik\widgets\ColorInput;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use kartik\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use kartik\widgets\Select2;
use kartik\widgets\FileInput;


/* @var $this yii\web\View */
/* @var $model app\models\Activity */
/* @var $form yii\widgets\ActiveForm */
$dateRender =  DataHelper::renderDate($activity->date_start,$activity->date_end);

$script = <<< JS
    $(document).ready(function(){
        $(".close_btn").click(function(){
            $("#right_panel").toggle("slow");
        });
        $("button.sp-choose").click(function(){
            App.color = App.getColor();
        });

        $("div[id*='activity-date']").change(function(){
            App.getDate($('#activity-date_start').val(), $('#activity-date_end').val());
        });

});




    var App = new Vue({
      el: '#app',
      data: {
        title: $('#activity-title').val(),
        color: $('#activity-color').val(),
        mark: $('#activity-mark').val(),
        description: $('#activity-description').val(),
        datestart: $('#activity-date_start').val(),
        dateend: $('#activity-date_end').val(),
        renderDate: '{$dateRender}'
        },

        methods: {
            getColor: function(){
                return this.parseColor($('.sp-preview-inner').css('background-color'));
            },
            parseColor:function(color) {
                var arr=[]; color.replace(/[\d+\.]+/g, function(v) { arr.push(parseFloat(v)); });
                return "#" + arr.slice(0, 3).map(this.toHex).join("");
            },
            toHex: function(int) {
                var hex = int.toString(16);
                return hex.length == 1 ? "0" + hex : hex;
            },
            getDate: function (start, end) {
                    var datestart = new Date(this.toDate(start));
                    var dateend = new Date(this.toDate(end));
                    var month = ['Января','Февраля','Марта','Апреля','Мая','Июня','Июля','Августа','Сентября','Октября','Ноября','Декабря']
                    var days = ['ВС', 'ПН', 'ВТ', 'СР', 'ЧТ', 'ПТ', 'СБ'];
                  // `this` указывает на экземпляр vm
                        if(datestart.getMonth() == dateend.getMonth() && datestart.getDate() == dateend.getDate()){
                            this.renderDate = datestart.getDate()+' '+month[datestart.getMonth()]+', '+days[datestart.getDay()];
                        }

                        if(datestart.getMonth() == dateend.getMonth() && datestart.getDate() != dateend.getDate()){
                            this.renderDate = datestart.getDate()+'-'+dateend.getDate()+' '+month[datestart.getMonth()];
                        }

                        if(datestart.getMonth() != dateend.getMonth() && datestart.getDate() != dateend.getDate()){
                            this.renderDate = datestart.getDate()+' '+month[datestart.getMonth()]+' - '+dateend.getDate()+' '+month[dateend.getMonth()];
                        }
                        if(this.renderDate == ''){
                            this.renderDate = 'err_date';
                        }
                    },
            toDate: function(dateStr) {
              var parts = dateStr.split(".")
              return new Date(parts[2], parts[1] - 1, parts[0])
            }
        }
    });
JS;
$this->registerJs($script, yii\web\View::POS_READY);
$this->registerJsFile('\web\js\vue.js',  ['position' => yii\web\View::POS_END]);
?>
<!-------------------------------------------------------->
<div id="app">

<div class="row row-flex">
    <?php
    /**
     * @var $activity \app\models\Activity
     */
    $activity = $model; ?>
    <div class="col-sm-4 col-xs-12 col-md-3 col-lg-3">
        <div class="thumbnail" v-bind:style="{ backgroundColor: color}">
            <div class="image"><img data-src="holder.js/100%x200" src="<?= $activity->getPictureUrl();?>" data-holder-rendered="true" style="height: 200px; width: 100%; display: block;"></div>
            <div class="caption">

                    <div v-if = "mark != ''" class="thumbnail_mark">{{ mark }}</div>

                <div class="thumbnail_favorite"><a class="btn btn-default btn-circle glyphicon glyphicon-heart" role="button"></a></div>
                <h4>{{ title }}</h4>
                <div class="thumbnail_adress">г. Климов, Рязанская область</div>
            </div>
            <div class="thumbnail_footer"><p><span class="thumbnail_date">{{ renderDate }}</span><a class="btn btn-default btn-circle pull-right glyphicon glyphicon-play close_btn" role="button"></a></div>
        </div>
    </div>

    <div id="right_panel" class="col-sm-8 col-xs-12 col-md-9 col-lg-9 thumbnail_description" style="display: none;">
        <!-- <div class="thumbnail_close_right_panel pull-right"><span class="close" aria-hidden="true">x</span></div> -->
        <button type="button" class="close close_btn" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4>{{ title }}</h4>
        <p>{{ description }}</p>
    </div>

</div>
<!-------------------------------------------------------->
<div class="activity-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true, 'v-model' => 'title']) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 3,  'v-model' => 'description']); ?>
    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'mark')->textInput(['maxlength' => true, 'v-model' => 'mark']) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'color')->widget(ColorInput::classname(), [
                'options' => ['placeholder' => 'Выберете цвет фона', 'v-model'=>'color', 'value' => $model->getColor()], ]);
            ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'adress_id')->textInput() ?>
        </div>
    </div>




    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'imageFile')->widget(FileInput::classname(), [
                'options' => ['accept' => 'image/*'],
            ]);?>

            <!--   $form->field($model, 'imageFile')->fileInput()  -->
        </div>
        <div class="col-md-6">
            <label class="control-label" for="picturePanel">Изображение</label>
            <div class="panel panel-default" id="picturePanel">
                <div class="panel-body">
                    <?= Html::img($model->getPictureUrl(), ['height' => '200px', 'width' => '50%']) ?>
                </div>
            </div>

        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'owner_user_id')->widget(Select2::classname(), [
                'data' => ArrayHelper::map(User::find()->asArray()->all(), 'id', 'username'),
                'options' => ['placeholder' => 'Select a state ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>

        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'status_id')->textInput() ?>
        </div>
    </div>


<div class="row">
    <div class="col-md-6">
        <?= $form->field($model, 'date_start')->widget(DatePicker::classname(), [
            'options' => ['placeholder' => 'Начало мероприятия'],
            'pluginOptions' => [
                'autoclose'=>true,
                'format' => 'dd.mm.yyyy'
                //'value' => empty($model->date_of_birth) ? null : date("d/m/Y", strtotime($model->date_of_birth))
            ]
        ]);
        ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($model, 'date_end')->widget(DatePicker::classname(), [
            'options' => ['placeholder' => 'Завершение мероприятия'],
            'pluginOptions' => [
                'autoclose'=>true,
                'format' => 'dd.mm.yyyy'
            ]
        ]);
        ?>
    </div>
</div>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


</div>

