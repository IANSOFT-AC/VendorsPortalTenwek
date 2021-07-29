<?php 

namespace app\models;

use Yii;
use yii\base\Model;

class PartnerDetails extends Model
{
  
    public $Supplier_No;
    public $Partner_ID_No;
    public $Partner_Name;
    public $Patrner_Address;
    public $City;
    public $Partner_Occupation;
    public $PIN;
    public $Mobile_No__x002B_254;
    public $Gender;
    public $Shares;
    public $Nationality;
    public $Passport_No;
    public $Key;

    public function rules()
    {
        return [
            [['Partner_ID_No', 'Partner_Name', 'Patrner_Address', 
                 'City', 'Partner_Occupation', 'PIN', 'Mobile_No__x002B_254', 'Gender',
                 'Shares', 'Nationality', 'Passport_No',], 
            'required'],

            ['Mobile_No__x002B_254', 'string', 'max' => 10],
            ['PIN', 'string', 'max' => 10, 'min'=>7],


        ];
    }


    public function attributeLabels()
    {
        return [
            'Partner_ID_No' => 'Partner Id No',
            'Partner_Name' => 'Patner Full Names',
            'Patrner_Address' => 'Place of Residence',
            'Partner_Occupation' =>  'Occupation',
            'PIN' => ' KRA PIN',
            'Mobile_No__x002B_254' => 'Mobile Phone No',
            'Passport_No' => 'Passport No',
        ];
    }



}
?>