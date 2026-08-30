<style>
    @media screen {
	@page { size: 86mm 53mm; margin: 0; }
        .content-depan {
            width: 83mm;
            height: 50mm;
            border: 1px solid black;
            background-color: gray;
        }

        .pasien {
            font-weight: bold;
        }

        .tab-pasien td {
            padding: 0;
            border-collapse: collapse;
            font-size: 10px;
        }

        .tab-pasien {
            position: absolute;
            top: 35mm;
            left: 4mm;
        }
        
        .barcode {
            width: 32mm;
            height: 14mm;
            position: absolute;
            top: 21mm;
            left: 4mm;
        }
        .barcode_rm {
            position: absolute;
            top: 29mm;
            left: 7mm;
            letter-spacing: 1.5mm;
            font-weight: bold;
        }
        
        .ofs {
            padding-left: 1mm !important;
        }
    }
    
    @media print {
	@page { size: 86mm 53mm; margin: 0; }
        .content-depan {
            width: 83mm;
            height: 50mm;
        }

        .pasien {
            font-weight: bold;
        }

        .tab-pasien td {
            padding: 0;
            border-collapse: collapse;
            font-size: 10px;
        }

        .tab-pasien {
            position: absolute;
            top: 35mm;
            left: 4mm;
        }
        
        .barcode {
            width: 32mm;
            height: 14mm;
            position: absolute;
            top: 21mm;
            left: 4mm;
        }
        .barcode_rm {
            position: absolute;
            top: 29mm;
            left: 7mm;
            letter-spacing: 1.5mm;
            font-weight: bold;
        }
        .ofs {
            padding-left: 1mm !important;
        }
    }
    
    <?php /*
    .content-depan{
    -webkit-transform: rotate(-90deg);
    -moz-transform: rotate(-90deg);
    -o-transform: rotate(-90deg);
    -ms-transform: rotate(0deg);
    transform: rotate(0deg);
        color:#000000;
        /*width:8.6cm;*/ /*
        width:8.6cm;
        height:5.5cm;
        border:0px solid;
        margin: 0;
        <?php if(Yii::app()->user->getState('iskartudgntemplate')){ ?>
            background-image: url("images/kartu_pasien_depan.jpg");
            background-size:8.6cm 5.5cm;
            background-repeat:no-repeat;
        <?php } ?>
        position:absolute;
    }
    <?php /* if(Yii::app()->user->getState('iskartudgntemplate')){ ?>
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
    <?php } */ /* ?>
    .pasien{
        font-weight: bold;
        width:35%;
        top:45%;
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
        margin:125px 0px 0px 182px;
        padding: 0;
        top: 0;
        overflow: hidden;
        position: absolute;
        filter: gray;
    }
    .data{
        width:200%;
        top:5px;
        margin-left:3px;
        z-index: 1;
        position: relative;
        font-size: 9px;
    }
     * 
     */ ?>
</style>
<?php // echo "index.php?r=barcode/myBarcode&code=".$modPasien->no_rekam_medik."&is_text="; die; ?>
<div class="content-depan">
    <div class="pasien">
        <div class="data">
            <table class="tab-pasien">
                <tr><td>Nama</td><td>: </td><td class="ofs"><?php echo strtoupper($modPasien->nama_pasien); ?></td></tr>
                <tr><td>No RM</td><td>: </td><td class="ofs"><?php echo strtoupper($modPasien->no_rekam_medik); ?></td></tr>
                <tr><td>Tgl. Lahir</td><td>: </td><td class="ofs"><?php echo strtoupper(MyFormatter::formatDateTimeForUser($modPasien->tanggal_lahir)); ?><br></td></tr>                
            </table>
        </div>   
    </div>
	<div class="barcode">
		<img src="index.php?r=barcode/myBarcodeKartuPasien&code=<?php echo $modPasien->no_rekam_medik; ?>&is_text=" style="transform:scale(1.0)">          
	</div>
        <div class="barcode_rm">
                <?php echo $modPasien->no_rekam_medik; ?>
        </div>
    <?php /* if (!empty($modPasien->photopasien)) { ?>
        <div class="foto">
            <?php $url_photopasien = (!empty($modPasien->photopasien) ? Params::urlPasienTumbsDirectory()."kecil_".$modPasien->photopasien : ""); //Params::urlPhotoPasienDirectory()."no_photo.jpeg")?>
            <img src="<?php echo $url_photopasien ?>">
        </div>
    <?php } */ ?>
</div>
<!--<div class="content-belakang"></div>  >>> RND-9125-->
<?php
$this->catatPrintKartu($modPasien);
?>