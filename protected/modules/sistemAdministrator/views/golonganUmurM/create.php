<div class="white-container">
    <legend class="rim2">Tambah <b>Golongan Umur</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Sagolongan Umur Ms'=>array('index'),
            'Create',
    );

    $this->menu=array(
    //        array('label'=>Yii::t('mds','Create').' Golongan Umur ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master')),
    //	array('label'=>Yii::t('mds','List').' Golongan Umur', 'icon'=>'list', 'url'=>array('index')),
    //	array('label'=>Yii::t('mds','Manage').' Golongan Umur', 'icon'=>'folder-open', 'url'=>array('admin')),
    );

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial($this->path_view.'_form', array('model'=>$model)); ?>
    <?php //$this->widget('UserTips',array('type'=>'create'));?>
</div>