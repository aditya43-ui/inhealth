
<div class="panel  panel-gradient">
    <div class="panel-heading">
        <div class="panel-title"> <i class="far fa-edit"></i> Ubah <strong>Periode Aset Opname</strong></div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs=array(
                'Periode Aset Opname'=>array('admin'),
                $model->periodeasetopname_id=>array('view','id'=>$model->periodeasetopname_id),
                'Ubah',
        );
        
        $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php echo $this->renderPartial('_form',array('model'=>$model)); ?>
    </div>
</div>

