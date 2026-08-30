<?php
$this->breadcrumbs = array(
    'Master Struktur Organigram',
);
/*
$arrMenu = array();
                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Gelar Belakang ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
//                (Yii::app()->user->checkAccess('Create')) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Gelar Belakang', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
                (Yii::app()->user->checkAccess('Admin')) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Gelar Belakang', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

$this->menu=$arrMenu;

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php $this->widget('ext.bootstrap.widgets.BootListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>

<?php $this->widget('UserTips',array('type'=>'list')); */ ?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-layer-group"></i> Master <b>Struktur Organigram</b>
        </div>
    </div>
    <div class="panel-body">
        <?php $this->renderPartial($this->path_view . '_tabMenu', array()); ?>
        <?php $this->renderPartial($this->path_view . '_jsFunctions', array()); ?>

        <iframe id="frame" class='biru' src="" style="width: 100%; overflow-y: scroll; border: none;"></iframe>
    </div>
</div>