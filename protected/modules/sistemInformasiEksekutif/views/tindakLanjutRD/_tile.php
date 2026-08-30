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
<div class="clear"></div>
<div class="panel panel-success" style="margin-top: 17px;">
    <div class="panel panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i> Summary <b>Tindak Lanjut IGD</b>
        </div>
    </div>
    <div class="panel-body">
        <div class="col-md-3" style="padding-right:4px !important;padding-left:4px !important">
            <div class="tile-stats tile-red" style="background: #FF7B89">
                <div class="icon"><i class="entypo-mail"></i></div>
                <div class="col-md-6">
                    <div id="tile1" style="font-size:6vw" class="num" data-start="0" data-end="<?php echo $tile['pasien_ri'];  ?>" data-postfix="" data-duration="1500" data-delay="0">0</div>
                </div>
                <div class="col-md-6">
                    <h4 style="color: white;text-align:right;">Rawat Inap </h4>
                </div>
            </div>
        </div>
        <div class="col-md-3" style="padding-right:4px !important;padding-left:4px !important">
            <div class="tile-stats tile-green" style="background: #8ac926">
                <div class="icon"><i class="entypo-mail"></i></div>
                <div class="col-md-6">
                    <div id="tile2" style="font-size:6vw" class="num" data-start="0" data-end="<?php echo $tile['pasien_rj'];  ?>" data-postfix="" data-duration="1500" data-delay="0">0</div>
                </div>
                <div class="col-md-6">
                    <h4 style="color: white;text-align:right;">Rawat Jalan</h4>
                </div>
            </div>
        </div>
        <div class="col-md-3" style="padding-right:4px !important;padding-left:4px !important">
            <div class="tile-stats tile-blue" style="background: #ffca3a">
                <div class="icon"><i class="entypo-mail"></i></div>
                <div class="col-md-6">
                    <div id="tile3" style="font-size:6vw" class="num" data-start="0" data-end="<?php echo $tile['pasien_pulang'];  ?>" data-postfix="" data-duration="1500" data-delay="0">0</div>
                </div>
                <div class="col-md-6">
                    <h4 style="color: white;text-align:right;">Pasien Pulang</h4>
                </div>
            </div>
        </div>
        <div class="col-md-3" style="padding-right:4px !important;padding-left:4px !important">
            <div class="tile-stats tile-brown" style="background: #1982c4">
                <div class="icon"><i class="entypo-mail"></i></div>
                <div class="col-md-6">
                    <div id="tile4" style="font-size:6vw" class="num" data-start="0" data-end="<?php echo $tile['pasien_meninggal']  ?>" data-postfix="" data-duration="1500" data-delay="0">0</div>
                </div>
                <div class="col-md-6">
                    <h4 style="color: white;text-align:right;"> Pasien Meninggal </h4>
                </div>
            </div>
        </div>
    </div>
</div>