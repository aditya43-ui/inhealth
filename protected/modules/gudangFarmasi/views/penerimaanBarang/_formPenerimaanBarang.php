<div class="row-fluid">
    <div class = "col-sm-6">
        <?php echo CHtml::hiddenField('penerimaanbarang_id',$modPenerimaanBarang->penerimaanbarang_id, array('class'=>'span3 ','readonly'=>true, 'onkeyup'=>"return $(this).focusNextInputField(event)")) ?>
        <?php echo $form->hiddenField($modPenerimaanBarang,'permintaanpembelian_id', array('class'=>'span3 ','readonly'=>true, 'onkeyup'=>"return $(this).focusNextInputField(event)")) ?>
        
        <?php echo $form->textFieldRow($modPenerimaanBarang,'noterima', array('class'=>'span3 ','readonly'=>true, 'onkeyup'=>"return $(this).focusNextInputField(event)")) ?>
        <div class="control-group ">
            <?php echo $form->labelEx($modPenerimaanBarang,'tglterima', array('class'=>'control-label')) ?>
            <div class="controls">
                <?php   
                        $modPenerimaanBarang->tglterima = (!empty($modPenerimaanBarang->tglterima) ? MyFormatter::formatDateTimeForUser(date("d/m/Y H:i:s",strtotime($modPenerimaanBarang->tglterima))) : null);
//                                          echo $form->textField($modPenerimaanBarang,'tglterima', array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event)", 'readonly'=>true));
                        $this->widget('MyDateTimePicker',array(
                                'model'=>$modPenerimaanBarang,
                                'attribute'=>'tglterima',
                                'mode'=>'datetime',
                                'options'=> array(
                                       'dateFormat'=>Params::DATE_FORMAT,
                                       'showOn' => false,
                                       'maxDate' => 'd',
                                       'yearRange'=> "-150:+0",

                                ),
                                'htmlOptions'=>array('placeholder'=>'00/00/0000 00:00:00','class'=>'span3 dtPicker2 ','onkeyup'=>"return $(this).focusNextInputField(event)",'readonly'=>true
                                ),
                )); 
                ?>
            </div>
        </div>
        <?php echo $form->textFieldRow($modPenerimaanBarang,'nosuratjalan', array('placeholder'=>'Ketik No. Surat Jalan','class'=>'span3 alphanumber', 'onkeyup'=>"return $(this).focusNextInputField(event)")) ?>
        <div class="control-group ">
            <?php echo $form->labelEx($modPenerimaanBarang,'tglsuratjalan', array('class'=>'control-label')) ?>
            <div class="controls">
                    <?php   
                             $modPenerimaanBarang->tglsuratjalan = (!empty($modPenerimaanBarang->tglsuratjalan) ? MyFormatter::formatDateTimeForUser(date("d/m/Y H:i:s",strtotime($modPenerimaanBarang->tglsuratjalan))) : null);
                             $this->widget('MyDateTimePicker',array(
                                     'model'=>$modPenerimaanBarang,
                                     'attribute'=>'tglsuratjalan',
                                     'mode'=>'datetime',
                                     'options'=> array(
                                            'dateFormat'=>Params::DATE_FORMAT,
                                            'showOn' => false,
                                            'maxDate' => 'd',
                                            'yearRange'=> "-150:+0",
                                    ),
                                     'htmlOptions'=>array('placeholder'=>'00/00/0000 00:00:00','class'=>'span3 dtPicker2 ','onkeyup'=>"return $(this).focusNextInputField(event)",'readonly'=>true
                                    ),
                     )); ?>
            </div>
        </div>
        <?php if(Yii::app()->user->getState('ispenerimaanlangsung') == true){ ?>
        <div class="control-group">
            <?php echo CHtml::label("Sumber Dana <span class='required'>*</span>",'',array('class' => 'control-label required')); ?>
            <div class="controls">
                <?php echo $form->dropDownList($modPenerimaanBarang,'sumberdana_id',
                        CHtml::listData(SumberdanaM::model()->findAll('sumberdana_aktif = true'), 'sumberdana_id', 'sumberdana_nama'),
                        array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event)",
                        'empty'=>'-- Pilih --')); 
                ?>  
            </div>
        </div>
        <div class="control-group ">
            <?php echo Chtml::label("Supplier <font style = 'color:red'>*</font>", 'supplier_id', array('class' => 'control-label required')); ?>
            <div class="controls">
                <?php echo $form->hiddenField($modPenerimaanBarang, 'supplier_id',array('readonly'=>true,'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
                <?php
                $this->widget('MyJuiAutoComplete', array(
                        'model'=>$modPenerimaanBarang,
                        'attribute' => 'supplier_nama',
                        'source' => 'js: function(request, response) {
                                $.ajax({
                                        url: "' . $this->createUrl('AutoCompleteSupplier') . '",
                                        dataType: "json",
                                        data: {
                                                term: request.term,
                                        },
                                        success: function (data) {
                                                response(data);
                                        }
                                })
                        }',
                        'options' => array(
                                'showAnim' => 'fold',
                                'minLength' => 3,
                                'focus' => 'js:function( event, ui ) {
                                        $(this).val( ui.item.label);
                                                                                refreshDialogOA();
                                        return false;
                                }',
                                'select' => 'js:function( event, ui ) {
                                        $("#'.Chtml::activeId($modPenerimaanBarang, 'supplier_id') . '").val(ui.item.supplier_id);
                                        $("#'.Chtml::activeId($modPenerimaanBarang, 'supplier_alamat') . '").val(ui.item.supplier_alamat);
                                        return false;
                                }',
                        ),
                        'htmlOptions' => array(
                                'class'=>'span3',
                                'onkeyup'=>"return $(this).focusNextInputField(event)",
                                'onblur' => 'if(this.value === "") $("#'.Chtml::activeId($modPenerimaanBarang, 'supplier_id') . '").val(""); '
                        ),
                        'tombolDialog' => array('idDialog' => 'dialogSupplier'),
                ));
                ?>
            </div>
        </div>
        <?php } ?>             

       
        <div class="control-group">
            <?php echo CHtml::label("Pegawai Penerima <span class='required'>*</span>",'',array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($modPenerimaanBarang,'pegawai_nama', array('class' => 'required span3', 'readonly'=>true)); ?>
            </div>
        </div>
        <div class="control-group ">
            <?php echo Chtml::label("Pegawai Mengetahui <font style='color:red'>*</font>", 'pegawaimengetahui_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->hiddenField($modPenerimaanBarang, 'pegawaimengetahui_id',array('readonly'=>true)); ?>
                <?php echo $form->textField($modPenerimaanBarang,'pegawaimengetahui_nama', array('class' => 'required span3', 'readonly'=>true)); ?>
            </div>
        </div>
        <?php echo $form->textAreaRow($modPenerimaanBarang,'keteranganterima', array('placeholder'=>'Ket. Penerimaan Barang','class'=>'span3 ', 'onkeyup'=>"return $(this).focusNextInputField(event)")) ?>		    	
    </div>
    <div class = "col-sm-6">
        <div class="control-group ">
            <?php echo Chtml::label('Status Penerimaan <font style="color:red">*</font>','statuspenerimaan', array('class'=>'control-label')) ?>
            <div class="controls">
                <?php echo $form->dropDownList($modPenerimaanBarang,'statuspenerimaan',LookupM::getItems('statuspenerimaan'),array('class'=>'required span3','empty'=>'--Pilih--','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
            </div>
        </div>
        <?php if(Yii::app()->user->getState('ispenerimaanlangsung') == true){ ?>
        <div class="control-group">
            <?php echo CHtml::label("Jenis PPh",'',array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->dropDownList($modPenerimaanBarang,'pajak_id',
                    CHtml::listData(PajakM::model()->findAll('pajak_aktif = true AND ispajakpegawai = false AND isppnkeluaran = false ORDER BY pajak_nama ASC'), 'pajak_id', 'pajak_nama'),
                    array('class'=>'span2', 'onkeyup'=>"return $(this).focusNextInputField(event)",
                    'empty'=>'-- Pilih --',)); ?>
            </div>
        </div>
        <?php } ?>  
        <div class="control-group ">
            <?php echo Chtml::label('Tgl Pembayaran Uang Muka','', array('class'=>'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($modPenerimaanBarang,'tgluangbelimuka', array('class' => 'span3', 'readonly'=>true)); ?>
            </div>
        </div>
        <div class="control-group ">
            <?php echo Chtml::label('Jumlah Uang Muka','', array('class'=>'control-label')) ?>
            <div class="controls">
                <?php echo (Params::cekHiddenHargaGudangFarmasi()==true)? $form->textField($modPenerimaanBarang,'jumlahuang', array('class' => 'span3 integer-decimal', 'readonly'=>true)):$form->passwordField($modPenerimaanBarang,'jumlahuang', array('class' => 'span3 integer-decimal', 'readonly'=>true)); ?>
            </div>
        </div>
        <div class="control-group ">
            <?php echo Chtml::label('Total Harga','', array('class'=>'control-label')) ?>
            <div class="controls">
                <?php echo (Params::cekHiddenHargaGudangFarmasi()==true)?  $form->textField($modPenerimaanBarang,'harganetto', array('class' => 'span3 integer-decimal', 'readonly'=>true)) : $form->passwordField($modPenerimaanBarang,'harganetto', array('class' => 'span3 integer-decimal', 'readonly'=>true)); ?>
            </div>
        </div>
        <div class="control-group ">
            <?php echo Chtml::label('Total Keringanan','', array('class'=>'control-label')) ?>
            <div class="controls">
                <?php echo (Params::cekHiddenHargaGudangFarmasi()==true)?  $form->textField($modPenerimaanBarang,'jmldiscount', array('class' => 'span3 integer-decimal', 'readonly'=>true)) : $form->passwordField($modPenerimaanBarang,'jmldiscount', array('class' => 'span3 integer-decimal', 'readonly'=>true)); ?>
            </div>
        </div>
        <div class="control-group ">
            <?php echo Chtml::label('Total PPN','', array('class'=>'control-label')) ?>
            <div class="controls">
                <?php echo (Params::cekHiddenHargaGudangFarmasi()==true)?  $form->textField($modPenerimaanBarang,'totalpajakppn', array('class' => 'span3 integer-decimal', 'readonly'=>true)): $form->passwordField($modPenerimaanBarang,'totalpajakppn', array('class' => 'span3 integer-decimal', 'readonly'=>true)); ?>
            </div>
        </div>
        <div class="control-group ">
            <?php echo Chtml::label('Total PPh','', array('class'=>'control-label')) ?>
            <div class="controls">
                <?php echo (Params::cekHiddenHargaGudangFarmasi()==true)?  $form->textField($modPenerimaanBarang,'totalpajakpph', array('class' => 'span3 integer-decimal', 'readonly'=>true)) : $form->passwordField($modPenerimaanBarang,'totalpajakpph', array('class' => 'span3 integer-decimal', 'readonly'=>true)); ?>
            </div>
        </div>
        <div class="control-group ">
            <?php echo Chtml::label('Total Keseluruhan','', array('class'=>'control-label')) ?>
            <div class="controls">
                <?php echo (Params::cekHiddenHargaGudangFarmasi()==true)?  $form->textField($modPenerimaanBarang,'totalharga', array('class' => 'span3 integer-decimal', 'readonly'=>true)) : $form->passwordField($modPenerimaanBarang,'totalharga', array('class' => 'span3 integer-decimal', 'readonly'=>true)); ?>
            </div>
        </div>
    </div>
</div>
