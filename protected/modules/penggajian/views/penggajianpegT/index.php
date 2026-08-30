<?php
$this->breadcrumbs = array(
    'Gjpenggajianpeg Ts',
);

$arrMenu = array();
array_push($arrMenu, array('label' => Yii::t('mds', 'List') . ' GJPenggajianpegT ', 'header' => true, 'itemOptions' => array('class' => 'heading-master')));
(Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ? array_push($arrMenu, array('label' => Yii::t('mds', 'Create') . ' GJPenggajianpegT', 'icon' => 'file', 'url' => array('create'))) :  '';
(Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ? array_push($arrMenu, array('label' => Yii::t('mds', 'Manage') . ' GJPenggajianpegT', 'icon' => 'folder-open', 'url' => array('admin'))) :  '';

$this->menu = $arrMenu;

$this->widget('bootstrap.widgets.BootAlert');
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-briefcase"></i> Pengajuan Gaji Pegawai
        </div>
    </div>
    <div class="panel-body">
        <?php $this->widget('ext.bootstrap.widgets.BootListView', array(
            'dataProvider' => $dataProvider,
            'itemView' => $this->path_view . '_view',
        )); ?>

        <?php $this->widget('UserTips', array('type' => 'list')); ?>
    </div>
</div>