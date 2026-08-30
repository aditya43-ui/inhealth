<div class="col-sm-6">
    <div class="control-group">
        <?php echo CHtml::label("Periode Bulan", 'jadwaldokter_mulai', array('class' => 'control-label')) ?>
        <div class="controls">
            <div class="input-append">
                <input value="<?php echo MyFormatter::formatMonthForUser($model->tgl_awal) ?>" type="text" name="PenggajianpegT[tgl_awal]" id="PenggajianpegT_tgl_awal" onkeypress="return $(this).focusNextInputField(event);" readonly="readonly" class="span3 hasDatepicker">
                <span class="add-on" onclick="$('#PenggajianpegT_tgl_awal').focus()"><i class="entypo-calendar"></i></span>
            </div>
        </div>
    </div>
    <?php /*
		<div class="control-group">
			<?php echo $form->labelEx($model,'tglpenggajian', array('class'=>'control-label')) ?>
			<div class="controls">  
				<?php $model->tgl_awal=$format->formatDateTimeForUser($model->tgl_awal); ?>
				<?php $this->widget('MyDateTimePicker',array(
									   'model'=>$model,
									   'attribute'=>'tgl_awal',
									   'mode'=>'date',
	//                                          'maxDate'=>'d',
									   'options'=> array(
									   'dateFormat'=>Params::DATE_FORMAT,
									  ),
									   'htmlOptions'=>array('readonly'=>true,
									   'class'=>'dtPicker2',
									   'style'=>'width:150px;',
									   'onkeypress'=>"return $(this).focusNextInputField(event)"),
				  )); ?>
					  <?php  $model->tgl_awal = $format->formatDateTimeForDb($model->tgl_awal); ?>
			</div>
		</div>
		
		<div class="control-group">
			<?php echo CHtml::label(' Sampai Dengan',' Sampai Dengan', array('class'=>'control-label')) ?>
			<div class="controls">  
			<?php $model->tgl_akhir=$format->formatDateTimeForUser($model->tgl_akhir); ?>
			<?php $this->widget('MyDateTimePicker',array(
								 'model'=>$model,
								 'attribute'=>'tgl_akhir',
								 'mode'=>'date',
	//                                         'maxdate'=>'d',
								 'options'=> array(
								 'dateFormat'=>Params::DATE_FORMAT,
								),
								 'htmlOptions'=>array('readonly'=>true,
								 'class'=>'dtPicker2',
							     'style'=>'width:150px;',
								 'onkeypress'=>"return $(this).focusNextInputField(event)"),
							)); ?>
					  <?php  $model->tgl_akhir = $format->formatDateTimeForDb($model->tgl_akhir); ?>
			</div> 
		</div>
		 * 
		 */ ?>
</div>
<div class="col-sm-6">
    <?php echo $form->textFieldRow($model, 'nopenggajian', array('placeholder' => 'No. Penggajian', 'class' => 'span3')); ?>

</div>
<div class="clear"></div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
    ); ?>
<?php echo CHtml::link(
    Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
    Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . ''),
    array(
        'title' => 'Ulang',
        'class' => 'btn btn-default',
        'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
    )
); ?>
    <?php
    //$content = $this->renderPartial($this->path_view.'../tips/informasi_penggajianKaryawan',array(),true);
    //$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
    ?>
</div>