<div class="col-md-6">
    <?php echo $form->textFieldRow($model, 'no_dokumen', array('readonly' => true, 'class' => 'span4 required', 'onkeypress' => "return $(this).focusNextInputField(event);", 'placeholder' => 'Nomor Pelaporan')); ?>
    <?php echo $form->textFieldRow($model, 'no_revisi', array('readonly' => true, 'class' => 'span4 required', 'onkeypress' => "return $(this).focusNextInputField(event);", 'placeholder' => 'Nomor Revisi')); ?>
    <div class="control-group">
        <?php echo CHtml::label("Tanggal Pelaporan <i style='color: red'> * </i>", "", array( 'class' => 'control-label' )); ?>
        <div class="controls">
            <?php
                echo CHtml::activeTextField($model, 'tgl_pelaporan', array('class' => 'span4', 'readonly' => true));
            ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Mengetahui <i style='color: red'> * </i>", '', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php
            echo CHtml::activeHiddenField($model, 'mengetahuipegawai_id', array('class' => 'span4', 'readonly' => true));
            echo CHtml::activeTextField($model, 'mengetahuipegawai_nama', array('class' => 'span4', 'readonly' => true));
            ?>
        </div>
    </div>
</div>
<div class="col-md-6">
    <div class="control-group">
        <?php echo CHtml::label("Nama Pelapor <i style='color: red'> * </i>", '', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php
            echo CHtml::activeHiddenField($model, 'pelapor_id', array('class' => 'span4', 'readonly' => true));
            echo CHtml::activeTextField($model, 'pelapor_nama', array('class' => 'span4', 'readonly' => true));
           ?>
        </div>
    </div>
    <?php echo $form->textFieldRow($model, 'nomorindukpegawai', array('readonly' => true, 'class' => 'span4 required', 'onkeypress' => "return $(this).focusNextInputField(event);", 'placeholder' => 'Nomor Induk Pegawai')); ?>
    <?php echo $form->textFieldRow($model, 'saksi1', array('readonly' => true, 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'placeholder' => 'Ketikkan Nama Saksi yang Mengetahui Kejadian')); ?>
    <?php echo $form->textFieldRow($model, 'saksi2', array('readonly' => true, 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'placeholder' => 'Ketikkan Nama Saksi yang Mengetahui Kejadian')); ?>
    <?php echo $form->textFieldRow($model, 'saksi3', array('readonly' => true, 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'placeholder' => 'Ketikkan Nama Saksi yang Mengetahui Kejadian')); ?>
</div>