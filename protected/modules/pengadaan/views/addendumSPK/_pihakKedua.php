<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title"> <b> Pihak Kedua </b></div>
    </div>
    <div class="panel-body">
        <div class="col-sm-6">
            <?php if($model->cekpenawaran == 1){ ?>
            <div class="control-group">
                <?php echo $form->labelEx($model, 'penawaranpenyedia_id', array(
                    'class'=>'control-label',
                )); ?>
                <div class="controls">
                    <?php
                        echo $form->hiddenField($model, 'penawaranpenyedia_id', array(
                            'class'=>'penawaranpenyedia_id',
                        ));

                        $penawaranpenyedia_nomor = "";
                        // --- kondisi jika ada data-nya
                        if (!empty($model->penawaranpenyedia_id)) {
                            $sup = PenawaranpenyediaT::model()->findByPk($model->penawaranpenyedia_id);
                            $penawaranpenyedia_nomor = $sup->penawaranpenyedia_nomor;
                        }

                        // --- end
                    echo $form->textField($model, 'nopenawaran', array(
                    'readonly'=>true, 
                    'class'=>'span3',
                    'onblur'=>'return false;',
                    )); ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo $form->labelEx($model, 'tglpenawaran', array('class' => 'control-label')) ?>
                <div class="controls">
                    <div class="input-append">
                        <input readonly="readonly" class="span3 hasDatepicker" onkeypress="return $(this).focusNextInputField(event)" id="SuratperjanjiankerjaT_tglpenawaran" name="SuratperjanjiankerjaT[tglpenawaran]" type="text" value="<?php echo $model->tglpenawaran; ?>">
                        <span id="SuratperjanjiankerjaT_tglpenawaran_date" class="add-on">
                            <i class="icon-calendar"></i><i class="icon-time"></i>
                        </span>
                    </div>
                </div>
            </div>
            <?php }else{ ?>
            <div class="control-group">
                <?php echo $form->labelEx($model, 'nopenawaran', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textField($model, 'nopenawaran', array(
                    'readonly'=>true, 
                    'class'=>'span3',
                    'onblur'=>'return false;',
                    )); ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo $form->labelEx($model, 'tglpenawaran', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textField($model, 'tglpenawaran', array(
                    'readonly'=>true, 
                    'class'=>'span3',
                    'onblur'=>'return false;',
                    )); ?>
                    <?php echo $form->error($model, 'tglpenawaran'); ?>
                </div>
            </div>
            <?php } ?>
            
            <div class="control-group">
                <?php echo $form->labelEx($model, 'supplier_id', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textField($model, 'supplier_nama', array(
                    'readonly'=>true, 
                    'class'=>'span3',
                    'onblur'=>'return false;',
                    )); ?>
                    <?php echo $form->hiddenField($model, 'supplier_id', array('readonly'=>true, 'class'=>'span1','onblur'=>'return false;')); ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo $form->labelEx($model, 'nama_supplier', array('class' => 'control-label', 'label'=>'Nama Direktur')) ?>
                <div class="controls">
                    <?php echo $form->textField($model, 'nama_supplier', array(
                    'readonly'=>true, 
                    'class'=>'span3',
                    'onblur'=>'return false;',
                    )); ?>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="control-group ">
                <?php echo $form->labelEx($model, 'alamat_supplier', array('class' => 'control-label','label'=>'Alamat Penyedia')) ?>
                <div class="controls">
                    <?php echo $form->textArea($model, 'alamat_supplier', array(
                    'readonly'=>true, 
                    'class'=>'span3',
                    'rows'=>3,
                    'onblur'=>'return false;',
                    )); ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo $form->labelEx($model, 'nomor_rekening', array('class' => 'control-label','label'=>'Nomor Rekening')) ?>
                <div class="controls">
                    <?php echo $form->textField($model, 'nomor_rekening', array(
                    'readonly'=>true, 
                    'class'=>'span3',
                    'onblur'=>'return false;',
                    )); ?>
                </div>
            </div>
        </div>
        <div class="clear"></div>
    </div>
</div>