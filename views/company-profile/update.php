<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 2/24/2020
 * Time: 12:31 PM
 */


use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\AgendaDocument */

$this->title = 'Update Applicant Personal info.: ' . $model->No;
$this->params['breadcrumbs'][] = ['label' => 'Recruitment ', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Update Applicant Profile', 'url' => ['applicantprofile/update','No' => $model->No ]];
?>
<div class="agenda-document-update">

    <?= $this->render('_form', [
        'model' => $model,
        'SupplierCategories'=>$SupplierCategories, 
        'PostalCodes'=>$PostalCodes
        // 'religion' => $religion
    ]) ?>

</div>
