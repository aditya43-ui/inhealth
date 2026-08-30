
<div class="panel  panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">Tambah <strong>Total Disolve Solids</strong></div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs=array(
                'Total Disolve Solids'=>array('admin'),                
                'Tambah',
        );
        
        $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php echo $this->renderPartial('_form',array('model'=>$model)); ?>
    </div>
</div>


