<?php
$this->breadcrumbs = array(
    'Edukasi B' => array('admin'),
    'Tambah'
);
?>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">Tambah <strong>Edukasi B</strong></div>
    </div>
    <div class="panel-body" style="overflow-x: scroll">
        <?php echo $this->renderPartial($this->path_view . '_form', array('model' => $model)); ?>
    </div>
</div>
