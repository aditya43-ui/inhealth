
<div class="panel  panel-gradient">
    <div class="panel-heading">
        <div class="panel-title"> <i class="far fa-edit"></i> Ubah <strong>Penanggung Jawab Aset Ruangan</strong></div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs=array(
                'Penanggung Jawab Aset Ruangan'=>array('admin'),
                $model->penanggungjawabaset_id=>array('view','id'=>$model->penanggungjawabaset_id),
                'Ubah',
        );
        
        $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php echo $this->renderPartial('_form',array('model'=>$model)); ?>
    </div>
</div>

