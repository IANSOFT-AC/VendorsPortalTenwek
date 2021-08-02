<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = 'Terms and Conditions';
?>

    <!--THE STEPS THING--->
    <div class="row">
        <div class="col-md-12">
            <?= $this->render('..\company-profile\_steps') ?>
        </div>
    </div>

        <div class="col-md-12">
             <div class="card-body">
                <?php $form = ActiveForm::begin(['id' => 'confrimation-form']); ?>

                    <p>I hereby declare that the information provided in this form is true to the best of my knowledge, and I understand that any false information given could render me liable to immediate disqualification.

                    </p>
                    <p>
                        <ol>

                        <li> <b> ACCURACY OF CONTENT:</b> The content of this application 
                                is accurate and contains no false information.
                        </li>

                        <!-- <li> <b> EDUCATION INFORMATION: </b> you give your full consent and authorize Tenwek Hospital to contact each of your education 
                                institutions listed in this application for the purpose of conducting required reference checks with regard to your educational background, and confirm the diploma or degree you have received from each education institution. You also authorize the mentioned educational institutions to provide 
                            requested information directly to Tenwek Hospital. Any information received will be treated with due regard to confidentiality
                        </li>

                        <li> <b> WORK EXPERIENCE: </b> You are aware Tenwek Hospital will contact former and current employers,
                            if applicable, regarding work experience as well as check your three professional
                            references Finally you understand that submission of false information or misrepresentation
                                and/or submission of falsified documentation constitutes serious misconduct for which sever disciplinary
                            sanctions can be imposed I consent to all of 
                            the foregoing as part of the process of evaluation of my application
                        </li> -->

                        </ol>
                    </p>

                    <div class="row">
                        <div class="row col-md-12">
                        <?= $form->field($model, 'Key')->hiddenInput()->label(false); ?>

                        <hr>
                            <div class="col-lg-5">
                                <?= 
                                    $form->field($model, 'HasAcceptedTermsAndConditions')->checkBox(['required' => true]) 
                                
                                ?>
                            </div>
                        
                            
                     

                        </div>
                        <div class="row">
                        <div class="col-lg-12">
                                     <?= Html::submitButton('Submit Profile', ['class' => 'btn btn-success form-control', 'name' => 'login-button']) ?>
                            </div>
                        </div>
                    </div>

                   


                <?php ActiveForm::end(); ?>

            </div>
        </div>
    

           