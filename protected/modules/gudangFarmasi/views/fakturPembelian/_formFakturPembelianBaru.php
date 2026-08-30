<div class="row">
    <div class="col-sm-6">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Informasi <b>Faktur</b>
                </div>
            </div>
            <div class="panel-body">
                <?php echo $form->textFieldRow($modFakturPembelian, 'nofaktur', array('placeholder' => 'No. Faktur', 'class' => 'span3 alphanumber', 'onkeyup' => "return $(this).focusNextInputField(event)")) ?>
                <div class="control-group">
                    <?php echo $form->labelEx($modFakturPembelian, 'tglfaktur', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        $modFakturPembelian->tglfaktur = (!empty($modFakturPembelian->tglfaktur) ? date("d/m/Y H:i:s", strtotime($modFakturPembelian->tglfaktur)) : null);
                        $this->widget('MyDateTimePicker', array(
                            'model' => $modFakturPembelian,
                            'attribute' => 'tglfaktur',
                            'mode' => 'datetime',
                            'options' => array(
                                'showOn' => false,
                                'maxDate' => 'd',
                                'yearRange' => "-150:+0",
                            ),
                            'htmlOptions' => array(
                                'style' => 'width:140px;', 'placeholder' => '00/00/0000 00:00:00', 'class' => 'span2 dtPicker2 datetimemask', 'onkeyup' => "return $(this).focusNextInputField(event)", 'onchange' => 'loadJatuhTempo();'
                            ),
                        )); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modFakturPembelian, 'tgljatuhtempo', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        $modFakturPembelian->tgljatuhtempo = (!empty($modFakturPembelian->tgljatuhtempo) ? date("d/m/Y H:i:s", strtotime($modFakturPembelian->tgljatuhtempo)) : null);
                        $this->widget('MyDateTimePicker', array(
                            'model' => $modFakturPembelian,
                            'attribute' => 'tgljatuhtempo',
                            'mode' => 'datetime',
                            'options' => array(
                                'showOn' => false,
                                'yearRange' => "-150:+0",
                            ),
                            'htmlOptions' => array(
                                'style' => 'width:140px;', 'placeholder' => '00/00/0000 00:00:00', 'class' => 'span2 dtPicker2 datetimemask', 'onkeyup' => "return $(this).focusNextInputField(event)"
                            ),
                        )); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label("Jenis PPh", "pajak_id", array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->hiddenField($modFakturPembelian, 'pajak_id', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        <?php echo $form->textField($modFakturPembelian, 'pajak_nama', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true)); ?>
                        <?php
                        //                                            echo $form->dropDownList($modFakturPembelian,'pajak_id',
                        //                                                                            CHtml::listData(PajakM::model()->findAll('pajak_aktif = true AND  ispajakpegawai = false order by pajak_nama ASC'), 'pajak_id', 'pajak_nama'),
                        //                                                                            array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",
                        //                                                                            'empty'=>'-- Pilih --',)); 
                        //									
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label("Syarat Bayar <span class='required'>*</span>", "syaratbayar_id", array('class' => 'control-label required')) ?>
                    <div class="controls">
                        <?php echo $form->dropDownList(
                            $modFakturPembelian,
                            'syaratbayar_id',
                            CHtml::listData(GFSyaratBayarM::model()->SyaratbayarItems, 'syaratbayar_id', 'syaratbayar_nama'),
                            array(
                                'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)",
                                'empty' => '-- Pilih --',
                            )
                        ); ?>
                    </div>
                </div>
                <?php echo $form->textAreaRow($modFakturPembelian, 'keteranganfaktur', array('placeholder' => 'Ket. Terima Langsung Faktur', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")) ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">Informasi Faktur</div>
            </div>
            <div class="panel-body">
                <?php echo $form->textFieldRow($modFakturPembelian, 'totharganetto', array('class' => 'span3 integer-decimal', 'readonly' => TRUE, 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                <div class="control-group">
                    <label class='control-label'>
                        Total Keringanan
                    </label>
                    <div class="controls">
                        <?php
                        $modFakturPembelian->persendiscount = 0;
                        //									$modFakturPembelian->persendiscount = (empty($modFakturPembelian->persendiscount)?0:$modFakturPembelian->persendiscount);
                        echo $form->hiddenField($modFakturPembelian, 'persendiscount', array('class' => 'span1 float2', 'readonly' => false, 'onblur' => 'setJmlDiskonFaktur(this);hitungTotalFaktur()')); ?>
                    </div>
                    <div class="controls">
                        <?php echo  $form->textField($modFakturPembelian, 'jmldiscount', array('class' => 'span3 integer-decimal', 'readonly' => true, 'onblur' => 'setPersenDisFaktur(this);hitungTotalFaktur()')); ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class='control-label'>
                        Total PPN
                    </label>
                    <div class="controls">
                        <?php
                        $modFakturPembelian->persenppn = 0;
                        //									$modFakturPembelian->persenppn = (empty($modFakturPembelian->persenppn)?10:$modFakturPembelian->persenppn);
                        echo $form->hiddenField($modFakturPembelian, 'persenppn', array('class' => 'span1 integer2', 'readonly' => false, 'onkeyup' => "return $(this).focusNextInputField(event)", 'onblur' => 'setPersenPPNTerima(this);hitungTotalFaktur();')); ?>
                    </div>
                    <div class="controls">
                        <?php echo $form->textField($modFakturPembelian, 'totalpajakppn', array('class' => 'span3 integer-decimal', 'readonly' => true, 'onkeyup' => "return $(this).focusNextInputField(event)", 'onblur' => 'hitungTotalFaktur()')) ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Total PPh', 'jmlpph_22', array('class' => 'control-label inline')) ?>
                    <div class="controls">
                        <?php
                        $modFakturPembelian->persenpph_22 = 0;
                        echo $form->hiddenField($modFakturPembelian, 'persenpph_22', array('readonly' => false, 'onblur' => 'hitungTotalFaktur();', 'class' => 'inputFormTabel float2 span1', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        <?php echo $form->textField($modFakturPembelian, 'totalpajakpph', array('readonly' => true, 'class' => 'inputFormTabel integer-decimal span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Total Keseluruhan', '', array('class' => 'control-label inline')) ?>
                    <div class="controls">
                        <?php echo  $form->textField($modFakturPembelian, 'totalhargabruto', array('class' => 'span3 integer-decimal', 'readonly' => TRUE, 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Jumlah Uang Muka', '', array('class' => 'control-label inline')) ?>
                    <div class="controls">
                        <?php echo $form->textField($modFakturPembelian, 'jmluangmukabeli', array('class' => 'span3 integer-decimal', 'readonly' => TRUE, 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Total Harga Netto', '', array('class' => 'control-label inline')) ?>
                    <div class="controls">
                        <?php echo $form->textField($modFakturPembelian, 'totalhutangusaha', array('class' => 'span3 integer-decimal', 'readonly' => TRUE, 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                    </div>
                </div>
            </div>			
        </div>	
	</div>
