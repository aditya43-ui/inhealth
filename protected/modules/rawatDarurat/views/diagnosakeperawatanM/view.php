<div class="white-container">
    <legend class="rim2">Lihat <b>Diagnosa Keperawatan</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Sadiagnosakeperawatan Ms'=>array('index'),
            $model->diagnosakeperawatan_id,
    );

    $arrMenu = array();
//                    array_push($arrMenu,array('label'=>Yii::t('mds','View').' Diagnosa Keperawatan', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' RDDiagnosakeperawatanM', 'icon'=>'list', 'url'=>array('index'))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' RDDiagnosakeperawatanM', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Update').' RDDiagnosakeperawatanM', 'icon'=>'pencil','url'=>array('update','id'=>$model->diagnosakeperawatan_id))) :  '' ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','Delete').' RDDiagnosakeperawatanM','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->diagnosakeperawatan_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?')))) ;
                    (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Diagnosa Keperawatan', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'diagnosakeperawatan_id',
		'diagnosa_id',
		'diagnosakeperawatan_kode',
		'diagnosa_medis',
		'diagnosa_keperawatan',
		'diagnosa_tujuan',
		'diagnosa_keperawatan_aktif',
                'kriteriahasil_id'
	),
    )); ?>

    <?php $this->widget('UserTips',array('type'=>'view'));?>
</div>