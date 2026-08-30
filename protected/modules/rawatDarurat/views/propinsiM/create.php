<?php
//$this->widget('bootstrap.widgets.BootMenu', array(
//    'type'=>'pills', // '', 'tabs', 'pills' (or 'list')
//    'stacked'=>false, // whether this is a stacked menu
//    'items'=>array(
//        array('label'=>'Provinsi', 'url'=>'', 'active'=>true),
//        array('label'=>'Kabupaten', 'url'=>$this->createUrl('/rawatDarurat/kabupatenM')),
//        array('label'=>'Kecamatan', 'url'=>$this->createUrl('/rawatDarurat/kecamatanM')),
//        array('label'=>'Kelurahan', 'url'=>$this->createUrl('/rawatDarurat/kelurahanM')),
//    ),
//)); 
?>
<!--<div class="white-container">
    <legend class="rim2">Tambah <b>Provinsi</b></legend>-->
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-plus-square"></i> Tambah <b>Provinsi</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Sapropinsi Ms' => array('index'),
            'Create',
        );

        $arrMenu = array();
        //                    array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Provinsi', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
        //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Provinsi', 'icon'=>'list', 'url'=>array('index'))) ;
        (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ? array_push($arrMenu, array('label' => Yii::t('mds', 'Manage') . ' Provinsi', 'icon' => 'folder-open', 'url' => array('Admin'))) :  '';

        $this->menu = $arrMenu;

        $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php echo $this->renderPartial('_form', array('model' => $model)); ?>
        <?php //$this->widget('UserTips',array('type'=>'create'));
        ?>
        <!--</div>-->
    </div>
</div>