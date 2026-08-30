<?php
$this->breadcrumbs = array(
    'Penyulit Hd Ms' => array('index'),
    $model->penyulit_hd_id => array('view', 'id' => $model->penyulit_hd_id),
    'Update',
);

$this->menu = array(
    array('label' => 'List PenyulitHdM', 'url' => array('index')),
    array('label' => 'Create PenyulitHdM', 'url' => array('create')),
    array('label' => 'View PenyulitHdM', 'url' => array('view', 'id' => $model->penyulit_hd_id)),
    array('label' => 'Manage PenyulitHdM', 'url' => array('admin')),
);
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">Ubah <b>Penyulit HD</b></div>
    </div>
    <div class="panel-body">
        <?php echo $this->renderPartial('_form', array('model' => $model)); ?>
    </div>
</div>
