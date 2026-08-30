<div class="row-fluid">
    <div class="col-sm-6">
        <?php echo $form->dropDownListRow($model,'profilrs_id',CHtml::listData(ProfilrumahsakitM::model()->findAll(),'profilrs_id','nama_rumahsakit'),array('empty'=>'Pilih','onClick'=>'setBank(this);setBankKeluar(this)'))?>
        <?php echo $form->textFieldRow($model,'jmladvance',array('class' => 'integer-decimal','readonly'=>true));?>
        <?php echo $form->hiddenField($model,'pegawai_id',array('class' => 'integer-decimal','onblur'=>'hitungRealisasi();hitungTotal();'));?>
        <?php echo $form->hiddenField($model,'pegawaisettlement_id',array('class' => 'integer-decimal','onblur'=>'hitungRealisasi();hitungTotal();'));?>
        <?php echo $form->textFieldRow($model,'realisasipembelian',array('class' => 'integer-decimal','onblur'=>'hitungRealisasi();hitungTotal();'));?>
       <!-- hutang realisasi -->
       <div id="hutangrealisasi">
            <?php echo $form->textFieldRow($model,'kekuranganrealisasi',array('class' => 'integer-decimal','readonly'=>true));?>
            <div class="control-group">
                <label class="control-label">Jumlah Pembayaran <span class="required">*</span></label>
                <div class="controls">
                <?php echo $form->textField($model,'jmlpembayaran2',array('class' => 'integer-decimal','onblur'=>'hitungTotal()'));?>

                </div>
            </div>
            
            <?php
                // $this->renderPartial('partials/_pembayaran',array(
                //     'form'=>$form,
                //     'model'=>$model,
                //     'modAdvancePayment'=>$modAdvancePayment,
                //     'modTandaBuktiBayar'=>$modTandaBuktiBayar,
                //     ));
                ?>
            <div class="control-group">
                <label class="control-label" for="TandabuktikeluarT_biayaadministrasi">Biaya Administrasi <span class="required">*</span></label>
                <div class="controls">
                    <?php echo $form->textField($modBuktiKeluar,'biayaadministrasi',array('class' => 'integer-decimal','onblur'=>'hitungTotal()'));?>
                </div>
            </div>
            <?php echo $form->textFieldRow($modBuktiKeluar,'jmlkaskeluar',array('class' => 'integer-decimal','readonly'=>true));?>
            <?php echo $form->textFieldRow($model,'sisakekurangan',array('class' => 'integer-decimal','readonly'=>true));?>
            
       </div>
       <!-- JIKA LEBIH -->
       <div id="sisa">
       <?php echo $form->textFieldRow($model,'sisarealisasi',array('class' => 'integer-decimal','readonly'=>true));?>
       
       </div>
        <div id="lebih">
            <?php echo $form->textFieldRow($model,'sisarealisasi',array('class' => 'integer-decimal','readonly'=>true));?>
            <?php echo $form->textFieldRow($model,'jmlpembayaran',array('class' => 'integer-decimal','onblur'=>'hitungTotal()'));?>

            <?php 
            // $this->renderPartial('partials/_pembayaran',array(
            //     'form'=>$form,
            //     'model'=>$model,
            //     'modAdvancePayment'=>$modAdvancePayment,
            //     'modTandaBuktiBayar'=>$modTandaBuktiBayar,
            //     ));
            ?>
            <div class="control-group">
                <label class="control-label" for="KUTandabuktibayarT_biayaadministrasi">Biaya Administrasi <span class="required">*</span></label>
                <div class="controls">
                    <?php echo $form->textField($modTandaBuktiBayar,'biayaadministrasi',array('class' => 'integer-decimal','onblur'=>'hitungTotal()'));?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="KUTandabuktibayarT_uangditerima">Jumlah Kas Masuk <span class="required">*</span></label>
                <div class="controls">
                    <?php echo $form->textField($modTandaBuktiBayar,'uangditerima',array('class' => 'integer-decimal','readonly'=>true));?>
                </div>
            </div>
            <?php echo $form->textFieldRow($model,'sisapengembalian',array('class' => 'integer-decimal','readonly'=>true));?>

        </div>
        <div id="pembayaran">

        </div>
       <div class="row" id="piutang">
            <div class="col-sm-12">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">Data Piutang Pegawai</div>
                    </div>
                    <div class="panel-body overflow-x" style="max-width: 100%;">
                    <?php 
                                        $this->renderPartial('_rowPiutangPegawai',array(
                                        'form'=>$form,
                                        'model'=>$model,
                                        'modAdvancePayment'=>$modAdvancePayment,
                                        'modTandaBuktiBayar'=>$modTandaBuktiBayar,
                                        //    'modTandaBuktiKeluar'=>$modTandaBuktiKeluar
                                        ));
                                ?>	
                    </div>
                </div>
            </div>
       </div>
       <div class="row" id="hutang">
            <div class="col-sm-12">
                <div class="panel panel-success">
                    <div class="panel-heading"> 
                        <div class="panel-title">Data Hutang Klinik</div>
                    </div>
                    <div class="panel-body overflow-x" style="max-width: 100%;">
                    <?php 
                                        $this->renderPartial('_rowHutangKlinik',array(
                                        'form'=>$form,
                                        'model'=>$model,
                                        'modAdvancePayment'=>$modAdvancePayment,
                                        'modTandaBuktiBayar'=>$modTandaBuktiBayar,
                                        //    'modTandaBuktiKeluar'=>$modTandaBuktiKeluar
                                        ));
                                ?>	
                    </div>
                </div>
            </div>
       </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group ">
            <?php $model->tglsettlement = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($model->tglsettlement, 'd F Y hh:mm:ss','medium',null)); ?>
            <?php echo $form->labelEx($model,'tglsettlement', array('class'=>'control-label')) ?>
            <div class="controls">
                <?php   
                    $this->widget('MyDateTimePicker',
                        array(
                                'model'=>$model,
                                'attribute'=>'tglsettlement',
                                'mode'=>'datetime',
                                'options'=>array(
                                    'dateFormat'=>Params::DATE_FORMAT,
                                    // 'maxDate' => 'd',
                                ),
                                'htmlOptions'=>array(
                                    'class'=>'dtPicker2-5 realtime',
                                    'onkeypress'=>"return $(this).focusNextInputField(event)",
                                    'onchange' => '$(this).removeClass("realtime")'
                                ),
                        )
                    ); 
                ?>

            </div>
        </div>
        <?php echo $form->textFieldRow($model,'nosettlement',array('readonly' => true));?>
        <?php echo $form->textFieldRow($model,'terimadari');?>
        <div id="bayarhutangrealisasi">
            <?php 
                $this->renderPartial('partials/_tandabuktikeluar',array(
                    'form'=>$form,
                    'model'=>$model,
                    'modAdvancePayment'=>$modAdvancePayment,
                    'modBuktiKeluar'=>$modBuktiKeluar,
                    ));
            ?>
            <?php echo $form->textFieldRow($model,'sebagaipembayaran') ?>  
        </div>
        <div id="lebihbayar">
            <div class="control-group ">
                <?php $modTandaBuktiBayar->tglbuktibayar = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modTandaBuktiBayar->tglbuktibayar, 'yyyy-MM-dd hh:mm:ss','medium',null)); ?>
                <?php echo $form->labelEx($modTandaBuktiBayar,'tglbuktibayar', array('class'=>'control-label')) ?>
                <div class="controls">
                    <?php   
                        $this->widget('MyDateTimePicker',
                            array(
                                    'model'=>$modTandaBuktiBayar,
                                    'attribute'=>'tglbuktibayar',
                                    'mode'=>'datetime',
                                    'options'=>array(
                                        'dateFormat'=>Params::DATE_FORMAT,
                                        // 'maxDate' => 'd',
                                    ),
                                    'htmlOptions'=>array(
                                        'class'=>'dtPicker2-5 realtime',
                                        'onkeypress'=>"return $(this).focusNextInputField(event)",
                                        'onchange' => '$(this).removeClass("realtime")'
                                    ),
                            )
                        ); 
                    ?>

                </div>
            </div>
            <?php echo $form->textFieldRow($modTandaBuktiBayar,'nobuktibayar',array('readonly' => true));?>
            <div class="control-group">
                <label class="control-label">Cara Pembayaran</label>
                <div class="controls">
                        <?php echo  $form->dropDownList($modTandaBuktiBayar,'carapembayaran',LookupM::getItems('carapembayaranklaim'),array('empty' => 'Pilih', 'onchange'=>'setCaraBayar(this)'))?>
                </div>
            </div>  
            <div id="transfer">
                <!-- only non tunai -->
                <div class="control-group">
                    <?php echo Chtml::label("Nama Bank Pengirim <span class='required'>*</span>", 'bank_id', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->dropDownList($modTandaBuktiBayar,'bank_id',CHtml::listData(BankM::model()->findAllByAttributes(array('ispengeluaran' => true)),'bank_id','namabank'),array('empty' => 'Pilih','onchange'=>'setNoRek(this)')) ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo Chtml::label("No. Rekening Pengirim <span class='required'>*</span>", 'denganrekening', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($modTandaBuktiBayar,'nokartu',array('readonly'=>true)) ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo Chtml::label("Nama Bank Penerima <span class='required'>*</span>", 'bank_nama', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->dropDownList($modTandaBuktiBayar,'bank_nama',LookupM::getItems('bank'),array('empty' => 'Pilih')) ?>
                    </div>
                </div>
            
                <div class="control-group">
                        <?php
                        ?>
                    <?php echo Chtml::label("No.Rekening Penerima", 'norekpenerima', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($modTandaBuktiBayar,'norekpenerima',array()) ?>
                    </div>
                </div>
                <?php echo $form->textFieldRow($modTandaBuktiBayar,'nostrukkartu') ?>
                <?php //echo $form->textFieldRow($modTandaBuktiBayar,'denganrekening') ?>
            
            </div>      
            <?php echo $form->textFieldRow($model,'sebagaipembayaran') ?>  
        </div>
         
    </div>
</div>

<script>
function setNoRek(obj){
    var data = $("#KUTandabuktibayarT_bank_id :selected").data('norek');
    $("#KUTandabuktibayarT_nokartu").val(data);
}
function setNoRekKeluar(obj){
    var data = $("#TandabuktikeluarT_bank_id :selected").data('norek');
    $("#TandabuktikeluarT_denganrekening").val(data);
}
</script>