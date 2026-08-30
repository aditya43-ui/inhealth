
<div class="panel  panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">Ubah <strong>Loket Pendaftaran Poli</strong></div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs=array(
                'Loket Pendaftaran Poli'=>array('admin'),
                $model->loketpendaftaranpoli_id=>array('view','id'=>$model->loketpendaftaranpoli_id),
                'Ubah',
        );
        
        $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php echo $this->renderPartial('_form',array('model'=>$model)); ?>
    </div>
</div>

