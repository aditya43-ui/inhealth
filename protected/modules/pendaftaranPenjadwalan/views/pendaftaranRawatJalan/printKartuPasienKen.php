<style>
    
        <?php if(Yii::app()->user->getState('iskartudgntemplate')){ ?>
            .content-depan{
    -webkit-transform: rotate(-90deg);
    -moz-transform: rotate(-90deg);
    -o-transform: rotate(-90deg);
    -ms-transform: rotate(0deg);
    transform: rotate(0deg);
        color:#000000;
        /*width:8.6cm;*/
        width:18.6cm;
        height:5.5cm;
        border:0px solid;
        margin: 0;
            background-image: url("images/kartu_pasien_depan.jpg");
            background-size:8.5cm 5.5cm;
            background-repeat:no-repeat;
            position:absolute;
        }
        <?php } ?>
 
 
    <?php if(Yii::app()->user->getState('iskartudgntemplate')){ ?>
    .content-belakang{
        color:#000000;
        width:9.5cm;
        height:5.5cm;
        border:0px solid;
        margin: 4cm 0px 0px 0px;
            background-image: url("images/kartu_pasien_belakang.jpg");
            background-size:9.5cm 6.5cm;
            background-repeat:no-repeat;
        position:absolute;
    }
    <?php } ?>
    .pasien{
        width:40%;
        top:18%;
        left:4%;
        border:0px solid;
        text-align: left;
    }
    .foto{
        width: 2cm;
        top:57%;
        left:38%;
        border: 0px solid;
        text-align: center;
        position:absolute;
    }
    .barcode{
        width:117px;
        border: 0 solid;
        margin: 1;
        padding: 1;
        margin-left:12px;
        top:28px;
        overflow: hidden;
        position: absolute;
        filter: gray;
    }
    .data{
        width:200%;
        top:28px;
        margin-left:5px;
        z-index: 1;
        position: relative;
        font-size: 9.2px;
    }
</style>
<div class="content-depan">
    <div class="data">
   
        <div class="pasien">
        <div style="margin-left:20px">  <?php echo $modPasien->nama_pasien.", ".$modPasien->namadepan;?><br></div>
        <div style="margin-left:20px">   <?php echo $modPasien->alamat_pasien; ?>  <?php echo "RT ".$modPasien->rt." / RW".$modPasien->rw; ?><br></div>
        <div style="margin-left:20px">    <?php echo $modPasien->no_rekam_medik; ?><br></div>

        <div style="border: 0 solid;margin-top: 5px;text-align:center;width:200px;">
    <img style="height: 64px;" src="index.php?r=barcode/myBarcode&code=<?php echo $modPasien->no_rekam_medik; ?>&is_text=">  
</div>
      
        
    </div>

</div><br>
<!--<div class="content-belakang"></div>  >>> RND-1713-->