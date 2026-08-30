<div class="white-container">
    <legend class="rim2">Lihat <b>Kelompok Modul</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Sakelompok Modul Ks'=>array('index'),
            $model->kelompokmodul_id,
    );

    $this->menu=array(
    //        array('label'=>Yii::t('mds','View').' Kelompok Modul ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master')),
    //	array('label'=>Yii::t('mds','List').' Kelompok Modul', 'icon'=>'list', 'url'=>array('index')),
    //	array('label'=>Yii::t('mds','Create').' Kelompok Modul', 'icon'=>'file', 'url'=>array('create')),
    //        array('label'=>Yii::t('mds','Update').' Kelompok Modul', 'icon'=>'pencil','url'=>array('update','id'=>$model->kelompokmodul_id)),
    //	array('label'=>Yii::t('mds','Delete').' Kelompok Modul','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->kelompokmodul_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?'))),
    //	array('label'=>Yii::t('mds','Manage').' Kelompok Modul', 'icon'=>'folder-open', 'url'=>array('admin')),
    );

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
            'data'=>$model,
            'attributes'=>array(
                    'kelompokmodul_id',
                    'kelompokmodul_nama',
                    'kelompokmodul_namalainnya',
                    'kelompokmodul_fungsi',
                                    array(
                                        'label'=>'Aktif',
                                        'value'=>(($model->kelompokmodul_aktif==1)? "Ya" : "Tidak"),
                                    ),
            ),
    )); ?>
    <?php echo CHtml::link(Yii::t('mds','{icon} Ubah',array('{icon}'=>'<i class="entypo-pencil"></i>')),$this->createUrl('update',array('id'=>$model->kelompokmodul_id,'modul_id'=> Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger',)); ?>
    <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Kelompok Modul', array('{icon}'=>'<i class="icon-file icon-white"></i>')), $this->createUrl(Yii::app()->controller->id.'/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger',));
            $this->widget('UserTips',array('type'=>'view'));?>
</div>