<style type="text/css">
    .paket {
        width: 320px;
        display: inline-table;
        margin-top: 20px;
        margin-left: 0px;
        vertical-align: top;
    }

    .pakettable {
        border: 1px solid LightSteelBlue;
    }

    .litindakan {
        list-style-position: inside;
        list-style: none;
    }

    .bedpaket {
        border-color: #CCCCCC;
        display: inline-block;
        margin: -5px;
        width: 100%;
    }

    .popover-title-pak {
        background-color: Lavender;
    }

    h4.popover-title-pak {
        text-align: center;
    }

    .paket {
        float: left;
    }

    .tile-purple {
        background-color: white !important;
        border: 2px solid #57a595;
        margin-bottom: 15px;
    }

    .tile-stats.tile-purple .num {
        color: #57a595;
    }

    .tile-stats.tile-purple p {
        color: #57a595;
    }

    .tile-stats .tile-purple h3 {
        color: black !important;
    }
</style>

<div class="block-kioskmodule" id="paketpelayanan" name="paketpelayanan">
    <div class="contentKamar" style="max-height:400px;">
        <div class="row">
            <?php
            $tipepaket = EKTipepaketM::model()->findAll('tipepaket_aktif = true');
            foreach ($tipepaket as $data => $paket) {
            ?>
                <div class="col-md-4">
                    <div class="tile-stats tile-purple">
                        <div class="icon"><i class="entypo-gauge"></i></div>
                        <div class="num"><?php echo $paket->tipepaket_nama ?></div>

                        <h3 style="color:black"><?php echo "Rp " . number_format($paket->tarifpaket, 2) ?></h3>
                        <h3 style="color:black">Paket Meliputi</h3>
                        <?php
                        $daftartindakan = PaketpelayananM::model()->findAll('tipepaket_id = ' . $paket->tipepaket_id);
                        foreach ($daftartindakan as $data => $tindakan) {
                            echo "<p><i class='icon-form-check'></i>&nbsp;" . $tindakan->daftartindakan->daftartindakan_nama . "<br></p>";
                        }
                        ?>

                    </div>
                </div>

            <?php
            }
            ?>
        </div>
    </div>
</div>