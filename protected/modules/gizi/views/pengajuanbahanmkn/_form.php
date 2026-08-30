<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END); ?>
<?php
if (!empty($_GET['id'])) {
?>
<?php } ?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-utensils"></i> Transaksi <b>Permintaan Pembelian Bahan Makanan</b>
            <span class="pull-right">
                <a href="<?= !empty($linkHalaman) ? $linkHalaman : '#'; ?>" class="btn btn-default" target="_blank">
                    <i class="fas fa-external-link-alt"></i> Ke Halaman Informasi
                </a>
            </span>
        </div>
    </div>
    <div class="panel-body">
        <?php
        if (isset($_GET['sukses'])) {
            Yii::app()->user->setFlash('success', '<b>Berhasil!</b> Data berhasil disimpan.');
        }
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'gzpengajuanbahanmkn-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
            'focus' => '#',
        ));
        ?>
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                                    ?></p>-->
        <?php //echo $form->errorSummary($model, $modDetails, $modDetailPengajuan); 
        ?>
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="fas fa-file-contract"></i> Data <b>Rencana Kebutuhan</b>
                        </div>
                    </div>
                    <div class="panel-body">
                        <?php echo $this->renderPartial($this->path_view . '_formRencanaKebutuhan', array('form' => $form, 'model' => $model, 'modDetails' => $modDetails, 'modDetailPengajuan' => $modDetailPengajuan), true); ?>
                    </div>
                </div>
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="fas fa-file-contract"></i> Data <b>Permintaan Pembelian</b>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <?php echo $form->textFieldRow($model, 'nopengajuan', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                                <div class="control-group">
                                    <?php echo $form->labelEx($model, 'tglpengajuanbahan', array('class' => 'control-label')) ?>
                                    <div class="controls">
                                        <?php
                                        $this->widget('MyDateTimePicker', array(
                                            'model' => $model,
                                            'attribute' => 'tglpengajuanbahan',
                                            'mode' => 'datetime',
                                            'options' => array(
                                                'dateFormat' => Params::DATE_FORMAT,
                                                'maxDate' => 'd',
                                            ),
                                            'htmlOptions' => array('readonly' => true, 'class' => 'span3'),
                                        ));
                                        ?>
                                        <?php echo $form->error($model, 'tglpengajuanbahan'); ?>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <?php echo CHtml::label("Supplier <span class='required'>*</span>", "", array('class' => 'control-label required')) ?>
                                    <div class="controls">
                                        <?php echo $form->dropDownList($model, 'supplier_id', CHtml::listData($model->Supplier, 'supplier_id', 'supplier_nama'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <?php echo $form->labelEx($model, 'tglmintadikirim', array('class' => 'control-label')) ?>
                                    <div class="controls">
                                        <?php echo $form->hiddenField($model, 'hari_pengiriman', array('class' => 'span3', 'readonly' => true)); ?>
                                        <?php
                                        $this->widget('MyDateTimePicker', array(
                                            'model' => $model,
                                            'attribute' => 'tglmintadikirim',
                                            'mode' => 'datetime',
                                            'options' => array(
                                                'dateFormat' => Params::DATE_FORMAT,
                                                //'maxDate' => 'd',
                                            ),
                                            'htmlOptions' => array('readonly' => true, 'class' => 'span3', 'onblur' => 'getHariKirim(this)'),
                                        ));
                                        ?>
                                        <?php echo $form->error($model, 'tglmintadikirim'); ?>
                                    </div>
                                </div>
                                <?php echo $form->textAreaRow($model, 'alamatpengiriman', array('rows' => 6, 'cols' => 50, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                                <?php echo $form->textFieldRow($model, 'noreferensi', array('placeholder' => 'No. Referensi', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 200)); ?>
                            </div>
                            <div class="col-sm-6">
                                <div class="control-group">
                                    <?php echo CHtml::label("Jenis PPh", "pajak_id", array('class' => 'control-label')) ?>
                                    <div class="controls">
                                        <?php echo $form->dropDownList(
                                            $model,
                                            'pajak_id',
                                            CHtml::listData(PajakM::model()->findAll('pajak_aktif = true AND ispajakpegawai = false AND isppnkeluaran = false ORDER BY pajak_nama ASC'), 'pajak_id', 'pajak_nama'),
                                            array(
                                                'class' => 'span2', 'onkeyup' => "return $(this).focusNextInputField(event)",
                                                'empty' => '-- Pilih --',
                                            )
                                        ); ?>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <?php echo CHtml::label("Pegawai Pemesan <span class='required'>*</span>", "", array('class' => 'control-label')) ?>
                                    <div class="controls">
                                        <?php echo $form->hiddenField($model, 'idpegawai_mengajukan', array('class' => 'required span3', 'readonly' => true)); ?>
                                        <?php echo $form->textField($model, 'idpegawai_mengajukan_nama', array('readonly' => true, 'empty' => '-- Pilih --', 'class' => 'span3 required', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <?php echo CHtml::label("Manajer Umum <span class='required'>*</span>", "", array('class' => 'control-label')) ?>
                                    <div class="controls">
                                        <?php echo $form->hiddenField($model, 'idpegawai_mengetahui', array('class' => 'required span3', 'readonly' => true)); ?>
                                        <?php echo $form->textField($model, 'idpegawai_mengetahui_nama', array('readonly' => true, 'empty' => '-- Pilih --', 'class' => 'span3 required', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <?php echo CHtml::label("Manager Keuangan <span class='required'>*</span>", "", array('class' => 'control-label')) ?>
                                    <div class="controls">
                                        <?php echo $form->hiddenField($model, 'idpegawai_mengetahui2', array('class' => 'required span3', 'readonly' => true)); ?>
                                        <?php echo $form->textField($model, 'idpegawai_mengetahui2_nama', array('readonly' => true, 'empty' => '-- Pilih --', 'class' => 'span3 required', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <?php echo CHtml::label("Direktur <span class='required'>*</span>", "", array('class' => 'control-label')) ?>
                                    <div class="controls">
                                        <?php echo $form->hiddenField($model, 'idpegawai_menyetujui', array('class' => 'required span3', 'readonly' => true)); ?>
                                        <?php echo $form->textField($model, 'idpegawai_menyetujui_nama', array('readonly' => true, 'empty' => '-- Pilih --', 'class' => 'span3 required', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                                    </div>
                                </div>
                                <?php echo $form->textAreaRow($model, 'keterangan_bahan', array('placeholder' => 'Keterangan', 'rows' => 6, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php echo $form->hiddenField($model, 'is_uangmukapembelian', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                <?php $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                    'id' => 'form-uangmukapembelian',
                    'content' => array(
                        'content-uangmukapembelian' => array(
                            'header' => '<b>Data Permintaan Uang Muka Pembelian</b>',
                            'isi' => $this->renderPartial($this->path_view . '_formUangMuka', array(
                                'form' => $form,
                                'model' => $model,
                            ), true),
                            'active' => $model->is_uangmukapembelian,
                        ),
                    ),
                )); ?>
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="entypo-credit-card"></i> Tabel <b>Permintaan Pembelian Bahan Makanan</b>
                        </div>
                    </div>
                    <div class="panel-body table-responsive">
                        <!--<div class="row">
                        <div class="col-sm-6">
                            <div class="control-group">
                                <label class="control-label">Nama Bahan Makanan <span color="red"> * </span></label>
                                <div class="controls">
                                    <?php // echo CHtml::hiddenField('idBahan'); 
                                    ?>
                                    <?php
                                    //                                    $this->widget('MyJuiAutoComplete', array(
                                    //                                        'name' => 'namaBahan',
                                    //                                        'source' => 'js: function(request, response) {
                                    //                                            $.ajax({
                                    //                                                    url: "' . $this->createUrl('AutocompleteBahanMakanan') . '",
                                    //                                                    dataType: "json",
                                    //                                                    data: {
                                    //                                                            term: request.term,
                                    //                                                            idSumberDana: $("#idSumberDana").val(),
                                    //                                                    },
                                    //                                                    success: function (data) {
                                    //                                                                    response(data);
                                    //                                                    }
                                    //                                            })
                                    //                                         }',
                                    //                                        'options' => array(
                                    //                                            'showAnim' => 'fold',
                                    //                                            'minLength' => 2,
                                    //                                            'focus' => 'js:function( event, ui ) {
                                    //                                                    $(this).val( ui.item.label);
                                    //                                                    return false;
                                    //                                            }',
                                    //                                            'select' => 'js:function( event, ui ) {
                                    //                                                    $("#idBahan").val(ui.item.bahanmakanan_id);
                                    //                                                    $("#qty").val(1);
                                    //                                                    $("#satuanbahan").val(ui.item.satuanbahan);
                                    //                                                    return false;
                                    //                                            }',
                                    //                                        ),
                                    //                                        'htmlOptions' => array(
                                    //                                            'onkeypress' => "return $(this).focusNextInputField(event)",
                                    //                                        ),
                                    //                                        'tombolDialog' => array('idDialog' => 'dialogBahanMakanan'),
                                    //                                    ));
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="control-group">
				<label class="control-label">Jumlah</label>
				<div class="controls">
                                    <?php // echo CHtml::textField('qty', 1.00, array('class' => 'span1 float2 number', 'onkeypress' => "return $(this).focusNextInputField(event)",)); 
                                    ?>
                                    <?php // echo CHtml::dropDownList('satuanbahan', '', LookupM::getItems('satuanbahanmakanan'), array('empty' => '-- Pilih --', 'class' => 'span2')); 
                                    ?>
                                    <?php
                                    //                                    echo CHtml::htmlButton('<i class="icon-plus icon-white"></i>', array('onclick' => 'inputBahanMakanan();return false;',
                                    //                                            'class' => 'btn btn-primary numbersOnly',
                                    //                                            'onkeypress' => "inputBahanMakanan();return $(this).focusNextInputField(event)",
                                    //                                            'rel' => "tooltip",
                                    //                                            'title' => "Klik untuk menambahkan Bahan Makanan",));
                                    ?>
				</div>
                            </div>
                        </div>
                    </div>-->
                        <!--<div class="panel panel-success">
                        <div class="panel-heading">
                            <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Permintaan Pembelian Bahan Makanan</b></div>
                        </div>-->
                        <table class="table table-bordered table-condensed" id="tableBahanMakanan">
                            <thead>
                                <tr>
                                    <th hidden><input type="checkbox" id="checkListUtama" name="checkListUtama" value="1" checked="checked" onclick="checkAll('cekList',this);hitungSemua();"></th>
                                    <th>No.</th>
                                    <th>Kelompok</th>
                                    <th>Nama</th>
                                    <th>Spesifikasi Bahan Makanan</th>
                                    <th>Tgl. Kedaluwarsa</th>
                                    <th>Jumlah Permintaan</th>
                                    <th>Jumlah Persediaan</th>
                                    <th>Satuan</th>
                                    <th>Harga Netto</th>
                                    <th>Keringanan (%)</th>
                                    <th>Keringanan (Rp)</th>
                                    <th>PPN (%)</th>
                                    <th>PPN (Rp)</th>
                                    <th>PPh (%)</th>
                                    <th>PPh (Rp)</th>
                                    <th>Subtotal</th>
                                    <th>Batal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (isset($_GET['ubah'])) {
                                    if (count((array)$modDetails) > 0) {
                                        foreach ($modDetails as $i => $modDetail) {
                                            $modDetail->subNetto = ($modDetail->qty_pengajuan * $modDetail->harganettobhn);
                                            $modDetail->qty_pengajuan = number_format($modDetail->qty_pengajuan, 2, ",", ".");
                                            echo $this->renderPartial($this->path_view . '_rowbahanmkn', array('modDetail' => $modDetail, 'model' => $model));
                                        }
                                    }
                                }
                                ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan='15'>
                                        <div class='pull-right'>Total Harga</div>
                                    </td>
                                    <td><?php
                                        echo (Params::cekHiddenHargaGizi() == true) ? $form->textField($model, 'totalharganetto', array('readonly' => true, 'class' => 'span2 integer-decimal', 'onkeypress' => "return $(this).focusNextInputField(event);", 'style' => 'text-align: right;width:100px;')) : $form->passwordField($model, 'totalharganetto', array('readonly' => true, 'class' => 'span2 integer-decimal', 'onkeypress' => "return $(this).focusNextInputField(event);", 'style' => 'text-align: right;width:100px;')); ?>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                        <!--</div>-->
                    </div>
                </div>
                <div class="form-actions">
                    <?php
                    if (isset($_GET['sukses'])) {
                        echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Simpan', array('{icon}' => '<i class="entypo-check"></i>')) :
                            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'button', 'onKeypress' => 'return formSubmit(this,event)', 'disabled' => true));
                    } else {
                        echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Simpan', array('{icon}' => '<i class="entypo-check"></i>')) :
                            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'button', 'onKeypress' => 'return formSubmit(this,event)', 'onclick' => 'cekValidasi($("form"))'));
                    }
                    ?>
                    <?php echo CHtml::link(
                        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                        $this->createUrl(ucwords($this->id) . '/index&modul_id=' . Yii::app()->session['modul_id']),
                        array(
                            'title' => 'Ulang',
                            'class' => 'btn btn-default',
                            'onclick' => 'return refreshForm(this);'
                        )
                    );
                    if (!isset($_GET['sukses'])) {
                        echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'disabled' => true));
                    } else {
                        echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "print('PRINT')"));
                    }
                    ?>
                    <?php
                    $content = $this->renderPartial($this->path_views . '../tips/transaksi', array(), true);
                    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content)); ?>
                </div>
            </div>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>
<script type="text/javascript">
    /**
     * rename input grid
     */
    function renameInputRowObatAlkes(obj_table) {
        var row = 0;
        $(obj_table).find("tbody > tr").each(function() {
            $(this).find("#noUrut").val(row + 1);
            $(this).find('input,select,textarea').each(function() { //element <input>
                var old_name = $(this).attr("name").replace(/]/g, "");
                var old_name_arr = old_name.split("[");
                if (old_name_arr.length == 3) {
                    $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2]);
                    $(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]");
                }
            });
            row++;
        });
    }

    function checkuangmuka() {
        unformatNumberSemua();
        var totalharga = parseFloat($('#<?php echo CHtml::activeId($model, 'totalharganetto'); ?>').val());
        var jmlpermintaanuangmuka = parseFloat($('#<?php echo CHtml::activeId($model, 'jmlpermintaanuangmuka'); ?>').val());
        if (jmlpermintaanuangmuka > totalharga) {
            myAlert("Jumlah Uang Muka Tidak Boleh Lebih Besar dari Total Permintaan Pembelian Bahan Makanan");
            $('#<?php echo CHtml::activeId($model, 'jmlpermintaanuangmuka'); ?>').val(0);
        }
        formatNumberSemua();
    }

    function loadRencana(id) {
        $('#tableBahanMakanan tbody').empty();
        $.post("<?php echo $this->createUrl('loadRencanaKebutuhan'); ?>", {
            id: id
        }, function(data) {
            $('#tableBahanMakanan tbody').html(data.html);
            hitungTotal();
            renameInputRowObatAlkes($('#tableBahanMakanan'));
        }, 'json');
    }

    function getHariKirim(obj) {
        var tglkirim = $(obj).val();
        $.post("<?php echo $this->createUrl('getHariPengiriman'); ?>", {
            tgl_kirim: tglkirim
        }, function(data) {
            $('#<?php echo CHtml::activeId($model, 'hari_pengiriman'); ?>').val(data.hariPengiriman);
        }, 'json');
    }
    $(document).ready(function() {
        <?php if (isset($_GET['rencana_id'])) : ?>
            loadRencana(<?php echo $_GET['rencana_id']; ?>);
        <?php endif; ?>
        <?php if (isset($_GET['ubah']) && $_GET['ubah'] == 1) { ?>
            hitungTotal();
        <?php } ?>
        $('#form-uangmukapembelian > div > .accordion-heading').click(function() {
            var is_uangmukapembelian = $("#<?php echo CHtml::activeId($model, 'is_uangmukapembelian'); ?>");
            if (is_uangmukapembelian.val() > 0) { //hide
                is_uangmukapembelian.val(0);
            } else { //show
                is_uangmukapembelian.val(1);
            }
        });
    });
</script>
<?php
$totalHarga = CHtml::activeId($model, 'totalharganetto');
$urlBahan = $this->createUrl('getBahanMakanan');
$pengajuanbahan_id =  $model->pengajuanbahanmkn_id;
$urlPrint = $this->createUrl('print');
$urlRencana = $this->createUrl('loadRencanaKebutuhan');
$pajak_id = CHtml::activeId($model, 'pajak_id');
$js = <<<JS
    function inputBahanMakanan(){
        var id = $('#idBahan').val();
        var qty= unformatNumber($('#qty').val());
        var ukuran = $('#ukuran').val();
        var merk = $('#merk').val();
        var satuanbahan = $('#satuanbahan').val();
        if (jQuery.isNumeric(id)){
        if(cekList(id)==true){
              $.post("${urlBahan}", {id:id, qty:qty, ukuran:ukuran, merk:merk, stuanbahan:satuanbahan},
                function(data){
                    $('#tableBahanMakanan tbody').append(data.tr);
                    hitungTotal();
                    $("#tableBahanMakanan tbody tr:last .numbersOnly").maskMoney({"defaultZero":true,"allowZero":true,"decimal":",","thousands":"","precision":0,"symbol":null});
					$("#tableBahanMakanan tbody tr:last .integer2").maskMoney({"defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":0,"symbol":null});
					$("#tableBahanMakanan tbody tr:last .float2").maskMoney({"defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":2,"symbol":null});
                    $("#tableBahanMakanan tbody tr:last .satuanbahan").val(satuanbahan);
                    renameInputRowObatAlkes($('#tableBahanMakanan'));
              }, "json");
              clear();
        }
        }
        else{
            myAlert('Isi Data dengan Benar');
        }
    }
    function hitungSemua(){
        noUrut = 1;
        value = 0;
        $('.noUrut').each(function(){
            $(this).val(noUrut);
            noUrut++;
           // if ($(this).parents('tr').find('#checkList').is(':checked')){
				val = parseFloat($(this).parents('tr').find('.subNetto').val());
                value += val;
            //}
            $('.cekList').each(function(){
               if ($(this).is(':checked')){
                     $(this).parents('tr').find('.cek').val(1);
                }else{
                    $(this).parents('tr').find('.cek').val(0);
                }
            });
        });
//        $('#${totalHarga}').val(value);
    }
    function hitung(obj){
        var netto = parseFloat(unformatNumber($(obj).parents("tr").find('.harganettobhn').val()));
        var jml = parseFloat(unformatNumber($(obj).val()));
		console.log(netto, jml);
        $(obj).parents('tr').find('.subNetto').val(formatNumber(netto*jml));
        hitungSemua();
    }
    function hapus(obj) {
        $(obj).parents('tr').remove();
        hitungTotal()
    }
    function cekList(id){
        x = true;
        $('.bahanmakanan_id').each(function(){
            if ($(this).val() == id){
                myAlert('Daftar Bahan Makanan telah ada di List');
                clear();
                x = false;
            }
        });
        return x;
    }
    function clear(){
        $('#namaBahan').val('');
        $('#qty').val('');
        $('#satuanbahan').val('');
        $('#ukuran').val('');
        $('#merk').val('');
    }
	function cekValidasi(obj){
		if ($("#tableBahanMakanan tbody tr").length == 0) {
			myAlert("Data Form Bahan Makanan belum diisi");
			return false;
		}
		var oa_det = "";
		var beda_netto = false;
		var cekValidasi = true;
                var cekpph = 0;
		if (!requiredCheck(obj)) return false;
		$("#tableBahanMakanan tbody tr").each(function() {
                    unformatNumberSemua();
                    var persenpph  = parseFloat($(this).find('.persenpph').val());
                    if(persenpph > 0){
                        cekpph += 1;
                    }else{
                        if(cekpph > 1){
                            cekpph -= 1;
                        }
                    }
                    formatNumberSemua();
		});
                if(cekpph > 0){
                    if($('#${pajak_id}').val() == ''){
                         myAlert("Jenis PPh harus diisi ");
                        return false;
                    }
                }
            $('.integer-decimal, .integer2, float2').each(function(){
                   $(this).val(unformatNumber($(this).val()));
               });
		$("#gzpengajuanbahanmkn-form").submit();
		return false;
	}
	function hitungTotal(){
        unformatNumberSemua();
		var totalnetto = 0;
		var sub = 0;
		$('#tableBahanMakanan tbody tr').each(function(){
			var netto  = parseFloat($(this).find('.harganettobhn').val());
			var qty  = parseFloat($(this).find('.qty').val());
                        var persendiscount = parseFloat($(this).find('.persendiscount').val());
                        var persenppn  = parseInt($(this).find('.persenppn').val());
                        var persenpph  = parseFloat($(this).find('.persenpph').val());
                        var totalJml = (netto * qty);
                        if (totalJml > 0){
                            totalJml = parseFloat(totalJml.toFixed(2));
                        }
                        var jmldiscount = ((totalJml * persendiscount)/100);
                        if (jmldiscount > 0){
                            jmldiscount = parseFloat(jmldiscount.toFixed(2));
                        }
                        var jmlppn = (((totalJml - jmldiscount) * persenppn)/100);
                        if (jmlppn > 0){
                            jmlppn = parseFloat(jmlppn.toFixed(2));
                        }
                        var jmlpph = (((totalJml - jmldiscount) * persenpph)/100);
                        if (jmlpph > 0){
                            jmlpph = parseFloat(jmlpph.toFixed(2));
                        }
                        var totalAll = (totalJml - jmldiscount + jmlppn - jmlpph);
                        if (totalAll > 0){
                            totalAll = parseFloat(totalAll.toFixed(2));
                        }
			totalnetto += totalAll;
			$(this).find('.subNetto').val(totalAll);
                        $(this).find('.jmldiscount').val(jmldiscount);
                        $(this).find('.jmlppn').val(jmlppn);
                        $(this).find('.jmlpph').val(jmlpph);
		});
                     $('#${totalHarga}').val(totalnetto);
//		hitungSemua();
        formatNumberSemua();
                     checkuangmuka();
	}
	function print(caraPrint)
	{
		var pengajuanbahanmkn_id = '${pengajuanbahan_id}';
		window.open('${urlPrint}&pengajuanbahanmkn_id='+pengajuanbahanmkn_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
	}
JS;
Yii::app()->clientScript->registerScript('fungsi', $js, CClientScript::POS_HEAD);
?>
<?php
//========= Dialog buat cari Bahan Makanan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogBahanMakanan',
    'options' => array(
        'title' => 'Bahan Makanan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'height' => 500,
        'resizable' => false,
    ),
));
$modBahanMakanan = new GZBahanMakananM('search');
$modBahanMakanan->unsetAttributes();
if (isset($_GET['GZBahanMakananM']))
    $modBahanMakanan->attributes = $_GET['GZBahanMakananM'];
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'gzbahanmakanan-m-grid',
    'dataProvider' => $modBahanMakanan->search(),
    'filter' => $modBahanMakanan,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small",
                                    "id" => "selectBahan",
                                    "onClick" => "$(\'#idBahan\').val($data->bahanmakanan_id);
                                    $(\'#satuanbahan\').val(\'$data->satuanbahan\');
                                    $(\'#qty\').val(1);
                                    $(\'#namaBahan\').val(\'$data->jenisbahanmakanan - $data->namabahanmakanan - $data->jmlpersediaan\');
                                    $(\'#dialogBahanMakanan\').dialog(\'close\');return false;"))',
        ),
        ////'bahanmakanan_id',
        //        array(
        //                        'name'=>'bahanmakanan_id',
        //                        'value'=>'$data->bahanmakanan_id',
        //                        'filter'=>false,
        //                ),
        array(
            'name' => 'golbahanmakanan_id',
            'filter' => CHtml::activeDropDownList($modBahanMakanan, 'golbahanmakanan_id', CHtml::listData(GolbahanmakananM::model()->findAll('golbahanmakanan_aktif = true'), 'golbahanmakanan_id', 'golbahanmakanan_nama'), array('empty' => '-- Pilih --')),
            'value' => '$data->golbahanmakanan->golbahanmakanan_nama',
        ),
        array(
            'name' => 'jenisbahanmakanan',
            'filter' => CHtml::activeDropDownList($modBahanMakanan, 'jenisbahanmakanan', LookupM::getItems('jenisbahanmakanan'), array('empty' => '-- Pilih --')),
            'value' => '$data->jenisbahanmakanan',
        ),
        array(
            'name' => 'kelbahanmakanan',
            'filter' => CHtml::activeDropDownList($modBahanMakanan, 'kelbahanmakanan', LookupM::getItems('kelompokbahanmakanan'), array('empty' => '-- Pilih --')),
            'value' => '$data->kelbahanmakanan',
        ),
        'namabahanmakanan',
        array(
            'name' => 'jmlpersediaan',
            'value' => function ($data) {
                /*
					 * Jika stok gizi di centang pada konfig sistem maka jumlah pada
					 * data stok ditampilkan. Jika tidak maka hanya menampilkan data
					 * jmlpersediaan pada master
					 */
                $stokgizi = Yii::app()->user->getState('krngistokgizi');
                if ($stokgizi) {
                    $stok = StokbahanmakananT::model()->findAllByAttributes(array(
                        'bahanmakanan_id' => $data->bahanmakanan_id,
                    ));
                    $tot = 0;
                    foreach ($stok as $item) {
                        $tot += $item->qty_current;
                    }
                    return $tot;
                }
                return $data->jmlpersediaan;
            },
            'htmlOptions' => array(
                'style' => 'text-align: right;',
            ),
            'filter' => false,
        ),
        array(
            'name' => 'harganettobahan',
            'value' => '((Params::cekHiddenHargaGizi()==true)?MyFormatter::formatNumberForPrint($data->harganettobahan):"Hidden")',
            'htmlOptions' => array(
                'style' => 'text-align: right;',
            ),
            'filter' => false,
        ),
        array(
            'name' => 'hargajualbahan',
            'value' => '((Params::cekHiddenHargaGizi()==true)?MyFormatter::formatNumberForPrint($data->hargajualbahan):"Hidden")',
            'htmlOptions' => array(
                'style' => 'text-align: right;',
            ),
            'filter' => false,
        ),
        //'harganettobahan',
        //'hargajualbahan',
        array(
            'name' => 'discount',
            'value' => 'MyFormatter::formatNumberForPrint($data->discount)',
            'htmlOptions' => array(
                'style' => 'text-align: right;',
            ),
            'filter' => false,
        ),
        //'discount',
        array(
            'name' => 'tglkadaluarsabahan',
            'value' => 'MyFormatter::formatDateTimeForUser($data->tglkadaluarsabahan);',
            'htmlOptions' => array(
                'style' => 'text-align: right;',
            ),
            'filter' => false,
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
?>
<?php
$this->widget('application.extensions.moneymask.MMask', array(
    'element' => '.numbersOnly',
    'config' => array(
        'defaultZero' => true,
        'allowZero' => true,
        'decimal' => ',',
        'thousands' => '',
        'precision' => 0,
    )
));
?>
<?php /*Yii::app()->clientScript->registerScript('submit', '
    $("form").submit(function(){
        sumberDana = $("#'.CHtml::activeId($model, 'sumberdanabhn').'").val();
        jumlah = 0;
        if (sumberDana == ""){
            myAlert("'.CHtml::encode($model->getAttributeLabel('sumberdanabhn')).' harus diisi!");
            return false;
        }
        $(".cekList").each(function(){
            if ($(this).is(":checked")){
                jumlah++;
            }
        });
        if (jumlah < 1){
            myAlert("Pilih bahan makanan yang akan diajukan!");
            return false;
        }
    });
', CClientScript::POS_READY);*/ ?>
<?php
//========= Dialog buat cari data Pegawai Mengetahui =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPegawaiMengetahui',
    'options' => array(
        'title' => 'Pencarian Pegawai Mengetahui',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => false,
    ),
));
$modPegawaiMengetahui = new GZPegawaiM('searchDialog');
$modPegawaiMengetahui->unsetAttributes();
$modPegawaiMengetahui->ruangan_id = Yii::app()->user->getState('ruangan_id');
if (isset($_GET['GZPegawaiM'])) {
    $modPegawaiMengetahui->attributes = $_GET['GZPegawaiM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawaimengetahui-grid',
    'dataProvider' => $modPegawaiMengetahui->searchPegawai(),
    'filter' => $modPegawaiMengetahui,
    //'template'=>"{items}\n{pager}",
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
                                                  $(\"#' . CHtml::activeId($model, 'idpegawai_mengetahui') . '\").val(\"$data->pegawai_id\");
                                                  $(\"#' . CHtml::activeId($model, 'idpegawai_mengetahui_nama') . '\").val(\"$data->NamaLengkap\");
                                                  $(\"#dialogPegawaiMengetahui\").dialog(\"close\");
                                                  return false;
                                        "))',
        ),
        array(
            'header' => 'NIP',
            'filter' =>  CHtml::activeTextField($modPegawaiMengetahui, 'nomorindukpegawai', array('class' => 'numbers-only')),
            'value' => '$data->nomorindukpegawai',
        ),
        array(
            'header' => 'Nama Pegawai',
            'filter' =>  CHtml::activeTextField($modPegawaiMengetahui, 'nama_pegawai', array('class' => 'hurufs-only')),
            'value' => '$data->gelardepan." ".$data->nama_pegawai." ".$data->gelarbelakang_nama',
        ),
        array(
            'header' => 'Jabatan',
            'filter' =>  CHtml::activeDropDownList($modPegawaiMengetahui, 'jabatan_id', Chtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --')),
            'value' => function ($data) {
                $j = JabatanM::model()->findByPk($data->jabatan_id);
                if (!empty($j)) {
                    return $j->jabatan_nama;
                } else {
                    return '-';
                }
            }
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'
        . '$(".numbers-only").keyup(function(){'
        . ' setNumbersOnly(this);'
        . '});'
        . '$(".hurufs-only").keyup(function(){'
        . ' setHurufsOnly(this);'
        . '});'
        . '}',
));
$this->endWidget();
//========= end Pegawai Mengetahui dialog =============================
?>
<?php
//========= Dialog buat cari data Pegawai menyetujui =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPegawaiMenyetujui',
    'options' => array(
        'title' => 'Pencarian Pegawai Menyetujui',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => false,
    ),
));
$modPegawaiMenyetujui = new GZPegawaiM('searchDialog');
$modPegawaiMenyetujui->unsetAttributes();
$modPegawaiMenyetujui->ruangan_id = Yii::app()->user->getState('ruangan_id');
if (isset($_GET['GZPegawaiM'])) {
    $modPegawaiMenyetujui->attributes = $_GET['GZPegawaiM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawaimenyetujui-grid',
    'dataProvider' => $modPegawaiMenyetujui->searchPegawai(),
    'filter' => $modPegawaiMenyetujui,
    //'template'=>"{items}\n{pager}",
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
                                                  $(\"#' . CHtml::activeId($model, 'idpegawai_menyetujui') . '\").val(\"$data->pegawai_id\");
                                                  $(\"#' . CHtml::activeId($model, 'idpegawai_menyetujui_nama') . '\").val(\"$data->NamaLengkap\");
                                                  $(\"#dialogPegawaiMenyetujui\").dialog(\"close\");
                                                  return false;
                                        "))',
        ),
        array(
            'header' => 'NIP',
            'filter' =>  CHtml::activeTextField($modPegawaiMenyetujui, 'nomorindukpegawai', array('class' => 'numbers-only')),
            'value' => '$data->nomorindukpegawai',
        ),
        array(
            'header' => 'Nama Pegawai',
            'filter' =>  CHtml::activeTextField($modPegawaiMenyetujui, 'nama_pegawai', array('class' => 'hurufs-only')),
            'value' => '$data->gelardepan." ".$data->nama_pegawai." ".$data->gelarbelakang_nama',
        ),
        array(
            'header' => 'Jabatan',
            'filter' =>  CHtml::activeDropDownList($modPegawaiMenyetujui, 'jabatan_id', Chtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --')),
            'value' => function ($data) {
                $j = JabatanM::model()->findByPk($data->jabatan_id);
                if (!empty($j)) {
                    return $j->jabatan_nama;
                } else {
                    return '-';
                }
            }
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'
        . '$(".numbers-only").keyup(function(){'
        . ' setNumbersOnly(this);'
        . '});'
        . '$(".hurufs-only").keyup(function(){'
        . ' setHurufsOnly(this);'
        . '});'
        . '}',
));
$this->endWidget();
//========= end Pegawai menyetujui dialog =============================
?>
<?php
//========= Dialog buat cari data Pegawai Mengetahui =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogRencanaKebutuhan',
    'options' => array(
        'title' => 'Rencana Kebutuhan Bahan Makanan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => false,
    ),
));
$modRencana = new InformasirenkebbahanmakananV();
$modRencana->unsetAttributes();
if (isset($_GET['InformasirenkebbahanmakananV'])) {
    $modRencana->attributes = $_GET['InformasirenkebbahanmakananV'];
    // $modRencana->pegmenyetujui_nama = $_GET['InformasirenkebbahanmakananV']['pegmenyetujui_nama'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'rencanakebutuhan-grid',
    'dataProvider' => $modRencana->searchDialogUntukPermintaan(),
    'filter' => $modRencana,
    //'template'=>"{items}\n{pager}",
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
                                                  $(\"#' . CHtml::activeId($model, 'renkebbahanmakanan_id') . '\").val(\"$data->renkebbahanmakanan_id\");
                                                  $(\"#' . CHtml::activeId($model, 'renkebbahanmakanan_no') . '\").val(\"$data->renkebbahanmakanan_no\");
                                                  $(\"#' . CHtml::activeId($model, 'renkebbahanmakanan_tgl') . '\").val(\"".MyFormatter::formatDateTimeForUser($data->renkebbahanmakanan_tgl)."\");
                                                  $(\"#dialogRencanaKebutuhan\").dialog(\"close\");
                                                  loadRencana(".$data->renkebbahanmakanan_id.");
                                                  return false;
                                        "))',
        ),
        array(
            'name' => 'renkebbahanmakanan_tgl',
            'type' => 'raw',
            'value' => 'MyFormatter::formatDateTimeForUser($data->renkebbahanmakanan_tgl)',
        ),
        'renkebbahanmakanan_no',
        array(
            'name' => 'ro_bahanmakanan_bulan',
            'value' => '$data->ro_bahanmakanan_bulan',
            'htmlOptions' => array('style' => 'text-align: right;'),
        ),
        array(
            'header' => 'Kepala Instalasi Gizi',
            'type' => 'raw',
            //                                        'value'=>'ADInformasirenkebbarangV::pegawaimengetahui($data->pegmengetahui_id)',
            'value' => function ($data) {
                $dataDialog = "$('#dialogMenyetujui').dialog('open');";
                $html = (isset($data->pegmenyetujui_id) ? $data->pegawaimengetahui($data->pegmenyetujui_id) : "-");
                return $html;
            },
            'filter' => false,
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){
                jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
            }',
));
$this->endWidget();
//========= end Pegawai Mengetahui dialog =============================
?>