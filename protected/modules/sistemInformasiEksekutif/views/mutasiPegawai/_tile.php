<div class="panel panel-success panel-shadow panel-collapse" style="margin-top: 17px;">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i> Summary Mutasi Pegawai
        </div>
        <div class="panel-options">
            <a data-rel="collapse" href="#"><i class="entypo-down-open"></i></a>
        </div>
    </div>
    <div class="panel-body">
        <div class="col-sm-3">
            <div class="tile-stats tile-red">
                <div class="icon"><i class="entypo-mail"></i></div>
                <div class="col-md-6">
                    <div id="tile1" style="font-size:6vw" class="num" data-start="0" data-end="<?= $count['tile_perempuan']  ?>" data-postfix="" data-duration="1500" data-delay="0">0</div>
                </div>
                <div class="col-md-6">
                    <h4 style="color: white;text-align:right;">Mutasi Pegawai Perempuan</h4>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="tile-stats tile-green">
                <div class="icon"><i class="entypo-mail"></i></div>
                <div class="col-md-6">
                    <div id="tile2" style="font-size:6vw" class="num" data-start="0" data-end="<?= $count['tile_laki']  ?>" data-postfix="" data-duration="1500" data-delay="0">0</div>
                </div>
                <div class="col-md-6">
                    <h4 style="color: white;text-align:right;">Mutasi Pegawai Laki-Laki</h4>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="tile-stats tile-blue">
                <div class="icon"><i class="entypo-mail"></i></div>
                <div class="col-md-6">
                    <div id="tile3" style="font-size:6vw" class="num" data-start="0" data-end="<?= $count['tile_pns']  ?>" data-postfix="" data-duration="1500" data-delay="0">0</div>
                </div>
                <div class="col-md-6">
                    <h4 style="color: white;text-align:right;">Mutasi Pegawai PNS</h4>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="tile-stats tile-brown">
                <div class="icon"><i class="entypo-mail"></i></div>
                <div class="col-md-6">
                    <div id="tile4" style="font-size:6vw" class="num" data-start="0" data-end="<?= $count['tile_blud']  ?>" data-postfix="" data-duration="1500" data-delay="0">0</div>
                </div>
                <div class="col-md-6">
                    <h4 style="color: white;text-align:right;">Mutasi Pegawai BLUD</h4>
                </div>
            </div>
        </div>
    </div>
</div>