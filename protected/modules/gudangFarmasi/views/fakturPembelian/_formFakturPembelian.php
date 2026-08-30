<div class="col-sm-6">
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">
                Data Faktur
            </div>
        </div>
        <div class="panel-body">
            <div id="fakturPembelian">
                <?php echo $form->textFieldRow($modFakturPembelian, 'nofaktur', array('placeholder' => 'No. Faktur', 'class' => 'span3 isRequiredFaktur', 'onkeyup' => "return $(this).focusNextInputField(event)",)) ?>
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
                                //                                            'dateFormat'=>Params::DATE_FORMAT,
                                'showOn' => false,
                                'maxDate' => 'd',
                                'yearRange' => "-150:+0",
                            ),
                            'htmlOptions' => array(
                                'placeholder' => '00/00/0000 00:00:00', 'class' => 'dtPicker2 datetimemask', 'onkeyup' => "return $(this).focusNextInputField(event)"
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
                                //                                            'dateFormat'=>Params::DATE_FORMAT,
                                'showOn' => false,
                                //                                                'maxDate' => 'd',
                                'yearRange' => "-150:+0",
                            ),
                            'htmlOptions' => array(
                                'placeholder' => '00/00/0000 00:00:00', 'class' => 'dtPicker2 datetimemask', 'onkeyup' => "return $(this).focusNextInputField(event)"
                            ),
                        )); ?>
                    </div>
                </div>
                <?php echo $form->textFieldRow($modFakturPembelian, 'biayamaterai', array('class' => 'span3 integer2', 'onkeyup' => "return $(this).focusNextInputField(event)",)) ?>
                <?php echo $form->textAreaRow($modFakturPembelian, 'keteranganfaktur', array('placeholder' => 'Ket. Faktur', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)",)) ?>
                <?php echo $form->dropDownListRow(
                    $modFakturPembelian,
                    'syaratbayar_id',
                    CHtml::listData(GFSyaratBayarM::model()->SyaratbayarItems, 'syaratbayar_id', 'syaratbayar_nama'),
                    array(
                        'readonly' => false, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)",
                        'empty' => '-- Pilih --',
                    )
                ); ?>
            </div>
        </div>
    </div>
</div>
<div class="col-sm-6">
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">
                <i class="entypo-info-circled"></i> Informasi <b>Harga</b>
            </div>
        </div>
        <div class="panel-body">
            <fieldset class="box2">
                <?php echo $form->textFieldRow($modFakturPembelian, 'totharganetto', array('class' => 'span2 isRequired integer2', 'readonly' => TRUE, 'onkeyup' => "return $(this).focusNextInputField(event)")) ?>
                <div class="control-group">
                    <label class='control-label'>
                        <?php echo CHtml::checkbox('termasukPPN', false, array('onclick' => 'persenPpn(this)', 'style' => 'width : 10px', 'onkeyup' => "return $(this).focusNextInputField(event)")) ?>
                        Ppn (Total)
                    </label>
                    <div class="controls">
                        <?php echo $form->textField($modFakturPembelian, 'totalpajakppn', array('class' => 'span2 isRequired integer2', 'readonly' => TRUE, 'onkeyup' => "return $(this).focusNextInputField(event)")) ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class='control-label'>
                        <?php echo CHtml::checkBox('termasukPPH', false, array('onclick' => 'persenPph(this)', 'style' => 'width : 10px', 'onkeyup' => "return $(this).focusNextInputField(event)")) ?>
                        Pph (Total)
                    </label>
                    <div class="controls">
                        <?php echo $form->textField($modFakturPembelian, 'totalpajakpph', array('class' => 'span2 isRequired integer2', 'readonly' => TRUE, 'onkeyup' => "return $(this).focusNextInputField(event)")) ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class='control-label'>
                        <?php echo CHtml::checkbox('diskonSemua', false, array('style' => 'width : 10px', 'onkeyup' => "return $(this).focusNextInputField(event)")) ?>
                        Persen Keringanan/ Faktur
                    </label>
                    <div class="controls">
                        <?php echo $form->textField($modFakturPembelian, 'persendiscount', array('class' => 'span2 isRequired integer2', 'readonly' => TRUE, 'onkeyup' => "hitungTotal(); return $(this).focusNextInputField(event)")) ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class='control-label'>
                        <?php // echo CHtml::checkbox('diskonSemuaRp',false,array('style'=>'width : 10px', 'onkeyup' => "return $(this).focusNextInputField(event)"))
                        ?>
                        Keringanan Rp / Faktur
                    </label>
                    <div class="controls">
                        <?php echo $form->textField($modFakturPembelian, 'jmldiscount', array('class' => 'span2 isRequired integer2', 'readonly' => TRUE, 'onkeyup' => "return $(this).focusNextInputField(event)")) ?>
                    </div>
                </div>
                <?php echo $form->textFieldRow($modFakturPembelian, 'totalhargabruto', array('class' => 'span2 isRequired integer2', 'readonly' => TRUE, 'onkeyup' => "return $(this).focusNextInputField(event)")) ?>
            </fieldset>
        </div>
    </div>
</div>
