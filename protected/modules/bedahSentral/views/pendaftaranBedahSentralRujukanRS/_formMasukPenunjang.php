<?php echo $form->hiddenField($modPasienMasukPenunjang, 'pasienmasukpenunjang_id', array('readonly' => true, 'class' => 'span4')); ?>
<?php echo $form->hiddenField($modPasienMasukPenunjang, 'pasienkirimkeunitlain_id', array('readonly' => true, 'class' => 'span4')); ?>
<?php echo $form->hiddenField($modPasienMasukPenunjang, 'ruangan_id', array('readonly' => true, 'class' => 'span4')); ?>
<div class="control-group">
    <?php echo CHtml::label('SMF <span class="required">*</span>', 'Tanggal', array('class' => 'control-label required')); ?>
    <div class="controls">
    <?php echo $form->dropDownList($modPasienMasukPenunjang, 'jeniskasuspenyakit_id', CHtml::listData(BSPendaftaranMp::model()->getJenisKasusPenyakitItems(), 'jeniskasuspenyakit_id', 'jeniskasuspenyakit_nama'), array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span4 required')); ?>
    </div>
</div>
<?php // echo $form->dropDownListRow($modPasienMasukPenunjang, 'jeniskasuspenyakit_id', CHtml::listData(BSPendaftaranMp::model()->getJenisKasusPenyakitItems(), 'jeniskasuspenyakit_id', 'jeniskasuspenyakit_nama'), array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span4 hide')); ?>