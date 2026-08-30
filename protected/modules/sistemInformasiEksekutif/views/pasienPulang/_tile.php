<div class="panel panel-success" style="margin-top: 17px;">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i> Summary Cara Pasien Pulang
        </div>
        <div class="panel-options">
            <a data-rel="collapse" href="#"><i class="entypo-down-open"></i></a>
        </div>
    </div>
    <div class="panel-body">
        <?php $class = ['tile-aqua', 'tile-green', 'tile-blue', 'tile-brown', 'tile-primary', 'tile-red', 'tile-orange', 'tile-purple']; ?>
        <div class="col-md-3" style="padding-right:4px !important;padding-left:4px !important">
            <div class="tile-stats tile-aqua">
                <div class="icon"><i class="entypo-mail"></i></div>
                <div class="col-md-6">
                    <div id="tile1" style="font-size:6vw" class="num" data-start="0" data-end="<?= !empty($map["DIPULANGKAN"]) ? $map["DIPULANGKAN"] : 0; ?>" data-postfix="" data-duration="1500" data-delay="0">0</div>
                </div>
                <div class="col-md-6">
                    <h4 style="color: white;text-align:right;"><b><?= "DIPULANGKAN" ?></b></h4>
                </div>
            </div>
        </div>
        <div class="col-md-3" style="padding-right:4px !important;padding-left:4px !important">
            <div class="tile-stats tile-green">
                <div class="icon"><i class="entypo-mail"></i></div>
                <div class="col-md-6">
                    <div id="tile1" style="font-size:6vw" class="num" data-start="0" data-end="<?= !empty($map["DIRUJUK"]) ? $map["DIRUJUK"] : 0; ?>" data-postfix="" data-duration="1500" data-delay="0">0</div>
                </div>
                <div class="col-md-6">
                    <h4 style="color: white;text-align:right;"><b><?= "DIRUJUK" ?></b></h4>
                </div>
            </div>
        </div>
        <div class="col-md-3" style="padding-right:4px !important;padding-left:4px !important">
            <div class="tile-stats tile-blue">
                <div class="icon"><i class="entypo-mail"></i></div>
                <div class="col-md-6">
                    <div id="tile1" style="font-size:6vw" class="num" data-start="0" data-end="<?= !empty($map["PULANG PAKSA"]) ? $map["PULANG PAKSA"] : 0; ?>" data-postfix="" data-duration="1500" data-delay="0">0</div>
                </div>
                <div class="col-md-6">
                    <h4 style="color: white;text-align:right;"><b><?= "PULANG PAKSA" ?></b></h4>
                </div>
            </div>
        </div>
        <div class="col-md-3" style="padding-right:4px !important;padding-left:4px !important">
            <div class="tile-stats tile-brown">
                <div class="icon"><i class="entypo-mail"></i></div>
                <div class="col-md-6">
                    <div id="tile1" style="font-size:6vw" class="num" data-start="0" data-end="<?= !empty($map["MENINGGAL"]) ? $map["MENINGGAL"] : 0; ?>" data-postfix="" data-duration="1500" data-delay="0">0</div>
                </div>
                <div class="col-md-6">
                    <h4 style="color: white;text-align:right;"><b><?= "MENINGGAL" ?></b></h4>
                </div>
            </div>
        </div>
        <div class="col-md-3" style="padding-right:4px !important;padding-left:4px !important">
            <div class="tile-stats tile-primary">
                <div class="icon"><i class="entypo-mail"></i></div>
                <div class="col-md-6">
                    <div id="tile1" style="font-size:6vw" class="num" data-start="0" data-end="<?= !empty($map["DIRAWAT INAP"]) ? $map["DIRAWAT INAP"] : 0; ?>" data-postfix="" data-duration="1500" data-delay="0">0</div>
                </div>
                <div class="col-md-6">
                    <h4 style="color: white;text-align:right;"><b><?= "DIRAWAT INAP" ?></b></h4>
                </div>
            </div>
        </div>
        <div class="col-md-3" style="padding-right:4px !important;padding-left:4px !important">
            <div class="tile-stats tile-red">
                <div class="icon"><i class="entypo-mail"></i></div>
                <div class="col-md-6">
                    <div id="tile1" style="font-size:6vw" class="num" data-start="0" data-end="<?= !empty($map["MELARIKAN DIRI"]) ? $map["MELARIKAN DIRI"] : 0; ?>" data-postfix="" data-duration="1500" data-delay="0">0</div>
                </div>
                <div class="col-md-6">
                    <h4 style="color: white;text-align:right;"><b><?= "MELARIKAN DIRI" ?></b></h4>
                </div>
            </div>
        </div>
        <div class="col-md-3" style="padding-right:4px !important;padding-left:4px !important">
            <div class="tile-stats tile-orange">
                <div class="icon"><i class="entypo-mail"></i></div>
                <div class="col-md-6">
                    <div id="tile1" style="font-size:6vw" class="num" data-start="0" data-end="<?= !empty($map["ALIH RAWAT"]) ? $map["ALIH RAWAT"] : 0; ?>" data-postfix="" data-duration="1500" data-delay="0">0</div>
                </div>
                <div class="col-md-6">
                    <h4 style="color: white;text-align:right;"><b><?= "ALIH RAWAT" ?></b></h4>
                </div>
            </div>
        </div>
        <div class="col-md-3" style="padding-right:4px !important;padding-left:4px !important">
            <div class="tile-stats tile-purple">
                <div class="icon"><i class="entypo-mail"></i></div>
                <div class="col-md-6">
                    <div id="tile1" style="font-size:6vw" class="num" data-start="0" data-end="<?= !empty($map["LAIN-LAIN"]) ? $map["LAIN-LAIN"] : 0; ?>" data-postfix="" data-duration="1500" data-delay="0">0</div>
                </div>
                <div class="col-md-6">
                    <h4 style="color: white;text-align:right;"><b><?= "LAIN-LAIN" ?></b></h4>
                </div>
            </div>
        </div>
    </div>
</div>