<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'saperiodeposting-m-search',
    'type' => 'horizontal',
)); ?>

<div class="row">
    <div class="col-sm-6">
        <?php echo $form->dropDownListRow($model, 'konfiganggaran_id', CHtml::listData(KonfiganggaranK::model()->findAll(array('order' => 'deskripsiperiode ASC')), 'konfiganggaran_id', 'deskripsiperiode'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')); ?>
        <?php echo $form->textFieldRow($model, 'periodeposting_nama', array('placeholder' => 'Nama Periode', 'class' => 'span3', 'maxlength' => 100)); ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->dropDownListRow($model, 'rekperiode_id', CHtml::listData(RekperiodM::model()->findAll(array('order' => 'deskripsi ASC')), 'rekperiod_id', 'deskripsi'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')); ?>
        <?php //echo $form->checkBoxRow($model,'periodeposting_aktif',array('checked'=>true)); 
        ?>

        <div class="control-group">
            <?php echo CHtml::label("", 'periodeposting_aktif', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'periodeposting_aktif', array('checked' => 'periodeposting_aktif')); ?> <label for="SAPeriodepostingM_periodeposting_aktif">Aktif</label>
            </div>
            <?php //echo $form->checkBoxRow($model,'pangkat_aktif',array('checked'=>'pangkat_aktif')); 
            ?>
        </div>
    </div>
    <!--<div class="col-sm-4"></div>-->
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
    ); ?>
    <?php //echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="entypo-search"></i>')),array('class' => 'btn btn-default', 'type'=>'reset')); 
    ?>
</div>

<?php $this->endWidget(); ?>