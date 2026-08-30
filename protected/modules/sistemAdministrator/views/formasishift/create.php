<?php
$this->breadcrumbs = array(
    'Saformasishift Ms' => array('index'),
    'Create',
);
?>

<!--<div class="white-container">
	<legend class="rim2">Tambah <b>Formasi Shift</b></legend>-->
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-plus-square"></i> Tambah <b>Formasi Shift</b>
        </div>
    </div>
    <div class="panel-body">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php echo $this->renderPartial($this->path_view . '_formCreate', array('model' => $model, 'modInstalasi' => $modInstalasi, 'instalasiTujuans' => $instalasiTujuans, 'ruanganTujuans' => $ruanganTujuans)); ?>
    </div>
</div>
<!--</div>-->
<?php echo $this->renderPartial($this->path_view . '_jsFunctions', array('model' => $model)); ?>