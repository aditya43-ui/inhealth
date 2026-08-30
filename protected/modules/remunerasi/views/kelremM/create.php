<fieldset class="box">
    <legend class="rim">Tambah Kelompok Remunerasi</legend>
    <?php
    //$this->breadcrumbs=array(
    //	'Sakelrem Ms'=>array('index'),
    //	'Create',
    //);

    //$arrMenu = array();
    //        array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Kelompok Remunerasi ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' SAGelarBelakangM', 'icon'=>'list', 'url'=>array('index'))) ;
    //    (Yii::app()->user->checkAccess('Admin')) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Kelompok Remunerasi', 'icon'=>'folder-open', 'url'=>array('Admin'))) :  '' ;

    //$this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>
    <?php //$this->renderPartial('_tabMenu',array()); 
    ?>
    <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'id' => 'kelrem-m-form',
        'enableAjaxValidation' => false,
        'type' => 'horizontal',
        'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => "return requiredCheck(this);"),
        'focus' => '#',
    )); ?>

    <!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>-->
    <?php echo $form->errorSummary($model); ?>

    <?php echo $form->textFieldRow($model, 'kelrem_urutan', array('size' => 3, 'maxlength' => 3, 'class' => 'numbers-only span1')); ?>
    <?php echo $form->textFieldRow($model, 'kelrem_kode', array('size' => 50, 'maxlength' => 50)); ?>
    <?php echo $form->textFieldRow($model, 'kelrem_nama', array('size' => 60, 'maxlength' => 100)); ?>
    <?php echo $form->textAreaRow($model, 'kelrem_desc', array('size' => 60, 'maxlength' => 200)); ?>
    <?php echo $form->textFieldRow($model, 'kelrem_singkatan', array('size' => 20, 'maxlength' => 20)); ?>
    <?php echo $form->textFieldRow($model, 'kelrem_rate', array('class' => 'numbers-only')); ?>
    <?php echo $form->checkBoxRow($model, 'kelrem_aktif'); ?>
    <div class="form-actions">
        <?php echo CHtml::htmlButton(
            $model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
                Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
            array(
                'class' => 'btn btn-danger', 'type' => 'submit',
                'onKeypress' => 'return formSubmit(this,event)',
                'id' => 'btn_simpan',
                //                                                    'onclick'=>'do_upload()',
            )
        ); ?>
        <?php echo CHtml::link(
            Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
            Yii::app()->createUrl($this->module->id . '/pegawaiM/admin'),
            array(
                'title' => 'Ulang',
                'class' => 'btn btn-default',
                'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
            )
        ); ?>
        <?php echo CHtml::link(
            Yii::t('mds', '{icon} Pengaturan Kelompok Remunerasi', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
            $this->createUrl('admin', array('tab' => 'frame', 'modul_id' => Yii::app()->session['modul_id'])),
            array('class' => 'btn btn-success',)
        ); ?>
        <?php
        $content = $this->renderPartial('sistemAdministrator.views.tips.tipsaddedit', array(), true);
        $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
        ?>
    </div>

    <?php $this->endWidget(); ?>

    </div><!--form-->
    <?php
    $js = <<< JS
    $(document).ready(function() {
    });
JS;
    Yii::app()->clientScript->registerScript('pencatatanriwayat', $js, CClientScript::POS_HEAD);
    ?>
</fieldset>