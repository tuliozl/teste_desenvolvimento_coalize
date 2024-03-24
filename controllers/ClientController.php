<?php
namespace app\controllers;

use yii\rest\ActiveController;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\data\Pagination;

use app\models\Client;
use \Exception;
use \Throwable;

class ClientController extends ActiveController
{
   public $modelClass = 'app\models\Client';
   public $response = array();

   /**
    * stores a new client
    */
   public function actionStore(){

        try{

            $this->validateInputData();

            $path = dirname(__DIR__)."/web/upload/";
            $file_name = substr(base64_encode($_FILES["photo"]["name"]), rand(1,10), 8).time().".".explode(".",$_FILES["photo"]["name"])[1];
            $new_file = $path.$file_name;
            
            move_uploaded_file($_FILES["photo"]["tmp_name"], $new_file);

            $client = new Client;
            $client->name = $_POST["name"];
            $client->cpf = $_POST["cpf"];
            $client->address = $_POST["address"];
            $client->number = $_POST["number"];
            $client->complement = isset($_POST["complement"]) ? $_POST["complement"] : null;
            $client->district = $_POST["district"];
            $client->city = $_POST["city"];
            $client->state = $_POST["state"];
            $client->zipcode = $_POST["zipcode"];
            $client->gender = $_POST["gender"];
            $client->photo = $new_file;
            $client->save();

            $this->response = array(
                "httpCode" => 200,
                "status" => "success",
                "client" => $client
            );

        } catch( Throwable $t ) {
			
			$this->response = array(
                "httpCode" => 400,
                "status" => "error",
                "message" => $t->getMessage()
            );
         
		} catch (Exception $e) {

            $this->response = array(
                "httpCode" => 400,
                "status" => "error",
                "message" => $e->getMessage()
            );

        }

        return $this->response;
   }

   /**
    * lists active clients
    */
   public function actionList(){

    try{

        $pageSize = (isset($_GET["size"]) && $_GET["size"] != "") ? $_GET["size"] : 5;
        $page = (isset($_GET["page"]) && $_GET["page"] != "") ? $_GET["page"] : 0;

        $query = Client::find()->where(['deleted_at' => null])->orderBy(['created_at' => SORT_DESC,'name' => SORT_ASC]);
        $count = $query->count();
        
        $pagination = new Pagination(['totalCount' => $count, 'defaultPageSize' => $pageSize]);
        $pagination->setPage($page);
        
        $clients = $query->offset($pagination->offset)->limit($pagination->limit)->all();

        $this->response = array(
            "httpCode" => 200,
            "status" => "success",
            "total" => $count,
            "client" => $clients
        );

    } catch( Throwable $t ) {
        
        $this->response = array(
            "httpCode" => 400,
            "status" => "error",
            "message" => $t->getMessage()
        );
     
    } catch (Exception $e) {

        $this->response = array(
            "httpCode" => 400,
            "status" => "error",
            "message" => $e->getMessage()
        );

    }

    return $this->response;
}

   /**
    * checks and validates input data to record new client
    */
   public function validateInputData(){

        if(!isset($_FILES["photo"]) || $_FILES["photo"]["size"] == 0){
            throw new Exception('É necessário enviar uma foto.');
        }
    
        if(!isset($_POST["name"]) || is_null($_POST["name"]) || $_POST["name"] == ""){
            throw new Exception('É necessário informar um nome.');
        }

        if(!isset($_POST["cpf"]) || is_null($_POST["cpf"]) || $_POST["cpf"] == ""){
            throw new Exception('É necessário informar um CPF.');
        }

        if(!isset($_POST["address"]) || is_null($_POST["address"]) || $_POST["address"] == ""){
            throw new Exception('É necessário informar um endereço.');
        }

        if(!isset($_POST["number"]) || is_null($_POST["number"]) || $_POST["number"] == ""){
            throw new Exception('É necessário informar um número.');
        }

        if(!isset($_POST["district"]) || is_null($_POST["district"]) || $_POST["district"] == ""){
            throw new Exception('É necessário informar um bairro.');
        }

        if(!isset($_POST["city"]) || is_null($_POST["city"]) || $_POST["city"] == ""){
            throw new Exception('É necessário informar uma cidade.');
        }

        if(!isset($_POST["state"]) || is_null($_POST["state"]) || $_POST["state"] == ""){
            throw new Exception('É necessário informar um estado.');
        }

        if(!isset($_POST["zipcode"]) || is_null($_POST["zipcode"]) || $_POST["zipcode"] == ""){
            throw new Exception('É necessário informar o CEP.');
        }

        if(!isset($_POST["gender"]) || is_null($_POST["gender"]) || $_POST["gender"] == ""){
            throw new Exception('É necessário informar o sexo.');
        }

        if(!in_array($_POST["gender"],array("F","M"))){
            throw new Exception('O sexo informado não é válido.');
        }

        $this->validateCPF($_POST["cpf"]);

   }
   
   
   /**
    * validate CPF string
    */
   public function validateCPF($cpf) {

        $cpf = preg_replace( '/[^0-9]/is', '', $cpf );

        if (strlen($cpf) != 11) {
            throw new Exception('CPF inválido: quantidade de dígitos incorreta.');
        }

        if (preg_match('/(\d)\1{10}/', $cpf)) {
            throw new Exception('CPF inválido: dígitos repetidos.');
        }
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                throw new Exception('CPF inválido.');
            }
        }
        return true;
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