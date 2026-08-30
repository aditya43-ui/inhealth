<?php
$this->breadcrumbs=array(
	'Loginpemakai Ks'=>array('index'),
	$model->loginpemakai_id,
);

$arrMenu = array();
                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Login Pemakai ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Login Pemakai', 'icon'=>'list', 'url'=>array('index'))) ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Login Pemakai', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Login Pemakai', 'icon'=>'pencil','url'=>array('update','id'=>$model->loginpemakai_id))) :  '' ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','Delete').' Login Pemakai','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->loginpemakai_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?')))) ;
                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Login Pemakai', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

$this->menu=$arrMenu;

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'loginpemakai_id',
		'nama_pemakai',
		'katakunci_pemakai',
		'lastlogin',
		'tglpembuatanlogin',
		'tglupdatelogin',
		array(            
                                            'label'=>'Status Login',
                                            'type'=>'raw',
                                            'value'=>(($model->statuslogin==1)? ''.Yii::t('mds','Yes').'' : ''.Yii::t('mds','No').''),
                                        ),
		array(            
                                            'label'=>'Aktif',
                                            'type'=>'raw',
                                            'value'=>(($model->loginpemakai_aktif==1)? ''.Yii::t('mds','Yes').'' : ''.Yii::t('mds','No').''),
                                        ),
		array(            
                                            'label'=>'Dibuat oleh Pemakai',
                                            'type'=>'raw',
                                            'value'=>(!empty ($model->loginpemakai_create)) ? LoginpemakaiK::model()->findByPk($model->loginpemakai_create)->nama_pemakai : '-',
                                        ),
		array(            
                                            'label'=>'Diubah oleh Pemakai',
                                            'type'=>'raw',
                                            'value'=>(!empty ($model->loginpemakai_update)) ? LoginpemakaiK::model()->findByPk($model->loginpemakai_update)->nama_pemakai : '-',
                                        ),
		array(            
                                            'label'=>'Ruangan',
                                            'type'=>'raw',
                                            'value'=>$this->renderPartial("_ruanganPemakai",array("modRuanganPemakai"=>$modRuanganPemakai),true),
                                        ),
		array(            
                                            'label'=>'Modul',
                                            'type'=>'raw',
                                            'value'=>$this->renderPartial("_modulPemakai",array("modModulPemakai"=>$modModulPemakai),true),
                                        ),
	),
)); ?>

<?php $this->widget('UserTips',array('type'=>'view'));?>