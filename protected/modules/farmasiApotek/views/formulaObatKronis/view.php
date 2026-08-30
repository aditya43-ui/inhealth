<?php
$this->breadcrumbs = array(
    'Pengaturan Formula Obat Kronis' => array('index'),
    $model->formulaobatkronis_id,
);

$arrMenu = array();
//                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Signa Obat ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','List').' FALookupM', 'icon'=>'list', 'url'=>array('index'))) ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' FALookupM', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Update').' FALookupM', 'icon'=>'pencil','url'=>array('update','id'=>$model->lookup_id))) :  '' ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','Delete').' FALookupM','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->lookup_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?')))) ;
// (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Signa Obat', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

$this->menu = $arrMenu;

$this->widget('bootstrap.widgets.BootAlert'); ?>

<div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Detail <b>Formula Obat Kronis</b>
                </div>
            </div>
            <div class="panel-body table-responsive">

         
<!--<fieldset class="box">-->
<!--<legend class="rim">Lihat <b>Signa Obat</b></legend>-->
<?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
    'data' => $model,
    'attributes' => array(
        array(
            'label' => 'ID',
            'type' => 'raw',
            'value' => $model->formulaobatkronis_id,
        ),
        array(
            'label' => 'Jumlah Obat',
            'type' => 'raw',
            'value' => $model->jumlahobat,
        ),
        array(
            'label' => 'Jumlah Obat Minimal <br> (Ina-CBGs)',
            'type' => 'raw',
            'value' => $model->jumlahobat_minimal,
        ),
        array(
            'label' => 'Jumlah Obat Maksimal <br> (fre for service)',
            'type' => 'raw',
            'value' => $model->jumlahobat_maksimal,
        ),
        array(
            'label' => 'Aktif',
            'type' => 'raw',
            'value' => (($model->is_aktif == 1) ? '' . Yii::t('mds', 'Aktif') . '' : '' . Yii::t('mds', 'Tidak Aktif') . ''),
        ),
    ),
)); ?>

<div class="form-actions">
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Formula Obat Kronis', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
    <?php $this->widget('UserTips', array('type' => 'view')); ?>
</div>
</div>
</div>
<!--</fieldset>-->