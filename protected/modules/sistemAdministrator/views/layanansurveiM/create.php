<?php
/*
$this->breadcrumbs=array(
	'Layanansurvei Ms'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List LayanansurveiM','url'=>array('index')),
	array('label'=>'Manage LayanansurveiM','url'=>array('admin')),
);
*/
?>

<!--<div class="white-container">
    <legend class="rim2">Tambah <b>Ruangan</b></legend>-->
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-plus-square"></i> Tambah <b>Layanan Survei</b>
        </div>
    </div>
    <div class="panel-body">

        <?php
        $this->breadcrumbs = array(
            'Layanansurvei Ms' => array('index'),
            'Create',
        );

        $arrMenu = array();
        //                array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Ruangan ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
        //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Ruangan', 'icon'=>'list', 'url'=>array('index'))) ;
        // (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Ruangan', 'icon'=>'folder-open', 'url'=>array('Admin'))) :  '' ;

        $this->menu = $arrMenu;

        $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php echo $this->renderPartial('_form', array('model' => $model)); ?>
        <?php //$this->widget('UserTips',array('type'=>'create'));
        ?>
    </div>
</div>