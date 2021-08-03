<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\depdrop\DepDrop;

/* @var $this yii\web\View */
/* @var $model app\models\BankrDetails */
/* @var $form ActiveForm */
?>
<div class="banks-_form">

    <?php $form = ActiveForm::begin(); ?>
     

    <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Bank Details </h3>
                </div>
                <div class="card-body">
                    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
                        <?= $form->field($model,'Key')->hiddenInput()->label(false) ?>
                        <?= $form->field($model,'Supplier_No')->hiddenInput()->label(false) ?>

                        <div class="row">
                            <div class=" row col-md-12">

                                <div class="col-sm-6">
                                    <?= $form->field($model, 'Code')->dropDownList($Banks, ['prompt' => 'Select a Bank', 'id'=>'cat-id']) ?>
                                    <?= $form->field($model, 'Contact')->textInput(['type' => 'number']) ?>

                                </div>

                                <div class="col-sm-6">


                                        
                               

                                      <?= $form->field($model, 'Bank_Account_No')->textInput() ?>

                                    <?= $form->field($model, 'Post_Code')->dropDownList($Cities, ['prompt' => 'Select a City']) ?>

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
