<?php
//$this->breadcrumbs=array(
//	'Sanapza Ms'=>array('index'),
//	$model->napza_id,
//);
//
//$arrMenu = array();
//                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Napza ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','List').' SANapzaM', 'icon'=>'list', 'url'=>array('index'))) ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' SANapzaM', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Update').' SANapzaM', 'icon'=>'pencil','url'=>array('update','id'=>$model->napza_id))) :  '' ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','Delete').' SANapzaM','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->napza_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?')))) ;
// (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Napza', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

//$this->menu=$arrMenu;
//
//$this->widget('bootstrap.widgets.BootAlert'); 
?>

<?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
    'data' => $model,
    'attributes' => array(
        'napza_id',
        array(
            'label' => 'Jenis Napza',
            'type' => 'raw',
            'value' => $model->jenisNavza
        ),
        'napza_nama',
        'napza_namalain',
        array(
            'label' => 'Aktif',
            'type' => 'raw',
            'value' => (($model->napza_aktif == 1) ? '' . Yii::t('mds', 'Yes') . '' : '' . Yii::t('mds', 'No') . ''),
        ),
    ),
)); ?>

<div class="form-actions">
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Napza', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
    <?php $this->widget('UserTips', array('type' => 'view')); ?>
</div>