<?php
$this->breadcrumbs = array(
    'Akjenisrekonsiliasibank Ms' => array('index'),
    $model->jenisrekonsiliasibank_id => array('view', 'id' => $model->jenisrekonsiliasibank_id),
    'Update',
);
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-edit"></i> Ubah <b>Jenis Rekonsiliasi Bank</b>
        </div>
    </div>
    <div class="panel-body">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php echo $this->renderPartial($this->path_view . '_form', array('model' => $model)); ?>
    </div>
</div>