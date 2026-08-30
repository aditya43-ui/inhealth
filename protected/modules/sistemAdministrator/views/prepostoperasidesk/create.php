<?php
$this->breadcrumbs = array(
    'Checklist Pra dan Post Operasi' => array('admin'),
    'Tambah'
);
?>
<div class="panel panel-success panel-shadow">
    <div class="panel-heading">
        <div class="panel-title">Tambah <strong>Checklist Pra dan Post Operasi</strong></div>
    </div>
    <div class="panel-body" style="overflow-x: scroll">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php echo $this->renderPartial($this->path_view . '_form', array('model' => $model)); ?>
    </div>
</div>
