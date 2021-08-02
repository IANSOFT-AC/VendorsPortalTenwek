<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PartnerDetails */
/* @var $form ActiveForm */
?>
<div class="partner-detail-_form">

    <?php $form = ActiveForm::begin(); ?>
     

    <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Partner Details </h3>
                </div>
                <div class="card-body">
                    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
                        <?= $form->field($model,'Key')->hiddenInput()->label(false) ?>
                        <?= $form->field($model,'Supplier_No')->hiddenInput()->label(false) ?>

                        <div class="row">
                            <div class=" row col-md-12">

                                <div class="col-sm-4">
                                    <?= $form->field($model, 'Partner_Name')->textInput() ?>
                                    <?= $form->field($model, 'Nationality')->dropDownList($Countries, ['prompt' => 'Select a Country']) ?>
                                    <?= $form->field($model, 'Gender')->dropDownList(['Female' => 'Female','Male' => 'Male',], ['prompt' => 'Select Gender']) ?>
                                    <?= $form->field($model, 'Shares')->textInput(['type' => 'number']) ?>

                                </div>

                                <div class="col-sm-4">

                                    <?= $form->field($model, 'Partner_Occupation')->textInput() ?>
                                    <?= $form->field($model, 'Partner_ID_No')->textInput() ?>
                                    <?= $form->field($model, 'PIN')->textInput() ?>
                                    <?= $form->field($model, 'Patrner_Address')->textInput() ?>

                                </div>

                                <div class="col-sm-4">
                                    <?= $form->field($model, 'Mobile_No__x002B_254')->textInput() ?>
                                    <?= $form->field($model, 'City')->dropDownList($Cities, ['prompt' => 'Select a City']) ?>
                                    <?= $form->field($model, 'Passport_No')->textInput() ?>
                                </div>

                            </div>  
                        </div>

                    <div class="row col-md-12">
                        <div class="form-group">
                            <?= Html::submitButton('Save', ['class' => 'btn btn-success btn-md']) ?>
                        </div>
                        
                    </div>
                    
                    <?php ActiveForm::end(); ?>
                </div>
             </div>

</div><!-- partner-detail-_form -->
