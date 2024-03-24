<?php

namespace app\controllers;

use yii\rest\ActiveController;
use app\models\User;
use Yii;

class AuthController extends ActiveController
{
    public $modelClass = '';

    public function actionLogin(){
        
        $username = !empty($_POST['username'])?$_POST['username']:'';
        $password = !empty($_POST['password'])?$_POST['password']:'';
        $response = [];
        
        if(empty($username) || empty($password)){
          $response = [
            'status' => 'error',
            'message' => 'Username e Password não podem ser NULL',
            'data' => '',
          ];
        
        }else{
            
            $user = User::find()->where(['username' => $username])->one();
            
            if(!empty($user)){
              
              if(Yii::$app->getSecurity()->validatePassword($password, $user->password)){
                
                $access_token = Yii::$app->security->generateRandomString() . '_' . time();

                $user->access_token = $access_token;
                $user->save();

                $data['access_token'] = $access_token;
                // $data['expires_at'] = $accesstoken->expires_at;
                
                $response = [
                  'status' => 'success',
                  'message' => 'Login efetuado com sucesso',
                  'data' => $data
                ];
              }
              
              else{
                $response = [
                  'status' => 'error',
                  'message' => 'Passoword incorreto',
                  'data' => '',
                ];
              }
            }
            
            else{
              $response = [
                'status' => 'error',
                'message' => 'Username não encontrado',
                'data' => '',
              ];
            }
        }
        return $response;
        // return array('msg' => "TESTANDO","status" => "xola");
    }
   
}