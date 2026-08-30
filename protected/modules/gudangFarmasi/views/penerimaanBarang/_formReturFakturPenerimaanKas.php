<div class="row-fluid">			
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">Form Pembayaran</div>
        </div>
        <div class="panel-body">
            <div class="col-sm-6">
                <?php echo $form->dropDownListRow($modPenUmum,'kelompoktransaksi',LookupM::getItems('kelompoktransaksi'),array('class'=>'span3 reqForm', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
                <?php echo $form->hiddenField($modPenUmum,'jenispenerimaan_id',array('readonly'=>true,'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                <div class="control-group ">
                    <?php echo $form->labelEx($modPenUmum,'jenispenerimaan_id', array('class'=>'control-label')) ?>
                    <div class="controls">
                        <?php 
                            $this->widget('MyJuiAutoComplete', array(
                            'model'=>$modPenUmum,
                            'attribute'=>'jenisKodeNama',
                            'source'=>'js: function(request, response) {
                                           $.ajax({
                                               url: "'.$this->createUrl('autocompleteJenisPenerimaan').'",
                                               dataType: "json",
                                               data: {
                                                   term: request.term,
                                               },
                                               success: function (data) {
                                                       response(data);
                                               }
                                           })
                                        }',
                             'options'=>array(
                                   'showAnim'=>'fold',
                                   'minLength' => 2,
                                   'focus'=> 'js:function( event, ui ) {
                                       $(this).val(ui.item.value);
                                        return false;
                                    }',
                                   'select'=>'js:function( event, ui ) {
                                        $("#KUPenerimaanUmumT_jenispenerimaan_id").val(ui.item.jenispenerimaan_id);
                                        getDataRekening(ui.item.jenispenerimaan_id);
                                        return false;
                                    }',
                            ),
                            'htmlOptions'=>array('placeholder'=>'ketik Kode/Nama Jenis Penerimaan','class'=>'span3 reqForm'),
                            'tombolDialog' => array('idDialog' => 'dialogJenisPenerimaan',),
                            )); 
                        ?>
                    </div>
                </div>
                <hr/>
                <?php echo $this->renderPartial('terimaKas/_rowListRekening', array(), true); ?>
            </div>
            <div class="col-sm-6">
                <div class="control-group ">
                    <?php echo $form->labelEx($modTandabukti,'tglbuktibayar', array('class'=>'control-label inline','style'=>'font-weight:bold;')) ?>
                    <div class="controls">
                        <?php   
                        echo $form->textField($modTandabukti, 'tglbuktibayar', array('class'=>'realtime span3'));
                        ?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo $form->labelEx($modTandabukti,'nobuktibayar', array('class'=>'control-label inline','style'=>'font-weight:bold;', 'readonly'=>true, 'label'=>'No. Penerimaan')) ?>
                    <div class="controls">
                        <?php   
                        echo $form->textField($modTandabukti, 'nobuktibayar', array('class'=>'span3', 'readonly'=>true));
                        ?>
                    </div>
                </div>
                <?php echo $form->dropDownListRow($modTandabukti,'carapembayaran',  LookupM::getItems('carapembayaran'),array('onchange'=>'ubahCaraPembayaran(this)','class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
                <div class="control-group ">
                    <?php echo CHtml::label('Total Penerimaan','totTagihan', array('class'=>'control-label inline')) ?>
                    <div class="controls">
                        <?php echo CHtml::textField('totTagihan',0,array('readonly'=>true,'class'=>'inputFormTabel integer2 span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")) ?>
                    </div><!-- total taginan-->
                </div>
                <?php // echo $form->textFieldRow($modTandabukti,'jmlpembulatan',array('readonly'=>true,'class'=>'inputFormTabel integer2 span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textFieldRow($modTandabukti,'biayaadministrasi',array('onkeyup'=>'hitungJmlBayar();','class'=>'inputFormTabel integer2 span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textFieldRow($modTandabukti,'biayamaterai',array('onkeyup'=>'hitungJmlBayar();','class'=>'inputFormTabel integer2 span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                <div class="control-group ">
                    <?php echo CHtml::label('Jumlah Penerimaan','jmlpembayaran', array('class'=>'control-label inline')) ?>
                    <div class="controls">
                        <?php echo $form->textField($modTandabukti,'jmlpembayaran',array('onkeyup'=>'hitungKembalian();','readonly'=>true,'class'=>'inputFormTabel integer2 span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                    </div>
                </div>                    
                <?php echo $form->textFieldRow($modTandabukti,'uangditerima',array('onkeyup'=>'hitungKembalian();','class'=>'inputFormTabel integer2 span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textFieldRow($modTandabukti,'uangkembalian',array('class'=>'inputFormTabel integer2 span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
									
               
                <?php /// echo $form->hiddenField($modTandabukti,'is_menggunakankartu',array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
                 <?php echo $form->textAreaRow($modTandabukti,'darinama_bkm',array('Placeholder'=>'Nama Lengkap Pembayar','class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textAreaRow($modTandabukti,'alamat_bkm',array('Placeholder'=>'Alamat Lengkap Pembayar','class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textAreaRow($modTandabukti,'sebagaipembayaran_bkm',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            </div>
                    
        </div>	
    </div>
</div>