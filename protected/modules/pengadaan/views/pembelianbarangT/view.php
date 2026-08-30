<?php
$this->breadcrumbs=array(
	'Gupembelianbarang Ts'=>array('index'),
	$model->pembelianbarang_id,
);

$arrMenu = array();
                array_push($arrMenu,array('label'=>Yii::t('mds','View').' GUPembelianbarangT #'.$model->pembelianbarang_id, 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
                array_push($arrMenu,array('label'=>Yii::t('mds','List').' GUPembelianbarangT', 'icon'=>'list', 'url'=>array('index'))) ;
                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' GUPembelianbarangT', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
                (Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Update').' GUPembelianbarangT', 'icon'=>'pencil','url'=>array('update','id'=>$model->pembelianbarang_id))) :  '' ;
                array_push($arrMenu,array('label'=>Yii::t('mds','Delete').' GUPembelianbarangT','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->pembelianbarang_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?')))) ;
                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' GUPembelianbarangT', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

$this->menu=$arrMenu;

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'pembelianbarang_id',
		'terimapersediaan_id',
		'sumberdana_id',
		'supplier_id',
		'tglpembelian',
		'nopembelian',
		'tgldikirim',
		'peg_pemesanan_id',
		'peg_mengetahui_id',
		'peg_menyetujui_id',
		'create_time',
		'update_time',
		'create_loginpemakai_id',
		'update_loginpemakai_id',
		'create_ruangan',
	),
)); ?>

<?php $this->widget('UserTips',array('type'=>'view'));?>