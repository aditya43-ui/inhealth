
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">Tambah <strong>Master Paket Obat</strong></div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs=array(
                'Paket Obat'=>array('admin'),
                'tambah',
        );
        ?>
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php echo $this->renderPartial($this->path_view.'_form', array('model'=>$model,'modDetail'=> $modDetail)); ?>
    </div>
</div>
  