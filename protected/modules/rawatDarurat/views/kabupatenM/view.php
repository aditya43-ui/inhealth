<?php
//$this->widget('bootstrap.widgets.BootMenu', array(
//    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
//    'stacked'=>false, // whether this is a stacked menu
//    'items'=>array(
//        array('label'=>'Provinsi',  'url'=>$this->createUrl('/rawatDarurat/propinsiM')),
//        array('label'=>'Kabupaten', 'url'=>'', 'active'=>true),
//        array('label'=>'Kecamatan', 'url'=>$this->createUrl('/rawatDarurat/kecamatanM')),
//        array('label'=>'Kelurahan', 'url'=>$this->createUrl('/rawatDarurat/kelurahanM')),
//    ),
//)); 
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-eye"></i> Lihat <b>Kabupaten</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php
        $this->breadcrumbs = array(
            'Sakabupaten Ms' => array('index'),
            $model->kabupaten_id,
        );

        $arrMenu = array();
        //                    array_push($arrMenu,array('label'=>Yii::t('mds','View').' Kabupaten ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
        (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ? array_push($arrMenu, array('label' => Yii::t('mds', 'Manage') . ' Kabupaten', 'icon' => 'folder-open', 'url' => array('admin'))) :  '';

        $this->menu = $arrMenu;

        $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
            'data' => $model,
            'attributes' => array(
                'kabupaten_id',
                'propinsi.propinsi_nama',
                'kabupaten_nama',
                'kabupaten_namalainnya',
                'longitude',
                'latitude',
                array(
                    'label' => 'Aktif',
                    'type' => 'raw',
                    'value' => (($model->kabupaten_aktif == 1) ? '' . Yii::t('mds', 'Yes') . '' : '' . Yii::t('mds', 'No') . ''),
                ),
            ),
        )); ?>
        <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Kabupaten', array('{icon}' => '<i class="entypo-folder"></i>')), $this->createUrl(Yii::app()->controller->id . '/admin', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger',)); ?>
        <?php $this->widget('UserTips', array('type' => 'view')); ?>
    </div>
</div>