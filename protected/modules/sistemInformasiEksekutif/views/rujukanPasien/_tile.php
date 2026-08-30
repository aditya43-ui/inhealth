<div class="panel panel-success" style="margin-top: 17px;">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i> Summary Rujukan Pasien
        </div>
        <div class="panel-options">
            <a data-rel="collapse" href="#"><i class="entypo-down-open"></i></a>
        </div>
    </div>
    <div class="panel-body">
        <div class="col-sm-3">
            <div class="tile-stats tile-red">
                <div class="icon"><i class="entypo-users"></i></div>
                <div class="col-sm-6" style="padding:30px 0px 0px 0px;">
                    <div class="num" data-start="0" data-end="<?php echo !empty($tile->jumlah_rs) ? $tile->jumlah_rs : 0; ?>" data-postfix="" data-duration="1500" data-delay="0">0</div>
                </div>
                <div class="col-sm-6" style="padding:40px 0px 0px 0px;text-align: right">
                    <h3><b>Rumah Sakit</b></h3>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="tile-stats tile-green">
                <div class="icon"><i class="entypo-users"></i></div>
                <div class="col-sm-6" style="padding:30px 0px 0px 0px;">
                    <div class="num" data-start="0" data-end="<?php echo !empty($tile->jumlah_klinik) ? $tile->jumlah_klinik : 0; ?>" data-postfix="" data-duration="1500" data-delay="0">0</div>
                </div>
                <div class="col-sm-6" style="padding:40px 0px 0px 0px;text-align: right">
                    <h3><b>Klinik</b></h3>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="tile-stats tile-orange">
                <div class="icon"><i class="entypo-users"></i></div>
                <div class="col-sm-6" style="padding:30px 0px 0px 0px;">
                    <div class="num" data-start="0" data-end="<?php echo !empty($tile->jumlah_dokter) ? $tile->jumlah_dokter : 0; ?>" data-postfix="" data-duration="1500" data-delay="0">0</div>
                </div>
                <div class="col-sm-6" style="padding:40px 0px 0px 0px;text-align: right">
                    <h3><b>Dokter</b></h3>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="tile-stats tile-aqua">
                <div class="icon"><i class="entypo-users"></i></div>
                <div class="col-sm-6" style="padding:30px 0px 0px 0px;">
                    <div class="num" data-start="0" data-end="<?php echo !empty($tile->jumlah_puskesmas) ? $tile->jumlah_puskesmas : 0; ?>" data-postfix="" data-duration="1500" data-delay="0">0</div>
                </div>
                <div class="col-sm-6" style="padding:40px 0px 0px 0px;text-align: right">
                    <h3><b>Puskesmas</b></h3>
                </div>
            </div>
        </div>
    </div>
</div>