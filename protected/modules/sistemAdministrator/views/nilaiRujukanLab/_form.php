<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'sanilairujukan-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
));
?>

<div class="row">
    <!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                                ?></p>-->
    <?php echo $form->errorSummary($model); ?>

    <div class="col-sm-6">
        <?php echo $form->dropDownListRow($model, 'kelkumurhasillab_id', CHtml::listData(KelkumurhasillabM::model()->findAll(array('order' => 'kelkumurhasillab_urutan'), 'kelkumurhasillab_aktif = true'), 'kelkumurhasillab_id', 'kelkumurhasillabnama'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->dropDownListRow($model, 'nilairujukan_jeniskelamin', LookupM::getItems('jeniskelamin'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
        <?php echo $form->textFieldRow($model, 'kelompokdet', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'placeholder' => 'Kelompok Detail')); ?>
        <?php echo $form->textFieldRow($model, 'namapemeriksaandet', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 200, 'placeholder' => 'Nama Detail Pemeriksaan')); ?>
        <?php echo $form->textFieldRow($model, 'nilairujukan_nama', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 100, 'placeholder' => 'Nilai Rujukan')); ?>

        <div class="control-group">
            <?php echo CHtml::label("", 'nilairujukan_aktif', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'nilairujukan_aktif', array('id' => 'aktif')); ?> <label for="aktif">Aktif</label>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'nilairujukan_min', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'placeholder' => 'Nilai Minimum')); ?>
        <?php echo $form->textFieldRow($model, 'nilairujukan_max', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'placeholder' => 'Nilai Maksimum')); ?>
        <?php //echo $form->textFieldRow($model,'nilairujukan_satuan',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); 
        ?>
        <?php echo $form->dropDownListRow($model, 'nilairujukan_satuan', LookupM::getItems('satuanhasillab'), array('class' => 'span3', 'empty' => '-- Pilih --')); ?>
        <?php echo $form->textFieldRow($model, 'nilairujukan_metode', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 30, 'placeholder' => 'Metode')); ?>
        <?php echo $form->dropDownListRow($model, 'jeniskegiatanlab_id', CHtml::listData(JeniskegiatanlabM::model()->findAll(array('order' => 'jeniskegiatanlab_kode'), 'jeniskegiatanlab_aktif = true'), 'jeniskegiatanlab_id', 'jeniskegiatanlab3'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
       
        <?php echo $form->textAreaRow($model, 'nilairujukan_keterangan', array('rows' => 3, 'cols' => 50, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'placeholder' => 'Keterangan')); ?>
    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('class' => 'btn btn-danger', 'title' => 'Simpan', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
    ); ?>
    <?php
    echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        $this->createUrl('create'),
        array(
            'class' => 'btn btn-default',
            'title' => 'Ulang',
            'onclick' => 'return refreshForm(this);'
        )
    );
    ?>
    <?php //echo CHtml::link(Yii::t('mds','{icon} Pengaturan Nilai Rujukan (Referensi) Lab',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger',)); 
    ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Nilai Rujukan (Referensi)', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
    <?php
    $content = $this->renderPartial($this->path_view . 'tips/tipsCreate', array(), true);
    $this->widget('UserTips', array('content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>