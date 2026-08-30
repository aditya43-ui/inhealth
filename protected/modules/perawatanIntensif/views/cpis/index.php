
<div class="panel  panel-gradient">
    <div class="panel-heading">
        <div class="panel-title"><strong>CPIS Pasien</strong></div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs=array(
                'CPIS Pasien'
        );
        
        $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php                 
        echo $this->renderPartial('_form',array(
            'model'=>$model,
            'modDet'=>$modDet,
        )); ?>
    </div>
</div>
<?= $this->renderPartial('_dialog',['model'=>$model], true) ?>
<?= $this->renderPartial('_jsFunction',['model'=>$model], true) ?>


