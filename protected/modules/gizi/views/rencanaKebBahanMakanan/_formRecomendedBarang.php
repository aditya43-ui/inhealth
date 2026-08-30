<div class="col-sm-6">
    <div class="control-group">
        <?php echo CHtml::label('Waktu Pemakaian Bahan Makanan <span style="color:red">*</span>', '', array('class' => 'control-label')); ?>
        <div class="controls">
            <?//php echo CHtml::hiddenField('o','',array()); ?>
            <?//php echo CHtml::hiddenField('x','',array()); ?>
            <?//php echo CHtml::hiddenField('sd','',array()); ?>
            <?//php echo CHtml::hiddenField('soh','',array()); ?>
            <?//php echo CHtml::hiddenField('k','',array()); ?>
            <?//php echo CHtml::hiddenField('lt','',array()); ?>
            <?//php echo CHtml::hiddenField('buffer_stok','',array()); ?>
            <?php echo CHtml::activeHiddenField($modRencanaKebBarang, 'leadtime_lt', array('readonly' => false, 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span2 numbers-only')) ?>
            <?php echo CHtml::activeTextField($modRencanaKebBarang, 'ro_bahanmakanan_bulan', array('placeholder' => '00', 'readonly' => false, 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span2 numbers-only')) ?> bulan
            <?php //echo CHtml::htmlButton('<i class="entypo-arrows-ccw"></i> Hitung RO',
            //	array('onclick'=>'hitungRO();return false;',
            //		  'class' => 'btn btn-danger',
            //		  'onkeyup'=>"hitungRO();",
            //		  'rel'=>"tooltip",
            //		  'title'=>"Klik untuk menghitung Recomended Order (RO)",)); 
            ?>
        </div>
    </div>
</div>