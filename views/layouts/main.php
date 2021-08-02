<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;

AppAsset::register($this);
$webroot = Yii::getAlias(@$webroot);
$absoluteUrl = \yii\helpers\Url::home(true);
$profileAction = '';//(Yii::$app->user->identity->profileID)?'applicantprofile/update?No='.Yii::$app->user->identity->profileID:'applicantprofile/view-profile';
$CompanyColor = 'indigo';
$SecondaryColorHeaderColor = 'wheat';
$CompaniesToDisplay = Yii::$app->recruitment->getCompanies();
?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
        <head>
            <meta charset="<?= Yii::$app->charset ?>">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <!-- Tell the browser to be responsive to screen width -->
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <?php $this->registerCsrfMetaTags() ?>
            <title><?= Html::encode($this->title) ?></title>
            <?php $this->head() ?>
        </head>

        <body class="hold-transition sidebar-mini layout-navbar-fixed">
            <?php $this->beginBody() ?>

                    <!-- Global Modal Here -->
                <div class="modal fade bs-example-modal-lg bs-modal-lg" tabindex="-1" role="dialog" aria-hidden="true" id="modal">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content" id="modalContent">

                            <div class="modal-header" id="modalHeader">
                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                                </button>
                                <h4 class="modal-title" id="myModalLabel" style="position: absolute"></h4>
                            </div>

                            <div class="modal-body">

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                <!--<button type="button" class="btn btn-primary">Save changes</button>-->
                            </div>

                        </div>
                    </div>
                </div>

                <div class="wrapper">

                    <!-- Navbar -->
                    <nav class="main-header navbar navbar-expand navbar-white navbar-light" style="background-color: <?= $CompanyColor?>;color: white;">
                        <!-- Left navbar links -->
                        <ul class="navbar-nav">
                            <li class="nav-item" >
                                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars" style="color: white;"></i></a>
                            </li>
                            <li class="nav-item d-none d-sm-inline-block">
                                <a href="<?= $absoluteUrl ?>" class="nav-link" style="color: white;">Home</a>
                            </li>
                      
                        </ul>


                        <div class="navbar-nav ml-auto">

                            <li class="nav-item dropdown">
                                

                                <?php if(Yii::$app->session->get('SelectedCompany')  ): ?>

                                    <a class="nav-link" data-toggle="dropdown" href="#" style=" color: white;font-weight: bolder;">
                                        <?= Yii::$app->session->get('SelectedCompany') ?>
                                    </a>

                                <?php else: ?>
                                    <a class="nav-link" data-toggle="dropdown" href="#" style=" color: white;font-weight: bolder;">
                                        Kindly Select a Company
                                    </a>
                                    
                                <?php endif; ?>

                                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">

                                    <?php foreach ($CompaniesToDisplay as $key => $CompanyToDisplay): ?>
                                            <?php if($CompanyToDisplay->Name == Yii::$app->session->get('SelectedCompany')): ?>

                                            <?php continue; ?>
                                            <?php endif; ?>
                                            <a href="<?= \yii\helpers\Url::to(['site/switch', 'Id'=>$CompanyToDisplay->Name]) ?>" class="dropdown-item">
                                                <!-- Message Start -->
                                                <div class="media">
                                                    <div class="media-body">
                                                        <h3 class="dropdown-item-title">
                                                            <?= $CompanyToDisplay->Name ?>
                                                        </h3>
                                                    </div>
                                                </div>
                                                <!-- Message End -->
                                            </a>
                                        <?php endforeach; ?>

                                </div>

                            </li>
                        </div>

                        <!-- Right navbar links -->
                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item" >
                                <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                                <i class="fas fa-user" style="background-color: <?=$CompanyColor ?>;color: white;"></i> 
                                </a>
                            </li>
                        </ul>
                    </nav>
                    <!-- /.navbar -->

                    <!-- Main Sidebar Container -->
                    <aside class="main-sidebar sidebar-dark-primary elevation-4" style="background-color: <?=$CompanyColor ?>;" >
                        <!-- Brand Logo -->
                        <a href="<?= $absoluteUrl ?>" class="brand-link" >
                        <img src="<?= $absoluteUrl ?>dist/img/TenwekLogo.jpg" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
                            style="opacity: .8">
                        <span class="brand-text font-weight-light" style="font-size: revert;"> Vendors Portal</span>
                        </a>

                        <!-- Sidebar -->
                        <div class="sidebar" style="padding: 0px 8px;height: 100%;width: 100%;background-color: <?=$CompanyColor ?>;">
                        <!-- Sidebar user panel (optional) -->
                        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                            <div class="image">
                                <!-- <p> Navigator </p> -->
                            </div>
                            <div class="info">
                            <a href="#" class="d-block"></a>
                            </div>
                        </div>

                        <!-- Sidebar Menu -->
                        <nav class="mt-2">
                            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                            <!-- Add icons to the links using the .nav-icon class
                                with font-awesome or any other icon font library -->
                            
                            <li class="nav-item">
                                <a href="<?= $absoluteUrl ?>tenders/" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Browse Tenders
                                </p>
                                </a>
                            </li>

                            <li class="nav-item">
                                
                                <a href="<?= yii\helpers\Url::to(['company-profile/',]) ?>" class="nav-link">
                                <i class="nav-icon fas fa-user"></i>
                                <p>
                                    Company Profile
                                </p>
                                </a>
                            </li>

                            <li class="nav-item has-treeview">
                                <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-copy"></i>
                                <p>
                                    Tender Applications
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                                </a>
                                <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="<?= $absoluteUrl ?>job-applications" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Submitted Applications</p>
                                    </a>
                                </li>
                                            
                                </ul>
                            </li>
                            
                       
                        
                            </ul>
                        </nav>
                        <!-- /.sidebar-menu -->
                        </div>
                        <!-- /.sidebar -->
                    </aside>

                      <!-- Content Wrapper. Contains page content -->
                        <div class="content-wrapper">
                     
                                <!-- Main content -->
                            <section class="content">
                                <div class="container-fluid">

                                    <div class="row">
                                        
                                        <div class="col-md-12">
                                                    <?php

                                                    if(Yii::$app->session->hasFlash('success')){
                                                        print ' <div class="alert alert-success alert-dismissable">
                                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                                                    <h5><i class="icon fas fa-check"></i> Success!</h5>';
                                                        echo Yii::$app->session->getFlash('success');
                                                        print '</div>';
                                                    }else if(Yii::$app->session->hasFlash('error')){
                                                        print ' <div class="alert alert-danger alert-dismissable">
                                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                                                    <h5><i class="icon fas fa-check"></i> Error!</h5>
                                                                            ';
                                                        echo Yii::$app->session->getFlash('error');
                                                        print '</div>';
                                                    }
                                                    ?>
                                        </div>
                                    </div>

                                    <?= $content ?>
                                </div>
                            </section>

                        </div>
                            <!-- /.content-header -->

                          

                    <footer class="main-footer">
                            <p class="pull-left">&copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?></p>

                            <div class="float-right d-none d-sm-inline-block">
                                <p> <?= Yii::powered() ?> </p>
                            </div>
                    </footer>

                 </div>

            <?php $this->endBody() ?>
        </body>

        
        <script>
        //               (function (document, window, $) {
        // setTimeout(() => {
        //     }, 200);
        // })(document, window, jQuery);

        $(document).ready(function () {
            $.blockUI({ message: '<h5><img src="<?=$absoluteUrl ?>dist/img/spinner.gif" /> Loading...</h5>' });

            setTimeout(() => {
                $.unblockUI();
            }, 900);
            $('.page-content').toggle();
        });
        
                 </script>
    </html>
<?php $this->endPage() ?>
