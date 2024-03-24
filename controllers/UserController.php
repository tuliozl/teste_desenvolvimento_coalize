<?php
namespace app\controllers;

use yii\rest\ActiveController;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBearerAuth;

class UserController extends ActiveController
{
   public $modelClass = 'app\models\User';

   public function actionTest(){
    return array('test' => 'TESTANDO AÇÃO TEST');
   }

   public function behaviors()
    {
    $behaviors = parent::behaviors();
    $behaviors['authenticator'] = [
        'class' => CompositeAuth::class,
        'authMethods' => [
            HttpBearerAuth::class,
        ],
    ];
    return $behaviors;
    }
}