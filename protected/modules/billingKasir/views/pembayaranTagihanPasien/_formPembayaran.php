<div class="col-sm-6">
    <div class="control-group">
        <?php echo $form->labelEx($modTandabukti, 'carapembayaran', array('class'=>'control-label','style'=>'font-weight:bold;'))?>
        <div class="controls">
            <?php echo $form->hiddenField($modTandabukti,'carapembayaran',array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    <?php echo $form->textField($modTandabukti,'carapembayaran_nama',array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
    <div class="control-group ">
        <?php $model->tglpembayaran = MyFormatter::formatDateTimeForUser(empty($model->tglpembayaran) ? date('Y-m-d H:i:s') : $model->tglpembayaran); ?>
        <?php echo $form->labelEx($model,'tglpembayaran', array('class'=>'control-label')) ?>
        <div class="controls">
            <?php   
                    $this->widget('MyDateTimePicker',array(
                            'model'=>$model,
                            'attribute'=>'tglpembayaran',
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
    
    
    <?php // echo $form->dropDownListRow($modTandabukti,'carapembayaran',LookupM::getItems('carapembayaran'),array('readonly'=>true,'onchange'=>'hitungUangKembalian();','class'=>'span2','onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
    <?php // echo $form->textFieldRow($model,'tglpembayaran',array('readonly'=>true,'class'=>'span3 realtime', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    <?php
      $hiddenPanel = "";
      $hiddenPaneltindakan = "";
//      if($this->id == "pembayaranTagihanPasienPenunjang"){
//        $hiddenPanel = "hidden";
//      }
      if($this->id == "pembayaranPenjualanApotek"){
        $hiddenPaneltindakan = "hidden";
      }
     ?>
    <div <?php echo $hiddenPaneltindakan; ?>>
      <?php echo $form->textFieldRow($model,'totalbiayatindakan',array('readonly'=>true,'class'=>'span2 integer-decimal_old integer2', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
   </div>

     <div <?php echo $hiddenPanel; ?>>
       <?php echo $form->textFieldRow($model,'totalbiayaoa',array('readonly'=>true,'class'=>'span2 integer-decimal_old integer2', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    </div>
    <?php echo $form->textFieldRow($model,'totalbiayapelayanan',array('readonly'=>true,'class'=>'span2 integer-decimal_old integer2', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    <div class="control-group input_admin_diskon hide">
        <?php echo $form->labelEx($modTandabukti, 'biayaadministrasi', array('class'=>'control-label','style'=>'font-weight:bold;'))?>
        <div class="controls">
            <?php echo CHtml::textField('persen_admin', "0,00", array('readonly'=>true,'class'=>'integer-decimal_old integer2 span1', 'onblur'=>'hitungBiayaAdministrasi();'))." %"; ?>
        </div>
        <div class="controls">
            <?php echo $form->textField($modTandabukti,'biayaadministrasi',array('readonly'=>true,'onblur'=>'hitungPersenBiayaAdministrasi();','class'=>'span2 integer-decimal_old integer2', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
    <div class="control-group input_admin_diskon hide">
        <?php echo $form->label($model, 'totaldiscount', array('class'=>'control-label','style'=>'font-weight:bold;'))?>
        <div class="controls">
            <?php echo CHtml::textField('persen_diskon_bayar', "0,00", array('class'=>'integer-decimal_old integer2 span1', 'onblur'=>'hitungDiskonBayar();'))." %"; ?>
        </div>
        <div class="controls">
            <?php echo $form->textField($model,'totaldiscount',array('onblur'=>'hitungPersenDiskonBayar();','class'=>'span2 integer-decimal_old integer2', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
    
    <div class="control-group jasapelayananfarmasi_div" style='display: none;'>
        <?php echo CHtml::label("Jasa Pelayanan Farmasi",'jasapelayanan_farmasi',array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo $form->textField($model,'jasapelayanan_farmasi',array('readonly'=>true,'class'=>'span2 integer-decimal_old integer2', 'onkeyup'=>"return $(this).focusNextInputField(event);",'style'=>'font-weight:bold;')); ?>
        </div>
    </div>

    <div class="control-group">
        <?php echo CHtml::label("Total Tagihan",'jmlpembayaran',array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo $form->textField($modTandabukti,'jmlpembayaran',array('readonly'=>true,'class'=>'span2 integer-decimal_old integer2', 'onkeyup'=>"return $(this).focusNextInputField(event);",'style'=>'font-weight:bold;')); ?>
        </div>
    </div>



    <div class="control-group" hidden>
        <?php echo $form->labelEx($modTandabukti, 'biayamaterai', array('class'=>'control-label','style'=>'font-weight:bold;'))?>
        <div class="controls">
            <?php echo $form->textField($modTandabukti,'biayamaterai',array('onblur'=>'hitungTotalSemua(); hitungJmlpembulatan();hitungJmlpembayaran();','class'=>'span2 integer-decimal_old integer2', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>

    <div id="input_subsidi">

    </div>

    <?php // echo $form->textFieldRow($model,'totalsubsidiasuransi',array('readonly'=>true,'class'=>'span2 integer2', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    <span hidden><?php // echo $form->textFieldRow($model,'totalsubsidipemerintah',array('readonly'=>true,'class'=>'span2 integer2', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?></span>
    <div class="control-group hide">
        <?php echo $form->labelEx($model, 'totalsubsidirs', array('class'=>'control-label required', 'label'=>'Total Subsidi RS'))?>
        <div class="controls">
            <?php echo $form->textField($model,'totalsubsidirs',array('readonly'=>true,'class'=>'span2 integer-decimal_old integer2', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'onblur'=> $this->id == 'pembayaranTagihanPasienPenunjang' ? 'hitungSubsidiRS()' : 'hitungJmlpembayaran()',)); ?>
        </div>
    </div>
    <div class="hide">
    <?php echo $form->textFieldRow($model,'totalpembebasan',array('readonly'=>true,'class'=>'span2 integer-decimal_old integer2', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    </div>
    <div hidden><?php echo $form->textFieldRow($model,'totalbayartindakan',array('readonly'=>true,'class'=>'span2 integer-decimal_old integer2', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?></div>

    <div class="control-group input_selisih_bpjs" hidden>
        <?php echo $form->labelEx($model, 'selisihuntungrugibpjs', array('class'=>'control-label required', 'label'=>'Total Selisih Tanggungan BPJS'))?>
        <div class="controls">
            <?php echo $form->textField($model,'selisihuntungrugibpjs',array('readonly'=>true,'class'=>'span2 integer-decimal_old integer2', 'onkeyup'=>"return $(this).focusNextInputField(event);",'style'=>'font-weight: bold;')); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo $form->labelEx($model, 'totaliurbiaya', array('class'=>'control-label required', 'label'=>'Dibayar Oleh Pasien'))?>
        <div class="controls">
            <?php echo $form->textField($model,'totaliurbiaya',array('readonly'=>true,'class'=>'span2 integer-decimal_old integer2', 'onkeyup'=>"return $(this).focusNextInputField(event);",'style'=>'font-weight: bold;')); ?>
        </div>
    </div>
    <div class="control-group hide">
        <?php echo $form->labelEx($model, 'jmlpembulatan', array('class'=>'control-label required', 'label'=>'Jumlah Pembulatan'))?>
        <div class="controls">
            <?php echo $form->textField($modTandabukti,'jmlpembulatan',array('id'=>'pembulatankasir','readonly'=>true,'class'=>'span2 integer-decimal_old integer2', 'onkeyup'=>"return $(this).focusNextInputField(event);",'style'=>'font-weight: bold;')); ?>
        </div>
    </div>

    <!--input readonly="readonly" class="span3"  name="pembulatankasir" id="pembulatankasir" type="hidden" value="0"-->

</div>
<div class="col-sm-6">
    <?php echo $form->textAreaRow($modTandabukti,'darinama_bkm',array('Placeholder'=>'Nama Lengkap Pembayar','class'=>'span3', 'onkeyup'=>"this.value = this.value.toUpperCase();")); ?>
    <div class="hide">
    <?php echo $form->textAreaRow($modTandabukti,'alamat_bkm',array('Placeholder'=>'Alamat Lengkap Pembayar','class'=>'span3 hide', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    <?php echo $form->textAreaRow($modTandabukti,'sebagaipembayaran_bkm',array('class'=>'span3 hide', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    <?php echo $form->textAreaRow($model,'keterangan',array('class'=>'span3 hide', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    </div>
    <hr/>
    <?php echo $form->textFieldRow($modPemakaianuangmuka,'totaluangmuka',array('readonly'=>true,'class'=>'span2 integer-decimal_old integer2', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    <div class="control-group">
        <?php echo $form->labelEx($modPemakaianuangmuka, 'pemakaianuangmuka', array('class'=>'control-label required','style'=>'font-weight:bold;'))?>
        <div class="controls">
            <?php echo $form->textField($modPemakaianuangmuka,'pemakaianuangmuka',array('onblur'=>'hitungJmlpembayaran();','class'=>'span2 integer-decimal_old integer2', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
    <?php echo $form->textFieldRow($modPemakaianuangmuka,'sisauangmuka',array('readonly'=>true,'class'=>'span2 integer-decimal_old integer2', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
</div>
<div class="clear"></div>
<hr/>

<div class="col-sm-6">
    <div class="control-group">
        <?php echo $form->labelEx($modTandabukti, 'uangditerima', array('class'=>'control-label','style'=>'font-weight:bold;'))?>
        <div class="controls">
            <?php echo $form->textField($modTandabukti,'uangditerima',array('readonly'=>false, 'onblur'=>'hitungUangKembalian();','class'=>'span2 integer2', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>

    <?php echo $form->textFieldRow($modTandabukti,'uangkembalian',array('readonly'=>true,'class'=>'span2 integer-decimal_old integer2', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>

    <div class="panel panel-default panel-berhutang">
        <div class="panel-heading">
            <div class="panel-title">
                Pasien Piutang
            </div>
        </div>
        <div class="panel-body">
            <?php echo $this->renderPartial($this->path_view.'_formPasienBerhutang', array(
                'form'=>$form,
                'model'=>$model,
            ), true); ?>
        </div>
    </div>

    <?php $modTandabukti->is_menggunakankartu = 1; // echo $form->textFieldRow($model,'totalsisatagihan',array('readonly'=>true,'class'=>'span2 integer2', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    <?php echo $form->hiddenField($modTandabukti,'is_menggunakankartu',array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
</div>

    <div class="col-sm-6">
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


        <?php //$this->Widget('ext.bootstrap.widgets.BootAccordion',array(
    // 'id'=>'form-kartupembayaran',
    // 'content'=>array(
    //     'content-kartupembayaran'=>array(
    //         'header'=>CHtml::htmlButton("<i class='icon-minus icon-white'></i>",array('class'=>'btn btn-primary btn-mini','onclick'=>'','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk tampilkan form Bayar Via Bank')).'<b> Bayar Via Bank</b>',
    //         'isi'=>$this->renderPartial($this->path_view.'_formKartuPembayaran',array(
    //             'form'=>$form,
    //             'modTandabukti'=>$modTandabukti,
    //         ),true),
    //         'active'=>false,
    //     ),
    // ),
    //)); ?>
    </div>
<div class="clear"></div>
