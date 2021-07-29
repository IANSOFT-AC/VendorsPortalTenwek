<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
//$this->title = 'AAS - Employee Profile'

//    echo '<pre>';
//         print_r($model);
//         exit;
?>
             <?= $this->render('_steps') ?>
            
             <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Company Details </h3>
                </div>
                <div class="card-body">
                    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
                    <?= $form->field($model,'Key')->hiddenInput()->label(false) ?>

                    <div class="row">
                        <div class=" row col-md-12">

                            <div class="col-sm-3">
                                <?= $form->field($model, 'Name')->textInput() ?>
                                <?= $form->field($model, 'Supplier_Type')->dropDownList($SupplierCategories, ['prompt' => 'Select Supplier Category']) ?>
                                <?= $form->field($model, 'Trade_Licennse_No')->textInput() ?>
                                <?= $form->field($model, 'Certificate_of_Incorporation')->textInput() ?>

                            </div>

                            <div class="col-sm-3">

                                <?= $form->field($model, 'Tax_Compliance_Certificate_No')->textInput() ?>
                                <?= $form->field($model, 'Tax_Compliance_Expiry_Date')->textInput(['type' => 'date']) ?>
                                <?= $form->field($model, 'PIN_No')->textInput() ?>
                                <?= $form->field($model, 'Registration_No')->textInput() ?>

                            </div>

                            <div class="col-sm-3">
                                <?= $form->field($model, 'E_Mail')->textInput() ?>
                                <?= $form->field($model, 'Phone_No')->textInput() ?>
                                <?= $form->field($model, 'Address')->textInput() ?>
                                <?= $form->field($model, 'Registration_Date')->textInput(['type' => 'date']) ?>
                            </div>


                            <div class="col-sm-3">
                                <?= $form->field($model, 'VAT_Certificate_No')->textInput() ?>
                            </div>


                        </div>  
                    </div>

                    <div class="row col-md-12">
                        <div class="form-group">
                            <?= Html::submitButton('Save', ['class' => 'btn btn-success btn-md']) ?>
                        </div>
                        
                    </div>

                </div>
             </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
