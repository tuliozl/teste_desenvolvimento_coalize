<?php

namespace app\models;

use yii\db\ActiveRecord;
use \yii\web\IdentityInterface;

class User extends ActiveRecord implements IdentityInterface
{
   const STATUS_INACTIVE = 0;
   const STATUS_ACTIVE = 1;
   public $authKey;
   public $id;
   
   /**
    * @return string the name of the table associated with this ActiveRecord class.
    */
   public static function tableName()
   {
       return 'user';
   }

   public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->authKey;
    }

    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

   public function fields()
{
   return ['id','username','firstname'];
}
}