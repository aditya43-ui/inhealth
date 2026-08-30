<div class="row" style="margin-top: 17px;">
    <div class="col-sm-6">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Data <b>Faktur</b>
                </div>
            </div>
            <div class="panel-body" style="min-height: 303px;">
                <div class="control-group">
                    <?php echo CHtml::label('No Faktur <span class="required">*</span>', '', array('class' => 'control-label required')); ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'nofaktur', array('placeholder' => 'No Faktur', 'class' => 'span3 alphanumber', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Tgl. Faktur <span class="required">*</span>', 'tglfaktur', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'tglfaktur',
                            'mode' => 'datetime',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                            ),
                            'htmlOptions' => array(
                                'readonly' => true, 'class' => 'span3 dtPicker3 isRequired', 'onkeypress' => "return $(this).focusNextInputField(event)", 'onchange' => 'loadJatuhTempo();'
                            ),
                        ));
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'tgljatuhtempo', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'tgljatuhtempo',
                            'mode' => 'datetime',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                            ),
                            'htmlOptions' => array(
                                'readonly' => true, 'class' => 'span3 dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                            ),
                        ));
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label("Syarat Bayar <span class='required'>*</span>", "syaratbayar_id", array('class' => 'control-label required')) ?>
                    <div class="controls">
                        <?php echo $form->dropDownList(
                            $model,
                            'syaratbayar_id',
                            CHtml::listData(SyaratbayarM::model()->findAll('syaratbayar_aktif = true ORDER BY syaratbayar_nama ASC'), 'syaratbayar_id', 'syaratbayar_nama'),
                            array(
                                'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)",
                                'empty' => '-- Pilih --',
                            )
                        ); ?>
                    </div>
                </div>
                <?php echo $form->textAreaRow($model, 'keteranganfaktur', array('placeholder' => 'Keterangan', 'class' => 'span3', 'rows' => 3,))  ?>
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
                <div class="control-group">
                    <?php echo CHtml::label('Total Harga', 'discount', array('class' => 'control-label inline')) ?>
                    <div class="controls">
                        <?php echo CHtml::textField('Faktupembelian[totalharga]', '', array('readonly' => true, 'class' => 'span3 integer-decimal', 'onkeypress' => "return $(this).focusNextInputField(event);", 'style' => 'text-align: right;')); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Total Keringanan', 'discount', array('class' => 'control-label inline')) ?>
                    <div class="controls">
                        <?php echo Chtml::hiddenField('discountpersen', '0', array('class' => 'span1 float2', 'onblur' => 'setTotalHarga();', 'style' => 'text-align: right;')); ?>
                        <!--% =-->
                        <?php echo CHtml::textField('Faktupembelian[discount]', '', array('readonly' => true, 'class' => 'span3 integer-decimal', 'onkeypress' => "return $(this).focusNextInputField(event);", 'style' => 'text-align: right;')); ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">
                        Total PPN
                    </label>
                    <div class="controls">
                        <?php echo Chtml::hiddenField('ppnpersen', '10', array('class' => 'span1 float2', 'style' => 'text-align: right;')); ?>
                        <?php echo CHtml::textField('Faktupembelian[pajakppn]','', array('class' => 'span3 integer-decimal', 'onkeypress' => "return $(this).focusNextInputField(event);", 'style' => 'text-align: right;', 'readonly' => true)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Total PPh', 'pajakpph', array('class' => 'control-label inline')) ?>
                    <div class="controls">
                        <?php echo $form->hiddenField($model, 'persenpph_22', array('readonly' => false, 'onblur' => 'setTotalHarga();', 'class' => 'inputFormTabel float2 span1', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        <!--%--> <?php echo CHtml::textField('Faktupembelian[pajakpph]','', array('readonly' => true, 'class' => 'inputFormTabel integer-decimal span3 text-right', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo Chtml::label("Total Keseluruhan", 'totalkeseluruhan', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo CHtml::textField('Faktupembelian[totalkeseluruhan]','', array('class' => 'span3 integer-decimal text-right', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100, 'readonly' => true)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo Chtml::label("Jumlah Uang Muka", 'jlmuangmukabeli', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'jlmuangmukabeli', array('class' => 'span3 integer-decimal text-right', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100, 'readonly' => true)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo Chtml::label("Total Harga Netto", 'totalhutangusaha', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'totalhutangusaha', array('class' => 'span3 integer-decimal text-right', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100, 'readonly' => true)); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>