<?php // echo $form->dropDownListRow($modTandabukti, 'dengankartu', LookupM::getItems('dengankartu'), array('required' => true,'onchange' => 'enableInputKartu()', 'empty' => '-- Pilih --', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50));  ?>
<div class="control-group">
	<?php echo CHtml::activeLabel($modTandabukti, 'dengankartu', array('class' => 'control-label', 'required' => true)); ?>
	<div class="controls">
		<?php echo $form->dropDownList($modTandabukti,'dengankartu',LookupM::getItems('dengankartu'),array('required' => true, 'empty'=>'-- Pilih --','class'=>'span3')); ?>
	</div>
</div>
<div class="control-group">
<?php echo CHtml::activeLabel($modTandabukti, 'bank_nama', array('class' => 'control-label', 'required' => true, 'label'=>'Bank Pengirim')); ?>
	<div class="controls">
	<?php
	echo $form->dropDownList($modTandabukti, 'bank_nama', LookupM::getItems('bank'), array('required' => true, 'class' => 'span3', 'empty' => '-- Pilih --', 'onchange' => 'setNamaBank();', 'onkeyup' => "return $(this).focusNextInputField(event);"));
	?>
	</div>
</div>
<div class="control-group">
<?php echo CHtml::activeLabel($modTandabukti, 'bankkartu', array('class' => 'control-label', 'required' => true, 'label'=>'Nama Pemilik Kartu / Rekening Pengirim')); ?>
	<div class="controls">
	<?php echo $form->textField($modTandabukti, 'bankkartu', array('required' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
	</div>
</div>
<div class="control-group">
<?php echo CHtml::activeLabel($modTandabukti, 'nokartu', array('class' => 'control-label', 'required' => true, 'label'=>'No. Kartu / No. Rekening Pengirim')); ?>
	<div class="controls">
	<?php echo $form->textField($modTandabukti, 'nokartu', array('required' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
	</div>
</div>
<div class="control-group">
<?php echo CHtml::activeLabel($modTandabukti, 'nostrukkartu', array('class' => 'control-label', 'required' => true, 'label'=>'No. Struk / No. Transfer Pengirim')); ?>
	<div class="controls">
	<?php echo $form->textField($modTandabukti, 'nostrukkartu', array('required' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
	</div>
</div>
<div class="control-group">
<?php echo CHtml::activeLabel($modTandabukti, 'bank_nominal', array('class' => 'control-label', 'required' => true, 'label'=>'Nominal')); ?>
	<div class="controls">
	<?php echo $form->textField($modTandabukti, 'bank_nominal', array('required' => true, 'class' => 'span2 integer2', 'onblur'=>'cekBayarBank(); hitungUangKembalian();', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
	</div>
</div>
<div class="control-group">
<?php echo CHtml::activeLabel($modTandabukti, 'bank_id', array('class' => 'control-label', 'required' => true, 'label'=>'Bank Penerima')); ?>
	<div class="controls">
	<?php 
    
    $bank_data = BankM::model()->findAll('bank_aktif = true order by namabank');
    
    $list_bank = CHtml::listData($bank_data, 'bank_id', 'bankNoRekening');
    $option_bank = array();
    
    foreach ($bank_data as $item) {
        $rekening = BankrekM::model()->findByAttributes(array(
            'bank_id'=>$item->bank_id,
            'saldonormal'=>'D',
        ));
        
        $option_bank[$item->bank_id] = array(
            'data-rekening'=>'',
        );
        
        if (!empty($rekening)) {
            $rek5 = Rekening5M::model()->findByPk($rekening->rekening5_id);
            $option_bank[$item->bank_id]['data-rekening'] = $rek5->kdrekening5." - ".$rek5->nmrekening5;
        }
        
        
    }
    
    echo $form->dropDownList($modTandabukti, 'bank_id', $list_bank,
            array('required' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 
                'onchange'=>'setKodeAkunBank()',
                'options'=>$option_bank)); ?>
	</div>
</div>
<div class="control-group">
    <?php echo CHtml::label("Kode Akun", '', array('class' => 'control-label', 'required' => true, 'label'=>'Nominal')); ?>
	<div class="controls">
        <?php echo CHtml::textField('kode_akun_bank', '', array(
            'id'=>'kode_akun_bank', 'class'=>'span4', 'readonly'=>true,
        )); ?>
	</div>
</div>

<script>

function setKodeAkunBank() {
    var data = $("#BKTandabuktibayarT_bank_id :selected").data('rekening');
    $("#kode_akun_bank").val(data);
}

$(document).ready(function() {
    setKodeAkunBank();
});


</script>