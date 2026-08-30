<?php $linkHalaman = CustomFunction::getUrlByMenuID(1415); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END); ?>
<?php // Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); 
?>
<?php // Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting.js'); 
?>
<?php
if (isset($_GET['sukses'])) {
    Yii::app()->user->setFlash('success', '<b>Berhasil!</b> Data berhasil disimpan.');
}
$this->breadcrumbs = array(
    'Transaksi Faktur Pembelian Barang Non Medis',
);
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'gffakturpembelian-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
));
$this->widget('bootstrap.widgets.BootAlert');
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-briefcase"></i> Transaksi <b>Faktur Pembelian Barang Non Medis</b>
            <span class="pull-right">
                <a href="<?= !empty($linkHalaman) ? $linkHalaman : '#'; ?>" class="btn btn-default" target="_blank">
                    <i class="fas fa-external-link-alt"></i> Ke Halaman Informasi
                </a>
            </span>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $disabled = (!empty($model->terimapersediaan_id)) ? true : '';
        $dialog = (!empty($model->terimapersediaan_id)) ? array() : array('idDialog' => 'dialogPenerimaanBarang');
        ?>
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
                                echo $form->textField($model, 'nopembelian', array('readonly' => true, 'class' => 'span4'));
                                ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo $form->labelEx($model, 'nopenerimaan', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo CHtml::hiddenField('terimapersediaan_id', '', array('readonly' => TRUE)); ?>
                                <?php
                                $this->widget('MyJuiAutoComplete', array(
                                    'model' => $model,
                                    'attribute' => 'nopenerimaan',
                                    'sourceUrl' => Yii::app()->createUrl('ActionAutoComplete/noTerima'),
                                    'options' => array(
                                        'showAnim' => 'fold',
                                        'minLength' => 2,
                                        'select' => 'js:function( event, ui ) {
                                                                $("#' . CHtml::activeId($model, 'nopenerimaan') . '").val(ui.item.nopenerimaan); 
                                                                $("#' . CHtml::activeId($model, 'pembelianbarang_id') . '").val(ui.item.pembelianbarang_id);   
                                                                $("#' . CHtml::activeId($model, 'peg_penerima_id') . '").val(ui.item.peg_penerima_id); 
                                                                $("#' . CHtml::activeId($model, 'peg_mengetahui_id') . '").val(ui.item.peg_mengetahui_id); 
                                                                $("#' . CHtml::activeId($model, 'tglterima') . '").val(ui.item.tglterima);   
                                                                $("#' . CHtml::activeId($model, 'sumberdana_id') . '").val(ui.item.sumberdana_id);   
                                                                $("#' . CHtml::activeId($model, 'tglsuratjalan') . '").val(ui.item.tglsuratjalan);   
                                                                $("#' . CHtml::activeId($model, 'terimapersediaan_id') . '").val(ui.item.terimapersediaan_id);   
                                                                $("#' . CHtml::activeId($model, 'keterangan_persediaan') . '").val(ui.item.keterangan_persediaan);   
                                                                $("#' . CHtml::activeId($model, 'nosuratjalan') . '").val(ui.item.nosuratjalan);   
                                                                $("#' . CHtml::activeId($model, 'nopembelian') . '").val(ui.item.pembelianbarang.nopembelian); 
                                                                $("#' . CHtml::activeId($model, 'peg_penerima_nama') . '").val(ui.item.penerima.nama_pegawai);   
                                                                $("#' . CHtml::activeId($model, 'peg_mengetahui_nama') . '").val(ui.item.pegawaiMengetahui);   
                                                                submitPermintaanPembelian();
                                                        }',
                                    ),
                                    'htmlOptions' => array(
                                        'disabled' => $disabled,
                                        'placeholder' => 'No. Penerimaan',
                                        'onkeypress' => "$(this).focusNextInputField(event)", 'class' => 'span4', 'readonly' => FALSE
                                    ),
                                    'tombolDialog' => $dialog,
                                ));
                                ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo $form->labelEx($model, 'sumberdana_id', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php
                                echo $form->hiddenField($model, 'sumberdana_id');
                                echo CHtml::textField('terima_sumberdana_nama', '', array('class' => 'span4', 'readonly' => true));
                                ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo $form->labelEx($model, 'tglterima', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->textField($model, 'tglterima', array('class' => 'span4', 'readonly' => true)); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo $form->labelEx($model, 'tglsuratjalan', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->textField($model, 'tglsuratjalan', array('class' => 'span4', 'readonly' => true)); ?>
                            </div>
                        </div>
                        <?php echo $form->textFieldRow($model, 'nosuratjalan', array('class' => 'span4', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                    </div>
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo $form->labelEx($model, 'supplier_id', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php
                                echo $form->hiddenField($model, 'supplier_id');
                                echo CHtml::textField('terima_supplier_nama', '', array('class' => 'span4', 'readonly' => true));
                                ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo $form->labelEx($model, 'peg_penerima_id', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php
                                echo $form->hiddenField($model, 'peg_penerima_id');
                                echo $form->textField($model, 'peg_penerima_nama', array('class' => 'span4', 'readonly' => true));
                                ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo $form->labelEx($model, 'peg_mengetahui_id', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php
                                echo $form->hiddenField($model, 'peg_mengetahui_id');
                                echo $form->textField($model, 'peg_mengetahui_nama', array('class' => 'span4', 'readonly' => true));
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
                                        <tr hidden>
                                                <td colspan='7'>Sisa Bayar</td>
                                                <td>" .
                        CHtml::textField('sisabayar', '', array('style' => 'text-align:right', 'readonly' => TRUE, 'class' => 'sisabayar span2 currency')) .
                        "</td>
                                        </tr>
                                </tfoot>";
                    ?>
                </table>
            </div>
        </div>
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
                            <?php echo CHtml::label("Pajak PPh", "syaratbayar_id", array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->hiddenField($model, 'pajak_id', array()); ?>
                                <?php echo $form->textField($model, 'pajak_nama', array('class' => 'span3', 'readonly' => true)); ?>
                            </div>
                        </div>
                        <?php // echo $form->dropDownListRow($model,'pajak_id',
                        //                                                            CHtml::listData(PajakM::model()->findAll('pajak_aktif = true AND  ispajakpegawai = false order by pajak_nama ASC'), 'pajak_id', 'pajak_nama'),
                        //                                                            array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",
                        //                                                            'empty'=>'-- Pilih --',)); 
                        //									
                        ?>
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
                        <?php echo $form->textFieldRow($model, 'totalharga', array('class' => 'span3 integer-decimal', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true, 'style' => 'text-align: right;')); ?>
                        <div class="control-group">
                            <?php echo CHtml::label('Total Keringanan', 'discount', array('class' => 'control-label inline')) ?>
                            <div class="controls">
                                <?php echo Chtml::hiddenField('discountpersen', '0', array('class' => 'span1 float2', 'onblur' => 'setTotalHarga();', 'style' => 'text-align: right;')); ?>
                                <!--% =-->
                                <?php echo $form->textField($model, 'discount', array('readonly' => true, 'class' => 'span3 integer-decimal', 'onkeypress' => "return $(this).focusNextInputField(event);", 'style' => 'text-align: right;')); ?>
                                <?php echo $form->error($model, 'discount'); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">
                                Total PPN
                            </label>
                            <div class="controls">
                                <?php echo Chtml::hiddenField('ppnpersen', '10', array('class' => 'span1 float2', 'style' => 'text-align: right;')); ?>
                                <?php echo $form->textField($model, 'pajakppn', array('class' => 'span3 integer-decimal', 'onkeypress' => "return $(this).focusNextInputField(event);", 'style' => 'text-align: right;', 'readonly' => true)); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label('Total PPh', 'pajakpph', array('class' => 'control-label inline')) ?>
                            <div class="controls">
                                <?php echo $form->hiddenField($model, 'persenpph_22', array('readonly' => false, 'onblur' => 'setTotalHarga();', 'class' => 'inputFormTabel float2 span1', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                                <!--%--> <?php echo $form->textField($model, 'pajakpph', array('readonly' => true, 'class' => 'inputFormTabel integer-decimal span3 text-right', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo Chtml::label("Total Keseluruhan", 'totalkeseluruhan', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->textField($model, 'totalkeseluruhan', array('class' => 'span3 integer-decimal text-right', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100, 'readonly' => true)); ?>
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
                echo CHtml::htmlButton(
                    Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')),
                    array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'button', 'disabled' => true)
                );
                $urlPrint = Yii::app()->createAbsoluteUrl('keuangan/fakturPembelianGU/Print', array('id' => $_GET['id']));
                $js = <<< JSCRIPT
            function print(caraPrint){
                    window.open("${urlPrint}","",'location=_new, width=900px');
            }
JSCRIPT;
                Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
            } else {
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'button', 'onclick' => 'setVerifikasiHpp()'));
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'disabled' => true));
                //            echo CHtml::htmlButton(Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'btn_simpan', 'style' => 'display:none;'));
            }
            ?>
            <?php
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), array('class' => 'btn btn-default', 'type' => 'button'));
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
<?php $this->endWidget(); ?>
<?php
//========= Dialog buat Permintaan Kebutuhan obatAlkes =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPenerimaanBarang',
    'options' => array(
        'title' => 'Pencarian Terima Persediaan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => false,
    ),
));
$format = new MyFormatter();
$modTerimaPers = new KUTerimapersediaanT;
if (isset($_GET['KUTerimapersediaanT'])) {
    $modTerimaPers->attributes = $_GET['KUTerimapersediaanT'];
    $modTerimaPers->peg_penerima_nama = $_GET['KUTerimapersediaanT']['peg_penerima_nama'];
    // $modTerimaPers->tglterima = $format->formatDateTimeForDb($_GET['KUTerimapersediaanT']['tglterima']);
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'permintaan-m-grid',
    'dataProvider' => $modTerimaPers->searchGUBelumAdaFaktur(),
    'filter' => $modTerimaPers,
    'template' => "{summary}\n{items}{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                    "id" => "selectPasien",
                                    "onClick" => "
                                                  $(\"#terima_sumberdana_nama\").val(\"".(!empty($data->sumberdana) ? $data->sumberdana->sumberdana_nama : "")."\");
                                                  $(\"#terima_supplier_nama\").val(\"".(!empty($data->supplier) ? $data->supplier->supplier_nama : "")."\");
                                                  $(\"#' . CHtml::activeId($model, 'nopenerimaan') . '\").val(\"$data->nopenerimaan\");
												  $(\"#' . CHtml::activeId($model, 'terimapersediaan_id') . '\").val(\"$data->terimapersediaan_id\");
												  $(\"#' . CHtml::activeId($model, 'pembelianbarang_id') . '\").val(\"$data->pembelianbarang_id\");
                                                  $(\"#' . CHtml::activeId($model, 'peg_penerima_id') . '\").val(\"$data->peg_penerima_id\");
                                                  $(\"#' . CHtml::activeId($model, 'peg_mengetahui_id') . '\").val(\"$data->peg_mengetahui_id\");
                                                  $(\"#' . CHtml::activeId($model, 'tglterima') . '\").val(\"$data->tglterima\"); 
                                                  $(\"#' . CHtml::activeId($model, 'sumberdana_id') . '\").val(\"$data->sumberdana_id\"); 
                                                  $(\"#' . CHtml::activeId($model, 'tglsuratjalan') . '\").val(\"$data->tglsuratjalan\");    
                                                  $(\"#' . CHtml::activeId($model, 'terimapersediaan_id') . '\").val(\"$data->terimapersediaan_id\");    
                                                  $(\"#' . CHtml::activeId($model, 'keterangan_persediaan') . '\").val(\"$data->keterangan_persediaan\");  
                                                  $(\"#' . CHtml::activeId($model, 'nosuratjalan') . '\").val(\"$data->nosuratjalan\");
                                                  $(\"#' . CHtml::activeId($model, 'peg_penerima_nama') . '\").val(\"$data->pegawaiPenerima\");
                                                  $(\"#' . CHtml::activeId($model, 'peg_mengetahui_nama') . '\").val(\"$data->pegawaiMengetahui\");  
                                                  $(\"#' . CHtml::activeId($model, 'totalharga') . '\").val(\"$data->totalharga\");    
                                                  $(\"#' . CHtml::activeId($model, 'discount') . '\").val(\"$data->discount\");  
                                                  $(\"#' . CHtml::activeId($model, 'biayaadministrasi') . '\").val(\"$data->biayaadministrasi\");  
                                                  $(\"#' . CHtml::activeId($model, 'pajakpph') . '\").val(\"$data->pajakpph\");
                                                  $(\"#' . CHtml::activeId($model, 'pajakppn') . '\").val(\"$data->pajakppn\");   
                                                  $(\"#' . CHtml::activeId($model, 'supplier_id') . '\").val(\"$data->SupplierId\");
                                                  $(\"#' . CHtml::activeId($model, 'pembelianbarang_id') . '\").val(\"$data->pembelianbarang_id\");
												  $(\"#' . CHtml::activeId($model, 'supplier_id') . '\").val(\"$data->supplier_id\");
                                                  $(\"#' . CHtml::activeId($model, 'tgljatuhtempo') . '\").val(\"$data->tgljatuhtempo\");
												  $(\"#' . CHtml::activeId($model, 'peg_penerima_nama') . '\").val(\"".$data->penerima->nama_pegawai."\"); 
												  $(\"#' . CHtml::activeId($model, 'nopembelian') . '\").val(\"".$data->pembelianbarang->nopembelian."\"); 
												  $(\"#' . CHtml::activeId($model, 'totalkeseluruhan') . '\").val(\"$data->totalSeluruh\"); 
												  $(\"#discountpersen\").val(\"$data->DiskonPersen\"); 
                                                  $(\"#' . CHtml::activeId($model, 'peg_mengetahui_nama') . '\").val(\"".(empty($data->mengetahui)?"":$data->mengetahui->nama_pegawai)."\");
												  $(\"#terimapersediaan_id\").val(\"$data->terimapersediaan_id\");    
                                                  submitPermintaanPembelian();
                                                  $(\"#dialogPenerimaanBarang\").dialog(\"close\");    
                                        "))',
        ),
        'nopenerimaan',
        array(
            'name' => 'tglterima',
            'filter' => false,
        ),
        array(
            'header' => 'Nama Pegawai Penerima',
            'type' => 'raw',
            'name' => 'peg_penerima_nama',
            'value' => '$data->penerima->nama_pegawai',
        )
    ),
    'afterAjaxUpdate' => 'function(id, data){
            $("#testing").datepicker(jQuery.extend({showMonthAfterYear:false}, jQuery.datepicker.regional["id"], {"dateFormat":"dd M yy","timeText":"Waktu","hourText":"Jam","minuteText":"Menit","secondText":"Detik","showSecond":true,"timeOnlyTitle":"Pilih Waktu","timeFormat":"hh:mm:ss","changeYear":true,"changeMonth":true,"showAnim":"fold","yearRange":"-80y:+20y"}));
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
//========= end Permintaan dialog =============================
?>
<?php
//========= Dialog buat untuk pegawai penerima =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPegawai',
    'options' => array(
        'title' => 'Daftar Pegawai',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'height' => 500,
        'resizable' => false,
    ),
));
$modPegawai = new KUPegawaiM('search');
$modPegawai->unsetAttributes();
if (isset($_GET['KUPegawaiM']))
    $modPegawai->attributes = $_GET['KUPegawaiM'];
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawai-m-grid1',
    'dataProvider' => $modPegawai->searchDialog(),
    'filter' => $modPegawai,
    'template' => "{summary}\n{items}{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        //'pegawai_id',
        'nomorindukpegawai',
        'namaLengkap',
        'alamat_pegawai',
        'agama',
        array(
            'name' => 'jeniskelamin',
            'filter' => LookupM::getItems('jeniskelamin'),
            'value' => '$data->jeniskelamin',
        ),
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                    "id" => "selectBahan",
                                    "onClick" => "
                                    var parent = $(\"#dialogPegawai\").attr(\"parentclick\");
                                    $(\"#\"+parent+\"\").val($data->pegawai_id);
                                    $(\"#\"+parent+\"\").parents(\".controls\").find(\".namaPegawai\").val(\"$data->nama_pegawai\");
                                    $(\"#dialogPegawai\").dialog(\"close\");   
                                    return false;"))',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
//========= end Permintaan dialog =============================
?>
<?php
$urlGetPenerimaanBarang = $this->createUrl('FakturPembelianGU/getPenerimaanPersediaan');
$idSupplier = CHtml::activeId($model, 'supplier_id');
$konfigFarmasi = KonfigfarmasiK::model()->find();
$persenPPN = $konfigFarmasi->persenppn;
$persenPPH = $konfigFarmasi->persenpph;
$idPersenDiskon = CHtml::activeId($modFakturPembelian, 'persendiscount');
$idTotalHargaNetto = CHtml::activeId($modFakturPembelian, 'totharganetto');
$idTotalPajakPPN = CHtml::activeId($modFakturPembelian, 'totalpajakppn');
$idTotalPajakPPH = CHtml::activeId($modFakturPembelian, 'totalpajakpph');
$idJumlahDiskon = CHtml::activeId($modFakturPembelian, 'jmldiscount');
$idSyaratBayar = CHtml::activeId($modFakturPembelian, 'syaratbayar_id');
$idTotalHargaBruto = CHtml::activeId($modFakturPembelian, 'totalhargabruto');
$jscript = <<< JS
function hitungJumlahHargaDiskon(obj)
{
    besarDiskon =obj.value;
    $('.persenDiskon').each(function() {
          $(this).val(besarDiskon);
        });
    hitungSemua();
}
function submitSupplier(supplier_id,sisabayar){
        var sisabayar = $('#sisabayar').val();
        getDataRekeningFaktur(supplier_id,sisabayar);
    }
function submitPermintaanPembelianDariInformasi(idPenerimaan,noPenerimaan,tglPenerimaan)
{
    idPenerimaanBarang = idPenerimaan;
        if(idPenerimaanBarang==''){
            alert('Silakan pilih penerimaan terlebih dahulu!');
        }else{
            $.post("${urlGetPenerimaanBarang}", { idPenerimaanBarang: idPenerimaanBarang },
            function(data){
                $('#tableFaktur > tbody').append(data.tr);
			console.log(data.tr);
                $('#idPenerimaanBarang').val(idPenerimaan);
                $('#${idSupplier}').val(data.supplier_id);
                $('#GFPenerimaanBarangT_noterima').val(noPenerimaan);
                $('#buttonpenerimaanBarang').attr('disabled','TRUE');
                $('#GFPenerimaanBarangT_tglterima').val(tglPenerimaan);
                $('#GFPenerimaanBarangT_noterima').attr('readonly','TRUE');
                $('#GFPenerimaanBarangT_tglterima').attr('readonly','TRUE');
                $('#GFFakturPembelianT_supplier_id').attr('readonly','TRUE');
                hitungSemua();
				//setTotalHarga();
				//alert("asdasd");
                if(data.isPPN=='1'){ //Jika termasuk PPN
                 $('#termasukPPN').attr('checked','checked');
                }
                if(data.isPPH=='1'){ //Jika termasuk PPH
                 $('#termasukPPH').attr('checked','checked');
                }
               var idObat = $("#tableFaktur tbody").parents().find('input[name$="[obatalkes_id]"]').val();
               var qty = $("#tableFaktur tbody").parents().find('input[name$="[jmlkemasan]"]').val();
               var supplier_id = $('#GFFakturPembelianT_supplier_id').val();                
               var hargaSatuan = unformatNumber($("#tableFaktur tbody").parents().find('input[name$="[harganettofaktur]"]').val());                               
               var total = unformatNumber($('#GFFakturPembelianT_totalhargabruto').val());
//               var total = unformatNumber($('#tableFaktur tbody').parents().find('.subTotal').val());
               var diskon = unformatNumber($('#tableFaktur tbody').parents().find('input[name$="[persendiscount]"]').val());
//                   saldo = (total - (total * (diskon/100)));
                   saldo = total;
                   if(saldo < 0){
                        saldo = total;
                   }
                hapusJurnal(idObat);
                getDataRekeningFaktur(supplier_id,saldo);
                setTimeout(function(){//karna form rekening butuh waktu ketika ajax request nya
                    updateRekeningFaktur(supplier_id, formatDesimal(saldo));
                },500);
            }, "json");
        }   
}  
function persenPPN(obj)
{
    if(obj.checked==true){ //Jika tidak termasuk PPN
          jumlahPPN = parseFloat(unformatNumber($('#KUTerimapersediaanT_totalharga').val())) * (parseFloat(${persenPPN})/100);
          $('#termasukPPN').val(jumlahPPN);
          $('#KUTerimapersediaanT_pajakppn').val(formatNumber(jumlahPPN));
          $('#termasukPPH').removeAttr('readonly');
    }else{//Jika Termasuk PPN
        $('#termasukPPH').removeAttr('checked'); 
        $('#KUTerimapersediaanT_pajakppn').val(0);
        $('#termasukPPH').attr('readonly','TRUE');
        $('#KUTerimapersediaanT_pajakpph').val(0);     
        $('#totalPPH').val(0);
        $('#termasukPPH').val(0);  
        $('#termasukPPN').val(0);     
    }
   hitungSemua();
}
function persenPPH(obj)
{
    if(obj.checked==true){ 
          jumlahPPH= parseFloat($('#KUTerimapersediaanT_totalharga').val()) * (parseFloat(${persenPPH})/100);
          $('#termasukPPH').val(jumlahPPH);
          $('#KUTerimapersediaanT_pajakpph').val(jumlahPPH);
    }else{
          $('#termasukPPH').val(0);  
          $('#KUTerimapersediaanT_pajakpph').val(0);          
    }
   hitungSemua();
}
function remove(obj) {
    $(obj).parents('tr').remove();
    var idbarang = $("#tableFaktur tbody").parents().find('input[name$="[barang_id]"]').val();
    removeRekeningObat(idbarang);
    hitungSemua();
}
function hapusJurnal(idObat) {
    removeRekeningObat(idObat);
    hitungSemua();
}
function openDialog(obj){
        $('#dialogPegawai').attr('parentClick',obj);
        $('#dialogPegawai').dialog('open');   
    }
JS;
Yii::app()->clientScript->registerScript('faktur', $jscript, CClientScript::POS_HEAD);
?>
<?php
$this->widget('application.extensions.moneymask.MMask', array(
    'element' => '.integer',
    'config' => array(
        'defaultZero' => true,
        'allowZero' => true,
        'allowDecimal' => true,
        'decimal' => '.',
        'thousands' => '',
        'precision' => 0,
    )
));
?>
<script type="text/javascript">
    function submitPermintaanPembelian() {
        var idTerimaPers = $('#terimapersediaan_id').val();
        if (idTerimaPers == '') {
            alert('Silakan pilih penerimaan terlebih dahulu!');
        } else {
            $("#tableFaktur tbody tr").remove();
            $.post('<?php echo $this->createUrl('FakturPembelianGU/getPenerimaanPersediaan'); ?>', {
                idTerimaPers: idTerimaPers
            }, function(data) {
                $('#tableFaktur').append(data.tab);
                $("#tableFaktur tbody tr .integer2").maskMoney({
                    "defaultZero": true,
                    "allowZero": true,
                    "decimal": ",",
                    "thousands": ".",
                    "precision": 0,
                    "symbol": null
                });
                //				$('#uangmuka').val(data.uangMuka);
                $('#<?php echo CHtml::activeId($model, 'jlmuangmukabeli') ?>').val(data.persdiaan.jlmuangmukabeli);
                $('#<?php echo CHtml::activeId($model, 'totalhutangusaha') ?>').val(data.persdiaan.totalhutangusaha);
                $('#<?php echo CHtml::activeId($model, 'pajak_id') ?>').val(data.persdiaan.pajak_id);
                $('#<?php echo CHtml::activeId($model, 'pajak_nama') ?>').val(data.pajak_nama);
                $('#<?php echo CHtml::activeId($modUangmuka, 'tgluangmukabeli') ?>').val(data.tgluangmuka);
                $('#<?php echo CHtml::activeId($modUangmuka, 'nopembayaran') ?>').val(data.nouangmuka);
                $('#<?php echo CHtml::activeId($modUangmuka, 'jumlahuang') ?>').val(data.persdiaan.jlmuangmukabeli);
                if (data.checkuangmuka == true) {
                    $('#divuangmukabeli').show();
                } else {
                    $('#divuangmukabeli').hide();
                }
                //				if (data.isPPN == '1') { //Jika termasuk PPN
                //					$('#termasukPPN').prop('checked', 'checked').change();
                //				} else {
                //					$('#termasukPPN').change();
                //				}
                //				if (data.isPPH == '1') { //Jika termasuk PPH
                //					$('#termasukPPH').prop('checked', 'checked').change();
                //				} else {
                //					$('#termasukPPH').change();
                //				}
                //hitungSemua();
                setTotalHarga();
                loadJatuhTempo();
            }, "json");
        }
    }
    //	function cekInputan() {
    //		$('.integer2').each(function () {
    //			this.value = unformatNumber(this.value)
    //		});
    //		$('.currency').each(function () {
    //			this.value = unformatNumber(this.value)
    //		});
    //		return true;
    //	}
    function setTotalHarga() {
        unformatNumberSemua();
        var totalHarga = 0;
        var totalSatuanHarga = 0;
        var diskontotal = 0;
        var ppntotal = 0;
        var pphtotal = 0;
        $('.cancel').each(function() {
            var qty = parseFloat($(this).parents('tr').find('.qty').val());
            var satuan = parseFloat($(this).parents('tr').find('.satuan').val());
            var persendiskon = parseFloat($(this).parents('tr').find('.persendiscount').val());
            var persenppn = parseFloat($(this).parents('tr').find('.persenppn').val());
            var persenpph = parseFloat($(this).parents('tr').find('.persenpph').val());
            var jmlHarga = (qty * satuan);
            if (jmlHarga > 0) {
                jmlHarga = parseFloat(jmlHarga.toFixed(2));
            }
            var jmlDiskon = ((jmlHarga * persendiskon) / 100);
            if (jmlDiskon > 0) {
                jmlDiskon = parseFloat(jmlDiskon.toFixed(2));
            }
            var jmlPpn = (((jmlHarga - jmlDiskon) * persenppn) / 100);
            if (jmlPpn > 0) {
                jmlPpn = parseFloat(jmlPpn.toFixed(2));
            }
            var jmlPph = (((jmlHarga - jmlDiskon) * persenpph) / 100);
            if (jmlPph > 0) {
                jmlPph = parseFloat(jmlPph.toFixed(2));
            }
            var subtotal = (jmlHarga - jmlDiskon + jmlPpn - jmlPph);
            if (subtotal > 0) {
                subtotal = parseFloat(subtotal.toFixed(2));
            }
            totalHarga += parseFloat(subtotal);
            diskontotal += jmlDiskon;
            ppntotal += jmlPpn;
            pphtotal += jmlPph;
            totalSatuanHarga += satuan;
            $(this).parents('tr').find('.jmldiscount').val(jmlDiskon);
            $(this).parents('tr').find('.jmlppn').val(jmlPpn);
            $(this).parents('tr').find('.jmlpph').val(jmlPph);
            $(this).parents('tr').find('.beli').val(subtotal);
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

    function getTotalSeluruh() {
        //		unformatNumberSemua();
        var totalharga = $("#<?php echo CHtml::activeId($model, 'totalharga') ?>").val();
        var diskon = $("#<?php echo CHtml::activeId($model, 'discount') ?>").val();
        //		var biayaadmin = $("#<?php echo CHtml::activeId($model, 'biayaadministrasi') ?>").val();
        var pajakpph = $("#<?php echo CHtml::activeId($model, 'pajakpph') ?>").val();
        var pajakppn = $("#<?php echo CHtml::activeId($model, 'pajakppn') ?>").val();
        //		var totalkeseluruhan = (parseInt(totalharga) - parseInt(diskon)) + parseInt(biayaadmin) + parseInt(pajakpph) + parseInt(pajakppn);
        var totalkeseluruhan = (parseFloat(totalharga) - parseFloat(diskon)) + parseFloat(pajakppn) - parseFloat(pajakpph);
        $("#<?php echo CHtml::activeId($model, 'totalkeseluruhan') ?>").val(totalkeseluruhan);
        //		formatNumberSemua();
    }

    function batal(obj) {
        myConfirm("<?php echo Yii::t('mds', 'Do You want to cancel?'); ?>", 'Perhatian!', function(r) {
            if (!r) {
                return false;
            } else {
                $(obj).parents('tr').remove();
                setTotalHarga();
                rename();
            }
        });
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
                // $.alerts.okButton = "Ya";
                // $.alerts.cancelButton = "Tidak";
                myConfirm("Harga Netto '" + pesanharga + "' berbeda dengan yang ada di master. Apakah Anda ingin melakukan update harga otomatis?", "Perhatian!", function(r) {
                    if (r) {
                        $('#tableFaktur tbody tr').each(function() {
                            $(this).find('input[name$="[hppcheck]"]').val(1);
                        });
                        $('.integer-decimal, .float2, .integer2').each(function() {
                            $(this).val(unformatNumber($(this).val()));
                        });
                        $("#gffakturpembelian-m-form").submit();
                    } else {
                        $('#tableFaktur tbody tr').each(function() {
                            $(this).find('input[name$="[hppcheck]"]').val(0);
                        });
                        $('.integer-decimal, .float2, .integer2').each(function() {
                            $(this).val(unformatNumber($(this).val()));
                        });
                        $("#gffakturpembelian-m-form").submit();
                    }
                });
            } else {
                $('#tableFaktur tbody tr').each(function() {
                    $(this).find('input[name$="[hppcheck]"]').val(1);
                });
                $('.integer-decimal, .float2, .integer2').each(function() {
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
    });
</script>