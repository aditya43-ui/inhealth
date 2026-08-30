
<div class="panel  panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">Tambah <strong>Loket Pendaftaran Poli</strong></div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs=array(
                'Loket Pendaftaran Poli'=>array('admin'),                
                'Tambah',
        );
        
        $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php echo $this->renderPartial('_form',array('model'=>$model)); ?>
    </div>
</div>


