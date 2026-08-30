<?php
  $labelIncbg = "INACBG";

  if(isset($kelas_tanggungan) && !empty($kelas_tanggungan)){
    $labelIncbg = "INA ".$kelas_tanggungan->kelaspelayanan_nama;
  }

 ?>


<div class="control-group">
    <?php echo CHtml::label("Total ".$labelIncbg, 'total_inacbg',array('class'=>'control-label', 'style'=>'font-weight: bold;')); ?>
    <div class="controls">
        <?php echo CHtml::activeTextField(BKPembayaranpelayananT::model(),'total_inacbg',array(
            'readonly'=>true,
            'class'=>'span2 integer-decimal subsidi_asuransi',
            'onkeyup'=>"return $(this).focusNextInputField(event);",
            'onblur'=>$this->id == 'pembayaranTagihanPasienPenunjang' ? 'hitungSubsidiPenunjang()' : 'hitungJmlpembayaran()',
         )); ?>
    </div>
</div>
