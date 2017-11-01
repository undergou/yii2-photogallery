<?php

namespace app\modules\photo\ui\controllers;

use Yii;
use yii\web\Controller;
use app\models\Category;
use app\models\Image;
use yii\data\Pagination;

/**
 * Default controller for the `ui` module
 */
class PageController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        if(Yii::$app->user->isGuest){
            $query = Category::find()->where(['status'=>'guest'])->orderBy('id');
        } elseif(Yii::$app->user->identity->username == 'admin'){
            $query = Category::find()->orderBy('id');
        } else{
            $query = Category::find()->where(['status'=>['user','guest'] ])->orderBy('id');
        }

        // $pagination = new Pagination([
        //     'defaultPageSize' => 6,
        //     'totalCount' => $query->count(),
        // ]);
        // $pagination->pageSizeParam = false;
        $userStatus = Image::getUserStatus();
        $categories = $query->limit(6)->all();

        return $this->render('index',[
            'categories' => $categories,
            'userStatus' => $userStatus
            // 'pagination' => $pagination,
        ]);
    }

    public function actionCategory($slug)
    {
        if(Yii::$app->user->isGuest){
            $query = Image::find()->where(['status'=>'guest', 'category'=>$slug])->orderBy('id');
        } elseif(Yii::$app->user->identity->username == 'admin'){
            $query = Image::find()->where(['category'=>$slug])->orderBy('id');
        } else{
            $query = Image::find()->where(['status'=>['user','guest'], 'category'=>$slug])->orderBy('id');
        }
        $userStatus = Image::getUserStatus();
        $images = $query
            ->limit(7)
            ->all();
        $category = Category::find()->where(['slug' => $slug])->one();

        return $this->render('category',[
            'images' => $images,
            'category' => $category,
            'userStatus' => $userStatus
        ]);
    }

    public function actionView()
    {
        return $this->render('view');
    }

}
