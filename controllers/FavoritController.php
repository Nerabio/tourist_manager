<?php

namespace app\controllers;
use Yii;
use app\models\FavoritActivity;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class FavoritController extends \yii\web\Controller
{

    public function actionTest()
    {
        echo 'test';

    }

    public function actionChange($id)
    {
        $userId = Yii::$app->user->identity->id;
        $model = FavoritActivity::findOne(['activity_id' => $id]);
        if(!empty($model)){
            $model->delete();
        }else{
            $model = new FavoritActivity();
            $model->activity_id = $id;
            $model->user_id = $userId;
            $model->save();
        }
    }


}
