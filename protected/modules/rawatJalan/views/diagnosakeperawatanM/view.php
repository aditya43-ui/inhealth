<legend class='rim'>Lihat Diagnosa Keperawatan</legend>
<?php
$this->breadcrumbs = array(
    'Sadiagnosakeperawatan Ms' => array('index'),
    $model->diagnosakeperawatan_id,
);

// $arrMenu = array();
// array_push($arrMenu,array('label'=>Yii::t('mds','View').' Diagnosa Keperawatan', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','List').' RJDiagnosakeperawatanM', 'icon'=>'list', 'url'=>array('index'))) ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' RJDiagnosakeperawatanM', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Update').' RJDiagnosakeperawatanM', 'icon'=>'pencil','url'=>array('update','id'=>$model->diagnosakeperawatan_id))) :  '' ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','Delete').' RJDiagnosakeperawatanM','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->diagnosakeperawatan_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?')))) ;
// (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Diagnosa Keperawatan', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

// $this->menu=$arrMenu;

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
    'data' => $model,
    'attributes' => array(
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

<div class="form-actions">
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Ubah', array('{icon}' => '<i class="entypo-pencil"></i>')),
        $this->createUrl('update', array('id' => $model->diagnosakeperawatan_id, 'modul_id' => Yii::app()->session['modul_id'])),
        array('title' => 'Ubah', 'class' => 'btn btn-danger',)
    ); ?>
    <?php
    echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Diagnosa Keperawatan', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl('diagnosakeperawatanM/Admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
    <?php $this->widget('UserTips', array('type' => 'view')); ?>
</div>