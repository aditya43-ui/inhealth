<?php
$this->breadcrumbs = array(
    'Diagnosakep Ms' => array('index'),
    $model->diagnosakep_id,
);

$arrMenu = array();
//                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Signa Obat ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','List').' FALookupM', 'icon'=>'list', 'url'=>array('index'))) ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' FALookupM', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Update').' FALookupM', 'icon'=>'pencil','url'=>array('update','id'=>$model->lookup_id))) :  '' ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','Delete').' FALookupM','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->lookup_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?')))) ;
// (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Signa Obat', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

$this->menu = $arrMenu;
$this->widget('bootstrap.widgets.BootAlert');
?>

<div class="panel panel-gradient">
    <div class="panel panel-heading">
        <div class="panel-title">
            <i class="far fa-eye"></i> Lihat <b>Diagnosa Keperawatan</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php
        $this->widget('ext.bootstrap.widgets.BootDetailView', array(
            'data' => $model,
            'attributes' => array(
                array(
                    'label' => 'Kode Diagnosa',
                    'type' => 'raw',
                    'value' => $model->diagnosakep_kode,
                ),
                array(
                    'label' => 'Diagnosa Keperawatan',
                    'type' => 'raw',
                    'value' => $model->diagnosakep_nama,
                ),
                array(
                    'label' => 'Deskripsi',
                    'type' => 'raw',
                    'value' => $model->diagnosakep_deskripsi,
                ),
                array(
                    'label' => 'Aktif',
                    'type' => 'raw',
                    'value' => (($model->diagnosakep_aktif == 1) ? '' . Yii::t('mds', 'Yes') . '' : '' . Yii::t('mds', 'No') . ''),
                ),
            ),
        ));
        ?>

        <div class="form-actions">
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Pengaturan Diagnosa Keperawatan', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
                $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
                array('class' => 'btn btn-success')
            ); ?>
            <?php $this->widget('UserTips', array('type' => 'view')); ?>
        </div>
    </div>
</div>