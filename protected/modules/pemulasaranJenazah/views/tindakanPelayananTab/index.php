<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-briefcase"></i> Transaksi <b>Tindakan Pelayanan</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
            $this->renderPartial('_ringkasDataPasien', array('modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien));
        ?>

        <div class="isContent">
            <style>
                .table thead tr th {
                    vertical-align: middle;
                }
            </style>

            <?php $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                'id' => 'form-riwayat',
                'content' => array(
                    'content-detailpasien' => array(
                        'header' => '<b>Riwayat Pasien</b>',
                        'isi' => '<iframe src="" id="riwayatPasien" style="width:100%; height: 98%;"></iframe>',
                        'active' => false,
                    ),
                ),
            )); ?>
        </div>
        <div>
            <?php $this->renderPartial('_tabMenu') ?>
        </div>
        <div id="frameLoad">
            <iframe id="frame" class="biru" src="" style="width: 100%; overflow-y: scroll; border: none;"></iframe>
        </div>
    </div>
</div>
<?php 
$this->renderPartial('_jsFunctions', array('modPasien' => $modPasien));
?>