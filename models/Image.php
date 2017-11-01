<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "image".
 *
 * @property integer $id
 * @property string $author
 * @property string $category
 * @property string $title
 * @property string $date
 * @property integer $status
 */
class Image extends \yii\db\ActiveRecord
{
    public $watermark;
    public $userStatus;

    public static function tableName()
    {
        return 'image';
    }

    public function rules()
    {
        return [
            [['date'], 'safe'],
            [['date'], 'default', 'value' => date('Y-m-d')],
            [['date'], 'date', 'format' => 'php:Y-m-d'],
            [['status'], 'string'],
            [['author', 'category', 'title'], 'string', 'max' => 255],
            [['image'], 'file', 'extensions' => 'jpg,png,gif,jpeg'],
            // [['image', 'title'], 'required'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'author' => 'Author',
            'category' => 'Category',
            'title' => 'Title',
            'date' => 'Date',
            'status' => 'Status',
        ];
    }

    public function uploadImage($file, $id, $extension)
    {
            $file->saveAs($this->getFolder() . $id . $extension);

            return $file->name;
    }
    public function getImageExtension($id)
    {
        return Image::findOne($id)->extension;
    }

    public function getFolder()
    {
        return Yii::getAlias('@web') . 'images/' . 'photogallery/';
    }

    public function getFilenameForCreate($file, $id)
    {
        rename($this->getFolder() . $file->name, $this->getFolder(). $id . '.' . $file->extension);
        return $id . '.' . $file->extension;
    }

    public function deleteImage($id)
    {
        unlink($this->getFolder() . $this->getImage($id));
    }

    public function getImage($id)
    {
        $img = Image::findOne($id);
        return $id . $img->extension;
    }
    public function getPathImage($id)
    {
        return Image::getFolder().$id.Image::getImageExtension($id);
    }

    public function getCategory()
        {
            return $this->hasOne(Category::className(), ['title' => 'category']);
        }
        
    public function createImageFromGd($imageExtension, $watermark, $id)
    {
                $img = Image::createImageOnExtension($imageExtension, $id);
                return Image::addWatermark($imageExtension, $img, $watermark, $id);
    }

    public function createImageOnExtension($imageExtension, $id)
    {
        switch($imageExtension){
            case '.jpg':
            $img = imagecreatefromjpeg(Image::getFolder().$id.$imageExtension);
            break;
            case '.jpeg':
            $img = imagecreatefromjpeg(Image::getFolder().$id.$imageExtension);
            break;
            case '.png':
            $img = imagecreatefrompng(Image::getFolder().$id.$imageExtension);
            break;
            case '.gif':
            $img = imagecreatefromgif(Image::getFolder().$id.$imageExtension);
            break;
            default:
            unlink(Image::getFolder() .  Image::getImage($id));
            Image::findOne($id)->delete();
            $img = false;
        }
        return $img;
    }
    public function addWatermark($imageExtension, $img, $watermark, $id)
    {
        if($img){
            $white = imagecolorallocate($img, 255,255,255);
            $width = imagesx($img);
            $height = imagesy($img);

            switch($watermark){
                case 'LeftUp':
                $x = 20;
                $y = 20;
                break;
                case 'RightUp':
                $x = $width-108-20;
                $y = 20;
                break;
                case 'RightDown':
                $x = $width-108-20;;
                $y = $height-20-15;
                break;
                case 'LeftDown':
                $x = 20;
                $y = $height-20-15;
            }
            if($watermark != 'None'){
                imagestring($img, 5, $x, $y, $_SERVER['SERVER_NAME'], $white);
                imagejpeg($img, Image::getFolder().$id.$imageExtension , 100);
            }

        return $img;

        } else {
            unlink(Image::getFolder() .  Image::getImage($id));
            Image::findOne($id)->delete();
            return false;
        }
    }

    public function getWatermark()
{
    return [
        ['id'=>'1', 'watermark' =>'LeftUp'],
        ['id'=>'2', 'watermark' =>'LeftDown'],
        ['id'=>'3', 'watermark' =>'RightUp'],
        ['id'=>'4', 'watermark' =>'RightDown'],
        ['id'=>'5', 'watermark' =>'None'],
    ];
}
public function getStatus()
{
    return [
        ['id'=>'1', 'status' =>'guest'],
        ['id'=>'2', 'status' =>'user'],
        ['id'=>'3', 'status' =>'admin'],
    ];
}
public function getUserStatus()
{
    if(Yii::$app->user->isGuest){
        $userStatus = 'guest';
    } elseif(Yii::$app->user->identity->username == 'admin'){
        $userStatus = 'admin';
    } else{
        $userStatus = 'user';
    }
    return $userStatus;
}
}
