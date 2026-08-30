<?php 
    if (!empty($model->keterangan)) { ?>
        <i style="color: red"> <?php echo $model->keterangan; ?> </i> 
<?php }
?>
<div class="row-fluid ">
    <div class="col-md-6">
        <div class="control-group">
            <?php echo CHtml::label("Nomor Penawaran", '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->hiddenField($modPenawaran, 'penawaranpenyedia_id', array('readonly' => true, 'class' => 'span1', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textField($modPenawaran, 'penawaranpenyedia_nomor', array('readonly' => true, 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("Tanggal Penawaran", '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $modPenawaran,
                    'attribute' => 'penawaranpenyedia_tanggal',
                    'mode' => 'date',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                        'maxDate' => 'd',
                    ),
                    'htmlOptions' => array('readonly' => true, 'class' => 'span4 dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)",),
                ));
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("Nomor Surat Penawaran", '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($modPenawaran, 'penawaranpenyedia_nomorsurat', array('disabled' => $disable, 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div> 
        <div class="control-group">
            <?php echo CHtml::label("Harga Ditawarkan", '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($modPenawaran, 'penawaranpenyedia_harga', array('disabled' => $disable, 'class' => 'span4 integer2 harga_ditawarkan', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div> 
    </div>
    <div class="col-md-6">
        <div class="control-group">
            <div class="controls">                               
                <?php echo CHtml::label("File ",'',array('class' => 'control-label ')); ?>
                <?php echo $form->fileField($modPenawaran, 'penawaranpenyedia_file', array('accept'=>'application/pdf','class' => 'span4 ', 'disabled' => $disable,  'Hint'=>'Isi Jika Akan Menambahkan File lampiran')); ?>               
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("",'',array('class' => 'control-label ')); ?>
            <div class="controls">
                <p style="color: red">Hanya file dengan ekstensi PDF, Max 3Mb.</p> 
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("",'',array('class' => 'control-label ')); ?>
            <div class="controls">
                <?php 
                    if (!empty($modPenawaran->penawaranpenyedia_file)) {
                        echo $form->hiddenField($modPenawaran, 'temp_file');
                        echo CHtml::link("$modPenawaran->penawaranpenyedia_file", $this->createUrl('Unduh', array('penawaranpenyedia_id' => $modPenawaran->penawaranpenyedia_id)), array('title' => 'Unduh File Penawaran', 'rel' => 'tooltip')) . '</td>'; 
                    } else {
                        echo "Belum ada file penawaran";
                    }
                ?>            
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("Keterangan", '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textArea($modPenawaran, 'penawaranpenyedia_keterangan', array('disabled' => $disable, 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div> 
    
    </div>
</div>

