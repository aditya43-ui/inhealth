
<div class="panel  panel-gradient">
    <div class="panel-heading">
        <div class="panel-title"><i class="far fa-edit"></i> Ubah <strong>Jadwal Pemberian Obat</strong></div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs=array(
                'Jadwal Pemberian Obat'=>array('admin'),
                $model->jadwalpemberianobat_id=>array('view','id'=>$model->jadwalpemberianobat_id),
                'Ubah',
        );
        
        $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php echo $this->renderPartial($this->path_view.'_form',array('model'=>$model)); ?>
    </div>
</div>

