<?php

namespace app\modules\photo\admin\controllers;

use Yii;
use app\models\Category;
use app\models\CategorySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\ImageSearch;
use app\models\Image;
use yii\helpers\ArrayHelper;


class CategoryController extends Controller
{
    /**
     * @inheritdoc
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


    public function actionIndex()
    {

        $searchModel = new CategorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = 10;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        $searchModel = new ImageSearch();
        $dataProvider = $searchModel->search($id);
        $dataProvider->pagination->pageSize = 5;

        return $this->render('view', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate()
    {
        $model = new Category();
        $status = ArrayHelper::map(Category::getStatus(),'status', 'status');
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'status' => $status,
            ]);
        }
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $status = ArrayHelper::map(Category::getStatus(),'status', 'status');
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'status' => $status,
            ]);
        }
    }
    public function actionConfirm($id)
    {
        $model = $this->findModel($id);
        $imgId = ArrayHelper::map($model->images, 'id', 'id');
        $categories = ArrayHelper::map(Category::find()->all(), 'id', 'title');
        unset($categories[$id]);
        if($model->load(Yii::$app->request->post())) {
            $this->findModel($id)->delete();
            $categoryTitle = Category::find()->where(['id'=>$model->title])->one()->title;

            foreach($imgId as $id){
                $image = Image::find()->where(['id'=>$id])->one();
                $image->category = $categoryTitle;
                $image->save();
            }

            Category::refreshCount($categoryTitle);

            Yii::$app->session->setFlash('success-move', "Images were successfully moved and category was deleted");
            return $this->redirect(['index']);
        }
        return $this->render('confirm',[
            'model'=> $model,
            'categories' => $categories,
        ]);
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $imgId = ArrayHelper::map($model->images, 'id', 'id');

        $this->findModel($id)->delete();

            foreach($imgId as $id){
                $img = Image::find()->where(['id'=>$id])->one();
                $img->deleteImage($id);
                $img->delete();
            }
            Yii::$app->session->setFlash('success-deleted', "Category was successfully deleted with all images");
            return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Category::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
