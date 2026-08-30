<?php
$this->breadcrumbs = array(
    'Satipeanastesi Ms' => array('index'),
    $model->typeanastesi_id,
);

$arrMenu = array();
array_push($arrMenu, array('label' => Yii::t('mds', 'View') . ' Tipe Anastesi ' . $model->typeanastesi_id, 'header' => true, 'itemOptions' => array('class' => 'heading-master')));
$this->menu = $arrMenu;
$this->widget('bootstrap.widgets.BootAlert');
?>

<?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
    'data' => $model,
    'attributes' => array(
        'typeanastesi_id',
        'anastesi_id',
        'typeanastesi_nama',
        'typeanastesi_namalain',
        'typeanastesi_aktif',
        array(
            'label' => 'Aktif',
            'type' => 'raw',
            'value' => (($model->typeanastesi_aktif == 1) ? '' . Yii::t('mds', 'Yes') . '' : '' . Yii::t('mds', 'No') . ''),
        ),
    ),
)); ?>

<?php //$this->widget('UserTips',array('type'=>'view'));
?>
<?php echo CHtml::link(
    Yii::t('mds', '{icon} Pengaturan Tipe Anastesi', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
    $this->createUrl('/sistemAdministrator/TipeAnastesiM/Admin', array('modul_id' => Yii::app()->session['modul_id'])),
    array('class' => 'btn btn-success',)
); ?>
