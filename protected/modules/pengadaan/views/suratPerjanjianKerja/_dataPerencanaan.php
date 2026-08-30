<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title"> <b>  Data Perencanaan </b> </div>
    </div>
    <div class="panel-body">
        <div class="col-sm-12">
            <div class="control-group">
                <?php echo $form->labelEx($model, 'program_kerja', array('class' => 'control-label', 'label' => 'Program')); ?>
                <div class="controls">
                    <?php echo $form->textField($model, 'programkerja_nama', array('class' => 'programkerja_nama span9', 'readonly' => true)); ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo $form->labelEx($model, 'kegiatanprogram_id', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php
                    echo $form->hiddenField($model, 'kegiatanprogram_id', array('class' => 'kegiatanprogram_id'));
                    echo $form->textField($model, 'kegiatanprogram_nama', array('class' => 'kegiatanprogram_nama span9', 'readonly' => true));
                    ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo $form->labelEx($model, 'subkegiatanprogram_id', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php
                    echo $form->hiddenField($model, 'subkegiatanprogram_id', array('class' => 'subkegiatanprogram_id'));
                    echo $form->textField($model, 'subprogramkerja_nama', array('class' => 'subprogramkerja_nama span9', 'readonly' => true));
                    ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo $form->labelEx($model, 'rekening5_id', array('class' => 'control-label'));?>
                <div class="controls">
                    <?php
                    echo $form->hiddenField($model, 'rekening5_id', array('class' => 'rekening5_id'));
                    echo $form->hiddenField($model, 'mappingrekeninganggaran_id', array('class' => 'mappingrekeninganggaran_id'));
                    echo $form->textField($model, 'nmrekening5', array('class' => 'nmrekening5 span9', 'readonly' => true));
                    ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo $form->labelEx($model, 'tahunanggaran', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->hiddenField($model, 'periodeanggaran_id', array('class' => 'span9', 'readonly' => true)); ?>
                    <?php echo $form->textField($model, 'tahunanggaran', array('class' => 'tahunanggaran span9', 'readonly' => true)); ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo $form->labelEx($model, 'no_dpa', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textField($model, 'no_dpa', array('readonly' => true, 'class' => 'span9', 'onblur' => 'return false;')); ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo $form->labelEx($model, 'tgl_dpa', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textField($model, 'tgl_dpa', array('class' => 'span9', 'readonly' => true)); ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo $form->labelEx($model, 'nilaikontrak', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textField($model, 'nilaikontrak', array('readonly' => true, 'class' => 'span9 integer-decimal', 'onblur' => 'return false;')); ?>
                </div>
            </div>
        </div>
        <div class="clear"></div>
    </div>
</div>