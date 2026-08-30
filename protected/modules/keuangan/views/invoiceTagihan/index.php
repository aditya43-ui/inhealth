<style>
    .panel-title>* {
        font-size: inherit !important;
        color: inherit !important;
    }
</style>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-briefcase"></i> Transaksi <b>Invoice Tagihan</b>
            <span class="pull-right">
                <a href="<?= !empty($linkHalaman) ? $linkHalaman : '#'; ?>" class="btn btn-default" target="_blank">
                    <i class="fas fa-external-link-alt"></i> Ke Halaman Informasi
                </a>
            </span>
        </div>
    </div>
    <div class="panel-body">
        <div id="input-penerimaan-kas">
            <?php $totTagihan = 0; ?>
            <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting.js'); ?>
            <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
            <?php
            $this->breadcrumbs = array(
                'Transaksi Invoice Tagihan',
            );
            $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
                'id' => 'kuinvoicetagihan-t-form',
                'enableAjaxValidation' => false,
                'type' => 'horizontal',
                'htmlOptions' => array(
                    'onKeyPress' => 'return disableKeyPress(event)'
                ),
            )); ?>
            <?php
            if (isset($_GET['sukses'])) {
                Yii::app()->user->setFlash('success', "Data berhasil disimpan!");
            }
            ?>
            <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
            <!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') 
                                        ?></p>-->
            <div class="row">
                <div class="col-sm-6">
                    <?php echo $form->textFieldRow($modInvoiceTagihan, 'invoicetagihan_no', array('placeholder' => 'No. Invoice', 'class' => 'span3 reqForm', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 20)); ?>
                    <div class="control-group">
                        <?php $modInvoiceTagihan->invoicetagihan_tgl = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modInvoiceTagihan->invoicetagihan_tgl, 'yyyy-MM-dd hh:mm:ss', 'medium', null)); ?>
                        <?php echo $form->labelEx($modInvoiceTagihan, 'invoicetagihan_tgl', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php
                            $this->widget(
                                'MyDateTimePicker',
                                array(
                                    'model' => $modInvoiceTagihan,
                                    'attribute' => 'invoicetagihan_tgl',
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
                    <div class="control-group">
                        <?php echo CHtml::label('Dari', 'namapenagih', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->textField($modInvoiceTagihan, 'namapenagih', array('placeholder' => 'Dari', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)) ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Perihal', 'perihal_tagihan', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->textField($modInvoiceTagihan, 'perihal_tagihan', array('placeholder' => 'Perihal', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)) ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Rekanan', 'rekanan_tagihan', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php // echo $form->textField($modInvoiceTagihan,'rekanan_tagihan', array('class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100))
                            ?>
                            <?php echo $form->dropDownList($modInvoiceTagihan, 'rekanan_tagihan', CHtml::listData(SupplierM::model()->findAll('supplier_aktif = true'), 'supplier_nama', 'supplier_nama'), array('empty' => '-- Pilih --', 'class' => 'span3', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        </div>
                    </div>
                    <?php echo $form->textAreaRow($modInvoiceTagihan, 'ket_pembayaran', array('rows' => 2, 'placeholder' => 'Keterangan Pembayaran', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                </div>
                <div class="col-sm-6">
                    <?php echo $form->textAreaRow($modInvoiceTagihan, 'isisurat_tagihan', array('rows' => 5, 'placeholder' => 'Isi Surat', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    <?php echo $form->dropDownListRow($modInvoiceTagihan, 'status_verifikasi', LookupM::getItems('status_verifikasi'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    <div class="control-group">
                        <?php $modInvoiceTagihan->tgl_verfikasi_tagihan = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modInvoiceTagihan->tgl_verfikasi_tagihan, 'yyyy-MM-dd hh:mm:ss', 'medium', null)); ?>
                        <?php echo $form->labelEx($modInvoiceTagihan, 'tgl_verfikasi_tagihan', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php
                            $this->widget(
                                'MyDateTimePicker',
                                array(
                                    'model' => $modInvoiceTagihan,
                                    'attribute' => 'tgl_verfikasi_tagihan',
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
                    <div class="control-group">
                        <?php echo $form->labelEx($modInvoiceTagihan, 'peg_verifikasi_tag_id', array('class' => 'control-label')) ?>
                        <?php echo $form->hiddenField($modInvoiceTagihan, 'peg_verifikasi_tag_id', array('class' => 'span3', 'maxlength' => 50)); ?>
                        <div class="controls">
                            <?php
                            $this->widget('MyJuiAutoComplete', array(
                                'name' => 'verifikator_tag_nama',
                                'source' => 'js: function(request, response) {
                                                    $.ajax({
                                                            url: "' . $this->createUrl('AutocompleteVerifikator') . '",
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
                                    'select' => 'js:function( event, ui ) {
                                            $(this).val( ui.item.label);
                                            $("#verifikator_tag_nama").val(ui.item.namalengkap);
                                            $("#KUInvoicetagihanT_peg_verifikasi_tag_id").val(ui.item.pegawai_id);
                                                return false;
                                        }',
                                ),
                                'tombolDialog' => array('idDialog' => 'dialogVerifikator', 'idTombol' => 'tombolDialogVerifikator'),
                                'htmlOptions' => array("placeholder" => "Ketik nama verifikator", "rel" => "tooltip", "title" => "Pencarian Data Verifikator", 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)"),
                            ));
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-success" style="margin-top: 17px;">
                <div class='panel-heading'>
                    <div class="panel-title">
                        <?php echo CHtml::checkBox('tagihanDetail', true, array('onchange' => 'bukaDetail(this)', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        <label for="tagihanDetail">Detail Tagihan</label>
                    </div>
                </div>
                <div class="panel-body table-responsive" id="div_tblInputDetail">
                    <table id="tblInputDetail" class="table table-striped table-condensed">
                        <thead>
                            <tr>
                                <th>Uraian</th>
                                <th>Total (Rp)</th>
                                <th>Keterangan</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $this->renderPartial('_rowDetail', array('form' => $form, 'modInvoiceTagDetail' => $modInvoiceTagDetail)); ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" style="text-align:right;">TOTAL TAGIHAN &nbsp;&nbsp;
                                    <?php echo $form->textField($modInvoiceTagihan, 'total_tagihan', array('class' => 'span3 integer', 'style' => 'width:90px;', 'readonly' => true)) ?></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="panel panel-success">
                <div class='panel-heading'>
                    <div class="panel-title">
                        <?php echo CHtml::checkBox('tagihanDisposisi', true, array('onchange' => 'bukaDisposisi(this)', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        <label for="tagihanDisposisi">Data Disposisi</label>
                    </div>
                </div>
                <div class="panel-body table-responsive" id="div_tblInputDisposisi">
                    <table id="tblInputDisposisi" class="table table-striped table-condensed">
                        <thead>
                            <tr>
                                <th>Uraian</th>
                                <th>Total (Rp)</th>
                                <th>Keterangan</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $this->renderPartial('_rowDisposisi', array('form' => $form, 'modInvoiceDisposisi' => $modInvoiceDisposisi)); ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="panel panel-success">
                <div class='panel-heading'>
                    <div class="panel-title">
                        <i class="glyphicon glyphicon-file"></i> Verifikasi
                    </div>
                </div>
                <div class="panel-body">
                    <table style="width: 100%; border: none;">
                        <tr>
                            <td width="50%">
                                <?php echo $form->textFieldRow($modInvoiceTagihan, 'disetujui_nama', array('placeholder' => 'Disetujui Oleh', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                                <?php echo $form->textFieldRow($modInvoiceTagihan, 'disetujui_posisi', array('placeholder' => 'Posisi', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                            </td>
                            <td width="50%">
                                <?php echo $form->textFieldRow($modInvoiceTagihan, 'verifikator_nama', array('placeholder' => 'Nama Verifikator', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                                <?php echo $form->textFieldRow($modInvoiceTagihan, 'verifikator_posisi', array('placeholder' => 'Posisi Verifikator', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="form-actions">
                <div style="float:left;margin-right:6px;">
                    <?php
                    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
                    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai    
                    $urlSave =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/index');
                    ?>
                </div>
                <?php
                if (!isset($_GET['sukses'])) {
                    echo CHtml::htmlButton(
                        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                        array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onClick' => 'inputData()', 'onKeypress' => 'inputData() return formSubmit(this,event)')
                    );
                    echo CHtml::htmlButton(
                        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                        array('title' => 'Ulang', 'id' => 'reseter', 'class' => 'btn btn-default', 'type' => 'reset')
                    );
                    echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'disabled' => true));
                } else {
                    echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'button', 'onclick' => 'return false', 'onkeypress' => 'return false', 'disabled' => true, 'style' => 'cursor:not-allowed;'));
                    echo CHtml::htmlButton(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), array('style' => 'display:none', 'id' => 'reseter', 'class' => 'btn btn-default', 'type' => 'reset'));
                    echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onClick' => 'print("PRINT")'));
                }
                ?>
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
<?php $this->renderPartial('_jsFunctions', array('form' => $form, 'modInvoiceTagDetail' => $modInvoiceTagDetail, 'modInvoiceDisposisi' => $modInvoiceDisposisi)); ?>
<?php $this->endWidget(); ?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogVerifikator',
    'options' => array(
        'title' => 'Daftar Pegawai Verifikator',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 900,
        'height' => 400,
        'resizable' => false,
    ),
));
$modPegawai = new PegawaiV('search');
$modPegawai->unsetAttributes();
if (isset($_GET['PegawaiV'])) {
    $modPegawai->attributes = $_GET['PegawaiV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawai-v-grid',
    'dataProvider' => $modPegawai->search(),
    'filter' => $modPegawai,
    'template' => "{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("rel"=>"tooltip","title"=>"Pilih Pegawai","class"=>"btn_small",
"id"=>"selectPegawai",
"onClick"=>"
$(\"#KUInvoicetagihanT_peg_verifikasi_tag_id\").val(\"$data->pegawai_id\");
$(\"#verifikator_tag_nama\").val(\"$data->namalengkap\");
$(\"#dialogVerifikator\").dialog(\"close\");
return false;
",
))'
        ),
        array(
            'header' => 'NIK',
            'type' => 'raw',
            'value' => '$data->nomorindukpegawai',
        ),
        array(
            'header' => 'ID',
            'type' => 'raw',
            'value' => '$data->pegawai_id',
        ),
        array(
            'header' => 'Nama Pegawai',
            'type' => 'raw',
            'value' => '$data->namalengkap',
            'filter' => CHtml::activeTextField($modPegawai, 'nama_pegawai'),
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
?>