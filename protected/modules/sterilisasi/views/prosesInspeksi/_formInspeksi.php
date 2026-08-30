<?php echo $form->errorSummary($model); ?>
<div class="col-sm-6">
    <?php echo $form->radioButtonListInlineRow($model, 'ins_kebersihan', array('Bersih' => 'Bersih', 'Bernoda' => 'Bernoda'), array('onkeypress' => "return $(this).focusNextInputField(event)")); ?>
</div>
<div class="col-sm-6">
    <div class="control-group">
        <?php echo CHtml::label('Keterangan', 'keterangan', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->textArea($model, 'kebersihan_ket', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
</div>
<div class="clear"></div>
<hr>

<div class="col-sm-6">
    <?php echo $form->radioButtonListInlineRow($model, 'ins_perubahanpermukaan', array('Tidak ada' => 'Tidak ada', 'Ada' => 'Ada'), array('onkeypress' => "return $(this).focusNextInputField(event)")); ?>
</div>
<div class="col-sm-6">
    <div class="control-group">
        <?php echo CHtml::label('Keterangan', 'keterangan', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->textArea($model, 'perubahanpermukaan_ket', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
</div>
<div class="clear"></div>
<hr>

<div class="col-sm-6">
    <?php echo $form->radioButtonListInlineRow($model, 'ins_lubrikasi', array('Ya' => 'Ya', 'Tidak' => 'Tidak'), array('onkeypress' => "return $(this).focusNextInputField(event)")); ?>
</div>
<div class="col-sm-6">
    <div class="control-group">
        <?php echo CHtml::label('Keterangan', 'keterangan', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->textArea($model, 'lubrikasi_ket', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
</div>
<div class="clear"></div>
<hr>

<div class="col-sm-6">
    <?php echo $form->radioButtonListInlineRow($model, 'ins_fungsionalitas', array('Lolos Semua' => 'Lolos Semua', 'Lolos Sebagian' => 'Lolos Sebagian', 'Tidak Lolos' => 'Tidak Lolos'), array('onkeypress' => "return $(this).focusNextInputField(event)")); ?>  
</div>
<div class="col-sm-6">
    <div class="control-group">
        <?php echo CHtml::label('Keterangan', 'keterangan', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php
            echo $form->textArea($model, 'fungsionalitas_ket', array('rows' => 3, 'cols' => 50, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);"));
            ?>
        </div>
    </div>
</div>
<div class="clear"></div>
<hr>

<div class="col-sm-6">
    <div class="control-group">
        <?php echo CHtml::label('Tindak Lanjut', 'keterangan', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->dropDownList($model, 'tindaklanjut', array('Cuci Ulang' => 'Cuci Ulang', 'Pemolesan' => 'Pemolesan', 'Pemusnahan' => 'Pemusnahan', 'Perbaiki Alat' => 'Perbaiki Alat', 'Lainnya' => 'Lainnya'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)",)); ?> 
        </div>
    </div> 
</div>
<div class="col-sm-6">
    <div class="control-group">
        <?php echo CHtml::label('Keterangan', 'keterangan', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php
            echo $form->textArea($model, 'tindaklanjut_ket', array('rows' => 3, 'cols' => 50, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);"));
            ?>
        </div>
    </div>
</div>
<div class="clear"></div>
<hr>

