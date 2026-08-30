<style>
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
        <?php if(Yii::app()->user->getState('iskartudgntemplate')){ ?>
            background-image: url("images/kartu_pasien_depan.jpg");
            background-size:8.5cm 5.5cm;
            background-repeat:no-repeat;
        <?php } ?>
        position:absolute;
    }
    <?php if(Yii::app()->user->getState('iskartudgntemplate')){ ?>
    .content-belakang{
        color:#000000;
        width:8.6cm;
        height:5.5cm;
        border:0px solid;
        margin: 5cm 0px 0px 0px;
            background-image: url("images/kartu_pasien_belakang.jpg");
            background-size:8.6cm 5.5cm;
            background-repeat:no-repeat;
        position:absolute;
    }
    <?php } ?>
    .pasien{
        font-weight: bold;
        width:35%;
        top:52%;
        left:2%;
        border:0px solid;
        text-align: left;
        position:relative;
    }
    .foto{
        width: 2cm;
        top:57%;
        left:38%;
        border:0px solid;
        text-align: center;
        position:absolute;
    }
    .barcode{
        width:100px;
        border: 0 solid;
        margin: 0;
        padding: 0;
        top:8px;
        overflow: hidden;
        position: absolute;
        filter: gray;
    }
    .data{
        width:200%;
        top:28px;
        margin-left:3px;
        z-index: 1;
        position: relative;
        font-size: 9px;
    }
</style>
<div class="content-depan">
    <div class="pasien">
        <div class="barcode">
            <img src="index.php?r=barcode/myBarcode&code=<?php echo $modPasien->no_rekam_medik; ?>&is_text=" style="transform:scale(2.0)">          
        </div>
        <div class="data">
            <div style="margin-left:30px"><?php echo $modPasien->no_rekam_medik; ?></div>
            <?php echo $modPasien->nama_pasien.", ".$modPasien->namadepan;?><br>
            <?php echo MyFormatter::formatDateTimeForUser($modPasien->tanggal_lahir); ?> / 
            <?php echo $modPasien->jeniskelamin; ?><br>
            <?php echo $modPasien->alamat_pasien; ?><br>
            <?php echo "RT ".$modPasien->rt." / RW".$modPasien->rw; ?><br>
            <?php echo $modPasien->kabupaten->kabupaten_nama; ?><br>
        </div>
        
    </div>
    <?php if (!empty($modPasien->photopasien)) { ?>
        <div class="foto">
            <?php $url_photopasien = (!empty($modPasien->photopasien) ? Params::urlPasienTumbsDirectory()."kecil_".$modPasien->photopasien : ""); //Params::urlPhotoPasienDirectory()."no_photo.jpeg")?>
            <img src="<?php echo $url_photopasien ?>">
        </div>
    <?php } ?>
</div><br>
<!--<div class="content-belakang"></div>  >>> RND-1713-->