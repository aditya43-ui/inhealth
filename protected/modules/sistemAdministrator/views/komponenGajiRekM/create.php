<?php
$this->breadcrumbs = array(
    'Rekening Komponen Gaji' => Yii::app()->request->getUrlReferrer(),
    'Tambah',
);
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-plus-square"></i> Tambah <b>Rekening Komponen Gaji</b>
        </div>
    </div>
    <div class="panel-body">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php echo $this->renderPartial($this->path_view . '_form', array('model' => $model)); ?>
    </div>
</div>