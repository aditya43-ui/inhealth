<?php
$this->breadcrumbs=array(
	'Esselon Ms'=>array('index'),
	$model->esselon_id,
);

$arrMenu = array();
                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Esselon ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Gelar Belakang', 'icon'=>'list', 'url'=>array('index'))) ;
//                (Yii::app()->user->checkAccess('Create')) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Gelar Belakang', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
//                (Yii::app()->user->checkAccess('Update')) ?array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Gelar Belakang', 'icon'=>'pencil','url'=>array('update','id'=>$model->gelarbelakang_id))) :  '' ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','Delete').' Gelar Belakang','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->gelarbelakang_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?')))) ;
                (Yii::app()->user->checkAccess('Admin')) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Esselon', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

$this->menu=$arrMenu;
?>

<?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'esselon_id',
		'esselon_nama',
		'esselon_namalainnya',
                                array(
                                    'label'=>'Aktif',
                                    'value'=>(($model->esselon_aktif==1)? "Ya" : "Tidak")
                                )
	),
)); ?>
