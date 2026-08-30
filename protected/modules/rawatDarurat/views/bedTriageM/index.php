<?php

$this->breadcrumbs = array(
    'Bed Triage Ms',
);

$arrMenu = array();
array_push($arrMenu, array('label' => Yii::t('mds', 'List') . ' Bed Triage ', 'header' => true, 'itemOptions' => array('class' => 'heading-master')));
(Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ? array_push($arrMenu, array('label' => Yii::t('mds', 'Manage') . ' Bed Triage ', 'icon' => 'folder-open', 'url' => array('admin'))) : '';

$this->menu = $arrMenu;

if (isset($_GET['sukses'])) {
    Yii::app()->user->setFlash('success', "Data pasien berhasil disimpan!");
}

$this->widget('bootstrap.widgets.BootAlert');
?>

<?php

$this->widget('ext.bootstrap.widgets.BootListView', array(
    'dataProvider' => $dataProvider,
    'itemView' => $this->path_view . '_view',
));
?>

<?php $this->widget('UserTips', array('type' => 'list')); ?>