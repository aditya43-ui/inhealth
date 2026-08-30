<?php
$this->breadcrumbs = array(
    'Sakelompok Umur Ms' => array('index'),
    $model->kelompokumur_id,
);

$arrMenu = array();
array_push($arrMenu, array('label' => Yii::t('mds', 'View') . ' Kelompok Umur #' . $model->kelompokumur_id, 'header' => true, 'itemOptions' => array('class' => 'heading-master')));
array_push($arrMenu, array('label' => Yii::t('mds', 'List') . ' Kelompok Umur', 'icon' => 'list', 'url' => array('index')));
(Yii::app()->user->checkAccess('Create')) ? array_push($arrMenu, array('label' => Yii::t('mds', 'Create') . ' Kelompok Umur', 'icon' => 'file', 'url' => array('create'))) :  '';
(Yii::app()->user->checkAccess('Update')) ? array_push($arrMenu, array('label' => Yii::t('mds', 'Update') . ' Kelompok Umur', 'icon' => 'pencil', 'url' => array('update', 'id' => $model->kelompokumur_id))) :  '';
array_push($arrMenu, array('label' => Yii::t('mds', 'Delete') . ' Kelompok Umur', 'icon' => 'trash', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->kelompokumur_id), 'confirm' => Yii::t('mds', 'Are you sure you want to delete this item?'))));
(Yii::app()->user->checkAccess('Admin')) ? array_push($arrMenu, array('label' => Yii::t('mds', 'Manage') . ' Kelompok Umur', 'icon' => 'folder-open', 'url' => array('admin'))) :  '';

$this->menu = $arrMenu;

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
    'data' => $model,
    'attributes' => array(
        'kelompokumur_id',
        'kelompokumur_nama',
        'kelompokumur_namalainnya',
        'kelompokumur_minimal',
        'kelompokumur_maksimal',
        array(               // related city displayed as a link
            'name' => 'kelompokumur_aktif',
            'type' => 'raw',
            'value' => (($model->kelompokumur_aktif == 1) ? Yii::t('mds', 'Yes') : Yii::t('mds', 'No')),
        ),
    ),
)); ?>

<div class="form-actions">
    <?php $this->widget('UserTips', array('type' => 'view')); ?>
</div>