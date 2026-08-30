<style>
    .row_kuning label, .row_kuning input {
        color: orange !important;
    }

    .row_merah label, .row_merah input {
        color: red !important;
    }
</style>

<div class="row-fluid">
    <div class = "col-sm-6">
      <div class="control-group">
          <?php echo $form->labelEx($modTandabukti, 'carapembayaran', array('class'=>'control-label','style'=>'font-weight:bold;'))?>
          <div class="controls">
              <?php echo $form->hiddenField($modTandabukti,'carapembayaran',array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
      <?php echo $form->textField($modTandabukti,'carapembayaran_nama',array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
          </div>
      </div>

    <div class="control-group ">
        <?php $model->tgluangmuka = MyFormatter::formatDateTimeForUser(empty($model->tgluangmuka) ? date('Y-m-d H:i:s') : $model->tgluangmuka); ?>
        <?php echo $form->labelEx($model,'tgluangmuka', array('class'=>'control-label','label'=>'Tgl. Pembayaran Uang Muka Pasien')) ?>
        <div class="controls">
            <?php   
                    $this->widget('MyDateTimePicker',array(
                            'model'=>$model,
                            'attribute'=>'tgluangmuka',
                            'mode'=>'datetime',
                            'options'=> array(
                                    'dateFormat'=>Params::DATE_FORMAT,
                                    //'maxDate' => 'd',
                            ),
                            'htmlOptions'=>array('class'=>'dtPicker2-5 span3', 
                                    'onkeypress'=>"return $(this).focusNextInputField(event)",
                                    'readonly' => true
                            ),
            )); ?>
        </div>
    </div>
        

        <div class="control-group">
            <?php echo CHtml::label('Total Tagihan Sementara', 'totbiayasementara', array('class'=>'control-label'))?>
            <div class="controls">
                <?php echo $form->hiddenField($model,'ruangan_id',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);","readonly"=>true)); ?>
                <?php echo $form->textField($model,'totbiayasementara',array('readonly'=>true, 'class'=>'span3 integer-decimal', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
        <div class="control-group input_sorot">
            <?php echo $form->labelEx($model, 'jumlahuangmuka', array('class'=>'control-label','style'=>'font-weight:bold;'))?>
            <div class="controls">
                <?php echo $form->textField($model,'jumlahuangmuka',array('class'=>'span3 integer2', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'onblur'=>'hitungJmlpembulatan();hitungJmlpembayaran();cekNominalUangMukaInput();')); ?>
            </div>
        </div>
        <div class="control-group" hidden>
            <?php echo $form->labelEx($modTandabukti, 'biayaadministrasi', array('class'=>'control-label','style'=>'font-weight:bold;'))?>
            <div class="controls">
                <?php echo $form->textField($modTandabukti,'biayaadministrasi',array('onblur'=>'hitungJmlpembulatan();hitungJmlpembayaran();','class'=>'span3 integer-decimal', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
        <div class="control-group" hidden>
            <?php echo $form->labelEx($modTandabukti, 'biayamaterai', array('class'=>'control-label','style'=>'font-weight:bold;'))?>
            <div class="controls">
                <?php echo $form->textField($modTandabukti,'biayamaterai',array('onblur'=>'hitungJmlpembulatan();hitungJmlpembayaran();','class'=>'span3 integer-decimal', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($modTandabukti, 'jmlpembulatan', array('class'=>'control-label'))?>
            <div class="controls">
                <?php echo $form->textField($modTandabukti,'jmlpembulatan',array('readonly'=>true,'class'=>'span3 integer-decimal', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
		<?php echo $form->textFieldRow($modTandabukti,'jmlpembayaran',array('readonly'=>true,'class'=>'span3 integer2', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        <div class="control-group">
            <?php echo $form->labelEx($modTandabukti, 'uangditerima', array('class'=>'control-label','style'=>'font-weight:bold;'))?>
            <div class="controls">
                <?php echo $form->textField($modTandabukti,'uangditerima',array('onblur'=>'hitungUangKembalian();','class'=>'span3 integer2', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
        <?php echo $form->textFieldRow($modTandabukti,'uangkembalian',array('readonly'=>true,'class'=>'span3 integer2', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        
        <?php echo $form->textAreaRow($model,'keteranganuangmuka',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>

    </div>
    <div class = "col-sm-6">
        <div class="control-group ">
            <?php echo $form->labelEx($modTandabukti,'tglbuktibayar', array('class'=>'control-label inline','style'=>'font-weight:bold;')) ?>
            <div class="controls">
                <?php
				echo $form->textField($modTandabukti, 'tglbuktibayar', array('class'=>'realtime span3','readonly'=>true));
				?>
            </div>
        </div>
		<?php
    $modTandabukti->is_menggunakankartu = 1;
    echo $form->hiddenField($modTandabukti,'is_menggunakankartu',array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
         <?php echo $form->textAreaRow($modTandabukti,'darinama_bkm',array('Placeholder'=>'Nama Lengkap Pembayar','class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textAreaRow($modTandabukti,'alamat_bkm',array('Placeholder'=>'Alamat Lengkap Pembayar','class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textAreaRow($modTandabukti,'sebagaipembayaran_bkm',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>


        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">Berdasarkan Jenis Pembayaran</div>
            </div>
            <div class="panel-body">
                <?php
                echo $this->renderPartial($this->path_view.'_formBayarBank',array(
                    'form'=>$form,
                    'modTandabukti'=>$modTandabukti,
                ),true);

                ?>
            </div>
        </div>

    </div>
</div>
