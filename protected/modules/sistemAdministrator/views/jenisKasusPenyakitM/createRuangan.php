<?php
$cs = Yii::app()->clientScript;
$cs->scriptMap = array(
    'bootstrap-multiselect.js' => false,
);

$this->breadcrumbs = array(
    'Sajenis Kasus Penyakit Ms' => array('index'),
    'Create',
);

$arrMenu = array();
array_push($arrMenu, array('label' => Yii::t('mds', 'Create') . ' Kasus Penyakit Ruangan', 'header' => true, 'itemOptions' => array('class' => 'heading-master')));
//                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Jenis Kasus Penyakit', 'icon'=>'list', 'url'=>array('index'))) ;
(Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ? array_push($arrMenu, array('label' => Yii::t('mds', 'Manage') . ' Jenis Kasus Penyakit', 'icon' => 'folder-open', 'url' => array('Admin'))) : '';

$this->menu = $arrMenu;
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'loginpemakai-k-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'focus' => '#',
));
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-plus-square"></i> Tambah <b>Jenis Kasus Penyakit</b>
        </div>
    </div>
    <div class="panel-body">
        <!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                                    ?></p>-->
        <?php echo $form->errorSummary($model); ?>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'Jenis Kasus Penyakit', array('class' => 'control-label required')); ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'jeniskasuspenyakit_id', CHtml::listData($model->JenisKasusPenyakitItems, 'jeniskasuspenyakit_id', 'jeniskasuspenyakit_nama'), array('empty' => '-- Pilih Jenis Kasus Penyakit --', 'class' => 'span5')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'ruangan_id', array('class' => 'control-label required')); ?>
            <div class="controls">
                <?php
                $this->widget(
                    'application.extensions.emultiselect.EMultiSelect',
                    array('sortable' => true, 'searchable' => true)
                );
                echo CHtml::dropDownList(
                    'ruangan_id[]',
                    '',
                    CHtml::listData(SARuanganM::model()->findAll(array('order' => 'ruangan_nama')), 'ruangan_id', 'ruangan_nama'),
                    array('multiple' => 'multiple', 'key' => 'ruangan_id', 'class' => 'multiselect', 'style' => 'width:500px;height:150px')
                );
                ?>

            </div>
        </div>
        <div class="form-actions">
            <?php
            echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
                Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'submitButton'));
            ?>
            <?php
            echo CHtml::link(
                Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                $this->createUrl('admin'),
                array('title' => 'Ulang', 'class' => 'btn btn-default', 'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')
            );
            ?>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>