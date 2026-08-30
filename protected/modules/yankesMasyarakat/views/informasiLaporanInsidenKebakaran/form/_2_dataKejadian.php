<div class="row-fluid">
    <div class="col-md-6">
        <div class="control-group">
            <?php echo CHtml::label("Tanggal Kejadian <i style='color: red'> * </i>", "", array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                    echo CHtml::activeTextField($model, 'tgl_kejadian', array('class' => 'span4', 'readonly' => true));

                ?>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="control-group">
            <?php echo CHtml::label('Unit Kerja Kejadian <span class="required">*</span>', 'unitkerjapenyebab_id', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                echo CHtml::activeHiddenField($model, 'unitkeja_kejadian_id', array('class' => 'span4', 'readonly' => true));
                echo CHtml::activeTextField($model, 'unitkerja_kejadian_nama', array('class' => 'span4', 'readonly' => true));
                
                ?>
            </div>
        </div>
        <?php echo $form->textFieldRow($model, 'lokasikejadian', array('readonly' => true, 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'placeholder' => 'Lokasi Kejadian')); ?>
    </div>
</div>
<div class="row-fluid">
    <div class="panel panel-success">
        <span class="group-title"> Rincian Kejadian </span>
        <div class="panel-body">
            <?php echo $form->textAreaRow($model, 'kronologis_kebakaran', array('readonly' => true, 'class' => 'span8', 'onkeypress' => "return $(this).focusNextInputField(event);", 'placeholder' => 'Kronologis Kebakaran')); ?>
            <?php echo $form->textAreaRow($model, 'penyebab_kebakaran', array('readonly' => true, 'class' => 'span8', 'onkeypress' => "return $(this).focusNextInputField(event);", 'placeholder' => 'Penyebab Kebakaran')); ?>
            <?php echo $form->textAreaRow($model, 'kerugianakibatkebakaran', array('readonly' => true, 'class' => 'span8', 'onkeypress' => "return $(this).focusNextInputField(event);", 'placeholder' => 'Kerugian/Akibat Kebakaran')); ?>
            <?php echo $form->textAreaRow($model, 'tindakanperbaikan', array('readonly' => true, 'class' => 'span8', 'onkeypress' => "return $(this).focusNextInputField(event);", 'placeholder' => 'Tindakan Perbaikan')); ?>
        </div>
    </div>
</div>