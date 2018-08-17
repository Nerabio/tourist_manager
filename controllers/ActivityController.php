<?php

namespace app\controllers;

use Yii;
use app\models\Activity;
use app\models\SearchActivity;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * ActivityController implements the CRUD actions for Activity model.
 */
class ActivityController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Activity models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchActivity();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Activity model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Activity model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Activity();

        if($model->load(Yii::$app->request->post())){

            //if(!empty(UploadedFile::getInstance($model, 'imageFile'))) {
            if ($model->validate()) {
                if(!empty(UploadedFile::getInstance($model, 'imageFile'))) {
                    $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
                    $model->imageFile->saveAs('uploads/' . $model->imageFile->baseName . '.' . $model->imageFile->extension);
                    $model->picture_url = 'uploads/' . $model->imageFile->baseName . '.' . $model->imageFile->extension;
                }
                $model->load(Yii::$app->request->post());
            }
            if($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Activity model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        //if ($model->load(Yii::$app->request->post())) {
        if(Yii::$app->request->isPost){

            //if(!empty(UploadedFile::getInstance($model, 'imageFile'))) {
            if ($model->validate()) {
                if(!empty(UploadedFile::getInstance($model, 'imageFile'))) {
                    $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
                    $model->imageFile->saveAs('uploads/' . $model->imageFile->baseName . '.' . $model->imageFile->extension);
                    $model->picture_url = 'uploads/' . $model->imageFile->baseName . '.' . $model->imageFile->extension;
                }
                $model->load(Yii::$app->request->post());
            }
            if($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Activity model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Activity model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Activity the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Activity::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
