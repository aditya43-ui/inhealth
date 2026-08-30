<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title"><i class="glyphicon glyphicon-briefcase"></i> Pencatatan Aset Ruangan</div>
    </div>
    <div class="panel-body">
        
    <?php
    $this->breadcrumbs=array(
            'Tambah Pencatatan Aset Ruangan'            
    );
    $this->widget('bootstrap.widgets.BootAlert');   

     ?>

    <?php echo $this->renderPartial('_form', array('model'=>$model,'modelDetail' => $modelDetail,'modBarang' => $modBarang)); ?>
    <?php $this->renderPartial('manajemenAset.views._jsFunction', array()); ?>
    </div>
</div>