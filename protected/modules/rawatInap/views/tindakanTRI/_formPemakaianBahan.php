<style>
    tr td .add-on,
    tr:last-child td label, tr:last-child td input {
        margin: 0 !important;
    }
</style>

<table style="width: 100%; border: none;">
    <?php /*
        <tr>
            <td colspan="2">
                <?php echo CHtml::radioButton('pilihAlkes', true, array('value'=>'bahan','onclick'=>'pilihAlkesMedis(this);')); ?>
                Pemakaian BMHP
                <?php echo CHtml::radioButton('pilihAlkes', false, array('value'=>'medis','onclick'=>'pilihAlkesMedis(this);')); ?>
                Alat Medis
            </td>
        </tr>
         * 
         */ ?>
    <tr>
        <td>
            <?php echo CHtml::dropDownList('daftartindakanPemakaianBahan', '', array(), array('empty' => 'Uraian Tindakan')) ?>
        </td>
        <td>
            <?php echo CHtml::hiddenField('obatalkes_id'); ?>
            <?php $this->widget('MyJuiAutoComplete', array(
                'name' => 'pakaiBahan',
                'value' => '',
                'source' => 'js: function(request, response) {
                                           $.ajax({
                                               url: "' . Yii::app()->createUrl('rawatInap/tindakanTRI/PemakaianBahan') . '",
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
//                                    inputPemakaianBahan(ui.item.obatalkes_id);
                                    $(this).val( ui.item.label);
                                    $("#obatalkes_id").val(ui.item.obatalkes_id);
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
                                               url: "' . Yii::app()->createUrl('rawatInap/tindakanTRI/PemakaianAlatMedis') . '",
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
        <td>
            <div class="control-group" id="qtyBahan">
                <label class="control-label" for="qty">Jumlah</label>
                <div class="controls">
                    <?php echo CHtml::textField('qty_oa', '1', array('readonly' => false, 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'inputFormTabel span1 numbersOnly')) ?>
                    <?php echo CHtml::htmlButton(
                        '<i class="icon-plus icon-white"></i>',
                        array(
                            'onclick' => 'inputPemakaianBahan(this);return false;',
                            'class' => 'btn btn-primary',
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
                            'class' => 'btn btn-primary',
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
            <th>Nama Alat Medis</th>
            <!--<th>Harga</th>-->
            <th>Jumlah</th>
            <th <?php echo Params::HIDDEN_HARGA ?>>Sub Total</th>
            <th>&nbsp;</th>
        </tr>
    </thead>
    <tbody>

    </tbody>
</table>
<div <?php echo Params::HIDDEN_HARGA ?>>
    <b>Total Pemakaian BMHP : </b>
    <?php echo CHtml::textField("totPemakaianBahan", 0, array('readonly' => true, 'class' => 'inputFormTabel integer')); ?>
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

$moObatAlkes = new RIObatalkesM('search');
$moObatAlkes->unsetAttributes();
if (isset($_GET['RIObatalkesM']))
    $moObatAlkes->attributes = $_GET['RIObatalkesM'];

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
                                    $(\"#pakaiBahan\").val(\"$data->obatalkes_nama\");

                                    $(\"#dialogAlkes\").dialog(\"close\");
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
            'visible' => Params::HIDDEN_GRID_HARGA
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
        //$('#tblInputPemakaianBahan > tbody').html('');
        //$('#totPemakaianBahan').val('0');
        //if(obj.value=='bahan'){
        //    $('#alatMedis').parent().addClass('hide');
        //    $('#qtyMedis').addClass('hide');
        //    $('#pakaiBahan').parent().removeClass('hide');
        //    $('#qtyBahan').removeClass('hide');
        //} else if(obj.value=='medis') {
        $('#pakaiBahan').parent().addClass('hide');
        $('#qtyBahan').addClass('hide');
        $('#alatMedis').parent().removeClass('hide');
        $('#qtyMedis').removeClass('hide');
        //}
    }

    function inputPemakaianBahan() {
        var obatalkes_id = $('#obatalkes_id').val();
        var qty_oa = $('#qty_oa').val();
        var daftartindakan_id = $('#daftartindakanPemakaianBahan option:selected').val();
        if (daftartindakan_id == '') {
            alert('Belum ada Tindakan');
            return false;
        }
        var pendaftaran_id = <?php echo (isset($_GET['pendaftaran_id']) ? $_GET['pendaftaran_id'] : null); ?>;

        jQuery.ajax({
            'url': '<?php echo Yii::app()->createUrl('rawatInap/tindakanTRI/addFormPemakaianBahan') ?>',
            'data': {
                obatalkes_id: obatalkes_id,
                daftartindakan_id: daftartindakan_id,
                pendaftaran_id: pendaftaran_id,
                qty_oa: qty_oa
            },
            'type': 'post',
            'dataType': 'json',
            'success': function(data) {
                if (data.pesan != '') {
                    alert(data.pesan);
                }
                if (!sudahAdaBahan(obatalkes_id)) {
                    $('#tblInputPemakaianBahan #trPemakaianBahan').detach();
                    $('#tblInputPemakaianBahan > tbody').append(data.form);
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
                    $('#qty_oa').val(1);

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
        myConfirm("Apakah Anda akan menghapus obat?", "Perhatian!", function(r) {
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

    function hitungSubTotal(obj) {
        var qty = unformatNumber(obj.value);
        var harga = unformatNumber($(obj).parents("#tblInputPemakaianBahan tr").find('input[name$="[hargasatuan]"]').val());
        var subtotal = qty * harga;
        $(obj).parents("#tblInputPemakaianBahan tr").find('input[name$="[subtotal]"]').val(formatNumber(subtotal));
        hitungTotal();
    }

    function hitungTotal() {
        var total = 0;
        $('#tblInputPemakaianBahan').find('input[name$="[subtotal]"]').each(function() {
            total = total + unformatNumber(this.value);
        });
        $('#totPemakaianBahan').val(formatNumber(total));
    }

    function inputAlatmedis(alatmedis_id) {
        var daftartindakan_id = $('#daftartindakanPemakaianBahan option:selected').val();
        if (daftartindakan_id == '') {
            alert('Belum ada Tindakan');
            return false;
        }

        jQuery.ajax({
            'url': '<?php echo Yii::app()->createUrl('rawatInap/tindakanTRI/addFormPemakaianAlat') ?>',
            'data': {
                alatmedis_id: alatmedis_id,
                daftartindakan_id: daftartindakan_id
            },
            'type': 'post',
            'dataType': 'json',
            'success': function(data) {
                if (!sudahAdaAlat(alatmedis_id)) {
                    if (!sudahAdaTindakanAlat(daftartindakan_id, data.daftarTinNama)) {
                        $('#tblInputPemakaianBahan #trPemakaianBahan').detach();
                        $('#tblInputPemakaianBahan > tbody').append(data.form);
                        //renameInput('pemakaianAlat', 'alatmedis_id');
                        //renameInput('pemakaianAlat', 'hargajual');
                        //renameInput('pemakaianAlat', 'hargasatuan');
                        //renameInput('pemakaianAlat', 'harganetto');
                        //renameInput('pemakaianAlat', 'qty');
                        //renameInput('pemakaianAlat', 'subtotal');
                        //renameInput('pemakaianAlat', 'daftartindakan_id');
                        //renameInput('pemakaianAlat', 'sumberdana_id');
                        renameInputBAHP($('#tblInputPemakaianBahan'));
                        hitungTotal();
                    }
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
                alert('Sudah ada!');
                ada = cek && true;
            }
        });

        return ada;
    }

    /**
     * - digunakan untuk memvalidasi, bahwa 1 tindakan hanya menerima 1 alat medis saja
     * @param {type} daftartindakan_id
     * @returns {cek|Boolean}
     */
    function sudahAdaTindakanAlat(daftartindakan_id, daftarTinNama) {
        var ada;
        $('#tblInputPemakaianBahan').find('input[name$="[daftartindakan_id]"]').each(function() {
            var cek = true;
            if (this.value != daftartindakan_id) {
                ada = cek && ada;
            } else {
                alert('Maaf, Tindakan ' + daftarTinNama + ', sudah ditambahkan alat medisnya (1 tindakan hanya berlaku 1 alat medis)');
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
                alert('Sudah ada!');
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
        $(obj_table).find("tbody > tr").each(function() {
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

    $(document).ready(function() {
        pilihAlkesMedis(null);
    });
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
                                    "onClick" => "inputAlatmedis($data->alatmedis_id);return false;"))',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget('zii.widgets.jui.CJuiDialog');
?>