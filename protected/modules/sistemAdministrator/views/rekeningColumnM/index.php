<?php
$this->breadcrumbs = array(
    'Master Jurnal Rekening',
);
/*
$arrMenu = array();
                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Jurnal Rek Penerimaan', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Jurnal Rek Penerimaan ', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

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
            <i class="fas fa-layer-group"></i> Master <b>Jurnal Rekening</b>
        </div>
    </div>
    <div class="panel-body">
        <?php $this->renderPartial('_tabMenuPenerimaan', array()); ?>
        <?php $this->renderPartial('_jsFunctions', array()); ?>

        <iframe id="frame" class='biru' src="" style="width: 100%; overflow-y: scroll; border: none;"></iframe>
    </div>
</div>