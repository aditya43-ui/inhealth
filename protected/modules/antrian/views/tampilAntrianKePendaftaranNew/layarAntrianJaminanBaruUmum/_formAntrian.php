<div>
    <div class="row-fluid">
        <div class = "span12">
        <?php echo CHtml::activehiddenField($model,'antrian_id',array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        <?php echo CHtml::activehiddenField($model,'ruangan_id',array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        <?php echo CHtml::activehiddenField($model,'carabayar_id',array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        <?php echo CHtml::activehiddenField($model,'pendaftaran_id',array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        <?php echo CHtml::activehiddenField($model,'profilrs_id',array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        <?php echo CHtml::activehiddenField($model,'loket_id',array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        <?php echo CHtml::activehiddenField($model,'tglantrian',array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        <?php echo CHtml::activehiddenField($model,'noantrian',array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>6)); ?>
        <?php echo CHtml::activehiddenField($model,'statuspasien',array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
        <?php echo CHtml::activehiddenField($model,'carabayar_loket',array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
        <?php echo CHtml::activehiddenField($model,'panggil_flaq',array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
	</div>
    </div>
</div>
    

