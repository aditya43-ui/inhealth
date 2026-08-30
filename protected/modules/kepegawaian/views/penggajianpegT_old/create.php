<div class="white-container">
    <?php
    $this->breadcrumbs=array(
            'Kppenggajianpeg Ts'=>array('index'),
            'Create',
    );

    $arrMenu = array();
//                    array_push($arrMenu,array('label'=>' Penggajian Pegawai ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' KPPenggajianpegT', 'icon'=>'list', 'url'=>array('index'))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' KPPenggajianpegT', 'icon'=>'folder-open', 'url'=>array('Admin'))) :  '' ;
    ?>
    <legend class="rim2">Penggajian <b>Pegawai</b></legend>
    <?php
    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>
    
    <?php echo $this->renderPartial('_form', array('model'=>$model, 'modPegawai'=>$modPegawai, 'komponen'=>$komponen)); ?>
</div>