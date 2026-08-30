<div class="white-container">
    <legend class="rim2">Ubah <b>Golongan Umur</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Sagolongan Umur Ms'=>array('index'),
            $model->golonganumur_id=>array('view','id'=>$model->golonganumur_id),
            'Update',
    );

    $this->menu=array(
    //        array('label'=>Yii::t('mds','Update').' Golongan Umur ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master')),
    //	array('label'=>Yii::t('mds','List').' Golongan Umur', 'icon'=>'list', 'url'=>array('index')),
    //	array('label'=>Yii::t('mds','Create').' Golongan Umur', 'icon'=>'file', 'url'=>array('create')),
    //	array('label'=>Yii::t('mds','View').' Golongan Umur', 'icon'=>'eye-open', 'url'=>array('view','id'=>$model->golonganumur_id)),
    //	array('label'=>Yii::t('mds','Manage').' Golongan Umur', 'icon'=>'folder-open', 'url'=>array('admin')),
    );

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial($this->path_view.'_formUpdate',array('model'=>$model)); ?>
    <?php //$this->widget('UserTips',array('type'=>'update'));?>
</div>