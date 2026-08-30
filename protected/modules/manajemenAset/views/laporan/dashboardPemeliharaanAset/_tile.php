<?php 
/**
 * digunakan untuk pembuatan interface beranda dinas sponsorship
 * menampilkan dalam bentuk tile 
 * RSST-8728
 * @author          M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version         2.0.0
 * @link            http://172.9.1.15/simpp/docs/
 *
 */
?>
<style>
    .tile-stats{
        min-height: 120px;
    }
</style>
<div class="col-md-6" style="padding-right:4px !important;padding-left:4px !important">
    <div class="tile-stats tile-red">
        <!--<div class="icon"><i class="entypo-mail"></i></div>-->
        <div class="col-md-12">
            <h4 style="color: white;">Jumlah Alat Medik</h4>
        </div>
        <div class="col-md-6">
            <div id="tile-inven" style="font-size:4vw" class="num" data-start="0" data-end="" data-postfix="" data-duration="1500" data-delay="0"><?= $tile['jml_alatmedis'] ?></div>
        </div>        
    </div>
</div>
<div class="col-md-6" style="padding-right:4px !important;padding-left:4px !important">
    <div class="tile-stats tile-green">
       <!--<div class="icon"><i class="entypo-mail"></i></div>-->
        <div class="col-md-12">
            <h4 style="color: white;">Jumlah Alat Non Medik</h4>
        </div>
        <div class="col-md-6">
            <div id="tile-sudah" style="font-size:4vw" class="num" data-start="0" data-end="" data-postfix="" data-duration="1500" data-delay="0"><?= $tile['jml_alatnonmedis'] ?></div>
        </div>    
    </div>
</div>
<div class="clear"></div>
<hr/>
<div class="col-md-4" style="padding-right:4px !important;padding-left:4px !important">
    <div class="tile-stats tile-blue">
        <!--<div class="icon"><i class="entypo-mail"></i></div>-->
         <div class="col-md-12">
            <h4 style="color: white;">Jumlah Alat Bisa Dikalibrasi</h4>
            <span style="font-size:12px;color:#fff;">&nbsp;</span>
        </div>
        <div class="col-md-6">
            <div id="tile-belum" style="font-size:4vw" class="num" data-start="0" data-end="" data-postfix="" data-duration="1500" data-delay="0"><?= $tile['jml_bisakalibrasi'] ?></div>
        </div> 
    </div>
</div>

<div class="col-md-4" style="padding-right:4px !important;padding-left:4px !important">
    <div class="tile-stats tile-brown">
        <!--<div class="icon"><i class="entypo-mail"></i></div>-->
        <div class="col-md-12">
            <h4 style="color: white;">Jumlah Alat Sudah Dikalibrasi</h4>
            <span style="font-size:12px;color:#fff;">Tahun <?= date('Y') ?></span>
        </div>
        <div class="col-md-6">
            <div id="tile-inven-baru" style="font-size:4vw" class="num" data-start="0" data-end="" data-postfix="" data-duration="1500" data-delay="0"><?= $tile['jml_sudahkalibrasi'] ?></div>
        </div> 
    </div>
</div>

<div class="col-md-4" style="padding-right:4px !important;padding-left:4px !important">
    <div class="tile-stats tile-cyan">
        <!--<div class="icon"><i class="entypo-mail"></i></div>-->
        <div class="col-md-12">
            <h4 style="color: white;">Jumlah Alat Belum Dikalibrasi</h4>
            <span style="font-size:12px;color:#fff;">Tahun <?= date('Y') ?></span>
        </div>
        <div class="col-md-6">
            <div id="tile-inven-baru" style="font-size:4vw" class="num" data-start="0" data-end="" data-postfix="" data-duration="1500" data-delay="0"><?= $tile['jml_belumkalibrasi'] ?></div>
        </div> 
    </div>
</div>
<div class="clear"></div>
<hr/>

<div class="col-md-6" style="padding-right:4px !important;padding-left:4px !important">
    <div class="tile-stats tile-red">
        <!--<div class="icon"><i class="entypo-mail"></i></div>-->
        <div class="col-md-12">
            <h4 style="color: white;">Jumlah Alat Dilakukan Preventive Maintance</h4>
            <span style="font-size:12px;color:#fff;">Tahun <?= date('Y') ?></span>
        </div>
        <div class="col-md-6">
            <div id="tile-inven" style="font-size:4vw" class="num" data-start="0" data-end="" data-postfix="" data-duration="1500" data-delay="0"><?= $tile['jml_preventive'] ?></div>
        </div>        
    </div>
</div>

<div class="col-md-6" style="padding-right:4px !important;padding-left:4px !important">
    <div class="tile-stats tile-green">
       <!--<div class="icon"><i class="entypo-mail"></i></div>-->
        <div class="col-md-12">
            <h4 style="color: white;">Jumlah Alat Dilakukan Corrective Maintance</h4>
            <span style="font-size:12px;color:#fff;">Tahun <?= date('Y') ?></span>
        </div>
        <div class="col-md-6">
            <div id="tile-sudah" style="font-size:4vw" class="num" data-start="0" data-end="" data-postfix="" data-duration="1500" data-delay="0"><?= $tile['jml_corrective'] ?></div>
        </div>    
    </div>
</div>

<div class="clear"></div>
<hr/>