<?php
/**
 * @link https://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license https://www.yiiframework.com/license/
 */

namespace app\commands;

use yii\console\Controller;
use yii\console\ExitCode;
use app\models\User;


class CreateuserController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     * @return int Exit code
     */
    public $username;
    public $firstname;
    public $password;
    
    public function options($actionID)
    {
        return ['username','firstname','password'];
    }
    
    public function optionAliases()
    {
        return ['u' => 'username','f' => 'firstname','p' => 'password'];
    }
    
    public function actionIndex()
    {   
        $user = new User();
        $user->username = $this->username;
        $user->firstname = $this->firstname;
        $user->password = \Yii::$app->security->generatePasswordHash($this->password);
        $user->save();
        
        echo "USUÁRIO: ".$this->username . " SALVO COM SUCESSO!\n";
    }

    /*
     public function validatePassword($password)
    {
        return Yii::$app->getSecurity()->validatePassword($password, $this->password_hash);
    }
    */
}
