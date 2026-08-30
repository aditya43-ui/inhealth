<div class="panel panel-success" style="margin-top: 17px;">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i> Summary <b>Rawat Inap Berdasarkan Cara Masuk</b>
        </div>
        <div class="panel-options">
            <a data-rel="collapse" href="#"><i class="entypo-down-open"></i></a>
        </div>
    </div>
    <div class="panel-body">
        <div class="col-md-6" style="padding-right:4px !important;padding-left:4px !important">
            <div class="tile-stats tile-red" style="background: #8ac926">
                <div class="icon"><i class="fa fa-folder"></i></div>
                <div class="col-md-6">
                    <div id="tile1" style="font-size:6vw" class="num" data-start="0" data-end="<?php echo $tile['rawat_darurat']; ?>" data-postfix="" data-duration="1500" data-delay="0">0</div>
                </div>
                <div class="col-md-6">
                    <h4 style="color: white;text-align:right;">Melalui Rawat Darurat</h4>
                </div>
            </div>
        </div>
        <div class="col-md-6" style="padding-right:4px !important;padding-left:4px !important">
            <div class="tile-stats tile-red" style="background: #ffca3a">
                <div class="icon"><i class="glyphicon glyphicon-alert"></i></div>
                <div class="col-md-6">
                    <div id="tile1" style="font-size:6vw" class="num" data-start="0" data-end="<?php echo $tile['rawat_jalan']; ?>" data-postfix="" data-duration="1500" data-delay="0">0</div>
                </div>
                <div class="col-md-6">
                    <h4 style="color: white;text-align:right;">Melalui Rawat Jalan </h4>
                </div>
            </div>
        </div>
    </div>
</div>