<?php
namespace app\models;
use Yii;
use yii\base\Model;

class SupplierCategories extends Model
    {

       public $Supplier_No;
       public $Category;
       public $Description;
       public $Key;

        public function rules()
        {
            return [
                [['Category', ], 'required'],    
            ];
        }
    
    
        public function attributeLabels()
        {
            return [
                'Category' => 'Category',

            ];
        }


    }

?>
