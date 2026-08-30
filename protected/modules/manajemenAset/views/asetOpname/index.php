
<div class="panel  panel-gradient">
    <div class="panel-heading">
        <div class="panel-title"><i class="glyphicon glyphicon-briefcase"></i> <strong>Aset Opname</strong></div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs=array(
                'Aset Opname'
        );
        
        $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php echo $this->renderPartial('_form',array(
            'model'=>$model,
            'modInv'=>$modInv,            
        )); ?>
    </div>
</div>
<?= $this->renderPartial($this->path_view.'_dialog',['model'=>$model], true) ?>
<?= $this->renderPartial($this->path_view.'_jsFunction',['model'=>$model], true) ?>


