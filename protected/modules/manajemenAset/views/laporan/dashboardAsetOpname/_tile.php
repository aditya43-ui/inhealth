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
<div class="col-md-3" style="padding-right:4px !important;padding-left:4px !important">
    <div class="tile-stats tile-red">
        <!--<div class="icon"><i class="entypo-mail"></i></div>-->
        <div class="col-md-12">
            <h4 style="color: white;">Jumlah Aset Terinventarisasi</h4>
        </div>
        <div class="col-md-6">
            <div id="tile-inven" style="font-size:4vw" class="num" data-start="0" data-end="" data-postfix="" data-duration="1500" data-delay="0">0</div>
        </div>        
    </div>
</div>

<div class="col-md-3" style="padding-right:4px !important;padding-left:4px !important">
    <div class="tile-stats tile-green">
       <!--<div class="icon"><i class="entypo-mail"></i></div>-->
        <div class="col-md-12">
            <h4 style="color: white;">Jumlah Aset Sudah Opname</h4>
        </div>
        <div class="col-md-6">
            <div id="tile-sudah" style="font-size:4vw" class="num" data-start="0" data-end="" data-postfix="" data-duration="1500" data-delay="0">0</div>
        </div>    
    </div>
</div>

<div class="col-md-3" style="padding-right:4px !important;padding-left:4px !important">
    <div class="tile-stats tile-blue">
        <!--<div class="icon"><i class="entypo-mail"></i></div>-->
         <div class="col-md-12">
            <h4 style="color: white;">Jumlah Aset Belum Opname</h4>
        </div>
        <div class="col-md-6">
            <div id="tile-belum" style="font-size:4vw" class="num" data-start="0" data-end="" data-postfix="" data-duration="1500" data-delay="0">0</div>
        </div> 
    </div>
</div>

<div class="col-md-3" style="padding-right:4px !important;padding-left:4px !important">
    <div class="tile-stats tile-brown">
        <!--<div class="icon"><i class="entypo-mail"></i></div>-->
        <div class="col-md-12">
            <h4 style="color: white;">Jumlah Aset Terinventarisasi Baru</h4>
        </div>
        <div class="col-md-6">
            <div id="tile-inven-baru" style="font-size:4vw" class="num" data-start="0" data-end="" data-postfix="" data-duration="1500" data-delay="0">0</div>
        </div> 
    </div>
</div>
