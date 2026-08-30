<div>
    <div class="row-fluid">
        <div class = "span12">
        <?php echo CHtml::hiddenField('kodeantrian',$loket->racikan_singkatan,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        <?php echo CHtml::activehiddenField($model,'antrianfarmasi_id',array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        <?php echo CHtml::activehiddenField($model,'racikan_id',array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        <?php echo CHtml::activehiddenField($model,'ruangan_id',array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        <?php echo CHtml::activehiddenField($model,'tglambilantrian',array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        <?php echo CHtml::activehiddenField($model,'noantrian',array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>6)); ?>
        <?php echo CHtml::activehiddenField($model,'panggilantrian',array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
        <?php echo CHtml::activehiddenField($model,'antrianlewat',array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
	</div>
    </div>
</div>
    

