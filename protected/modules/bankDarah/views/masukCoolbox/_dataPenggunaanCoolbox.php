<div class="col-sm-6">
    <div class="control-group">
        <?php echo CHtml::label('Pilih Coolbox <span class="required">*</span>', '', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php echo $form->dropDownList($model, 'penggunaan_coolbox_id', CHtml::listData(PenggunaanCoolboxT::model()->findAllByAttributes(array('tgl_penggunaan_coolbox' => date('Y-m-d'))), 'penggunaan_coolbox_id', 'coolboxdarah.coolboxdarah_nama'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'onchange'=>'setPenggunaanCoolbox(this);')); ?>				 
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('No. Penggunaan Coolbox ', '', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php echo $form->textfield($model, 'no_penggunaan_coolbox', array('class' => 'span3', 'readonly' => true)); ?>				 
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('Tanggal Penggunaan Coolbox ', '', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php echo $form->textfield($model, 'tgl_penggunaan_coolbox', array('class' => 'span3', 'readonly' => true)); ?>				 
        </div>
    </div>
</div>
<div class="col-sm-6">
    <div class="control-group">
        <?php echo CHtml::label('Jumlah Ice Pack', '', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->textField($model, 'jumlah_icepack', array('class' => 'span3 numbers-only', 'readonly' => true)); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('Jenis Kantong Yang Diisikan', '', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->textField($model, 'jenis_kantong', array('class' => 'span3', 'readonly' => true)); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('Standar Suhu', '', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->textField($model, 'standar_suhu', array('class' => 'span3', 'readonly' => true)); ?> ℃
        </div>
    </div>
</div>

<script>
    function setPenggunaanCoolbox(obj){
        var id = obj.value;
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('GetPenggunaanCoolbox'); ?>',
            data: {id: id},
            dataType: "json",
            success: function (data) {
                $('#PenggunaanCoolboxT_no_penggunaan_coolbox').val(data.no_penggunaan_coolbox);
                $('#PenggunaanCoolboxT_tgl_penggunaan_coolbox').val(data.tgl_penggunaan_coolbox);
                $('#PenggunaanCoolboxT_jumlah_icepack').val(data.jumlah_icepack);
                $('#PenggunaanCoolboxT_jenis_kantong').val(data.jenis_kantong);
                $('#PenggunaanCoolboxT_standar_suhu').val(data.standar_suhu);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }
</script>