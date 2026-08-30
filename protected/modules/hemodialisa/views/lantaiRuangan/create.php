<!--<div class="white-container">
    <legend class="rim2">Tambah <b>Lookup</b></legend>-->
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">Tambah <b>Lantai Ruangan</b></div>
    </div>
    <div class="panel-body">
    <?php
    $this->breadcrumbs=array(
            'Lookup'=>array('index'),
            'Create',
    );
    $this->menu=array(
//        array('label'=>Yii::t('mds','Create').' Lookup ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master')),
    );

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial('_form', array('model'=>$model,'modDetail'=>$modDetail)); ?>
    </div>
</div>