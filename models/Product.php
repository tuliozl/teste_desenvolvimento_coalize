<?php

namespace app\models;

use yii\db\ActiveRecord;

class Product extends ActiveRecord
{
   
   /**
    * @return string the name of the table associated with this ActiveRecord class.
    */
   public static function tableName(){
       return 'product';
   }

   
}