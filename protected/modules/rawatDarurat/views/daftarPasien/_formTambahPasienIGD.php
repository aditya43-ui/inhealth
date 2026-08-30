<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm',
        array(
            'id'=>'ubahKelPenyakit-form',
            'enableAjaxValidation'=>false,
            'type'=>'horizontal',
            'focus'=>'#',
            'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
        )
    );
?>
<p class="help-block">
    <?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?>
</p>
<?php echo $form->errorSummary(array($model)); ?>
<?php echo $form->hiddenField($model, 'pendaftaran_id'); ?>
<div class="control-group">
    <div class="controls">
        <?php
                  $criteria = new CDbCriteria();
                  $criteria->addCondition(" statusperiksa = '" . Params::STATUSPERIKSA_ANTRIAN . "' ");
                  $criteria->addCondition(" instalasi_id = '" . Params::INSTALASI_ID_RD . "' ");
                  $tanggal = date('Y-m-d');
                  $criteria->addCondition("date(create_time) = '".$tanggal."'");
                  $criteria->addCondition(" no_triage_pasien IS NULL");
                  $criteria->select = 'pendaftaran_id,no_pendaftaran,nama_pasien';
                  $criteria->group = 'pendaftaran_id,no_pendaftaran,nama_pasien';
                  $infokunjungan = InfokunjunganrdV::model()->findAll($criteria);

        // echo $form->dropDownListRow($model, 'bed_triage_id', CHtml::listData(BedTriageM::model()->findAllByAttributes(array('is_aktif'=>true)), 'bed_triage_id', 'no_bed'), array('empty' => '-- Pilih --', 'class' => 'span2 required', 'style'=>'width:200px;','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'readonly' => isset($model->pendaftaran_id) ? true : false, 'disabled' => isset($model->pendaftaran_id) ? true : false));
        ?>
        <select id="select-state" class="required span4" onchange="loadDataPasien(this)" style="font-size: 10px;">
                    <option value="">-- Pilih --</option>
                    <?php foreach ($infokunjungan as $result) { ?>
                        <option value="<?php echo $result->pendaftaran_id; ?>">
                            <?php echo $result->no_pendaftaran . " - " . $result->nama_pasien; ?>
                        </option>
                    <?php } ?>
                </select>
              
    </div>
</div>
<div class="control-group">
    <div class="controls">
        <?php echo $form->textFieldRow($model, 'no_bed_triage',array('readonly'=>true, 'class' => 'span2')); ?>
    </div>
</div>
<div class="control-group">
    <div class="controls">
       <?php echo $form->textAreaRow($model,'keterangan',array('rows'=>2, 'cols'=>60, 'class'=>'span3 ', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    </div>
</div>

<div class="form-actions">
    <?php
        echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),array('class' => 'btn btn-danger', 'type'=>'submit','onKeypress'=>'return formSubmit(this,event)'));
    ?>
	<?php
        echo CHtml::htmlButton(
			Yii::t('mds','{icon} Cancel', array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
			array('class' => 'btn btn-default', 'type'=>'button','onClick'=>'closeDialog();')
		);
    ?>
</div>
<?php $this->endWidget(); ?>

<script type="text/javascript">
	function closeDialog(){
		window.parent.$('#tambahTriage').dialog('close');
	}
</script>