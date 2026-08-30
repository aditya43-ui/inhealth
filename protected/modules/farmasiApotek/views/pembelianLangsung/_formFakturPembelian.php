<div class="row-fluid">
<div class = "span6">
        <div id="fakturPembelian">      
            <?php echo CHtml::hiddenField('ppn','0',array()); ?>
            <?php echo CHtml::hiddenField('pph','0',array()); ?>            
            <?php echo $form->textFieldRow($modFakturPembelian,'nofaktur', array('placeholder'=>'Ketik No. Faktur','class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)")) ?>
                 <div class="control-group ">
                        <?php echo $form->labelEx($modFakturPembelian,'tglfaktur', array('class'=>'control-label')) ?>
                            <div class="controls">
                                <?php   
                                    $modFakturPembelian->tglfaktur = (!empty($modFakturPembelian->tglfaktur) ? date("d/m/Y H:i:s",strtotime($modFakturPembelian->tglfaktur)) : null);
                                    $this->widget('MyDateTimePicker',array(
                                        'model'=>$modFakturPembelian,
                                        'attribute'=>'tglfaktur',
                                        'mode'=>'datetime',
                                        'options'=> array(
                                            'showOn' => false,
                                            'maxDate' => 'd',
                                            'yearRange'=> "-150:+0",
                                        ),
                                        'htmlOptions'=>array('placeholder'=>'00/00/0000 00:00:00','class'=>'dtPicker2 datetimemask','onkeyup'=>"return $(this).focusNextInputField(event)"
                                        ),
                                )); ?>
                            </div>
                 </div>
                <div class="control-group ">
                    <?php echo $form->labelEx($modFakturPembelian,'tgljatuhtempo', array('class'=>'control-label')) ?>
                        <div class="controls">
                            <?php   
                                    $modFakturPembelian->tgljatuhtempo = (!empty($modFakturPembelian->tgljatuhtempo) ? date("d/m/Y H:i:s",strtotime($modFakturPembelian->tgljatuhtempo)) : null);
                                    $this->widget('MyDateTimePicker',array(
                                        'model'=>$modFakturPembelian,
                                        'attribute'=>'tgljatuhtempo',
                                        'mode'=>'datetime',
                                        'options'=> array(
                                            'showOn' => false,
                                            'yearRange'=> "-150:+0",
                                        ),
                                        'htmlOptions'=>array('placeholder'=>'00/00/0000 00:00:00','class'=>'dtPicker2 datetimemask','onkeyup'=>"return $(this).focusNextInputField(event)"
                                        ),
                            )); ?>
                        </div>
                </div>
            <?php echo $form->textFieldRow($modFakturPembelian,'biayamaterai', array('class'=>'span3integer', 'onkeyup'=>"return $(this).focusNextInputField(event)")) ?>
            <?php echo $form->textAreaRow($modFakturPembelian,'keteranganfaktur', array('placeholder'=>'Ket. Terima Langsung Faktur','class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)")) ?>
            <?php echo $form->dropDownListRow($modFakturPembelian,'syaratbayar_id',
                                           CHtml::listData(FASyaratbayarM::model()->SyaratbayarItems, 'syaratbayar_id', 'syaratbayar_nama'),
                                           array('readonly'=>true, 'disable'=>'disable','class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event)",
                                           'empty'=>'-- Pilih --',)); ?>
        </div>    
</div>
<div class="span6">
        <div>
        <legend class="rim">Informasi Harga</legend>
        <?php echo $form->textFieldRow($modFakturPembelian,'totharganetto', array('class'=>'span2 integer','readonly'=>TRUE, 'onkeyup'=>"return $(this).focusNextInputField(event)")) ?>
        <div class="control-group ">
            <label class='control-label'>
                <?php echo CHtml::checkbox('termasukPPN',false,array('onclick'=>'persenPpn(this)','disabled'=>TRUE,'style'=>'width : 10px', 'onkeyup'=>"return $(this).focusNextInputField(event)"))?>
                PPN (Total)
                </label>
            <div class="controls">
                <?php echo $form->textField($modFakturPembelian,'totalpajakppn', array('class'=>'span2 integer','readonly'=>TRUE, 'onkeyup'=>"return $(this).focusNextInputField(event)")) ?>
            </div>
         </div>
        <div class="control-group ">
            <label class='control-label'>
                <?php echo CHtml::checkBox('termasukPPH',false,array('onclick'=>'persenPph(this)','disabled'=>TRUE,'style'=>'width : 10px', 'onkeyup'=>"return $(this).focusNextInputField(event)"))?>
                Pph (Total)
                </label>
            <div class="controls">
                <?php echo $form->textField($modFakturPembelian,'totalpajakpph', array('class'=>'span2 integer','readonly'=>TRUE, 'onkeyup'=>"return $(this).focusNextInputField(event)")) ?>
            </div>
         </div>
        <div class="control-group ">
            <label class='control-label'>
                <?php echo CHtml::checkbox('diskonSemua',false,array('onclick'=>'setPersenDiskonFaktur(this)','disabled'=>TRUE,'style'=>'width : 10px', 'onkeyup'=>"return $(this).focusNextInputField(event)"))?>
                Persen Keringanan / Faktur
                </label>
            <div class="controls">
                <?php echo $form->textField($modFakturPembelian,'persendiscount', array('onkeyup'=>'gantiDiskonFakturPersen(this);','class'=>'span2  integer','readonly'=>TRUE, 'onkeyup'=>"return $(this).focusNextInputField(event)",'onblur'=>'setPersenDiskonDetail();')) ?>
            </div>
         </div>
        <div class="control-group ">
            <label class='control-label'>
            Keringanan Rp / Faktur
                </label>
            <div class="controls">
                <?php echo $form->textField($modFakturPembelian,'jmldiscount', array('onkeyup'=>'gantiDiskonFakturRp(this);','class'=>'span2 integer','readonly'=>TRUE,'onkeyup'=>"return $(this).focusNextInputField(event)",)); ?>
            </div>
         </div>
         <?php echo $form->textFieldRow($modFakturPembelian,'totalhargabruto', array('class'=>'span2 integer','readonly'=>TRUE,'onkeyup'=>"return $(this).focusNextInputField(event)")) ?>
        </div>
</div>
</div>