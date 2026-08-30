<?php
$this->breadcrumbs = array(
    'Master Index Penilaian Kinerja Pegawai',
);
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-layer-group"></i> Master <b>Index Penilaian Kinerja Pegawai</b>
        </div>
    </div>
    <div class="panel-body">
        <?php $this->renderPartial('_tabMenu', array()); ?>
        <?php $this->renderPartial('_jsFunctions', array()); ?>

        <iframe id="frame" class="biru" src="" style="width: 100%; overflow-y: scroll; border: none;"></iframe>
    </div>
</div>