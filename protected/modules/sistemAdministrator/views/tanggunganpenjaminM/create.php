<?php
$this->breadcrumbs = array(
    'Tanggungan Pasien' => array('admin'),
    'Tambah/Udpdate',
);

$arrMenu = array();
//                    array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Tanggungan Penjamin ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Tanggungan Penjamin', 'icon'=>'list', 'url'=>array('index'))) ;
// (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Tanggungan Penjamin', 'icon'=>'folder-open', 'url'=>array('Admin'))) :  '' ;

$this->menu = $arrMenu;
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-plus-square"></i> Tambah/Update <b>Tanggungan Pasien</b>
        </div>
    </div>
    <div class="panel-body">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php echo $this->renderPartial($this->path_view . '_form', array('model' => $model, 'dataTanggunganPenjamin' => $dataTanggunganPenjamin, 'modTanggung' => $modTanggung)); ?>
        <?php //$this->widget('UserTips',array('type'=>'create'));
        ?>

    </div>
</div>