<?php
$this->breadcrumbs = array(
    'gzbahanmakanan Ms' => array('index'),
    'Create',
);
//
//$arrMenu = array();
////                array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Bahan Makanan ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
////                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Bahan Makanan', 'icon'=>'list', 'url'=>array('index'))) ;
////                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Bahan Makanan', 'icon'=>'folder-open', 'url'=>array('Admin'))) :  '' ;
//
//$this->menu=$arrMenu;
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-plus-square"></i> Tambah <b>Bahan Makanan</b>
        </div>
    </div>
    <div class="panel-body">
        <?php echo $this->renderPartial('_form', array('model' => $model)); ?>
    </div>
</div>