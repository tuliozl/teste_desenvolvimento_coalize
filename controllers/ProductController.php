<?php
namespace app\controllers;

use yii\rest\ActiveController;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\data\Pagination;

use app\models\Product;
use \Exception;
use \Throwable;

class ProductController extends ActiveController
{
   public $modelClass = 'app\models\Product';
   public $response = array();

   /**
    * stores a new product
    */
   public function actionStore(){

        try{

            $this->validateInputData();

            $path = dirname(__DIR__)."/web/upload/";
            $file_name = substr(base64_encode($_FILES["photo"]["name"]), rand(1,10), 8).time().".".explode(".",$_FILES["photo"]["name"])[1];
            $new_file = $path.$file_name;
            
            move_uploaded_file($_FILES["photo"]["tmp_name"], $new_file);

            $product = new Product;
            $product->name = $_POST["name"];
            $product->client_id = $_POST["client_id"];
            $product->price = $_POST["price"];
            $product->photo = $new_file;
            $product->save();

            $this->response = array(
                "httpCode" => 200,
                "status" => "success",
                "product" => $product
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
    * lists active products
    */
   public function actionList(){

        try{

            $pageSize = (isset($_GET["size"]) && $_GET["size"] != "") ? $_GET["size"] : 5;
            $page = (isset($_GET["page"]) && $_GET["page"] != "") ? $_GET["page"] : 0;

            $whereClause['deleted_at'] = null;
            if(isset($_GET["client"]) && $_GET["client"] != ""){
                $whereClause['client_id'] = $_GET["client"];
            }

            $query = Product::find()
                        ->where($whereClause)
                        ->orderBy(['created_at' => SORT_DESC,'name' => SORT_ASC]);

            $count = $query->count();
            
            $pagination = new Pagination(['totalCount' => $count, 'defaultPageSize' => $pageSize]);
            $pagination->setPage($page);
            
            $products = $query
                        ->offset($pagination->offset)
                        ->limit($pagination->limit)
                        ->all();

            $this->response = array(
                "httpCode" => 200,
                "status" => "success",
                "total" => (int)$count,
                "totalPages" => ceil($count / $pageSize),
                "product" => $products
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
    * updates product data
    */
    public function actionEdit($id){
        try{

            $this->validateInputData(true);

            if(isset($_FILES["photo"])){
                $path = dirname(__DIR__)."/web/upload/";
                $file_name = substr(base64_encode($_FILES["photo"]["name"]), rand(1,10), 8).time().".".explode(".",$_FILES["photo"]["name"])[1];
                $new_file = $path.$file_name;
                
                move_uploaded_file($_FILES["photo"]["tmp_name"], $new_file);
            }

            $product = Product::findOne($id);
            $product->name = $_POST["name"];
            $product->client_id = $_POST["client_id"];
            $product->price = $_POST["price"];
            if(isset($_FILES["photo"])){
                $product->photo = $new_file;
            }
            $product->last_edit_at = date("Y-m-d H:i:s");
            $product->save();

            $this->response = array(
                "httpCode" => 200,
                "status" => "success",
                "product" => $product
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
    * deletes a product
    */
    public function actionSoftdelete($id){
        try{

            $product = Product::findOne($id);
            $product->deleted_at = date("Y-m-d H:i:s");
            $product->save();

            $this->response = array(
                "httpCode" => 200,
                "status" => "success",
                "product" => $product
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
    * checks and validates input data to record new / update product 
    */
   public function validateInputData($update=false){

        if(!$update && (!isset($_FILES["photo"]) || $_FILES["photo"]["size"] == 0)){
            throw new Exception('É necessário enviar uma foto.');
        }
    
        if(!isset($_POST["name"]) || is_null($_POST["name"]) || $_POST["name"] == ""){
            throw new Exception('É necessário informar um nome.');
        }

        if(!isset($_POST["price"]) || is_null($_POST["price"]) || $_POST["price"] == ""){
            throw new Exception('É necessário informar um preço.');
        }

        if(!isset($_POST["client_id"]) || is_null($_POST["client_id"]) || $_POST["client_id"] == ""){
            throw new Exception('É necessário informar o cliente.');
        }

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