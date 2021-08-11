<?php
use yii\helpers\Html;
?>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><?= Html::encode($this->title) ?></h3>
            </div>
            <div class="card-body">
                 <?php $atform = \yii\widgets\ActiveForm::begin(['id'=>'attachmentform'],['options' => ['enctype' => 'multipart/form-data']]); ?>
                 <?= $atform->errorSummary($Attachmentmodel)?>
                <div class="row">
                    <div class="row col-md-12">
                            <div class="col-md-6">
                            <?= $atform->field($Attachmentmodel,'Name')->textInput();?>

                                <?= $atform->field($Attachmentmodel,'Supplier_No')->hiddenInput(['value' => $CompanyData[0]->No])->label(false);?>

                            </div>
                            <div class="col-md-6">
                                 <?= $atform->field($Attachmentmodel,'File_path')->fileInput(['id' => 'File_path', 'name' => 'File_path', ]);?>

                            </div>
                    </div>
                </div>
                <?= Html::submitButton('Upload', ['class' => 'btn btn-success']) ?>

            </div>
        </div>
    </div>
</div>

   


<?php \yii\widgets\ActiveForm::end(); ?>