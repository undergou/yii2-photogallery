<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "category".
 *
 * @property integer $id
 * @property string $title
 * @property string $slug
 * @property integer $status
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status'], 'string'],
            [['title', 'slug'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'slug' => 'Slug',
            'status' => 'Status',
        ];
    }
    public function getImages()
   {
       return $this->hasMany(Image::className(), ['category' => 'title']);
   }
   public function getCurrentCategory($title)
   {
       return Category::find()->where(['title' => $title])->one();
   }

   public function getFolder()
   {
       return Yii::getAlias('@web') . 'images/' . 'photogallery/';
   }
   public function getStatus()
{
    return [
        ['id'=>'1', 'status' =>'guest'],
        ['id'=>'2', 'status' =>'user'],
        ['id'=>'3', 'status' =>'admin'],
    ];
}
    public function getNumberOnStatus($slug)
    {
        if(Yii::$app->user->isGuest){
            $query = Image::find()->where(['status'=>'guest', 'category'=>$slug])->orderBy('id')->all();
        } elseif(Yii::$app->user->identity->username == 'admin'){
            $query = Image::find()->where(['category'=>$slug])->orderBy('id')->all();
        } else{
            $query = Image::find()->where(['status'=>['user','guest'], 'category'=>$slug])->orderBy('id')->all();
        }
        return count($query);
    }
    public function getImagesOnStatus($slug)
    {
        if(Yii::$app->user->isGuest){
            $query = Image::find()->where(['status'=>'guest', 'category'=>$slug])->orderBy('id')->all();
        } elseif(Yii::$app->user->identity->username == 'admin'){
            $query = Image::find()->where(['category'=>$slug])->orderBy('id')->all();
        } else{
            $query = Image::find()->where(['status'=>['user','guest'], 'category'=>$slug])->orderBy('id')->all();
        }
        return $query;
    }

    public function refreshCount($categoryTitle)
    {
        $rowsImg = (new \yii\db\Query())
            ->select('*')
            ->from('image')
            ->where(['category' => $categoryTitle])
            ->all();
            $rowsCount = count($rowsImg);
            $currentCategory = Category::find()->where(['title' => $categoryTitle])->one();
            $currentCategory->count = $rowsCount;
            $currentCategory->save();
    }
}
