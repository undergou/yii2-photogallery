<?php

namespace app\modules\photo\admin\controllers;

use Yii;
use app\models\Image;
use app\models\ImageSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use app\models\Category;
use yii\helpers\ArrayHelper;

class ImageController extends Controller
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
        $searchModel = new ImageSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = 10;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        $category['title'] = $this->findModel($id)->category;
        $category['id'] = Category::find()->where(['title' => $category['title']])->one()->id;

        Category::refreshCount($category['title']);

        return $this->render('view', [
            'model' => $this->findModel($id),
            'category' => $category,
        ]);
    }

    public function actionCreate()
    {
        $model = new Image();

        if($model->load(Yii::$app->request->post()) && $model->validate()){

            $watermark = Yii::$app->request->post()['Image']['watermark'];
            $file = UploadedFile::getInstance($model, 'image');

            if($file){
                $model->extension = '.'.$file->extension;
                $model->save();
                $model->uploadImage($file, $model->id, $model->extension);

                $imgId = $model->id;
                $img = Image::createImageFromGd($model->extension, $watermark, $imgId);
                if(!$img){
                    Yii::$app->session->setFlash('error-extension', "Your file is not image or incorrect extension!");
                    return $this->redirect('/photo/admin/category/index');
                } else{
                    Yii::$app->session->setFlash('success', "Image uploaded successfully");
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            } else {
                Yii::$app->session->setFlash('error-null', "Please, choose the image!");
                return $this->redirect('/photo/admin/image/create');
            }
        } else {
            $categories = ArrayHelper::map(Category::find()->all(), 'title', 'title');
            $watermarks = ArrayHelper::map(Image::getWatermark(), 'watermark', 'watermark');
            $status = ArrayHelper::map(Image::getStatus(),'status', 'status');
            return $this->render('create', [
                'model' => $model,
                'categories' => $categories,
                'watermarks' => $watermarks,
                'status' => $status,
            ]);
        }
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $category['title'] = $this->findModel($id)->category;
        $category['id'] = Category::find()->where(['title' => $category['title']])->one()->id;
        $categories = ArrayHelper::map(Category::find()->all(), 'title', 'title');
        $status = ArrayHelper::map(Image::getStatus(),'status', 'status');
        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            return $this->redirect(['view', 'id' => $model->id]);
            } else {
            return $this->render('update', [
                'model' => $model,
                'categories' => $categories,
                'category' => $category,
                'status' => $status,
            ]);
        }
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $currentCategory = Category::find()->where(['title'=>$model->category])->one();
        $catId = $currentCategory->id;

        $this->findModel($id)->deleteImage($id);
        $this->findModel($id)->delete();
        $currentCategory->save();

        return $this->redirect(['/photo/admin/category/view?id='.$catId]);
    }

    protected function findModel($id)
    {
        if (($model = Image::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
