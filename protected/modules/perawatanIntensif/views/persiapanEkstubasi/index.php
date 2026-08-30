
<div class="panel  panel-gradient">
    <div class="panel-heading">
        <div class="panel-title"><strong>Formulir Persiapan Ekstubasi Pasien</strong></div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs=array(
                'Formulir Persiapan Ekstubasi Pasien'
        );
        
        $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php        
        echo CHtml::hiddenField("jns_dialog","");
        echo $this->renderPartial('_form',array(
            'model'=>$model,
        )); ?>
    </div>
</div>
<?= $this->renderPartial('_dialog',['model'=>$model], true) ?>
<?= $this->renderPartial('_jsFunction',['model'=>$model], true) ?>


