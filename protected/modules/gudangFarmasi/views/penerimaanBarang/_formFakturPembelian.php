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
                    <?php echo $form->dropDownListRow(
                        $modFakturPembelian,
                        'syaratbayar_id',
                        CHtml::listData(GFSyaratBayarM::model()->SyaratbayarItems, 'syaratbayar_id', 'syaratbayar_nama'),
                        array(
                            'readonly' => true, 'disable' => 'disable', 'class' => 'span2', 'onkeyup' => "return $(this).focusNextInputField(event)",
                            'empty' => '-- Pilih --',
                        )
                    ); ?>
                    <?php echo $form->textAreaRow($modFakturPembelian, 'keteranganfaktur', array('placeholder' => 'Ket. Terima Langsung Faktur', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")) ?>
                </div>
                <?php echo $form->textAreaRow($modFakturPembelian, 'keteranganfaktur', array('placeholder' => 'Ket. Terima Langsung Faktur', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")) ?>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="panel panel-gradient">
                <div class="panel-heading">
                    <div class="panel-title">
                        <i class="entypo-info-circled"></i> Informasi <b>Harga</b>
                    </div>
                </div>
                <div class="panel-body">
                    <?php echo $form->textFieldRow($modFakturPembelian, 'totharganetto', array('class' => 'span3 integer2', 'readonly' => TRUE, 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                    <?php /*
					<div class="control-group">
							<label class='control-label'>
								<?php //echo CHtml::checkbox('diskonSemua',false,array('onclick'=>'setPersenDiskonFaktur(this)','disabled'=>TRUE,'style'=>'width : 10px', 'onkeyup'=>"return $(this).focusNextInputField(event)"))?>
								Diskon 
							</label>
							<div class="controls">
								<?php echo $form->textField($modFakturPembelian,'persendiscount', array('class'=>'span2  float2','readonly'=>false, 'onblur'=>'setJmlDiskonFaktur(this);hitungTotalFaktur()')); ?>
							</div>
						</div>
					 * 
					 */ ?>
                    <div class="control-group">
                        <label class='control-label'>
                            Total Keringanan
                        </label>
                        <div class="controls">
                            <?php
                            $modFakturPembelian->persendiscount = (empty($modFakturPembelian->persendiscount) ? 0 : $modFakturPembelian->persendiscount);
                            echo $form->textField($modFakturPembelian, 'persendiscount', array('class' => 'span1  float2', 'readonly' => false, 'onblur' => 'setJmlDiskonFaktur(this, true);hitungTotalFaktur()')) . '% ';   ?>
                        </div>
                        <div class="controls">
                            <?php echo $form->textField($modFakturPembelian, 'jmldiscount', array('class' => 'span2 integer2', 'readonly' => false, 'onblur' => 'setPersenDisFaktur(this);hitungTotalFaktur()')); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class='control-label'>
                            <?php //echo CHtml::checkbox('termasukPPN',true,array('onclick'=>'persenPpn(this)','disabled'=>TRUE,'style'=>'width : 10px', 'onkeyup'=>"return $(this).focusNextInputField(event)"))
                            ?>
                            Total PPN
                        </label>
                        <div class="controls">
                            <?php
                            $modFakturPembelian->persenppn = (empty($modFakturPembelian->persenppn) ? 10 : $modFakturPembelian->persenppn);
                            echo $form->textField($modFakturPembelian, 'persenppn', array('class' => 'span1 integer2', 'readonly' => false, 'onkeyup' => "return $(this).focusNextInputField(event)", 'onblur' => 'setPersenPPNTerima(this, true);hitungTotalFaktur();')) . ' %'; ?>
                        </div>
                        <div class="controls">
                            <?php echo $form->textField($modFakturPembelian, 'totalpajakppn', array('class' => 'span2 integer2', 'readonly' => true, 'onkeyup' => "return $(this).focusNextInputField(event)", 'onblur' => 'hitungTotalFaktur()')) ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class='control-label'>
                            Total PPh Final
                        </label>
                        <div class="controls">
                            <?php
                            $modFakturPembelian->persenpph = (empty($modFakturPembelian->persenpph) ? 0 : $modFakturPembelian->persenpph);
                            echo $form->textField($modFakturPembelian, 'persenpph', array('class' => 'span1 integer2', 'readonly' => false, 'onkeyup' => "return $(this).focusNextInputField(event)", 'onblur' => 'hitungTotalFaktur();')) . ' %'; ?>
                        </div>
                        <div class="controls">
                            <?php echo $form->textField($modFakturPembelian, 'totalpajakpph', array('class' => 'span2 integer2', 'readonly' => true, 'onkeyup' => "return $(this).focusNextInputField(event)", 'onblur' => 'hitungTotalFaktur()')) ?>
                        </div>
                    </div>
                    <?php echo $form->textField($modFakturPembelian, 'biayamaterai', array('class' => 'span2 integer2', 'onkeyup' => "return $(this).focusNextInputField(event)", 'style' => 'display:none;')) ?>
                    <?php echo $form->textFieldRow($modFakturPembelian, 'totalhargabruto', array('class' => 'span3 integer2', 'readonly' => TRUE, 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
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
</div>