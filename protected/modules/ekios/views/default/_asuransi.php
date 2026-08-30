<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Oswald" />
<style>
    body {
        font-family: oswald;
    }

    .dafasun {
        height: 200px;
    }

    .tile-cyan {
        background-color: white !important;
        border: 2px solid #57a595;
        margin-bottom: 15px;
    }

    .tile-stats.tile-cyan .num {
        color: #57a595;
    }

    .tile-stats.tile-cyan h3 {
        color: black !important;
    }
</style>


<div class="block-kioskmodule" id="asuransi" name="asuransi">
    <div class="row">
        <?php


        $penjamin = EKPenjaminPasienM::model();
        $criteria = new CDbCriteria();

        $dataku = $penjamin->findAll($criteria);

        foreach ($dataku as $jamin) {


        ?>
            <div class="col-sm-3">

                <div class="tile-stats tile-cyan dafasun">
                    <div class="icon"><i class="entypo-paper-plane"></i></div>
                    <div class="num" style="font-size:2vw"><?php echo $jamin->penjamin_nama  ?></div>

                    <h3><?php echo $jamin->carabayar->carabayar_nama ?></h3>
                    <p></p>
                </div>

            </div>

        <?php
        }


        ?>
    </div>
</div>