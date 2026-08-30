<div class="panel panel-success" style="margin-top: 17px;">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i> Summary Kunjungan ke Rumah Sakit
        </div>
        <div class="panel-options">
            <a data-rel="collapse" href="#"><i class="entypo-down-open"></i></a>
        </div>
    </div>
    <div class="panel-body">
        <?php $class = ['tile-aqua', 'tile-green', 'tile-blue', 'tile-brown', 'tile-primary', 'tile-red', 'tile-orange', 'tile-purple']; ?>
        <div class="col-md-4" style="padding-right:4px !important;padding-left:4px !important">
            <div class="tile-stats tile-aqua">
                <div class="icon"><i class="entypo-mail"></i></div>
                <div class="col-md-6">
                    <div id="tile1" style="font-size:6vw" class="num" data-start="0" data-end="<?= $dataTile['kunjungan_ri'] ?>" data-postfix="" data-duration="1500" data-delay="0">0</div>
                </div>
                <div class="col-md-6">
                    <h4 style="color: white;text-align:right;"><b><?= "Kunjungan ke Rawat Inap" ?></b></h4>
                </div>
            </div>
        </div>
        <div class="col-md-4" style="padding-right:4px !important;padding-left:4px !important">
            <div class="tile-stats tile-green">
                <div class="icon"><i class="entypo-mail"></i></div>
                <div class="col-md-6">
                    <div id="tile1" style="font-size:6vw" class="num" data-start="0" data-end="<?= $dataTile['kunjungan_rj'] ?>" data-postfix="" data-duration="1500" data-delay="0">0</div>
                </div>
                <div class="col-md-6">
                    <h4 style="color: white;text-align:right;"><b><?= "Kunjungan ke Rawat Jalan" ?></b></h4>
                </div>
            </div>
        </div>
        <div class="col-md-4" style="padding-right:4px !important;padding-left:4px !important">
            <div class="tile-stats tile-blue">
                <div class="icon"><i class="entypo-mail"></i></div>
                <div class="col-md-6">
                    <div id="tile1" style="font-size:6vw" class="num" data-start="0" data-end="<?= $dataTile['kunjungan_rd'] ?>" data-postfix="" data-duration="1500" data-delay="0">0</div>
                </div>
                <div class="col-md-6">
                    <h4 style="color: white;text-align:right;"><b>Kunjungan ke Rawat Darurat</b></h4>
                </div>
            </div>
        </div>
    </div>
</div>