<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);

$script = <<< JS
function submitForm(){
 document.getElementById('form_logout').submit();
}
JS;
$this->registerJs($script, yii\web\View::POS_END);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">



    <!-- HTML Markup for Sidebar Slide Out Menu -->
    <!-- HTML Markup for Top Navigation Menu -->
    <nav>
        <ul>
            <li><a href="#" class="icon icon-menu" id="btn-menu">Menu</a></li>
            <li><a href="http://www.queness.com">Queness</a></li>
            <li><a href="http://www.queness.com/post/14666/recreate-google-nexus-menu">Read Tutorial</a></li>
        </ul>
    </nav>

    <!-- HTML Markup for Sidebar Slide Out Menu -->
    <div id="sideNav">
        <ul>
            <li class="searchForm"><a href="#" class="icon icon-search"><span><input type="text" placeholder="Search" class="search" /></span></a></li>
            <li><a href="<?= Url::home();?>" class="icon icon-home"><span>Home</span></a></li>
            <li><a href="#" class="icon icon-articles"><span>Articles</span></a>
                <ul>
                    <li><a href="#"><span>Web Design</span></a></li>
                    <li><a href="#"><span>Web Development</span></a></li>
                </ul>
            </li>
            <li><a href="<?= Url::to(['/activity/index']);?>" class="icon icon-home"><span>Activities</span></a></li>
            <li><a href="#" class="icon icon-social"><span>Social Media</span></a>
                <ul>
                    <li><a href="#"><span>Facebook</span></a></li>
                    <li><a href="#"><span>Twitter</span></a></li>
                </ul>
            </li>
            <?=
            Yii::$app->user->isGuest ? (
                '<li><a href="'.Url::to(['/site/login']).'" class="icon icon-home"><span>ВХОД</span></a></li>'
            ) : (
                '<li>'.Html::beginForm(['/site/logout'], 'post', ['id' => 'form_logout']).Html::a('Выход ('.Html::encode(Yii::$app->user->identity->username).')',$url=false,['class'=>'icon icon-home','onclick'=>'submitForm()']). Html::endForm().'</li>'
            ) ?>
        </ul>
    </div>
    <!-- HTML Markup for Sidebar Slide Out Menu -->




    <div class="container">

        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
