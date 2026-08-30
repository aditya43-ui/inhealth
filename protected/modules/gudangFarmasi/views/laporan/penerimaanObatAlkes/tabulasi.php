<?php
$this->breadcrumbs = array(
    'Laporan Penerimaan Obat Alkes',
);
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-newspaper"></i> Laporan <b>Penerimaan Obat Alkes</b>
        </div>
    </div>
    <div class="panel-body">
        <?php $this->renderPartial('penerimaanObatAlkes/_tabMenu', array()); ?>
        <?php $this->renderPartial('penerimaanObatAlkes/_jsFunctions', array()); ?>

            <iframe id="frame" class="biru" src="" style="width: 100%; overflow-y: scroll; border: none;"></iframe>
    </div>
</div>