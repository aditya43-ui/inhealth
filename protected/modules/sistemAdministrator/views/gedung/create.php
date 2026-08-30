
<div class="panel  panel-gradient">
    <div class="panel-heading">
        <div class="panel-title"><i class="far fa-plus-square"></i> Tambah <strong>Gedung</strong></div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs=array(
                'Gedung'=>array('admin'),                
                'Tambah',
        );
        $this->pageTitle = 'Tambah Gedung';
        $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php echo $this->renderPartial($this->path_view.'_form',array('model'=>$model)); ?>
    </div>
</div>


