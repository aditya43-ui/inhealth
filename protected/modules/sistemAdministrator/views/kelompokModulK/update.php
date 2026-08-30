<div class="white-container">
    <legend class="rim2">Ubah <b>Kelompok Modul</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Sakelompok Modul Ks'=>array('index'),
            $model->kelompokmodul_id=>array('view','id'=>$model->kelompokmodul_id),
            'Update',
    );

    $this->menu=array(
    //        array('label'=>Yii::t('mds','Update').' Kelompok Modul ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master')),
    //	array('label'=>Yii::t('mds','List').' Kelompok Modul', 'icon'=>'list', 'url'=>array('index')),
    //	array('label'=>Yii::t('mds','Create').' Kelompok Modul', 'icon'=>'file', 'url'=>array('create')),
    //	array('label'=>Yii::t('mds','View').' Kelompok Modul', 'icon'=>'eye-open', 'url'=>array('view','id'=>$model->kelompokmodul_id)),
    //	array('label'=>Yii::t('mds','Manage').' Kelompok Modul', 'icon'=>'folder-open', 'url'=>array('admin')),
    );

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial('_formUpdate',array('model'=>$model)); ?>
    <?php //$this->widget('UserTips',array('type'=>'update'));?>
</div>