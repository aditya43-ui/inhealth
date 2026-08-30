<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END); ?>
<?php
if (isset($_GET['sukses'])) {
    Yii::app()->user->setFlash('success', '<b>Berhasil!</b> Data berhasil disimpan.');
}
$this->breadcrumbs = array(
    'Ubah Faktur Pembelian Barang Non Medis',
);
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'gffakturpembelian-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
    //		'focus' => '#',
));
$this->widget('bootstrap.widgets.BootAlert');
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-edit"></i> Ubah <b>Faktur Pembelian Barang Non Medis</b>
        </div>
    </div>
    <div class="panel-body">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Data <b>Penerimaan Barang</b>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo CHtml::label("No Permintaan", "", array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php
                                echo $form->hiddenField($model, 'pembelianbarang_id', array('readonly' => true));
                                echo $form->textField($model, 'nopembelian', array('readonly' => true, 'class' => 'span3'));
                                ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo $form->labelEx($model, 'nopenerimaan', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo CHtml::hiddenField('terimapersediaan_id', $model->terimapersediaan_id, array('readonly' => TRUE)); ?>
                                <?php echo $form->textField($model, 'nopenerimaan', array('class' => 'span3', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo $form->labelEx($model, 'sumberdana_id', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php
                                echo $form->hiddenField($model, 'sumberdana_id');
                                $sumberdana_nama = (!empty($model->sumberdana_id) ? $model->sumberdana->sumberdana_nama : "");
                                echo CHtml::textField('terima_sumberdana_nama', $sumberdana_nama, array('readonly' => true));
                                ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo $form->labelEx($model, 'tglterima', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php
                                echo $form->textField($model, 'tglterima', array('readonly' => true));
                                ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo $form->labelEx($model, 'tglsuratjalan', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php
                                echo $form->textField($model, 'tglsuratjalan', array('readonly' => true));
                                ?>
                            </div>
                        </div>
                        <?php echo $form->textFieldRow($model, 'nosuratjalan', array('class' => 'span3', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                    </div>
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo $form->labelEx($model, 'supplier_id', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php
                                echo $form->hiddenField($model, 'supplier_id');
                                $suppliernama = (!empty($model->supplier_id) ? $model->supplier->supplier_nama : "");
                                echo CHtml::textField('terima_supplier_nama', $suppliernama, array('readonly' => true));
                                ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo $form->labelEx($model, 'peg_penerima_id', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php
                                echo $form->hiddenField($model, 'peg_penerima_id');
                                $model->peg_penerima_nama = (!empty($model->peg_penerima_id) ? $model->penerima->namaLengkap : "");
                                echo $form->textField($model, 'peg_penerima_nama', array('readonly' => true));
                                ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo $form->labelEx($model, 'peg_mengetahui_id', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php
                                echo $form->hiddenField($model, 'peg_mengetahui_id');
                                $model->peg_mengetahui_nama = (!empty($model->peg_mengetahui_id) ? $model->mengetahui->namaLengkap : "");
                                echo $form->textField($model, 'peg_mengetahui_nama', array('readonly' => true));
                                ?>
                            </div>
                        </div>
                        <?php echo $form->textAreaRow($model, 'keterangan_persediaan', array('rows' => 4, 'cols' => 50, 'class' => 'span4', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-success" style="display: none;" id="divuangmukabeli">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Data <b>Pembayaran Uang Muka</b>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo CHtml::label('No. Pembayaran <span class="required">*</span>', 'nopembayaran', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->textField($modUangmuka, 'nopembayaran', array('readonly' => true, 'class' => 'span3')); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label('Tgl. Pembayaran <span class="required">*</span>', 'tgluangmukabeli', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->textField($modUangmuka, 'tgluangmukabeli', array('readonly' => true, 'class' => 'span3')); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo CHtml::label('Jumlah Uang Muka <span class="required">*</span>', 'jumlahuang', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->textField($modUangmuka, 'jumlahuang', array('readonly' => true, 'class' => 'integer-decimal span3')); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Penerimaan Barang</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <table id="tableFaktur" class="table table-bordered table-condensed">
                    <thead>
                        <tr>
                            <th>Tipe Barang</th>
                            <th>Jenis Barang</th>
                            <th>Kode Barang/<br>Nama Barang</th>
                            <th>Jumlah Terima</th>
                            <th>Satuan</th>
                            <th>Jumlah Dalam <br>Kemasan </th>
                            <th>Harga Satuan (Rp)</th>
                            <th>Keringanan (%)</th>
                            <th>Keringanan (Rp)</th>
                            <th>PPN (%)</th>
                            <th>PPN (Rp)</th>
                            <th>PPh (%)</th>
                            <th>PPh (Rp)</th>
                            <th>Subtotal (Rp)</th>
                            <th>Kondisi</th>
                            <?php if (!isset($modFakturDetail)) { ?>
                                <th hidden>Batal</th>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (count((array)$modDetails) > 0) {
                            foreach ($modDetails as $key => $modDetail) {
                                $modBarang = BarangM::model()->findByPk($modDetail->barang_id);
                                echo $this->renderPartial('_detailPenerimaanPersediaanBarangUbah', array('modDetail' => $modDetail, 'modBarang' => $modBarang, 'key' => $key));
                            }
                        }
                        ?>
                    </tbody>
                    <?php
                    echo
                    "<tfoot>
                                        <tr>
                                                <td colspan='13' style='text-align:right;'><b>Total</b></td>
                                                <td>" .
                        CHtml::textField('tothargabruto', '', array('style' => 'text-align:right;', 'readonly' => TRUE, 'class' => 'totalhargabruto span2 integer-decimal')) .
                        "</td>
                                        </tr>
                                </tfoot>";
                    ?>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="glyphicon glyphicon-file"></i> Data <b>Faktur</b>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="control-group">
                            <?php echo CHtml::label('No Faktur <span class="required">*</span>', '', array('class' => 'control-label required')); ?>
                            <div class="controls">
                                <?php echo $form->textField($model, 'nofaktur', array('class' => 'span3 alphanumber', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
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
                                        'readonly' => true, 'class' => 'span3 isRequired', 'onkeypress' => "return $(this).focusNextInputField(event)", 'onchange' => 'loadJatuhTempo();'
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
                                        'readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                                    ),
                                ));
                                ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label("Pajak PPh", "pajak_id", array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->hiddenField($model, 'pajak_id', array()); ?>
                                <?php echo $form->textField($model, 'pajak_nama', array('class' => 'span3', 'readonly' => true)); ?>
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
                        <?php echo $form->textAreaRow($model, 'keteranganfaktur', array('class' => 'span3'))  ?>
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
                        <?php echo $form->textFieldRow($model, 'totalharga', array('class' => 'span3 integer-decimal', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true, 'style' => 'text-align: right;')); ?>
                        <div class="control-group">
                            <?php echo CHtml::label('Total Keringanan', 'discount', array('class' => 'control-label inline')) ?>
                            <div class="controls">
                                <?php echo $form->textField($model, 'discount', array('readonly' => true, 'class' => 'span3 integer-decimal', 'onkeypress' => "return $(this).focusNextInputField(event);", 'style' => 'text-align: right;')); ?>
                                <?php echo $form->error($model, 'discount'); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">
                                Total PPN
                            </label>
                            <div class="controls">
                                <?php echo $form->textField($model, 'pajakppn', array('class' => 'span3 integer-decimal', 'onkeypress' => "return $(this).focusNextInputField(event);", 'style' => 'text-align: right;', 'readonly' => true)); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label('Total PPh', 'pajakpph', array('class' => 'control-label inline')) ?>
                            <div class="controls">
                                <?php echo $form->textField($model, 'pajakpph', array('readonly' => true, 'class' => 'inputFormTabel integer-decimal span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'style' => 'text-align: right;')); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo Chtml::label("Total Keseluruhan", 'totalkeseluruhan', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->textField($model, 'totalkeseluruhan', array('class' => 'span3 integer-decimal', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true, 'style' => 'text-align: right;')); ?>
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
        <div class="form-actions">
            <?php
            if (isset($_GET['sukses'])) {
                $urlPrint = Yii::app()->createAbsoluteUrl('keuangan/fakturPembelianGU/Print', array('id' => $_GET['terimapersediaan_id']));
                $js = <<< JSCRIPT
						function print(caraPrint){
							window.open("${urlPrint}&caraPrint="+caraPrint,"",'location=_new, width=900px');
						}
JSCRIPT;
                Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'button', 'disabled' => true));
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
            } else {
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'button', 'onclick' => 'setVerifikasiHpp()'));
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'disabled' => true));
                //						echo CHtml::htmlButton(Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'btn_simpan', 'style' => 'display:none;'));
            }
            ?>
            <?php
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), array('class' => 'btn btn-default', 'type' => 'button'));
            ?>
            <?php
            $content = $this->renderPartial('keuangan.views.tips.transaksi', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>
<?php
//$this->widget('application.extensions.moneymask.MMask', array(
//	'element' => '.integer',
//	'config' => array(
//		'defaultZero' => true,
//		'allowZero' => true,
//		'allowDecimal' => true,
//		'decimal' => '.',
//		'thousands' => '',
//		'precision' => 0,
//	)
//));
?>
<script type="text/javascript">
    //function unformatNumberSemua(){
    //    $(".integer").each(function(){
    //        $(this).val(parseInt(unformatNumber($(this).val())));
    //    });
    //    $(".float2").each(function(){
    //        $(this).val(parseFloat(unformatNumber($(this).val())));
    //    });
    //    $('.currency').each(function () {
    //            this.value = unformatNumber(this.value)
    //    });
    //}
    //function formatNumberSemua(){
    //    $(".integer").each(function(){
    //        $(this).val(formatInteger($(this).val()));
    //    });
    //     $(".float2").each(function(){
    //        $(this).val(formatFloat($(this).val()));
    //    });
    //     $(".currency").each(function(){
    //        $(this).val(formatNumber($(this).val()));
    //    });
    //}
    function cekInputan() {
        //        $('.integer2').each(function () {
        //                this.value = unformatNumber(this.value);
        //        });
        //        $('.float2').each(function () {
        //                this.value = unformatNumber(this.value);
        //        });
        //        $('.currency').each(function () {
        //                this.value = unformatNumber(this.value);
        //        });
        return true;
    }

    function setTotalHarga() {
        unformatNumberSemua();
        var totalHarga = 0;
        var totalSatuanHarga = 0;
        var diskontotal = 0;
        var ppntotal = 0;
        var pphtotal = 0;
        $('#tableFaktur tbody tr').each(function() {
            var qty = parseFloat($(this).find('.qty').val());
            var satuan = parseFloat($(this).find('.satuan').val());
            var persendiskon = parseFloat($(this).find('.persendiscount').val());
            var persenppn = parseFloat($(this).find('.persenppn').val());
            var persenpph = parseFloat($(this).find('.persenpph').val());
            var jmlHarga = (qty * satuan);
            var jmlDiskon = ((jmlHarga * persendiskon) / 100);
            var jmlPpn = (((jmlHarga - jmlDiskon) * persenppn) / 100);
            var jmlPph = (((jmlHarga - jmlDiskon) * persenpph) / 100);
            var subtotal = (jmlHarga - jmlDiskon + jmlPpn - jmlPph);
            totalHarga += parseFloat(subtotal);
            diskontotal += jmlDiskon;
            ppntotal += jmlPpn;
            pphtotal += jmlPph;
            totalSatuanHarga += satuan;
            $(this).find('.jmldiscount').val(jmlDiskon);
            $(this).find('.jmlppn').val(jmlPpn);
            $(this).find('.jmlpph').val(jmlPph);
            $(this).find('.beli').val(subtotal);
        });
        $('#<?php echo CHtml::activeId($model, 'totalharga') ?>').val(totalSatuanHarga);
        $("#tothargabruto").val(totalHarga);
        if (jQuery.isNumeric(diskontotal)) {
            $('#<?php echo CHtml::activeId($model, 'discount') ?>').val(diskontotal);
        }
        if (jQuery.isNumeric(ppntotal)) {
            $('#<?php echo CHtml::activeId($model, 'pajakppn') ?>').val(ppntotal);
        }
        if (jQuery.isNumeric(pphtotal)) {
            $('#<?php echo CHtml::activeId($model, 'pajakpph') ?>').val(pphtotal);
        }
        $("#<?php echo CHtml::activeId($model, 'totalkeseluruhan') ?>").val(totalHarga);
        var jlmuangmukabeli = parseInt($("#<?php echo CHtml::activeId($model, 'jlmuangmukabeli') ?>").val());
        $("#<?php echo CHtml::activeId($model, 'totalhutangusaha') ?>").val((totalHarga - jlmuangmukabeli));
        formatNumberSemua();
    }

    function rename() {
        noUrut = 1;
        $('.cancel').each(function() {
            $(this).parents('tr').find('[name*="TerimapersdetailT"]').each(function() {
                var nama = $(this).attr('name');
                data = nama.split('TerimapersdetailT[]');
                if (typeof data[1] === "undefined") {} else {
                    $(this).attr('name', 'TerimapersdetailT[' + (noUrut - 1) + ']' + data[1]);
                }
            });
            noUrut++;
        });
    }

    function setVerifikasiHpp() {
        if (requiredCheck($("form"))) {
            var index = 0;
            var pesanharga = "";
            var kecilHpp = 0;
            var cekpph = 0;
            $('#tableFaktur tbody tr').each(function() {
                unformatNumberSemua();
                var hargaLama = parseFloat($(this).find('input[name$="[hargasatuanmaster]"]').val());
                var hargabaru = parseFloat($(this).find('input[name$="[hargasatuan]"]').val());
                var namaBahan = $(this).find('input[name$="[namabarangmaster]"]').val();
                var persenpph = parseFloat($(this).find('input[name$="[persenpph]"]').val());
                if (hargaLama != hargabaru) {
                    kecilHpp += 1;
                    if (index > 0) {
                        pesanharga += ",";
                    }
                    pesanharga += namaBahan + " (" + hargabaru + ")";
                    index++;
                } else {
                    if (kecilHpp > 1) {
                        kecilHpp -= 1;
                    }
                }
                if (persenpph > 0) {
                    cekpph += 1;
                } else {
                    if (cekpph > 1) {
                        cekpph -= 1;
                    }
                }
                $(this).find('input[name$="[hppcheck]"]').val(0);
                formatNumberSemua();
            });
            if (cekpph > 0) {
                if ($('#<?php echo CHtml::activeId($model, 'pajak_id'); ?>').val() == '') {
                    myAlert("Jenis Pajak harus diisi ");
                    return false;
                }
            }
            if (kecilHpp > 0) {
                $.alerts.okButton = "Ya";
                $.alerts.cancelButton = "Tidak";
                myConfirm("Harga Netto '" + pesanharga + "' berbeda dengan yang ada di master. Apakah Anda ingin melakukan update harga otomatis?", "Perhatian!", function(r) {
                    if (r) {
                        $('#tableFaktur tbody tr').each(function() {
                            $(this).find('input[name$="[hppcheck]"]').val(1);
                        });
                        $('.integer-decimal, float2, .integer2').each(function() {
                            $(this).val(unformatNumber($(this).val()));
                        });
                        $("#gffakturpembelian-m-form").submit();
                    } else {
                        $('#tableFaktur tbody tr').each(function() {
                            $(this).find('input[name$="[hppcheck]"]').val(0);
                        });
                        $('.integer-decimal, float2, .integer2').each(function() {
                            $(this).val(unformatNumber($(this).val()));
                        });
                        //                        unformatNumberSemua();
                        $("#gffakturpembelian-m-form").submit();
                    }
                });
            } else {
                $('#tableFaktur tbody tr').each(function() {
                    $(this).find('input[name$="[hppcheck]"]').val(1);
                });
                $('.integer-decimal, float2, .integer2').each(function() {
                    $(this).val(unformatNumber($(this).val()));
                });
                $("#gffakturpembelian-m-form").submit();
            }
        }
        return false;
    }

    function loadJatuhTempo() {
        var tanggalfaktur = $('#<?php echo CHtml::activeId($model, 'tglfaktur'); ?>').val();
        var supplierid = $('#<?php echo CHtml::activeId($model, 'supplier_id'); ?>').val();
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('loadJatuhTempo'); ?>',
            data: {
                tgl_faktur: tanggalfaktur,
                supplier_id: supplierid
            },
            dataType: "json",
            success: function(data) {
                $('#<?php echo CHtml::activeId($model, 'tgljatuhtempo'); ?>').val(data.value);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }
    $(document).ready(function() {
        $(".rqd div label").append("<span class='required'> *</span>");
        $(".rqd div:last-child label span.required").remove();
        setTotalHarga();
        loadJatuhTempo();
        <?php if (!empty($modUangmuka->uangmukabeli_id)) { ?>
            $('#divuangmukabeli').show();
        <?php } else { ?>
            $('#divuangmukabeli').hide();
        <?php } ?>
    });
</script>