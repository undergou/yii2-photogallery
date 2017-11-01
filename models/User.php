<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $username
 * @property string $email
 * @property string $password
 */

class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    public static function tableName()
    {
        return 'user';
    }

    public function rules()
    {
        return [
            [['username', 'email', 'password'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'email' => 'Email',
            'password' => 'Password',
        ];
    }

    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    public function validatePassword($password)
    {
        return $this->password === $password;
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        foreach (self::$users as $user) {
            if ($user['accessToken'] === $token) {
                return new static($user);
            }
        }

        return null;
    }

    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    public function getAuthKey()
    {
         return $this->auth_key;
    }

    // public function isAdmin($username)
    // {
    //     // if(!Yii::$app->user->isGuest){
    //     //     $username = Yii::$app->user->identity->username;
    //     //     $identity = User::findOne(['username' => $username]);
    //     //         if($identity->username == 'admin'){
    //     //             $data['admin'] = true;
    //     //         } else{
    //     //             $data['admin'] = false;
    //     //         }
    //     //     $data['username'] = $username;
    //     // } else {
    //     //     $data['admin'] = false;
    //     //     $data['username'] = null;
    //     // }
    //     //
    //     // return $data;
    //
    //     $identity = User::findOne(['username' => $username]);
    //     return $identity->username == 'admin';
    // }
}
