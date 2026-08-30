<?php
$this->breadcrumbs = array(
    'Master Pendidikan',
);
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-layer-group"></i> Master <b>Pendidikan</b>
        </div>
    </div>
    <div class="panel-body">
        <?php $this->renderPartial('_tabMenu', array()); ?>
        <?php $this->renderPartial('_jsFunctions', array()); ?>

        <iframe class="biru" id="frame" src="" width='100%' height="100%" frameborder="0" style="overflow-y:scroll"></iframe>
    </div>
</div>