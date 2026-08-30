<?php echo CHtml::activehiddenField($model, 'pendaftaran_id', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
<?php echo CHtml::activehiddenField($model, 'ruangan_id', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
<?php echo CHtml::activehiddenField($model, 'carabayar_id', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
<?php echo CHtml::activehiddenField($model, 'antrian_id', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
<?php echo CHtml::activehiddenField($model, 'pegawai_id', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
<?php echo CHtml::activehiddenField($model, 'ruangan_nama', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
<?php echo CHtml::activehiddenField($model, 'ruangan_singkatan', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
<?php echo CHtml::activehiddenField($model, 'tgl_pendaftaran', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
<?php echo CHtml::activehiddenField($model, 'no_pendaftaran', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 6)); ?>
<?php echo CHtml::activehiddenField($model, 'no_urutantri', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
<?php echo CHtml::activehiddenField($model, 'no_rekam_medik', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
<?php echo CHtml::activehiddenField($model, 'namadepan', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
<?php echo CHtml::activehiddenField($model, 'nama_pasien', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
<?php echo CHtml::activehiddenField($model, 'gelardepan', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
<?php echo CHtml::activehiddenField($model, 'nama_pegawai', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
<?php echo CHtml::activehiddenField($model, 'gelarbelakang_nama', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
<?php echo CHtml::activehiddenField($model, 'statuspasien', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
<?php echo CHtml::activehiddenField($model, 'panggilantrian', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>