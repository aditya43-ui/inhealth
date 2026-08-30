<?php $linkHalaman = CustomFunction::getUrlByMenuID(1394); ?>
<div id="input-penerimaan-kas">
    <div class="panel panel-gradient">
        <div class="panel-heading">
            <div class="panel-title">
                <i class="glyphicon glyphicon-briefcase"></i> Transaksi <b>Penerimaan Kas / Umum</b>
                <span class="pull-right">
                    <a href="<?= !empty($linkHalaman) ? $linkHalaman : '#'; ?>" class="btn btn-default" target="_blank">
                        <i class="fas fa-external-link-alt"></i> Ke Halaman Informasi
                    </a>
                </span>
            </div>
        </div>
        <div class="panel-body">
            <?php $totTagihan = 0; ?>
            <?php
            /*  $this->widget('application.extensions.moneymask.MMask',array(
						'element'=>'.currency',
						'currency'=>'PHP',
						'config'=>array(
							'symbol'=>'Rp ',
							'defaultZero'=>true,
							'allowZero'=>true,
							'precision'=>0,
						)
					));*/
            ?>
            <?php // Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting.js'); 
            ?>
            <?php // Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); 
            ?>
            <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END); ?>
            <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END); ?>
            <?php
            $this->breadcrumbs = array(
                'Transaksi Penerimaan Kas / Umum',
            );
            $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
                'id' => 'akpenerimaan-umum-t-form',
                'enableAjaxValidation' => false,
                'type' => 'horizontal',
                'htmlOptions' => array(
                    'onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'
                ),
                'focus' => '#KUPenerimaanUmumT_nopenerimaan',
            ));
            $this->widget('bootstrap.widgets.BootAlert');
            ?>
            <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
            <!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') 
                                        ?></p>-->
            <div class="row">
                <div class="col-sm-6">
                    <div class="control-group">
                        <?php $modPenUmum->tglpenerimaan = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modPenUmum->tglpenerimaan, 'yyyy-MM-dd hh:mm:ss', 'medium', null)); ?>
                        <?php echo $form->labelEx($modPenUmum, 'tglpenerimaan', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            $this->widget(
                                'MyDateTimePicker',
                                array(
                                    'model' => $modPenUmum,
                                    'attribute' => 'tglpenerimaan',
                                    'mode' => 'datetime',
                                    'options' => array(
                                        'dateFormat' => Params::DATE_FORMAT,
                                        'maxDate' => 'd',
                                    ),
                                    'htmlOptions' => array(
                                        'class' => 'dtPicker2-5 reqForm span3',
                                        'onkeypress' => "return $(this).focusNextInputField(event)"
                                    ),
                                )
                            );
                            ?>
                        </div>
                    </div>
                    <?php echo $form->hiddenField($modPenUmum, 'nopenerimaan', array('readonly' => TRUE, 'class' => 'span3 reqForm', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 20)); ?>
                    <div class="control-group">
                        <?php echo CHtml::label('No. Penerimaan <span style="color:red;">*</span>', 'nomor', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->textField($modPenUmum, 'nomor', array('readonly' => TRUE, 'class' => 'span3 reqForm', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 20)); ?>
                        </div>
                    </div>
                    <?php echo $form->dropDownListRow($modPenUmum, 'kelompoktransaksi', LookupM::getItems('kelompoktransaksi'), array('class' => 'span3 reqForm', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                    <?php echo $form->hiddenField($modPenUmum, 'jenispenerimaan_id', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    <div class="control-group">
                        <?php echo $form->labelEx($modPenUmum, 'jenispenerimaan_id', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            $this->widget('MyJuiAutoComplete', array(
                                'model' => $modPenUmum,
                                'attribute' => 'jenisKodeNama',
                                'source' => 'js: function(request, response) {
												   $.ajax({
													   url: "' . $this->createUrl('autocompleteJenisPenerimaan') . '",
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
                                    'minLength' => 2,
                                    'focus' => 'js:function( event, ui ) {
											   $(this).val(ui.item.value);
												return false;
											}',
                                    'select' => 'js:function( event, ui ) {
												$("#KUPenerimaanUmumT_jenispenerimaan_id").val(ui.item.jenispenerimaan_id);
												getDataRekening(ui.item.jenispenerimaan_id);
                                                                                                getSebagaiBayar(ui.item.jenispenerimaan_nama);
												return false;
											}',
                                ),
                                'htmlOptions' => array('placeholder' => 'Kode/Nama Jenis Penerimaan', 'class' => 'span3 reqForm'),
                                'tombolDialog' => array('idDialog' => 'dialogJenisPenerimaan',),
                            ));
                            ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo $form->labelEx($modPenUmum, 'volume', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->textField($modPenUmum, 'volume', array('onblur' => 'hitungTotalHarga()', 'class' => 'span1 reqForm numbers-only', 'onkeypress' => "return $(this).focusNextInputField(event);", 'style' => 'text-align: right;')); ?>
                            <?php echo $form->dropDownList($modPenUmum, 'satuanvol', LookupM::getItems('satuanumum'), array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                        </div>
                    </div>
                    <?php echo $form->textFieldRow($modPenUmum, 'hargasatuan', array('onblur' => 'hitungTotalHarga()', 'class' => 'inputFormTabel integer2 reqForm span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                </div>
                <div class="col-sm-6">
                    <?php echo $form->textFieldRow($modPenUmum, 'totalharga', array('readonly' => true, 'class' => 'inputFormTabel integer2 span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    <?php echo $form->textAreaRow($modPenUmum, 'keterangan_penerimaan', array('placeholder' => 'Keterangan Penerimaan', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    <div class="control-group">
                        <?php echo $form->label($modPenUmum, 'namapenandatangan', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php $this->widget('MyJuiAutoComplete', array(
                                'model' => $modPenUmum,
                                'attribute' => 'namapenandatangan',
                                'source' => 'js: function(request, response) {
										$.ajax({
											url: "' . $this->createUrl('autoCompletePegawaiTandaTangan') . '",
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
                                    'minLength' => 2,
                                    'focus' => 'js:function( event, ui ) {
											 $(this).val(ui.item.label);
											 return false;
										 }',
                                    'select' => 'js:function( event, ui ) {
											 $(this).val(ui.item.label);
											 return false;
										 }',
                                ),
                                'htmlOptions' => array(
                                    'class' => 'span3',
                                    'placeholder' => 'Nama Penanda Tangan',
                                    'onkeyup' => "return $(this).focusNextInputField(event)",
                                    'onblur' => 'if(this.value === "") $("#obatalkes_id").val(""); '
                                ),
                                'tombolDialog' => array('idDialog' => 'dialogPegawai'),
                            ));
                            ?>
                        </div>
                    </div>
                    <?php // echo $form->textFieldRow($modPenUmum,'namapenandatangan',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); 
                    ?>
                    <?php echo $form->textFieldRow($modPenUmum, 'nippenandatangan', array('placeholder' => 'NIP Penanda Tangan', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                    <?php echo $form->textFieldRow($modPenUmum, 'jabatanpenandatangan', array('placeholder' => 'Jabatan Penanda Tangan', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                </div>
            </div>
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="panel-title"><?php echo CHtml::checkBox('pakeAsuransi', true, array('onchange' => 'bukaUraian(this)', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        Pilih Jika Transaksi Ada Uraiannya</div>
                </div>
                <div class="panel-body">
                    <fieldset class="">
                        <div id="div_tblInputUraian">
                            <table id="tblInputUraian" class="table table-bordered table-striped table-condensed">
                                <thead>
                                    <tr>
                                        <th>Uraian</th>
                                        <th>Volume</th>
                                        <th>Satuan</th>
                                        <th>Harga</th>
                                        <th>Total</th>
                                        <th>&nbsp;</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $this->renderPartial($this->path_view . '_rowUraian', array('form' => $form, 'modUraian' => $modUraian)); ?>
                                </tbody>
                            </table>
                        </div>
                    </fieldset>
                </div>
            </div>
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="panel-title">
                        <i class="glyphicon glyphicon-file"></i> Data <b>Tambahan</b>
                    </div>
                </div>
                <div class="panel-body">
                    <fieldset class="">
                        <div class="row">
                            <div class="col-sm-6">
                                <div style="overflow-x: auto;max-width: 100%">
                                    <?php
                                    $this->renderPartial(
                                        $this->path_view . '_rowListRekening',
                                        array(
                                            'form' => $form,
                                            'modUraian' => $modUraian,
                                        )
                                    );
                                    ?>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="control-group">
                                    <?php echo CHtml::label('Total PPh 21', 'jmlpph_21', array('class' => 'control-label inline')) ?>
                                    <div class="controls">
                                        <?php echo $form->textField($modPenUmum, 'persenpph_21', array('readonly' => false, 'onblur' => 'hitungTotalHarga(); changeRekColumnDataLoad(this);', 'class' => 'float2 span1', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                                        % <?php echo $form->textField($modPenUmum, 'jmlpph_21', array('readonly' => true, 'class' => 'integer2 span2', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <?php echo CHtml::label('Total PPh 23', 'jmlpph_23', array('class' => 'control-label inline')) ?>
                                    <div class="controls">
                                        <?php echo $form->textField($modPenUmum, 'persenpph_23', array('readonly' => false, 'onblur' => 'hitungTotalHarga(); changeRekColumnDataLoad(this);', 'class' => 'inputFormTabel float2 span1', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                                        % <?php echo $form->textField($modPenUmum, 'jmlpph_23', array('readonly' => true, 'class' => 'inputFormTabel integer2 span2', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <?php echo CHtml::label('Total PPh Final', 'jmlpph_22', array('class' => 'control-label inline')) ?>
                                    <div class="controls">
                                        <?php echo $form->textField($modPenUmum, 'persenpph_22', array('readonly' => false, 'onblur' => 'hitungTotalHarga(); changeRekColumnDataLoad(this);', 'class' => 'inputFormTabel float2 span1', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                                        % <?php echo $form->textField($modPenUmum, 'jmlpph_22', array('readonly' => true, 'class' => 'inputFormTabel integer2 span2', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <?php echo CHtml::label('Total PPN', 'ppn', array('class' => 'control-label inline')) ?>
                                    <div class="controls">
                                        <?php echo $form->textField($modPenUmum, 'persenppn', array('readonly' => false, 'onblur' => 'hitungTotalHarga(); changeRekColumnDataLoad(this);', 'class' => 'inputFormTabel integer2 span1', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                                        % <?php echo $form->textField($modPenUmum, 'ppn', array('readonly' => true, 'class' => 'inputFormTabel integer2 span2', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <?php echo CHtml::label('Total Penerimaan', 'totTagihan', array('class' => 'control-label inline')) ?>
                                    <div class="controls">
                                        <?php echo CHtml::textField('totTagihan', $totTagihan, array('readonly' => true, 'class' => 'inputFormTabel integer2 span3', 'onkeypress' => "return $(this).focusNextInputField(event);")) ?>
                                    </div>
                                    <!--total taginan-->
                                </div>
                                <?php // echo $form->textFieldRow($modTandaBukti,'jmlpembulatan',array('readonly'=>true,'class'=>'inputFormTabel integer2 span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
                                ?>
                                <?php echo $form->textFieldRow($modTandaBukti, 'biayaadministrasi', array('onkeyup' => 'hitungJmlBayar(); changeRekColumnDataLoad(this);', 'class' => 'inputFormTabel integer2 span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                                <?php echo $form->textFieldRow($modTandaBukti, 'biayamaterai', array('onkeyup' => 'hitungJmlBayar(); changeRekColumnDataLoad(this);', 'class' => 'inputFormTabel integer2 span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                                <div class="control-group">
                                    <?php echo CHtml::label('Jumlah Penerimaan', 'jmlpembayaran', array('class' => 'control-label inline')) ?>
                                    <div class="controls">
                                        <?php echo $form->textField($modTandaBukti, 'jmlpembayaran', array('onkeyup' => 'hitungKembalian();', 'readonly' => true, 'class' => 'inputFormTabel integer2 span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                                    </div>
                                </div>
                                <?php echo $form->textFieldRow($modTandaBukti, 'uangditerima', array('onkeyup' => 'hitungKembalian();', 'class' => 'inputFormTabel integer2 span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                                <?php echo $form->textFieldRow($modTandaBukti, 'uangkembalian', array('class' => 'inputFormTabel integer2 span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true)); ?>
                                <div class="control-group">
                                    <?php $modTandaBukti->tglbuktibayar = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modTandaBukti->tglbuktibayar, 'yyyy-MM-dd hh:mm:ss', 'medium', null)); ?>
                                    <?php echo $form->labelEx($modTandaBukti, 'tglbuktibayar', array('class' => 'control-label inline')) ?>
                                    <div class="controls">
                                        <?php
                                        $this->widget('MyDateTimePicker', array(
                                            'model' => $modTandaBukti,
                                            'attribute' => 'tglbuktibayar',
                                            'mode' => 'datetime',
                                            'options' => array(
                                                'dateFormat' => Params::DATE_FORMAT,
                                                'maxDate' => 'd',
                                            ),
                                            'htmlOptions' => array(
                                                'class' => 'dtPicker2-5 span3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                                            ),
                                        ));
                                        ?>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <?php echo CHtml::label('Cara Pembayaran', 'carapembayaran', array('class' => 'control-label inline')) ?>
                                    <div class="controls">
                                        <?php
                                        $modTandaBukti->carapembayaran = Params::CARAPEMBAYARAN_TUNAI;
                                        echo $form->textField($modTandaBukti, 'carapembayaran', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                                    </div>
                                </div>
                                <?php // echo $form->dropDownListRow($modTandaBukti,'carapembayaran',  LookupM::getItems('carapembayaran'),array('onchange'=>'ubahCaraPembayaran(this)','class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); 
                                ?>
                                <div class="control-group">
                                    <?php echo CHtml::label('Menggunakan Kartu', 'pakeKartu', array('class' => 'control-label inline')) ?>
                                    <div class="controls">
                                        <?php echo CHtml::checkBox('pakeKartu', false, array('onchange' => "enableInputKartu();", 'onkeypress' => "return $(this).focusNextInputField(event);")) ?> <i class="icon-chevron-down"></i>
                                    </div>
                                </div>
                                <div id="divDenganKartu" style="display: none;">
                                    <?php echo $form->dropDownListRow($modTandaBukti, 'dengankartu',  LookupM::getItems('dengankartu'), array('onchange' => 'enableInputKartu()', 'empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                                    <div class="control-group">
                                        <?php echo CHtml::label('Bank Pengirim', 'bankkartu', array('class' => 'control-label inline')) ?>
                                        <div class="controls">
                                            <?php echo $form->dropDownList($modTandaBukti, 'bankkartu', LookupM::getItems('bank'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <?php echo CHtml::activeLabel($modTandaBukti, 'nokartu', array('class' => 'control-label')); ?>
                                        <div class="controls">
                                            <?php echo $form->textField($modTandaBukti, 'nokartu', array('required' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <?php echo CHtml::activeLabel($modTandaBukti, 'nostrukkartu', array('class' => 'control-label')); ?>
                                        <div class="controls">
                                            <?php echo $form->textField($modTandaBukti, 'nostrukkartu', array('required' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                                        </div>
                                    </div>
                                    <!--<div class="control-group">-->
                                    <?php // echo CHtml::activeLabel($modTandaBukti, 'bank_nominal', array('class' => 'control-label required', 'required' => true, 'label'=>'Nominal')); 
                                    ?>
                                    <!--<div class="controls">-->
                                    <?php // echo $form->textField($modTandaBukti, 'bank_nominal', array('required' => true, 'class' => 'span2 integer2', 'onblur'=>'cekBayarBank(); hitungKembalian();', 'onkeyup' => "return $(this).focusNextInputField(event);")); 
                                    ?>
                                    <!--</div>-->
                                    <!--</div>-->
                                    <div class="control-group">
                                        <?php echo CHtml::activeLabel($modTandaBukti, 'bank_id', array('class' => 'control-label', 'label' => 'Bank Penerima')); ?>
                                        <div class="controls">
                                            <?php
                                            $bank_data = BankM::model()->findAll('bank_aktif = true and ispenerimaan = true order by namabank');
                                            $list_bank = CHtml::listData($bank_data, 'bank_id', 'bankNoRekening');
                                            echo $form->dropDownList(
                                                $modTandaBukti,
                                                'bank_id',
                                                $list_bank,
                                                array(
                                                    'empty' => '-- Pilih --', 'required' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);",
                                                    'onchange' => 'getDataRekeningCarapembayar();'
                                                )
                                            ); ?>
                                        </div>
                                    </div>
                                    <?php // echo $form->dropDownListRow($modTandaBukti,'dengankartu',  LookupM::getItems('dengankartu'),array('onchange'=>'enableInputKartu()','empty'=>'-- Pilih --','class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); 
                                    ?>
                                    <?php // echo $form->textFieldRow($modTandaBukti,'bankkartu',array('readonly'=>true,'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); 
                                    ?>
                                    <?php // echo $form->textFieldRow($modTandaBukti,'nokartu',array('readonly'=>true,'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); 
                                    ?>
                                    <?php // echo $form->textFieldRow($modTandaBukti,'nostrukkartu',array('readonly'=>true,'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); 
                                    ?>
                                </div>
                                <div class="control-group">
                                    <?php echo CHtml::label('Nama Pengirim <span style="color:red;">*</span>', 'darinama_bkm', array('class' => 'control-label inline required')) ?>
                                    <div class="controls">
                                        <?php echo $form->textField($modTandaBukti, 'darinama_bkm', array('placeholder' => 'Nama Pengirim', 'class' => 'span3 reqForm', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <?php echo CHtml::label('Alamat Pengirim  <span style="color:red;">*</span>', 'alamat_bkm', array('class' => 'control-label inline required')) ?>
                                    <div class="controls">
                                        <?php echo $form->textArea($modTandaBukti, 'alamat_bkm', array('placeholder' => 'Alamat Pengirim', 'class' => 'span3 reqForm', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                                    </div>
                                </div>
                                <?php echo $form->textFieldRow($modTandaBukti, 'sebagaipembayaran_bkm', array('placeholder' => 'Sebagai Pembayaran', 'class' => 'span3 reqForm', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                            </div>
                        </div>
                    </fieldset>
                </div>
            </div>
            <div class="form-actions">
                <!--div style="float:left;margin-right:6px;"-->
                <?php
                $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
                $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai    
                $urlSave =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/index');
                $this->widget('bootstrap.widgets.BootButtonGroup', array(
                    'type' => 'danger',
                    'buttons' => array(
                        array(
                            'label' => 'Simpan',
                            'icon' => 'entypo-check',
                            'url' => "javascript:void(0)",
                            'htmlOptions' =>
                            array(
                                'onclick' => 'simpanPenerimaan(\'jurnal\');return false;',
                            )
                        ),
                        array(
                            'label' => '',
                            'items' => array(
                                array(
                                    'label' => 'Posting',
                                    'icon' => 'icon-ok',
                                    'url' => "javascript:void(0)",
                                    'itemOptions' => array(
                                        'onclick' => 'simpanPenerimaan(\'posting\');return false;'
                                    )
                                ),
                            )
                        ),
                    ),
                    'htmlOptions' => array(
                        'style' => 'float:left; margin-top: 2px; margin-right: 5px;'
                    ),
                ));
                echo CHtml::htmlButton(
                    Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                    array('style' => 'display:none', 'id' => 'reseter', 'class' => 'btn btn-default', 'type' => 'reset')
                );
                echo CHtml::hiddenField('url');
                ?>
                <!--/div-->
                <?php echo CHtml::link(
                    Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                    Yii::app()->createUrl($this->module->id . '/penerimaanUmum/index'),
                    array(
                        'title' => 'Ulang',
                        'class' => 'btn btn-default',
                        'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
                    )
                ); ?>
                <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'id' => 'btn_print', 'onclick' => 'print(\'PRINT\')', 'disabled' => true)); ?>
                <?php
                $tips = array(
                    '0' => 'simpan',
                    '1' => 'ulang',
                    '2' => 'print',
                );
                $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips', array('tips' => $tips), true);
                $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
                ?>
            </div>
        </div>
    </div>
</div>
<!--div class="white-container" id="input-penerimaan-kas"-->
<!--/div-->
<?php $this->renderPartial($this->path_view . '_jsFunctions', array('modPenUmum' => $modPenUmum, 'form' => $form, 'modUraian' => $modUraian, 'modTandaBukti' => $modTandaBukti)); ?>
<?php $this->endWidget(); ?>
<?php
//========= Dialog buat cari data Rek Kredit =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogJenisPenerimaan',
    'options' => array(
        'title' => 'Daftar Jenis Penerimaan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 600,
        'height' => 400,
        'resizable' => false,
    ),
));
$modJenisPenerimaan = new JenispenerimaanM();
$modJenisPenerimaan->unsetAttributes();
if (isset($_GET['JenispenerimaanM'])) {
    $modJenisPenerimaan->attributes = $_GET['JenispenerimaanM'];
}
$this->widget('ext.bootstrap.widgets.HeaderGroupGridView', array(
    'id' => 'jenispenerimaan-m-grid',
    //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
    'dataProvider' => $modJenisPenerimaan->searchJenisPenerimaanRek(),
    'filter' => $modJenisPenerimaan,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'No.',
            'value' => '$this->grid->dataProvider->Pagination->CurrentPage*$this->grid->dataProvider->pagination->pageSize+$row+1',
        ),
        array(
            'header' => 'Jenis Penerimaan',
            'name' => 'jenispenerimaan_nama',
            'value' => '$data->jenispenerimaan_nama',
        ),
        array(
            'header' => 'Nama Lain',
            'name' => 'jenispenerimaan_namalain',
            'value' => '$data->jenispenerimaan_namalain',
        ), /*
                array(
			'header'=>'PPh 22 (%)',
			'name'=>'persenpph_22',
			'value'=>'$data->persenpph_22',
		),
         * 
         */
        array(
            'header' => 'PPh 23 (%)',
            'name' => 'persenpph_23',
            'value' => '$data->persenpph_23',
            'htmlOptions' => array(
                'style' => 'text-align: right;'
            )
        ),
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
				"id" => "selectRekDebit",
				"onClick" =>"
					getDataRekening($data->jenispenerimaan_id);
                                        getSebagaiBayar(\"$data->jenispenerimaan_nama\");
					$(\"#KUPenerimaanUmumT_jenispenerimaan_id\").val(\"$data->jenispenerimaan_id\");
					$(\"#KUPenerimaanUmumT_jenisKodeNama\").val(\"$data->jenispenerimaan_nama\");
                    $(\"#KUPenerimaanUmumT_persenpph_22\").val(\"".number_format($data->persenpph_22, 2, ",", "")."\");
					$(\"#KUPenerimaanUmumT_persenpph_23\").val(\"".number_format($data->persenpph_23, 2, ",", "")."\");
					$(\"#dialogJenisPenerimaan\").dialog(\"close\");    
					return false;
			"))',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
//========= end Rek Kredit dialog =============================
?>
<?php
//========= Dialog buat cari data Pegawai Mengetahui =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPegawai',
    'options' => array(
        'title' => 'Pencarian Pegawai',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => false,
    ),
));
$modPegawaiMengetahui = new PegawaiV('search');
$modPegawaiMengetahui->unsetAttributes();
if (isset($_GET['PegawaiV'])) {
    $modPegawaiMengetahui->attributes = $_GET['PegawaiV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawai-grid',
    'dataProvider' => $modPegawaiMengetahui->search(),
    'filter' => $modPegawaiMengetahui,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                                    "href"=>"",
                                    "id" => "selectObat",
                                    "onClick" => "
                                                $(\"#' . CHtml::activeId($modPenUmum, 'namapenandatangan') . '\").val(\"$data->namaLengkap\");
                                                $(\"#' . CHtml::activeId($modPenUmum, 'nippenandatangan') . '\").val(\"$data->nomorindukpegawai\");
												$(\"#' . CHtml::activeId($modPenUmum, 'jabatanpenandatangan') . '\").val(\"".(empty($data->jabatan_id)?"":JabatanM::model()->findByPk($data->jabatan_id)->jabatan_nama)."\");
                                                $(\"#dialogPegawai\").dialog(\"close\"); 
                                                return false;
                                        "))',
        ),
        array(
            'header' => 'NIP',
            'filter' =>  CHtml::activeTextField($modPegawaiMengetahui, 'nomorindukpegawai'),
            'value' => '$data->nomorindukpegawai',
        ),
        array(
            'header' => 'Nama Pegawai',
            'filter' =>  CHtml::activeTextField($modPegawaiMengetahui, 'nama_pegawai'),
            'value' => '$data->namaLengkap',
        ),
        array(
            'header' => 'Jabatan',
            'filter' =>  CHtml::activeDropDownList(
                $modPegawaiMengetahui,
                'jabatan_id',
                CHtml::listData(JabatanM::model()->findAll('jabatan_aktif = true order by jabatan_nama'), 'jabatan_id', 'jabatan_nama'),
                array('empty' => '-- Pilih --')
            ),
            'value' => '$data->alamat_pegawai',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
//========= end Pegawai Mengetahui dialog =============================
?>