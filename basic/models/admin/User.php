<?php

namespace app\models\admin;
use yii\db\ActiveRecord;

class User extends ActiveRecord implements \yii\web\IdentityInterface
{
    public static function tableName(){
        return 'user';
    }

    public static function findIdentity($id){
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token,$type=null){
        return static::findOne(['accessToken'=>$token]);
    }

    public static function findByUsername($username){
        return static::findOne(['username'=>$username]);
    }

    public function getId(){
        return $this->id;
    }

    public function getAuthkey(){
        return $this->auth_key;
    }

    public function validateAuthKey($authKey){
        return $this->auth_key === $authKey;
    }

        public function validatePassword($password){
            //return $this->password === md5($password);
        return $this->password === $password;
    }


    public function generateAuthKey()
    {
        $this->auth_key = \Yii::$app->security->generateRandomString();
        $this->save();
    }

}

