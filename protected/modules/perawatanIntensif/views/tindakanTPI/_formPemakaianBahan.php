<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i> Pemakaian BMHP
        </div>
    </div>
    <div class="panel-body">
        <table>
            <tr>
                <td colspan="2">
                    <?php echo CHtml::radioButton('pilihAlkes', true, array('value' => 'bahan', 'onclick' => 'pilihAlkesMedis(this);')); ?>
                    Pemakaian BMHP
                    <?php echo CHtml::radioButton('pilihAlkes', false, array('value' => 'medis', 'onclick' => 'pilihAlkesMedis(this);')); ?>
                    Alat Medis
                </td>
            </tr>
            <tr>
                <td width="230px">
                    <?php echo CHtml::dropDownList('daftartindakanPemakaianBahan', '', array(), array('empty' => 'Uraian Tindakan')) ?>
                </td>
                <td>
                    <?php echo CHtml::hiddenField('obatalkes_id'); ?>
                    <?php echo CHtml::hiddenField('satuankecil_id'); ?>
                    <?php $this->widget('MyJuiAutoComplete', array(
                        'name' => 'pakaiBahan',
                        'value' => '',
                        'source' => 'js: function(request, response) {
                                           $.ajax({
                                               url: "' . Yii::app()->createUrl('perawatanIntensif/tindakanTPI/PemakaianBahan') . '",
                                               dataType: "json",
                                               data: {
                                                   term: request.term,
                                                   idTipePaket: $("#RJTindakanPelayananT_0_tipepaket_id").val(),
                                                   idKelasPelayanan: $("#RJPendaftaranT_kelaspelayanan_id").val(),
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
                                    $(this).val( ui.item.label);
                                    return false;
                                }',
                            'select' => 'js:function( event, ui ) {
									$("#qty_input").val(ui.item.kemasanterkecil);
									$("#jmlkemasan").val(ui.item.kemasanterkecil);
									$("#pakaiBahan").val(ui.item.obatalkes_nama);
									setSatuanObat(ui.item.obatalkes_id);
									totalKonversi();
//                                    inputPemakaianBahan(ui.item.obatalkes_id);
                                    $(this).val( ui.item.label);
                                    $("#obatalkes_id").val(ui.item.obatalkes_id);
									$("#satuankecil_id").val(ui.item.satuankecil_id);
                                    return false;
                                }',

                        ),
                        'htmlOptions' => array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span2', 'placeholder' => 'Pemakaian BMHP'),
                        'tombolDialog' => array('idDialog' => 'dialogAlkes'),
                    )); ?>

                    <?php $this->widget('MyJuiAutoComplete', array(
                        'name' => 'alatMedis',
                        'value' => '',
                        'source' => 'js: function(request, response) {
                                           $.ajax({
                                               url: "' . Yii::app()->createUrl('perawatanIntensif/tindakanTPI/PemakaianAlatMedis') . '",
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
                                    $(this).val( ui.item.label);
                                    return false;
                                }',
                            'select' => 'js:function( event, ui ) {
                                    inputAlatmedis(ui.item.alatmedis_id);
                                    return false;
                                }',

                        ),
                        'htmlOptions' => array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span2', 'placeholder' => 'Alat Medis'),
                        'tombolDialog' => array('idDialog' => 'dialogAlatmedis'),
                    )); ?>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <div class="control-group" id="qtyBahan">
                        <label class="control-label" for="qty">Jumlah</label>
                        <div class="controls">
                            <?php echo CHtml::textField('qty_oa', '1', array('readonly' => false, 'onblur' => '$("#qty_oa").val(this.value);totalKonversi();', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span1 float')) ?>
                            / <?php echo CHtml::textField('jmlkemasan', '1', array('readonly' => false, 'onblur' => '$("#jmlkemasan").val(this.value);', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span1 float', 'readonly' => true)) ?> <span id="satuanterkecil_nama"></span> =
                            <?php echo CHtml::textField('jmlkonversi', '1', array('readonly' => false, 'onblur' => '$("#jmlkonversi").val(this.value);totalJumlah();', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span1 float')) ?> <span id="satuankecil_nama"></span>
                            <?php echo CHtml::htmlButton(
                                '<i class="icon-plus icon-white"></i>',
                                array(
                                    'onclick' => 'inputPemakaianBahan(this);return false;',
                                    'class' => 'btn btn-danger',
                                    'onkeypress' => "inputPemakaianBahan(this);return false;",
                                    'rel' => "tooltip",
                                    'title' => "Klik untuk menambahkan bahan",
                                )
                            ); ?>
                        </div>
                    </div>
                    <div class="control-group" id="qtyMedis">
                        <label class="control-label" for="qty">Jumlah</label>
                        <div class="controls">
                            <?php echo CHtml::textField('qty_oa', '1', array('readonly' => false, 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'inputFormTabel span1 numbersOnly')) ?>
                            <?php echo CHtml::htmlButton(
                                '<i class="icon-plus icon-white"></i>',
                                array(
                                    'onclick' => 'inputAlatmedis(this);return false;',
                                    'class' => 'btn btn-danger',
                                    'onkeypress' => "inputAlatmedis(this);return false;",
                                    'rel' => "tooltip",
                                    'title' => "Klik untuk menambahkan bahan",
                                )
                            ); ?>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
        <table class="items table table-striped table-bordered table-condensed" id="tblInputPemakaianBahan">
            <thead>
                <tr>
                    <th>Uraian Tindakan</th>
                    <th>Jenis Pemakaian</th>
                    <th>Nama Alkes</th>
                    <th>Jumlah</th>
                    <th>Sub Total</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
        <div>
            <b>Total Pemakaian BMHP : </b>
            <?php echo CHtml::textField("totPemakaianBahan", 0, array('readonly' => true, 'class' => 'inputFormTabel integer')); ?>
        </div>
    </div>
</div>

<?php
//========= Dialog buat cari data Alat Kesehatan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogAlkes',
    'options' => array(
        'title' => 'Alat Kesehatan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'height' => 550,
        'resizable' => false,
    ),
));

$moObatAlkes = new PIObatalkesM('search');
$moObatAlkes->unsetAttributes();
if (isset($_GET['PIObatalkesM']))
    $moObatAlkes->attributes = $_GET['PIObatalkesM'];

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'rjobat-alkes-m-grid',
    'dataProvider' => $moObatAlkes->search(),
    'filter' => $moObatAlkes,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("rel"=>"tooltip","title"=>"Pilih Obat/Alkes","class"=>"btn_small",
                        "id"=>"selectObat",
                        "onClick"=>"

                                    $(\"#obatalkes_id\").val(\"$data->obatalkes_id\");
									$(\"#satuankecil_id\").val(\"$data->satuankecil_id\");
                                    $(\"#pakaiBahan\").val(\"$data->obatalkes_nama\");
									
                                    $(\'#qty_input\').val(\'$data->kemasanterkecil\');
									$(\'#jmlkemasan\').val(\'$data->kemasanterkecil\');
									$(\'#dialogAlkes\').dialog(\'close\');										
									setSatuanObat($data->obatalkes_id);
									totalKonversi();
//										inputPemakaianBahan($data->obatalkes_id);
                                    return false;
                        ",
                       ))'
        ),
        'obatalkes_kategori',
        'obatalkes_nama',
        'obatalkes_golongan',
        array(
            'name' => 'satuankecilNama',
            'value' => '$data->satuankecil->satuankecil_nama',
        ),
        array(
            'name' => 'sumberdanaNama',
            'value' => '$data->sumberdana->sumberdana_nama',
        ),
        'minimalstok',
        //'hargajual',
        array(
            'name' => 'hargajual',
            'value' => 'number_format($data->hargajual)',
        ),
        array(
            'header' => 'Jumlah Stok',
            'type' => 'raw',
            'value' => '$data->StokObatRuangan',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>

<script type="text/javascript">
    $('#alatMedis').parent().addClass('hide');
    $('#qtyMedis').addClass('hide');

    function pilihAlkesMedis(obj) {
        // $('#tblInputPemakaianBahan > tbody').html('');
        // $('#totPemakaianBahan').val('0');
        if (obj.value == 'bahan') {
            $('#alatMedis').parent().addClass('hide');
            $('#qtyMedis').addClass('hide');
            $('#pakaiBahan').parent().removeClass('hide');
            $('#qtyBahan').removeClass('hide');
        } else if (obj.value == 'medis') {
            $('#pakaiBahan').parent().addClass('hide');
            $('#qtyBahan').addClass('hide');
            $('#alatMedis').parent().removeClass('hide');
            $('#qtyMedis').removeClass('hide');
        }
    }

    function inputPemakaianBahan() {
        var obatalkes_id = $('#obatalkes_id').val();
        var penjamin_id = $('#penjamin_id').val();
        //    var qty_oa = $('#qty_oa').val(); //RND-11929
        var qty_oa = $('#jmlkonversi').val();
        var daftartindakan_id = $('#daftartindakanPemakaianBahan option:selected').val();
        if (daftartindakan_id == '') {
            myAlert('Belum ada Tindakan');
            return false;
        }
        var pendaftaran_id = <?php echo (isset($_GET['pendaftaran_id']) ? $_GET['pendaftaran_id'] : null); ?>;

        jQuery.ajax({
            'url': '<?php echo Yii::app()->createUrl('perawatanIntensif/tindakanTPI/addFormPemakaianBahan') ?>',
            'data': {
                obatalkes_id: obatalkes_id,
                daftartindakan_id: daftartindakan_id,
                pendaftaran_id: pendaftaran_id,
                qty_oa: qty_oa,
                penjamin_id: penjamin_id
            },
            'type': 'post',
            'dataType': 'json',
            'success': function(data) {
                if (data.pesan != '') {
                    myAlert(data.pesan);
                }
                if (!sudahAdaBahan(obatalkes_id)) {
                    $('#tblInputPemakaianBahan #trPemakaianBahan').detach();
                    $('#tblInputPemakaianBahan > tbody').append(data.form);
                    //                         echo CHtml::link("<i class='icon-minus'></i>", '#', array('onclick'=>'batalTindakan(this);return false;','rel'=>'tooltip','title'=>'Klik untuk membatalkan tindakan'));
                    //                         renameInput('pemakaianBahan', 'obatalkes_id');
                    //                         renameInput('pemakaianBahan', 'hargajual');
                    //                         renameInput('pemakaianBahan', 'hargasatuan');
                    //                         renameInput('pemakaianBahan', 'harganetto');
                    //                         renameInput('pemakaianBahan', 'qty');
                    //                         renameInput('pemakaianBahan', 'subtotal');
                    //                         renameInput('pemakaianBahan', 'daftartindakan_id');
                    //                         renameInput('pemakaianBahan', 'sumberdana_id');
                    //                         renameInput('pemakaianBahan', 'satuankecil_id');
                    renameInputBAHP($("#tblInputPemakaianBahan"));
                    hitungTotal();
                    $('#obatalkes_id').val('');
                    $('#pakaiBahan').val('');
                    $('#qty_oa').val('');

                    $("#tblInputPemakaianBahan > tbody tr:last .integer").maskMoney({
                        "symbol": "",
                        "defaultZero": true,
                        "allowZero": true,
                        "decimal": ".",
                        "thousands": ",",
                        "precision": 0
                    });
                    $('.integer').each(function() {
                        this.value = formatNumber(this.value)
                    });
                }
            },
            'cache': false
        });
    }

    //    function renameInput(modelName,attributeName)
    //    {
    //        var i = -1;
    //        $('#tblInputPemakaianBahan tr').each(function(){
    //            if($(this).has('input[name$="[obatalkes_id]"]').length){
    //                i++;
    //            }
    //            $(this).find('input[name$="['+attributeName+']"]').attr('name',modelName+'['+i+']['+attributeName+']');
    //            $(this).find('input[name$="['+attributeName+']"]').attr('id',modelName+'_'+i+'_'+attributeName+'');
    //            $(this).find('select[name$="['+attributeName+']"]').attr('name',modelName+'['+i+']['+attributeName+']');
    //            $(this).find('select[name$="['+attributeName+']"]').attr('id',modelName+'_'+i+'_'+attributeName+'');
    //        });
    //    }

    function removeObat(obj) {
        myConfirm("Apakah Anda akan menghapus obat ini?", "Perhatian!", function(r) {
            if (r) {
                $(obj).parent().parent().remove();

                renameInputAfterRemove('pemakaianBahan', 'obatalkes_id');
                renameInputAfterRemove('pemakaianBahan', 'hargajual');
                renameInputAfterRemove('pemakaianBahan', 'qty');
                renameInputAfterRemove('pemakaianBahan', 'subtotal');
                renameInputAfterRemove('pemakaianBahan', 'daftartindakan_id');

                renameInputAfterRemove('pemakaianBahan', 'hargasatuan');
                renameInputAfterRemove('pemakaianBahan', 'harganetto');
                renameInputAfterRemove('pemakaianBahan', 'sumberdana_id');
                renameInputAfterRemove('pemakaianBahan', 'satuankecil_id');
                hitungTotal();
            }
        });
    }

    function removeObat(obj) {
        myConfirm("Apakah Anda akan menghapus alat medis ini?", "Perhatian!", function(r) {
            if (r) {
                $(obj).parent().parent().remove();

                renameInputPemakaianBahanAlatMedis('pemakaianAlat', 'alatmedis_id');
                renameInputPemakaianBahanAlatMedis('pemakaianAlat', 'hargajual');
                renameInputPemakaianBahanAlatMedis('pemakaianAlat', 'hargasatuan');
                renameInputPemakaianBahanAlatMedis('pemakaianAlat', 'harganetto');
                renameInputPemakaianBahanAlatMedis('pemakaianAlat', 'qty');
                renameInputPemakaianBahanAlatMedis('pemakaianAlat', 'subtotal');
                renameInputPemakaianBahanAlatMedis('pemakaianAlat', 'daftartindakan_id');
                renameInputPemakaianBahanAlatMedis('pemakaianAlat', 'sumberdana_id');
                renameInputPemakaianBahanAlatMedis('pemakaianAlat', 'satuankecil_id');
                hitungTotal();
            }
        });
    }

    function renameInputAfterRemove(modelName, attributeName) {
        var i = -1;
        $('#tblInputPemakaianBahan tr').each(function() {
            if ($(this).has('input[name$="[obatalkes_id]"]').length) {
                i++;
            }
            $(this).find('input[name$="[' + attributeName + ']"]').attr('name', modelName + '[' + i + '][' + attributeName + ']');
            $(this).find('input[name$="[' + attributeName + ']"]').attr('id', modelName + '_' + i + '_' + attributeName + '');
            $(this).find('select[name$="[' + attributeName + ']"]').attr('name', modelName + '[' + i + '][' + attributeName + ']');
            $(this).find('select[name$="[' + attributeName + ']"]').attr('id', modelName + '_' + i + '_' + attributeName + '');
        });
    }

    function hitungSubTotal(obj, tidak_hitung_total) {
        var qty = unformatNumber(obj.value);
        var harga = unformatNumber($(obj).parents("#tblInputPemakaianBahan tr").find('input[name$="[hargasatuan]"]').val());
        var subtotal = qty * harga;
        $(obj).parents("#tblInputPemakaianBahan tr").find('input[name$="[subtotal]"]').val(formatNumber(subtotal));
        if (tidak_hitung_total == false) {
            hitungTotal();
        }
    }

    function hitungTotal() {
        var total = 0;
        $('#tblInputPemakaianBahan').find('input[name$="[subtotal]"]').each(function() {
            hitungSubTotal($(this).parents("tr").find('.qty').get(0), true);
            total = total + unformatNumber(this.value);
        });
        $('#totPemakaianBahan').val(formatNumber(total));
    }

    function inputAlatmedis(alatmedis_id) {
        var daftartindakan_id = $('#daftartindakanPemakaianBahan option:selected').val();
        if (daftartindakan_id == '') {
            myAlert('Belum ada Tindakan');
            return false;
        }

        jQuery.ajax({
            'url': '<?php echo Yii::app()->createUrl('perawatanIntensif/tindakanTPI/addFormPemakaianAlat') ?>',
            'data': {
                alatmedis_id: alatmedis_id,
                daftartindakan_id: daftartindakan_id
            },
            'type': 'post',
            'dataType': 'json',
            'success': function(data) {
                if (!sudahAdaAlat(alatmedis_id)) {
                    $('#tblInputPemakaianBahan #trPemakaianBahan').detach();
                    $('#tblInputPemakaianBahan > tbody').append(data.form);
                    renameInputPemakaianBahanAlatMedis('pemakaianAlat', 'alatmedis_id');
                    renameInputPemakaianBahanAlatMedis('pemakaianAlat', 'hargajual');
                    renameInputPemakaianBahanAlatMedis('pemakaianAlat', 'hargasatuan');
                    renameInputPemakaianBahanAlatMedis('pemakaianAlat', 'harganetto');
                    renameInputPemakaianBahanAlatMedis('pemakaianAlat', 'qty');
                    renameInputPemakaianBahanAlatMedis('pemakaianAlat', 'subtotal');
                    renameInputPemakaianBahanAlatMedis('pemakaianAlat', 'daftartindakan_id');
                    renameInputPemakaianBahanAlatMedis('pemakaianAlat', 'sumberdana_id');
                    renameInputPemakaianBahanAlatMedis('pemakaianAlat', 'satuankecil_id');
                    hitungTotal();
                }

                $("#tblInputPemakaianBahan > tbody tr:last .integer").maskMoney({
                    "symbol": "",
                    "defaultZero": true,
                    "allowZero": true,
                    "decimal": ".",
                    "thousands": ",",
                    "precision": 0
                });
                $('.integer').each(function() {
                    this.value = formatNumber(this.value)
                });
            },
            'cache': false
        });
    }

    function sudahAdaAlat(alatmedis_id) {
        var ada;
        $('#tblInputPemakaianBahan').find('input[name$="[alatmedis_id]"]').each(function() {
            var cek = true;
            if (this.value != alatmedis_id) {
                ada = cek && ada;
            } else {
                myAlert('Sudah ada!');
                ada = cek && true;
            }
        });

        return ada;
    }

    function sudahAdaBahan(obatalkes_id) {
        var ada;
        $('#tblInputPemakaianBahan').find('input[name$="[obatalkes_id]"]').each(function() {
            var cek = true;
            if (this.value != obatalkes_id) {
                ada = cek && ada;
            } else {
                myAlert('Sudah ada!');
                ada = cek && true;
            }
        });
        $('#obatalkes_id').val('');
        $('#pakaiBahan').val('');
        $('#qty_oa').val('');

        return ada;
    }

    /**
     * rename input grid
     */
    function renameInputBAHP(obj_table) {
        var row = 0;
        $(obj_table).find("tbody > tr.pemakaian_bahan").each(function() {
            $(this).find("#no_urut").val(row + 1);
            $(this).find('span').each(function() { //element <input>
                var old_name = $(this).attr("name").replace(/]/g, "");
                var old_name_arr = old_name.split("[");
                if (old_name_arr.length == 3) {
                    $(this).attr("name", "[" + row + "][" + old_name_arr[2] + "]");
                }
            });
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

    // untuk menjumlahkan konversi dari qty input / jmlkemasan terkecil
    function totalKonversi() {
        unformatNumberSemua();
        var qty_input = parseFloat($('#qty_oa').val());
        var jmlkemasan = parseFloat($('#jmlkemasan').val());
        var jmlkonversi = parseFloat($('#jmlkonversi').val());

        var jml = qty_input / jmlkemasan;
        if (!jQuery.isNumeric(jml)) {
            jml = 0;
        }
        $('#jmlkonversi').val(jml);
        formatNumberSemua();
    }

    function totalJumlah() {
        unformatNumberSemua();
        var qty_input = parseFloat($('#qty_oa').val());
        var jmlkemasan = parseFloat($('#jmlkemasan').val());
        var jmlkonversi = parseFloat($('#jmlkonversi').val());

        var jumlah = jmlkonversi * jmlkemasan;
        if (!jQuery.isNumeric(jumlah)) {
            jumlah = 0;
        }
        $('#qty_oa').val(jumlah);
        formatNumberSemua();
    }

    function setSatuanObat(obatalkes_id) {
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('setSatuanObat'); ?>',
            data: {
                obatalkes_id: obatalkes_id
            },
            dataType: "json",
            success: function(data) {
                if (data.pesan != "") {
                    myAlert(data.pesan);
                } else {
                    $('#satuankecil_nama').html(data.satuankecil);
                    $('#satuanterkecil_nama').html(data.satuanterkecil);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                myAlert("Data Obat tidak ditemukan!");
                console.log(errorThrown);
            }
        });
    }
</script>

<?php
//========= Dialog buat cari data Alat Kesehatan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogAlatmedis',
    'options' => array(
        'title' => 'Alat Medis',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'height' => 550,
        'resizable' => false,
    ),
));

$modAlat = new AlatmedisM('search');
$modAlat->unsetAttributes();
if (isset($_GET['AlatmedisM']))
    $modAlat->attributes = $_GET['AlatmedisM'];

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'almes-m-grid',
    'dataProvider' => $modAlat->search(),
    'filter' => $modAlat,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        'jenisalatmedis.jenisalatmedis_nama',
        'alatmedis_nama',
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                    "id" => "selectObat",
                                    "onClick" => "inputAlatmedis($data->alatmedis_id); $(\'#dialogAlatmedis\').dialog(\'close\'); return false;"))',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget('zii.widgets.jui.CJuiDialog');
?>