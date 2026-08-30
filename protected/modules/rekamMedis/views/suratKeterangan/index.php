<?php
$this->breadcrumbs = array(
    'Transaksi Surat Keterangan'
);
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-briefcase"></i> Transaksi <b>Surat Keterangan</b>
        </div>
    </div>
    <div class="panel-body">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-user"></i> Data <b>Pasien</b>
                </div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial($this->path_view . '_dataPasien', array('modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien)); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Surat Keterangan
                </div>
            </div>
            <div class="panel-body">
                <!--fieldset class="box"-->
                <?php
                $this->renderPartial($this->path_view . '_tabMenu', array('modPendaftaran' => $modPendaftaran));
                $this->renderPartial($this->path_view . '_jsFunctions', array("modPasien" => $modPasien));
                ?>
                <iframe class="biru" id="frame" src="" width='100%' frameborder="0" style="overflow-y:scroll; "></iframe>
                <!--</fieldset>-->
            </div>
        </div>
    </div>
</div>