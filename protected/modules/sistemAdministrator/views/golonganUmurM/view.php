<div class="white-container">
    <legend class="rim2">Lihat <b>Golongan Umur</b></legend>
    <?php
    $this->breadcrumbs = array(
        'Sagolongan Umur Ms' => array('index'),
        $model->golonganumur_id,
    );

    $this->menu = array(
        //        array('label'=>Yii::t('mds','View').' Golongan Umur ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master')),
        //	array('label'=>Yii::t('mds','List').' Golongan Umur', 'icon'=>'list', 'url'=>array('index')),
        //	array('label'=>Yii::t('mds','Create').' Golongan Umur', 'icon'=>'file', 'url'=>array('create')),
        //        array('label'=>Yii::t('mds','Update').' Golongan Umur', 'icon'=>'pencil','url'=>array('update','id'=>$model->golonganumur_id)),
        //	array('label'=>Yii::t('mds','Delete').' Golongan Umur','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->golonganumur_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?'))),
        //	array('label'=>Yii::t('mds','Manage').' Golongan Umur', 'icon'=>'folder-open', 'url'=>array('admin')),
    );

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
        'data' => $model,
        'attributes' => array(
            'golonganumur_id',
            'golonganumur_nama',
            'golonganumur_namalainnya',
            'golonganumur_minimal',
            'golonganumur_maksimal',
            'golonganumur_aktif',
        ),
    )); ?>

    <div class="form-actions">
        <?php echo CHtml::link(
            Yii::t('mds', '{icon} Pengaturan Golongan Umur', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
            $this->createUrl('Admin', array('modul_id' => Yii::app()->session['modul_id'])),
            array('class' => 'btn btn-success',)
        ); ?>
        <?php $this->widget('UserTips', array('type' => 'view')); ?>
    </div>
</div>