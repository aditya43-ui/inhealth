<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
          <i class="far fa-edit"></i>  Ubah <b>Unit Kerja</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
    <?php
    $this->breadcrumbs=array(
            'Agunitkerja Ms'=>array('index'),
            $model->unitkerja_id=>array('view','id'=>$model->unitkerja_id),
            'Update',
    );

    ?>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <?php echo $this->renderPartial($this->path_view.'_form',array('model'=>$model,'modRuanganUnit'=>$modRuanganUnit)); ?>
    </div>
</div>