<div class="control-group">
    <?php echo CHtml::label('GAJI POKOK', '', array('class' => 'control-label')) ?>
    <div class="controls">
        <?php echo CHtml::textField('thr_gajipokok', '0', array('class' => 'span2 inputFormTabel integer2', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
        / Bulan
    </div>
</div>
<div class="control-group">
    <?php echo CHtml::label('TUNJANGAN TETAP', '', array('class' => 'control-label')) ?>
    <div class="controls">
        <?php echo CHtml::textField('thr_tunj_fungsional', '0', array('class' => 'span2 inputFormTabel integer2', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
        / Bulan
    </div>
</div>
<?php /*
  <div class="control-group">
  <?php echo CHtml::label('TUNJANGAN JABATAN', '', array('class' => 'control-label')) ?>
  <div class="controls">
  <?php echo CHtml::textField('thr_tunj_jabatan','0',array('class'=>'span2 inputFormTabel integer2', 'readonly'=>true, 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
  / Bulan
  </div>
  </div>
 * 
 */ ?>
<div class="control-group">
    <?php echo CHtml::label('PENGHASILAN BRUTO DISETAHUNKAN', '', array('class' => 'control-label')) ?>
    <div class="controls">
        <?php echo CHtml::textField('thr_bruto', '0', array('class' => 'span2 inputFormTabel integer2', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
    </div>
</div>
<div class="control-group">
    <?php echo CHtml::label('THR', '', array('class' => 'control-label')) ?>
    <div class="controls">
        <?php echo CHtml::textField('thr_thr', '0', array('class' => 'span2 inputFormTabel integer2', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
    </div>
</div>
<div class="control-group">
    <?php echo CHtml::label('TOTAL PENGHASILAN GAJI & THR', '', array('class' => 'control-label')) ?>
    <div class="controls">
        <?php echo CHtml::textField('thr_total_gaji_thr', '0', array('class' => 'span2 inputFormTabel integer2', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
    </div>
</div>
<div class="control-group">
    <?php echo CHtml::label('BIAYA JABATAN', '', array('class' => 'control-label')) ?>
    <div class="controls">
        <?php echo CHtml::textField('thr_biaya_jabatan', '0', array('class' => 'span2 inputFormTabel integer2', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
        / Tahun
    </div>
</div>
<div class="control-group">
    <?php echo CHtml::label('PENGHASILAN NETO SETAHUN ', '', array('class' => 'control-label')) ?>
    <div class="controls">
        <?php echo CHtml::textField('thr_neto', '0', array('class' => 'span2 inputFormTabel integer2', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
    </div>
</div>
<div class="control-group">
    <?php echo CHtml::label('PTKP', '', array('class' => 'control-label')) ?>
    <div class="controls">
        <?php echo CHtml::textField('thr_ptkp', '0', array('class' => 'span2 inputFormTabel integer2', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
    </div>
</div>
<div class="control-group">
    <?php echo CHtml::label('PKP', '', array('class' => 'control-label')) ?>
    <div class="controls">
        <?php echo CHtml::textField('thr_pkp', '0', array('class' => 'span2 inputFormTabel integer2', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo CHtml::hiddenField('pphpersenkomponenTHR', '', array('class' => 'span3', 'readonly' => TRUE)); ?>
        <?php echo CHtml::hiddenField('pphpersen21komponenTHR', '', array('class' => 'span3', 'readonly' => TRUE)); ?>
        <?php echo CHtml::hiddenField('blnpertamagaji', '', array('class' => 'span3', 'readonly' => TRUE)); ?>
    </div>
</div>
<div class="control-group">
    <?php echo CHtml::label('PPh 21 TERUTANG ATAS GAJI & THR', '', array('class' => 'control-label')) ?>
    <div class="controls">
        <?php echo CHtml::textField('thr_pph21', '0', array('class' => 'span2 inputFormTabel integer2', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
    </div>
</div>
<div class="control-group">
    <?php echo CHtml::label('PPh 21 TERUTANG ATAS GAJI', '', array('class' => 'control-label')) ?>
    <div class="controls">
        <?php echo CHtml::textField('thr_pph21_atasgaji', '0', array('class' => 'span2 inputFormTabel integer2', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
    </div>
</div>
<div class="control-group">
    <?php echo CHtml::label('PPh 21 TERUTANG ATAS THR', '', array('class' => 'control-label')) ?>
    <div class="controls">
        <?php echo CHtml::textField('thr_pph21_atasthr', '0', array('class' => 'span2 inputFormTabel integer2', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
    </div>
</div>
<div class="control-group">
    <?php echo CHtml::label('TUNJANGAN HARI RAYA YANG DIDAPAT', '', array('class' => 'control-label')) ?>
    <div class="controls">
        <?php echo CHtml::textField('thr_pph21_ygdidapat', '0', array('class' => 'span2 inputFormTabel integer2', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
    </div>
</div>

