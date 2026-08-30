<?php

/**
 * digunakan untuk pembuatan interface beranda dinas sponsorship
 * menampilkan dalam bentuk tile 
 * RSST-7935
 * @author          M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version         2.0.0
 * @link            http://172.9.1.15/simpp/docs/
 *
 */
?>
<div class="row">
    <div class="col-md-3 col-sm-6 col-sm-12">
        <div class="tile-stats tile-red">
            <div class="icon"><i class="entypo-mail"></i></div>
            <div class="col-md-6">
                <div id="tile1" style="font-size:2vw" class="num" data-start="0" data-end="<?php echo $tile['laporaninsiden']; ?>" data-postfix="" data-duration="1500" data-delay="0">0</div>
            </div>
            <div class="clear"></div>
            <div class="col-md-12">
                <h4 style="color: white;text-align:left;padding-top: 13%;">Laporan Insiden Pasien Hari Ini</h4>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6 col-sm-12">
        <div class="tile-stats tile-green">
            <div class="icon"><i class="entypo-mail"></i></div>
            <div class="col-md-6">
                <div id="tile2" style="font-size:2vw" class="num" data-start="0" data-end="<?php echo $tile['riskregister']; ?>" data-postfix="" data-duration="1500" data-delay="0">0</div>
            </div>
            <div class="clear"></div>
            <div class="col-md-12">
                <h4 style="color: white;text-align:left;padding-top: 13%;">Risk Register dalam Setahun</h4>
            </div>
        </div>
    </div>
</div>