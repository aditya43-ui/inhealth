<div class="white-container">
    <legend class="rim2">Tambah <b>Alternatif Diagnosa</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Bataskarakteristik Ms'=>array('index'),
            'Create',
    );
    $this->menu=array(
//        array('label'=>Yii::t('mds','Create').' Lookup ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master')),
    );

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial($this->path_view. '_form', array('model'=>$model,'modDetail'=>$modDetail)); ?>
</div>