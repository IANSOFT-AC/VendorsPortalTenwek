<?php 

namespace app\models;

use Yii;
use yii\base\Model;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

class SupplierAttachement extends Model
{
  
    public $Supplier_No;
    public $Name;
    public $File_path;
    public $Key;

    public function rules()
    {
        return [
            [['Supplier_No', 'Name', 'File_path',], 'required'],
            [['File_path'],'file'],
        ];
    }


    public function attributeLabels()
    {
        return [
            'File_path' => 'Document',
        ];
    }


    public function upload($model)
    {
       // $model = $this;

        $imageId = Yii::$app->security->generateRandomString(8);

        $imagePath = Yii::getAlias('uploads/'.$imageId.'.'.$this->File_path->extension);
        // $navPath = \yii\helpers\Url::home(true).'leave_attachments/'.$imageId.'.'.$this->attachmentfile->extension; // Readable from nav interface


        //return($model); 

        if($model->validate()){
            // Check if directory exists, else create it
            if(!is_dir(dirname($imagePath))){
                FileHelper::createDirectory(dirname($imagePath));
            }

            $this->File_path->saveAs($imagePath);
            $CompanyProfileData = Yii::$app->recruitment->getCompanyApplicationNo();

                //Post to Nav
            $service = Yii::$app->params['ServiceName']['SupplierAttachements'];
            $model->Supplier_No = $CompanyProfileData[0]->No;
            $model->File_path = $imagePath;//$imagePath;
            $result = Yii::$app->navhelper->postData($service, $model);
            
            return $result;
                
           
        }else{

            return false;
        }
    }

    public function getPathLeave($DocNo='', $LineNo){
        if(!$DocNo){
            return false;
        }
        $service = Yii::$app->params['ServiceName']['LeaveAttachments'];
        $filter = [
            'Document_No' => $DocNo,
            'Line_No'=>$LineNo
        ];

        $result = Yii::$app->navhelper->getData($service,$filter);
        if(is_array($result)) {
            return basename($result[0]->File_path);
        }else{
            return false;
        }

    }

    public function getPath($DocNo=''){
        if(!$DocNo){
            return false;
        }
        $service = Yii::$app->params['ServiceName']['LeaveAttachments'];
        $filter = [
            'Document_No' => $DocNo,
        ];

        $result = Yii::$app->navhelper->getData($service,$filter);
        if(is_array($result)) {
            return basename($result[0]->File_path);
        }else{
            return false;
        }

    }

    public function readAttachment($DocNo)
    {
        $service = Yii::$app->params['ServiceName']['LeaveAttachments'];
        $filter = [
            'Document_No' => $DocNo,
        ];

        $result = Yii::$app->navhelper->getData($service,$filter);

        $path = $result[0]->File_path;

        if(is_file($path))
        {
            $binary = file_get_contents($path);
            $content = chunk_split(base64_encode($binary));
            return $content;
        }
    }

    
    public function readAttachmentLeave($DocNo, $LineNo)
    {
        $service = Yii::$app->params['ServiceName']['LeaveAttachments'];
        $filter = [
            'Document_No' => $DocNo,
            'Line_No'=>$LineNo
        ];

        $result = Yii::$app->navhelper->getData($service,$filter);

        $path = $result[0]->File_path;

        if(is_file($path))
        {
            $binary = file_get_contents($path);
            $content = chunk_split(base64_encode($binary));
            return $content;
        }
    }

    public function getAttachment($DocNo)
    {

        $service = Yii::$app->params['ServiceName']['LeaveAttachments'];
        $filter = [
            'Document_No' => $DocNo
        ];

        $result = Yii::$app->navhelper->getData($service,$filter);
        if(is_array($result)){
            return $result[0];
        }else{
            return false;
        }

    }

    public function getFileProperties($binary)
    {
        $bin  = base64_decode($binary);
        $props =  getImageSizeFromString($bin);
        return $props['mime'];
    }


}
?>