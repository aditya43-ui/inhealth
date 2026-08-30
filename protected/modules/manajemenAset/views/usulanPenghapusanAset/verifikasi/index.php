
<div class="panel  panel-gradient">
    <div class="panel-heading">
        <div class="panel-title"><i class="glyphicon glyphicon-file"></i> <strong>Usulan Penghapusan</strong></div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs=array(
                'Usulan Penghapusan'
        );
        
        $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php echo $this->renderPartial('verifikasi/_form',array(
            'model'=>$model,
            'modDet'=>$modDet,                     
        )); ?>
    </div>
</div>
<?= $this->renderPartial($this->path_view.'verifikasi/_dialog',['model'=>$model], true) ?>



