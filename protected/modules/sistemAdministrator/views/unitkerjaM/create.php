<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
           <i class="far fa-plus-square"></i> Tambah <b>Unit Kerja</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php
        $this->breadcrumbs=array(
                'Agunitkerja Ms'=>array('index'),
                'Create',
        );
        ?>
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php echo $this->renderPartial($this->path_view.'_form', array('model'=>$model)); ?>
    </div>
</div>