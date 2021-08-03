<?php
// echo '<pre>';
// print_r($Companies);
// exit;
?>

<style type="text/css"> 
    /* body {
     padding: 40px 0;
    } */

    .grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    grid-gap: 20px;
    align-items: stretch;
    }

    .grid > article {
    border: 1px solid #ccc;
    box-shadow: 2px 2px 6px 0px rgba(0, 0, 0, 0.3);
    }

    .grid > article img {
    max-width: 100%;
    }

    .grid .text {
    padding: 20px;
    }

    .instruction{
      text-align: center;
      padding-bottom: .7em;
      padding-top: .5em;
    }

    .content{
    background-color: khaki;
    }
</style>

<!-- <div class="container"> -->
  <h2 class ="instruction"> Please Select A Company  </h2>
  <div class="grid">

  <?php foreach($Companies as $Company): ?>

    
    <article>

      <div class="text">
        <h3><?= $Company->Display_Name?></h3>
        <!-- <p>Completely synergize resource taxing relationships via premier niche markets.</p> -->
        <a href="<?= \yii\helpers\Url::to(['site/switch', 'Id'=>$Company->Name]) ?>" class="btn btn-primary btn-block">Select Company</a>
      </div>
    </article>

  <?php endforeach;?>
 

  </div>
</div>

