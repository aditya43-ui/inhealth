<?php
$this->breadcrumbs = array(
    'Informasi Umur Piutang',
);
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Umur Piutang Perorangan</b>
        </div>
    </div>
    <div class="panel-body">
        <?php $this->renderPartial('indexPengajuanPiutang', array('model' => $model)); ?>
    </div>
</div>