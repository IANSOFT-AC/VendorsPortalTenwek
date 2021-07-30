<?php
$this->title = 'Organization Bank Accounts';
?>

<?= $this->render('..\company-profile\_steps') ?>

<div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <?=  \yii\helpers\Html::button('Add Bank Account',
                            [  'value' => \yii\helpers\Url::to(['banks/create',
                                ]),
                                'title' => 'New Partner',
                                'class' => 'btn btn-info push-right showModalButton',
                                ]
                            ); 
                    ?>      
            </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Organization Bank Accounts</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered dt-responsive table-hover" id="partners">
                    </table>
                </div>
            </div>
        </div>
    </div>


 




<input type="hidden" name="absolute" value="<?= Yii::$app->recruitment->absoluteUrl() ?>">
<?php

$script = <<<JS

    $(function(){
        
        var absolute = $('input[name=absolute]').val();
            /*Data Tables*/
            // $.fn.dataTable.ext.errMode = 'throw';
          $('#partners').DataTable({
           
            //serverSide: true,  
            ajax: absolute+'banks/get-banks',
            paging: true,
            columns: [
                { title: '....', data: 'index'},
                { title: 'Bank Name' ,data: 'Bank_Name'},
                { title: 'Postal Code' ,data: 'Post_Code'},
                { title: 'Bank Account No' ,data: 'Bank_Account_No'},
                { title: 'Swift Code' ,data: 'SWIFT_Code'},
                { title: 'Bank Branch' ,data: 'Bank_Branch_No'},
                { title: 'Action' ,data: 'Action'},
                //{ title: 'Remove' ,data: 'Remove'},
                
               
            ] ,                              
           language: {
                "zeroRecords": "No Partners to Show.."
            },
            
            order : [[ 0, "asc" ]]
            
           
       });
        
       //Hidding some 
       var table = $('#partners').DataTable();
      table.columns([5]).visible(true);
    
    /*End Data tables*/
      $('#leaves').on('click','.update', function(e){
             e.preventDefault();
            var url = $(this).attr('href');
            console.log('clicking...');
            $('.modal').modal('show')
                            .find('.modal-body')
                            .load(url); 

        });
        
        

    
    /*Handle dismissal eveent of modal */
    $('.modal').on('hidden.bs.modal',function(){
        var reld = location.reload(true);
        setTimeout(reld,1000);
    }); 
        
    });
        
JS;

$this->registerJs($script);

$style = <<<CSS
    /* tr > td:last-child{ text-align: center; } */
CSS;

$this->registerCss($style);









