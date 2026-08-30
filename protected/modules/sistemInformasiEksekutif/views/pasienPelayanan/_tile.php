<div class="panel panel-success" style="margin-top: 17px;">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i> Summary Pelayanan Pasien (3 Terbanyak)
        </div>
        <div class="panel-options">
            <a data-rel="collapse" href="#"><i class="entypo-down-open"></i></a>
        </div>
    </div>
    <div class="panel-body">
        <?php
        ksort($dataTile);
        $i = 1;
        if (isset($dataTile)) {
            foreach ($dataTile as $k => $val) {
                if ($i <= 3) {
                    switch ($i) {
                        case 3:
                            $warna = 'tile-green';
                            break;
                        case 2:
                            $warna = 'tile-blue';
                            break;
                        default:
                            $warna = 'tile-red';
                            break;
                    }
        ?>
                    <div class="col-md-4" style="padding-right:4px !important;padding-left:4px !important">
                        <div class="tile-stats <?= $warna ?>">
                            <div class="icon"><i class="entypo-mail"></i></div>
                            <div class="col-md-6">
                                <div id="tile1" style="font-size:6vw" class="num" data-start="0" data-end="<?= $val['jumlah'] ?>" data-postfix="" data-duration="1500" data-delay="0">0</div>
                            </div>
                            <div class="col-md-6">
                                <h4 style="color: white;text-align:right;"><b><?= $val['jenis'] ?></b></h4>
                            </div>
                        </div>
                    </div>
        <?php };
                $i++;
            };
        }; ?>
    </div>
</div>