<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END); ?>
<fieldset id="input-pengeluaran">
    <div class="panel panel-gradient">
        <div class="panel-heading">
            <div class="panel-title">
                <i class="fas fa-money-bill"></i> Transaksi <b>Pengeluaran Kas / Umum</b>
                <span class="pull-right">
                    <a href="<?= !empty($linkHalaman) ? $linkHalaman : '#'; ?>" class="btn btn-default" target="_blank">
                        <i class="fas fa-external-link-alt"></i> Ke Halaman Informasi
                    </a>
                </span>
            </div>
        </div>
        <div class="panel-body">
            <?php
            $this->breadcrumbs = array(
                'Transaksi Pengeluaran Kas / Umum',
            );
            $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
                'id' => 'akpengeluaran-umum-t-form',
                'enableAjaxValidation' => false,
                'type' => 'horizontal',
                'htmlOptions' => array(
                    'onKeyPress' => 'return disableKeyPress(event)',
                ), //'onsubmit'=>'return requiredCheck(this);'
                'focus' => '#',
            ));
            $this->widget('bootstrap.widgets.BootAlert');
            ?>
            <div class="row">
                <!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.')
                                            ?></p>-->
                <?php echo $form->errorSummary(array($modPengUmum, $modBuktiKeluar)); ?>
                <div class="col-sm-6">
                    <div class="control-group">
                        <?php $modPengUmum->tglpengeluaran = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modPengUmum->tglpengeluaran, 'yyyy-MM-dd hh:mm:ss', 'medium', null)); ?>
                        <?php echo $form->labelEx($modPengUmum, 'tglpengeluaran', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            $this->widget('MyDateTimePicker', array(
                                'model' => $modPengUmum,
                                'attribute' => 'tglpengeluaran',
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
                    <?php echo $form->textFieldRow($modPengUmum, 'nopengeluaran', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 20)); ?>
                    <?php echo $form->dropDownListRow($modPengUmum, 'kelompoktransaksi', LookupM::getItems('kelompoktransaksi'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                    <?php echo $form->hiddenField($modPengUmum, 'jenispengeluaran_id', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    <div class="control-group">
                        <?php echo $form->labelEx($modPengUmum, 'jenispengeluaran_id', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            $this->widget('MyJuiAutoComplete', array(
                                'model' => $modPengUmum,
                                'attribute' => 'jenisKodeNama',
                                'source' => 'js: function(request, response) {
											$.ajax({
												url: "' . Yii::app()->createUrl('billingKasir/ActionAutoComplete/jenisPengeluaran') . '",
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
                                                $("#KUPengeluaranumumT_jenispengeluaran_id").val(ui.item.jenispengeluaran_id);
                                                $("#KUPengeluaranumumT_persenpph_21").val(formatFloat2(ui.item.persenpph_21));
                                                $("#KUPengeluaranumumT_persenpph_22").val(formatFloat2(ui.item.persenpph_22));
                                                $("#KUPengeluaranumumT_persenpph_23").val(formatFloat2(ui.item.persenpph_23));
                                                getSebagaiBayar(ui.item.jenispenerimaan_nama);
												getDataRekening(ui.item.jenispenerimaan_id);
												return false;
											}',
                                ),
                                'htmlOptions' => array('placeholder' => 'Nama Jenis Pengeluaran', 'class' => 'span3'),
                                'tombolDialog' => array('idDialog' => 'dialogJenisPengeluaran',),
                            ));
                            ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo $form->labelEx($modPengUmum, 'pegawaimengetahui_id', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            echo $form->hiddenField($modPengUmum, 'pegawaimengetahui_id', array('class'=>'pegawaimengetahui_id'));
                            $modPengUmum->pegawaimengetahui_nama = empty($modPengUmum->pegawaimengetahui) ? "" : $modPengUmum->pegawaimengetahui->namaLengkap;
                            $this->widget('MyJuiAutoComplete', array(
                                'model' => $modPengUmum,
                                'attribute' => 'pegawaimengetahui_nama',
                                'source' => 'js: function(request, response) {
											$.ajax({
												url: "' . $this->createUrl('searchPegawaiMengetahui') . '",
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
                                                $(".pegawaimengetahui_id").val(ui.item.value);
                                                $(".pegawaimengetahui_nama").val(ui.item.label);
												return false;
											}',
                                ),
                                'htmlOptions' => array('placeholder' => 'Pegawai Mengetahui', 'class' => 'span3 pegawaimengetahui_nama'),
                                'tombolDialog' => array('idDialog' => 'dialogPegawaiMengetahui',),
                            ));
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="control-group">
                        <?php echo $form->labelEx($modPengUmum, 'volume', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->textField($modPengUmum, 'volume', array('onblur' => 'hitungTotalHarga()', 'class' => 'span1', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                            <?php echo $form->dropDownList($modPengUmum, 'satuanvol', LookupM::getItems('satuanumum'), array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                        </div>
                    </div>
                    <?php echo $form->textFieldRow($modPengUmum, 'hargasatuan', array('onblur' => 'hitungTotalHarga()', 'class' => 'inputFormTabel integer2 span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    <?php echo $form->textFieldRow($modPengUmum, 'totalharga', array('readonly' => true, 'class' => 'inputFormTabel integer2 span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    <?php echo $form->textAreaRow($modPengUmum, 'keterangankeluar', array('placeholder' => 'Keterangan', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                </div>
            </div>
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="panel-title"><?php echo $form->checkBox($modPengUmum, 'isurainkeluarumum', array('checked' => true, 'onchange' => 'bukaUraian(this)', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        Pilih Jika Transaksi Ada Uraiannya</div>
                </div>
                <div class="panel-body">
                    <div id="div_tblInputUraian">
                        <table id="tblInputUraian" class="table table-bordered table-condensed">
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
                                <?php
                                $removeButton = '';
                                foreach ($modUraian as $i => $uraian) {
                                ?>
                                    <tr class="<?php echo ($removeButton == true ? "child" : "") ?>">
                                        <td>
                                            <?php echo $form->textField($uraian, "[$i]uraiantransaksi", array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                                        </td>
                                        <td>
                                            <?php echo $form->textField($uraian, "[$i]volume", array('onkeyup' => 'hitungTotalUraian(this)', 'class' => 'inputFormTabel span1', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                                        </td>
                                        <td>
                                            <?php echo $form->dropDownList($uraian, "[$i]satuanvol", LookupM::getItems('satuanumum'), array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                                        </td>
                                        <td>
                                            <?php echo $form->textField($uraian, "[$i]hargasatuan", array('onkeyup' => 'hitungTotalUraian(this)', 'class' => 'inputFormTabel span2 integer2', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                                        </td>
                                        <td>
                                            <?php echo $form->textField($uraian, "[$i]totalharga", array('readonly' => true, 'class' => 'inputFormTabel span2 integer2', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                                        </td>
                                        <td>
                                            <?php
                                            if ($removeButton || $i > 0) {
                                                echo CHtml::link("<i class='icon-plus'></i>", '#', array('onclick' => 'addRowUraian(this);return false;', 'rel' => 'tooltip', 'title' => 'Klik untuk menambah uraian'));
                                                echo CHtml::link("<i class='icon-minus'></i>", '#', array('onclick' => 'batalUraian(this);return false;', 'rel' => 'tooltip', 'title' => 'Klik untuk membatalkan uraian'));
                                            } else {
                                                echo CHtml::link("<i class='icon-plus'></i>", '#', array('onclick' => 'addRowUraian(this);return false;', 'rel' => 'tooltip', 'title' => 'Klik untuk menambah uraian'));
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="panel-title">
                        <i class="glyphicon glyphicon-file"></i> Data <b>Tambahan</b>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div style="overflow-x: auto; max-width: 100%">
                                <div class='control-group' style="display: none;">
                                    <?php // echo CHtml::label('Rekening Debit', 'rekening debit', array('class' => 'control-label'))
                                    ?>
                                    <div class="controls">
                                        <?php
                                        //													$this->widget('MyJuiAutoComplete', array(
                                        //														'name' => 'rekDebit',
                                        //														'id' => 'rekDebit',
                                        //														'sourceUrl' => Yii::app()->createUrl('ActionAutoComplete/rekeningAkuntansi', array('id_jenis_rek' => 'Kredit')),
                                        //														'options' => array(
                                        //															'showAnim' => 'fold',
                                        //															'minLength' => 2,
                                        //															'focus' => 'js:function( event, ui ){
                                        //																return false;
                                        //															}',
                                        //															'select' => 'js:function( event, ui ){
                                        //																$(this).val(ui.item.value);
                                        //																var data = {
                                        //																	rekening5_id:ui.item.rekening5_id,
                                        //																	rekening4_id:ui.item.rekening4_id,
                                        //																	rekening3_id:ui.item.rekening3_id,
                                        //																	rekening2_id:ui.item.rekening2_id,
                                        //																	rekening1_id:ui.item.rekening1_id,
                                        //																	status:"debit"
                                        //																};
                                        //																getDataRekeningFromGrid(data);
                                        //																return false;
                                        //															}'
                                        //														),
                                        //														'htmlOptions' => array(
                                        //															'onkeypress' => "return $(this).focusNextInputField(event)",
                                        //															'placeholder' => 'Nama Rekening',
                                        //															'class' => 'span3',
                                        //															'style' => 'width:150px;',
                                        //														),
                                        //														'tombolDialog' => array(
                                        //															'idDialog' => 'dialogRekDebit'
                                        //														),
                                        //													));
                                        ?>
                                    </div>
                                </div>
                                <div class='control-group' style="display: none;">
                                    <?php // echo CHtml::label('Rekening Kredit', 'rekening kredit', array('class' => 'control-label'))
                                    ?>
                                    <div class="controls">
                                        <?php
                                        //													$this->widget('MyJuiAutoComplete', array(
                                        //														'name' => 'rekKredit',
                                        //														'id' => 'rekKredit',
                                        //														'sourceUrl' => Yii::app()->createUrl('ActionAutoComplete/rekeningAkuntansi', array('id_jenis_rek' => 'Kredit')),
                                        //														'options' => array(
                                        //															'showAnim' => 'fold',
                                        //															'minLength' => 2,
                                        //															'focus' => 'js:function( event, ui ){
                                        //																return false;
                                        //															}',
                                        //															'select' => 'js:function( event, ui ){
                                        //																$(this).val(ui.item.value);
                                        //																var data = {
                                        //																	rekening5_id:ui.item.rekening5_id,
                                        //																	rekening4_id:ui.item.rekening4_id,
                                        //																	rekening3_id:ui.item.rekening3_id,
                                        //																	rekening2_id:ui.item.rekening2_id,
                                        //																	rekening1_id:ui.item.rekening1_id,
                                        //																	status:"kredit"
                                        //																};
                                        //																getDataRekeningFromGrid(data);
                                        //																return false;
                                        //															}'
                                        //														),
                                        //														'htmlOptions' => array(
                                        //															'onkeypress' => "return $(this).focusNextInputField(event)",
                                        //															'placeholder' => 'Nama Rekening',
                                        //															'class' => 'span3',
                                        //															'style' => 'width:150px;',
                                        //														),
                                        //														'tombolDialog' => array(
                                        //															'idDialog' => 'dialogRekKredit'
                                        //														),
                                        //													));
                                        ?>
                                    </div>
                                </div>
                                <table id="tblInputRekening" class="table table-bordered table-condensed" widht="450">
                                    <thead>
                                        <tr>
                                            <th width="100">Kode Rekening</th>
                                            <th>Nama Rekening</th>
                                            <th width="100">Debit</th>
                                            <th width="100">Kredit</th>
                                            <th width="50">Batal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="control-group">
                                <?php $modBuktiKeluar->tglkaskeluar = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modBuktiKeluar->tglkaskeluar, 'yyyy-MM-dd hh:mm:ss', 'medium', null)); ?>
                                <?php echo $form->labelEx($modBuktiKeluar, 'tglkaskeluar', array('class' => 'control-label inline')) ?>
                                <div class="controls">
                                    <?php
                                    $this->widget('MyDateTimePicker', array(
                                        'model' => $modBuktiKeluar,
                                        'attribute' => 'tglkaskeluar',
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
                            <?php // echo $form->dropDownListRow($modBuktiKeluar,'tahun', CustomFunction::getTahun(null,null),array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>4));
                            ?>
                            <?php $modBuktiKeluar->tglkaskeluar = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modBuktiKeluar->tglkaskeluar, 'yyyy-MM-dd hh:mm:ss', 'medium', null)); ?>
                            <?php echo $form->textFieldRow($modBuktiKeluar, 'nokaskeluar', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                            <?php echo $form->textFieldRow($modBuktiKeluar, 'biayaadministrasi', array('placeholder' => 'Biaya administrasi', 'onkeyup' => 'hitungTotalHarga();', 'class' => 'inputFormTabel integer2 span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                            <div class="control-group">
                                <?php echo CHtml::label('Total PPh 21', 'jmlpph_21', array('class' => 'control-label inline')) ?>
                                <div class="controls">
                                    <?php echo $form->textField($modPengUmum, 'persenpph_21', array('placeholder' => '00', 'readonly' => false, 'onblur' => 'hitungTotalHarga();', 'class' => 'inputFormTabel float2 span1', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                                    % <?php echo $form->textField($modPengUmum, 'jmlpph_21', array('readonly' => true, 'class' => 'inputFormTabel integer2 span2', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <?php echo CHtml::label('Total PPh 23', 'jmlpph_23', array('class' => 'control-label inline')) ?>
                                <div class="controls">
                                    <?php echo $form->textField($modPengUmum, 'persenpph_23', array('placeholder' => '00', 'readonly' => false, 'onblur' => 'hitungTotalHarga();', 'class' => 'inputFormTabel float2 span1', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                                    % <?php echo $form->textField($modPengUmum, 'jmlpph_23', array('readonly' => true, 'class' => 'inputFormTabel integer2 span2', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <?php echo CHtml::label('Total PPh Final', 'jmlpph_22', array('class' => 'control-label inline')) ?>
                                <div class="controls">
                                    <?php echo $form->textField($modPengUmum, 'persenpph_22', array('placeholder' => '00', 'readonly' => false, 'onblur' => 'hitungTotalHarga();', 'class' => 'inputFormTabel float2 span1', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                                    % <?php echo $form->textField($modPengUmum, 'jmlpph_22', array('readonly' => true, 'class' => 'inputFormTabel integer2 span2', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <?php echo CHtml::label('Total PPn (10%)', 'ppn', array('class' => 'control-label inline')) ?>
                                <div class="controls">
                                    <?php echo $form->textField($modPengUmum, 'persenppn', array('placeholder' => '00', 'readonly' => false, 'onblur' => 'hitungTotalHarga();', 'class' => 'inputFormTabel integer2 span1', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                                    % <?php echo $form->textField($modPengUmum, 'ppn', array('readonly' => true, 'class' => 'inputFormTabel integer2 span2', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                                </div>
                            </div>
                            <?php echo $form->textFieldRow($modBuktiKeluar, 'jmlkaskeluar', array('readonly' => true, 'class' => 'inputFormTabel integer2 span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                            <?php echo $form->dropDownListRow($modBuktiKeluar, 'carabayarkeluar', LookupM::getItems('carabayarkeluar'), array('onchange' => 'formCarabayar(this.value)', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                            <div id="divCaraBayarTransfer" style="display:none;">
                                <div class="control-group">
                                    <?php echo CHtml::label('Nama Bank Penerima', 'bank_id', array('class' => 'control-label')); ?>
                                    <div class="controls">
                                        <?php
                                        $modBank = BankM::getItems($modBuktiKeluar->bank_id);
                                        echo $form->dropDownList($modBuktiKeluar, 'bank_id', CHtml::listData($modBank, 'bank_id', 'namabank'), array(
                                            'class' => 'span3', 'empty' => '-- Pilih --', 'onchange' => 'setNamaBank(this);',
                                            'onkeyup' => "return $(this).focusNextInputField(event);"
                                        ));
                                        ?>
                                    </div>
                                </div>
                                <?php echo CHtml::activeHiddenField($modBuktiKeluar, 'melalubank', array('readonly' => true, 'class' => 'span3')); ?>
                                <?php // echo $form->textFieldRow($modBuktiKeluar, 'melalubank', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                                ?>
                                <?php echo $form->textFieldRow($modBuktiKeluar, 'denganrekening', array('placeholder' => 'Dengan rekening', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                                <?php echo $form->textFieldRow($modBuktiKeluar, 'atasnamarekening', array('placeholder' => 'Atas nama rekening', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                            </div>
                            <?php echo $form->textFieldRow($modBuktiKeluar, 'namapenerima', array('placeholder' => 'Nama penerima', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                            <?php echo $form->textAreaRow($modBuktiKeluar, 'alamatpenerima', array('placeholder' => 'Alamat penerima', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                            <?php // echo $form->textFieldRow($modBuktiKeluar, 'untukpembayaran', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                            ?>
                            <div class="control-group">
                                <?php echo CHtml::label('Sebagai Pembayaran <span class="required">*</span>', 'untukpembayaran', array('class' => 'control-label inline required')) ?>
                                <div class="controls">
                                    <?php echo $form->textField($modBuktiKeluar, 'untukpembayaran', array('placeholder' => 'Sebagai pembayaran', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-actions">
                <!--div style="float:left;margin-right:6px;"-->
                <?php
                $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
                $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
                $urlSave = Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/index');
                $this->widget('bootstrap.widgets.BootButtonGroup', array(
                    'type' => 'danger',
                    'buttons' => array(
                        array(
                            'label' => 'Simpan',
                            'icon' => 'entypo-check',
                            'url' => "javascript:void(0)",
                            'htmlOptions' =>
                            array(
                                'title' => 'Simpan',
                                'onclick' => 'simpanPengeluaran(\'jurnal\');return false;',
                            )
                        ),
                        array(
                            'label' => '',
                            'items' => array(
                                array(
                                    'label' => 'Posting',
                                    'icon' => 'icon-ok',
                                    'url' => "#",
                                    'itemOptions' => array(
                                        'onclick' => 'simpanPengeluaran(\'posting\');return false;'
                                    )
                                ),
                            )
                        ),
                    ),
                    'htmlOptions' => array(
                        'style' => 'float:left; margin-top: 2px; margin-right: 5px;'
                    ),
                ));
                echo CHtml::hiddenField('url');
                echo CHtml::htmlButton(
                    Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                    array('title' => 'Ulang', 'style' => 'display:none', 'id' => 'reseter', 'class' => 'btn btn-default', 'type' => 'reset')
                );
                ?>
                <!--/div-->
                <?php
                echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), Yii::app()->createUrl($this->module->id . '/pengeluaranUmum/index'), array(
                    'class' => 'btn btn-default',
                    'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
                ));
                ?>
                <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'id' => 'btn_print', 'onclick' => 'print(\'PDF\')', 'disabled' => true)); ?>
                <?php // echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="entypo-print"></i>')), '#', array('class' => 'btn btn-danger','id'=>'btn_print','onclick'=>"print(\"PRINT\")",'disabled'=>true));
                ?>
                <?php
                $content = $this->renderPartial('keuangan.views/tips/transaksi', array(), true);
                $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
                ?>
            </div>
        </div>
    </div>
</fieldset>
<?php $this->renderPartial($this->path_view . '_jsFunctions', array('modPengUmum' => $modPengUmum, 'form' => $form, 'modUraian' => $modUraian, 'modBuktiKeluar' => $modBuktiKeluar)); ?>
<?php $this->endWidget(); ?>


<?php
//========= Dialog buat cari data Rek Kredit =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPegawaiMengetahui',
    'options' => array(
        'title' => 'Daftar Pegawai Mengetahui',
        'autoOpen' => false,
        'modal' => true,
        'width' => 700,
        'height' => 500,
        'resizable' => false,
    ),
));
$pegawaiPengetahui = new PegawairuanganV('search');
$pegawaiPengetahui->unsetAttributes();
$pegawaiPengetahui->ruangan_id = Yii::app()->user->getState('ruangan_id');
$pegawaiPengetahui->pegawai_aktif = true;

if (isset($_GET['PegawairuanganV'])) {
    $pegawaiPengetahui->attributes = $_GET['PegawairuanganV'];
}

$prov = $pegawaiPengetahui->search();
$prov->sort->defaultOrder = 'nama_pegawai';

$this->widget('ext.bootstrap.widgets.HeaderGroupGridView', array(
    'id' => 'pegawai-pengetahui-grid',
    //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
    'dataProvider' => $prov,
    'filter' => $pegawaiPengetahui,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Nama Pegawai',
            'name' => 'nama_pegawai',
            'value' => '$data->namaLengkap',
        ),
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small",
                                    "id" => "selectPegMengetahui",
                                    "onClick" =>"
                                        $(\".pegawaimengetahui_id\").val(\"".$data->pegawai_id."\");
                                        $(\".pegawaimengetahui_nama\").val(\"".$data->namaLengkap."\");
                                        $(\"#dialogPegawaiMengetahui\").dialog(\"close\");
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
//========= Dialog buat cari data Rek Kredit =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogJenisPengeluaran',
    'options' => array(
        'title' => 'Daftar Jenis Pengeluaran',
        'autoOpen' => false,
        'modal' => true,
        'width' => 700,
        'height' => 500,
        'resizable' => false,
    ),
));
$modJenisPengeluaran = new JenispengeluaranM('search');
$modJenisPengeluaran->unsetAttributes();
if (isset($_GET['JenispengeluaranM'])) {
    $modJenisPengeluaran->attributes = $_GET['JenispengeluaranM'];
}
$this->widget('ext.bootstrap.widgets.HeaderGroupGridView', array(
    'id' => 'jenispengeluaran-m-grid',
    //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
    'dataProvider' => $modJenisPengeluaran->searchJnsPengeluaranInDialog(),
    'filter' => $modJenisPengeluaran,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'No.',
            'value' => '$this->grid->dataProvider->Pagination->CurrentPage*$this->grid->dataProvider->pagination->pageSize+$row+1',
        ),
        array(
            'header' => 'Jenis Pengeluaran',
            'name' => 'jenispengeluaran_nama',
            'value' => '$data->jenispengeluaran_nama',
        ),
        array(
            'header' => 'Nama Lain',
            'name' => 'jenispengeluaran_namalain',
            'value' => '$data->jenispengeluaran_namalain',
        ),
        array(
            'header' => 'PPh 21 (%)',
            'name' => 'persenpph_21',
            'value' => '$data->persenpph_21',
            'htmlOptions' => array(
                'style' => 'text-align: right;',
            ),
        ),
        array(
            'header' => 'PPh 23 (%)',
            'name' => 'persenpph_23',
            'value' => '$data->persenpph_23',
            'htmlOptions' => array(
                'style' => 'text-align: right;',
            ),
        ),
        array(
            'header' => 'PPh Final (%)',
            'name' => 'persenpph_22',
            'value' => '$data->persenpph_22',
            'htmlOptions' => array(
                'style' => 'text-align: right;',
            ),
        ),
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small",
                                    "id" => "selectRekDebit",
                                    "onClick" =>"
                                        getDataRekening($data->jenispengeluaran_id);
                                        getSebagaiBayar(\"$data->jenispengeluaran_nama\");
                                        $(\"#KUPengeluaranumumT_jenispengeluaran_id\").val(\"$data->jenispengeluaran_id\");
                                        $(\"#KUPengeluaranumumT_jenisKodeNama\").val(\"$data->jenispengeluaran_nama\");
                                        $(\"#KUPengeluaranumumT_persenpph_21\").val(\"".number_format($data->persenpph_21, 2, ",", "")."\");
                                        $(\"#KUPengeluaranumumT_persenpph_22\").val(\"".number_format($data->persenpph_22, 2, ",", "")."\");
                                        $(\"#KUPengeluaranumumT_persenpph_23\").val(\"".number_format($data->persenpph_23, 2, ",", "")."\");
                                        $(\"#dialogJenisPengeluaran\").dialog(\"close\");
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
//========= Dialog buat cari data Rek Kredit =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogRekKredit',
    'options' => array(
        'title' => 'Daftar Rekening Kredit',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1000,
        'height' => 500,
        'resizable' => false,
    ),
));
$modRekKredit = new KURekeningakuntansiV('searchDialogAccount');
$modRekKredit->unsetAttributes();
$account = "";
if (isset($_GET['KURekeningakuntansiV'])) {
    $modRekKredit->attributes = $_GET['KURekeningakuntansiV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'rekkredit-m-grid',
    //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
    'dataProvider' => $modRekKredit->searchDialogAccount(),
    'filter' => $modRekKredit,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    //                'mergeHeaders'=>array(
    //                    array(
    //                        'name'=>'<p style="margin: 0; text-align: center;">Kode Rekening</p>',
    //                        'start'=>1, //indeks kolom 3
    //                        'end'=>5, //indeks kolom 4
    //                    ),
    //                ),
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small",
						"id" => "selectRekDebit",
						"onClick" =>"
//								RND-8713
//								var data = {
//									rekening5_id:$data->rekening5_id,
//									rekening4_id:$data->rekening4_id,
//									rekening3_id:$data->rekening3_id,
//									rekening2_id:$data->rekening2_id,
//									rekening1_id:$data->rekening1_id,
//									status:\"kredit\"
//								};
//									getDataRekeningFromGrid(data);
								getDataRekeningFromGrid(\'$data->rekening1_id\',\'$data->rekening2_id\',\'$data->rekening3_id\',\'$data->rekening4_id\',\'$data->rekeninglast_id\', \"kredit\");
							$(\"#dialogRekKredit\").dialog(\"close\");
							return false;
				"))',
        ),
        array(
            'header' => 'Kode Akun',
            'name' => 'kdrekeninglast',
            'value' => '$data->kdrekeninglast',
        ),
        array(
            'header' => 'Level 1',
            'name' => 'nmrekening1',
            'value' => '$data->nmrekening1',
        ),
        array(
            'header' => 'Level 2',
            'name' => 'nmrekening2',
            'value' => '$data->nmrekening2',
        ),
        array(
            'header' => 'Level 3',
            'name' => 'nmrekening3',
            'value' => '$data->nmrekening3',
        ),
        array(
            'header' => 'Level 4',
            'name' => 'nmrekening4',
            'value' => '$data->nmrekening4',
        ),
        array(
            'header' => 'Level 5',
            'name' => 'nmrekening5',
            'value' => '$data->nmrekening5',
        ),
        array(
            'header' => 'Level 6',
            'name' => 'kdrekening6',
            'value' => '$data->nmrekening6',
        ),
        array(
            'header' => 'Level 7',
            'name' => 'nmrekening7',
            'value' => '$data->nmrekening7',
        ),
        array(
            'header' => 'Level 8',
            'name' => 'nmrekening8',
            'value' => '$data->nmrekening8',
        ),
        array(
            'header' => 'Level 9',
            'name' => 'nmrekening9',
            'value' => '$data->nmrekening9',
        ),
        array(
            'header' => 'Level 10',
            'name' => 'nmrekening10',
            'value' => '$data->nmrekening10',
        ),
        array(
            'header' => 'Saldo Normal',
            'name' => 'rekeninglast_nb',
            'value' => '($data->rekeninglast_nb == "D") ? "Debit" : "Kredit"',
            'filter' =>  CHtml::activeDropDownList($modRekKredit, 'rekeninglast_nb', array('D' => 'Debit', 'K' => 'Kredit'), array('empty' => "-- Pilih --")),
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
//========= end Rek Kredit dialog =============================
?>
<?php
//========= Dialog buat cari data Rek Kredit =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogRekDebit',
    'options' => array(
        'title' => 'Daftar Rekening Debit',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1000,
        'height' => 500,
        'resizable' => false,
    ),
));
$modRekKredit = new KURekeningakuntansiV('searchDialogAccount');
$modRekKredit->unsetAttributes();
//        $account = "D"; RND-8514
$account = "";
if (isset($_GET['KURekeningakuntansiV'])) {
    $modRekKredit->attributes = $_GET['KURekeningakuntansiV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'rekdedit-m-grid',
    //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
    'dataProvider' => $modRekKredit->searchDialogAccount(),
    'filter' => $modRekKredit,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    //                'mergeHeaders'=>array(
    //                    array(
    //                        'name'=>'<p style="margin: 0; text-align: center;">Kode Rekening</p>',
    //                        'start'=>1, //indeks kolom 3
    //                        'end'=>5, //indeks kolom 4
    //                    ),
    //                ),
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small",
					"id" => "selectRekDebit",
					"onClick" =>"
//							RND-8713
//							var data = {
//								rekening5_id:$data->rekening5_id,
//								rekening4_id:$data->rekening4_id,
//								rekening3_id:$data->rekening3_id,
//								rekening2_id:$data->rekening2_id,
//								rekening1_id:$data->rekening1_id,
//								status:\"debit\"
//							};
//							getDataRekeningFromGrid(data);
						getDataRekeningFromGrid(\'$data->rekening1_id\',\'$data->rekening2_id\',\'$data->rekening3_id\',\'$data->rekening4_id\',\'$data->rekeninglast_id\', \"debit\");
					$(\"#dialogRekDebit\").dialog(\"close\");
					return false;
				"))',
        ),
        array(
            'header' => 'Kode Akun',
            'name' => 'kdrekeninglast',
            'value' => '$data->kdrekeninglast',
        ),
        array(
            'header' => 'Level 1',
            'name' => 'nmrekening1',
            'value' => '$data->nmrekening1',
        ),
        array(
            'header' => 'Level 2',
            'name' => 'nmrekening2',
            'value' => '$data->nmrekening2',
        ),
        array(
            'header' => 'Level 3',
            'name' => 'nmrekening3',
            'value' => '$data->nmrekening3',
        ),
        array(
            'header' => 'Level 4',
            'name' => 'nmrekening4',
            'value' => '$data->nmrekening4',
        ),
        array(
            'header' => 'Level 5',
            'name' => 'nmrekening5',
            'value' => '$data->nmrekening5',
        ),
        array(
            'header' => 'Level 6',
            'name' => 'kdrekening6',
            'value' => '$data->nmrekening6',
        ),
        array(
            'header' => 'Level 7',
            'name' => 'nmrekening7',
            'value' => '$data->nmrekening7',
        ),
        array(
            'header' => 'Level 8',
            'name' => 'nmrekening8',
            'value' => '$data->nmrekening8',
        ),
        array(
            'header' => 'Level 9',
            'name' => 'nmrekening9',
            'value' => '$data->nmrekening9',
        ),
        array(
            'header' => 'Level 10',
            'name' => 'nmrekening10',
            'value' => '$data->nmrekening10',
        ),
        array(
            'header' => 'Saldo Normal',
            'name' => 'rekeninglast_nb',
            'value' => '($data->rekeninglast_nb == "D") ? "Debit" : "Kredit"',
            'filter' =>  CHtml::activeDropDownList($modRekKredit, 'rekeninglast_nb', array('D' => 'Debit', 'K' => 'Kredit'), array('empty' => "-- Pilih --")),
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
//========= end Rek Kredit dialog =============================
?>