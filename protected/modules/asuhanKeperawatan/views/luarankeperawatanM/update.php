<?php
$this->breadcrumbs = array(
    'Luarankeperawatan Ms' => array('index'),
    $model->luarankeperawatan_id => array('view', 'id' => $model->luarankeperawatan_id),
    'Update',
);
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-edit"></i> Ubah <b>Luaran Keperawatan</b>
        </div>
    </div>
    <div class="panel-body">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php echo $this->renderPartial($this->path_view . '_form', array('model' => $model)); ?>
    </div>
</div>