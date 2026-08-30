
<div class="panel panel-primary panel-gradient">
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

        <?php echo $this->renderPartial($this->path_view.'_form', array('modDet' => $modDet, 'model'=>$model,'modDetail'=> $modDetail, 'racikan' => $racikan, 'nonRacikan' => $nonRacikan, 'racikanDetail' => $racikanDetail)); ?>
    </div>
</div>
  