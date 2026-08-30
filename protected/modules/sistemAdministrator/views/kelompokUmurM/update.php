<?php
$this->breadcrumbs = array(
    'Sakelompok Umur Ms' => array('index'),
    $model->kelompokumur_id => array('view', 'id' => $model->kelompokumur_id),
    'Update',
);

$arrMenu = array();
array_push($arrMenu, array('label' => Yii::t('mds', 'Update') . ' Kelompok Umur #' . $model->kelompokumur_id, 'header' => true, 'itemOptions' => array('class' => 'heading-master')));
array_push($arrMenu, array('label' => Yii::t('mds', 'List') . ' Kelompok Umur', 'icon' => 'list', 'url' => array('index')));
(Yii::app()->user->checkAccess('Create')) ? array_push($arrMenu, array('label' => Yii::t('mds', 'Create') . ' Kelompok Umur', 'icon' => 'file', 'url' => array('create'))) :  '';
array_push($arrMenu, array('label' => Yii::t('mds', 'View') . ' Kelompok Umur', 'icon' => 'eye-open', 'url' => array('view', 'id' => $model->kelompokumur_id)));
(Yii::app()->user->checkAccess('Admin')) ? array_push($arrMenu, array('label' => Yii::t('mds', 'Manage') . ' Kelompok Umur', 'icon' => 'folder-open', 'url' => array('admin'))) :  '';

$this->menu = $arrMenu;

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php echo $this->renderPartial('_formUpdate', array('model' => $model)); ?>
<?php //$this->widget('UserTips',array('type'=>'update'));
?>