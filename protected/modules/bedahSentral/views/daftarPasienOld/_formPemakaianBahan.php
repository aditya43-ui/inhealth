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
                    <?php //echo CHtml::link('<i class="entypo-search"></i>', '#', array('class' => 'btn btn-danger','onclick'=>'$("#dialogAlkes").dialog("open");return false;')); 
                    ?>
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
                    <?php $this->widget('MyJuiAutoComplete', array(
                        'name' => 'pakaiBahan',
                        'value' => '',
                        'source' => 'js: function(request, response) {
                                               $.ajax({
                                                   url: "' . Yii::app()->createUrl('ActionAutoComplete/PemakaianBahan') . '",
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
                                        inputPemakaianBahan(ui.item.obatalkes_id);
                                        return false;
                                    }',

                        ),
                        'htmlOptions' => array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span2', 'placeholder' => 'Pemakaian BMHP'),
                        'tombolDialog' => array('idDialog' => 'dialogAlkes'),
                    )); ?>
                    <?php //echo CHtml::link('<i class="entypo-search"></i>', '#', array('class' => 'btn btn-danger','onclick'=>'$("#dialogAlatmedis").dialog("open");return false;')); 
                    ?>

                    <?php $this->widget('MyJuiAutoComplete', array(
                        'name' => 'alatMedis',
                        'value' => '',
                        'source' => 'js: function(request, response) {
                                               $.ajax({
                                                   url: "' . Yii::app()->createUrl('ActionAutoComplete/PemakaianAlatMedis') . '",
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
        </table>
        <table class="items table table-striped table-condensed" id="tblInputPemakaianBahan">
            <thead>
                <tr>
                    <th width="300">Uraian Tindakan</th>
                    <th>Nama Alkes/Alat Medis</th>
                    <th width="50">Jumlah</th>
                    <th width="30">&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $data = '';
                if (count((array)$modViewBahan) > 0) {
                    for ($i = 0; $i < count((array)$modViewBahan); $i++) {
                        $modDaftartindakan = DaftartindakanM::model()->findByPk(
                            $modViewBahan[$i]['daftartindakan_id']
                        );
                ?>
                        <tr>
                            <td>
                                <?php echo isset($modDaftartindakan->daftartindakan_nama) ? $modDaftartindakan->daftartindakan_nama : " - "; ?>
                            </td>
                            <td>
                                <?php echo $modViewBahan[$i]['obatalkes']['obatalkes_nama']; ?>
                            </td>
                            <td><?php echo $modViewBahan[$i]['qty_oa']; ?></td>
                            <td>&nbsp;</td>
                        </tr>
                <?php
                    }
                }
                echo $data;
                ?>
            </tbody>
        </table>
    </div>
</div>

<?php
//========= Dialog buat cari data Alat Kesehatan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogAlkes',
    'options' => array(
        'title' => 'Obat dan Alkes Stok ' . Yii::app()->user->getState('ruangan_nama'),
        'autoOpen' => false,
        'modal' => true,
        'width' => 950,
        'height' => 600,
        'resizable' => false,
    ),
));

/*$moObatAlkes = new BSObatalkesM('search');
$moObatAlkes->unsetAttributes();
if(isset($_GET['BSObatalkesM']))
    $moObatAlkes->attributes = $_GET['BSObatalkesM'];

$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'rjobat-alkes-m-grid',
	'dataProvider'=>$moObatAlkes->searchObatFarmasi(),
	'filter'=>$moObatAlkes,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
				array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                    "id" => "selectObat",
                                    "onClick" => "inputPemakaianBahan($data->obatalkes_id);return false;"))',
                ),
                'obatalkes_kategori',
		'obatalkes_nama',
                'obatalkes_golongan',
                array(
                    'name'=>'satuankecilNama',
                    'value'=>'$data->satuankecil->satuankecil_nama',
                ),
                array(
                    'name'=>'sumberdanaNama',
                    'value'=>'$data->sumberdana->sumberdana_nama',
                ),
                'minimalstok',
		//'hargajual',
                array(
                    'name'=>'hargajual',
                    'value'=>'number_format($data->hargajual)',
                ),
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); */

$modObatAlkes = new InfostokobatalkesruanganV('searchObat');
$modObatAlkes->unsetAttributes();
if (isset($_GET['InfostokobatalkesruanganV'])) {
    $modObatAlkes->attributes = $_GET['InfostokobatalkesruanganV'];
    //$modObatAlkes->jenisobatalkes_nama = $_GET['InfostokobatalkesruanganV']['jenisobatalkes_nama'];
    // $modObatAlkes->satuankecil_nama = $_GET['InfostokobatalkesruanganV']['satuankecil_nama'];
    //    $modObatAlkes->sumberdana_nama = $_GET['LBObatalkesM']['sumberdana_nama'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'obatalkes-m-grid',
    'dataProvider' => $modObatAlkes->searchObat(),
    'filter' => $modObatAlkes,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                    "id" => "selectObat",
                                    "onClick" => "inputPemakaianBahan($data->obatalkes_id);return false;"
                                        ))',
        ),
        array(
            'name' => 'jenisobatalkes_id',
            'type' => 'raw',
            'value' => function ($data) {
                return (!empty($data->jenisobatalkes_id) ? $data->jenisobatalkes_nama : "");
            },
            'filter' =>  CHtml::activeDropDownList($modObatAlkes, 'jenisobatalkes_id', CHtml::listData(
                JenisobatalkesM::model()->findAll(array(
                    'condition' => 'jenisobatalkes_aktif = true',
                    'order' => 'jenisobatalkes_nama',
                )),
                'jenisobatalkes_id',
                'jenisobatalkes_nama'
            ), array('empty' => '-- Pilih --')),
        ),
        array(
            'name' => 'obatalkes_kategori',
            'filter' =>  CHtml::activeDropDownList($modObatAlkes, 'obatalkes_kategori', LookupM::getItems('obatalkes_kategori'), array(
                'empty' => '-- Pilih --'
            ))
        ),
        array(
            'name' => 'obatalkes_golongan',
            'filter' =>  CHtml::activeDropDownList($modObatAlkes, 'obatalkes_golongan', LookupM::getItems('obatalkes_golongan'), array(
                'empty' => '-- Pilih --'
            ))
        ),
        array(
            'name' => 'obatalkes_nama',
            'filter' => CHtml::activeTextField($modObatAlkes, 'obatalkes_nama', array('class' => 'custom-only'))
        ),

        //  'obatalkes_kategori',
        // 'obatalkes_golongan',
        // array(
        //    'name'=>'satuankecil_id',
        //    'type'=>'raw',
        //     'value'=>'$data->satuankecil->satuankecil_nama',
        //    'filter'=>  CHtml::activeTextField($modObatAlkes, 'satuankecil_nama'),
        // ),
        //                array(
        //                    'name'=>'sumberdana_id',
        //                    'type'=>'raw',
        //                    'value'=>'$data->sumberdana->sumberdana_nama',
        //                    'filter'=>  CHtml::activeTextField($modObatAlkes, 'sumberdana_nama'),
        //                ),
        array(
            'header' => 'Jumlah Stok',
            'type' => 'raw',
            'value' => 'StokobatalkesT::getJumlahStok($data->obatalkes_id, Yii::app()->user->getState("ruangan_id"))." ".$data->satuankecil_nama',
        ),


    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'
        . '$(".custom-only").keyup(function(){setCustomOnly(this);});}',
));

$this->endWidget('zii.widgets.jui.CJuiDialog');
?>

<script type="text/javascript">
    $('#alatMedis').parent().addClass('hide');

    function pilihAlkesMedis(obj) {
        //$('#tblInputPemakaianBahan > tbody').html('');
        //    $('#totPemakaianBahan').val('0');
        if (obj.value == 'bahan') {
            $('#alatMedis').parent().addClass('hide');
            $('#pakaiBahan').parent().removeClass('hide');
        } else if (obj.value == 'medis') {
            $('#pakaiBahan').parent().addClass('hide');
            $('#alatMedis').parent().removeClass('hide');
        }
    }

    function inputPemakaianBahan(idObatAlkes) {
        var idDaftartindakan = $('#daftartindakanPemakaianBahan option:selected').val();
        if (idDaftartindakan == '') {
            myAlert('Belum ada Tindakan');
            return false;
        }

        jQuery.ajax({
            'url': '<?php echo $this->createUrl('addFormPemakaianBahan') ?>',
            'data': {
                idObatAlkes: idObatAlkes,
                idDaftartindakan: idDaftartindakan
            },
            'type': 'post',
            'dataType': 'json',
            'success': function(data) {
                $('#tblInputPemakaianBahan #trPemakaianBahan').detach();
                $('#tblInputPemakaianBahan > tbody').append(data.form);
                renameInput('pemakaianBahan', 'obatalkes_id');
                renameInput('pemakaianBahan', 'hargajual');
                renameInput('pemakaianBahan', 'hargasatuan');
                renameInput('pemakaianBahan', 'harganetto');
                renameInput('pemakaianBahan', 'qty');
                renameInput('pemakaianBahan', 'subtotal');
                renameInput('pemakaianBahan', 'daftartindakan_id');
                renameInput('pemakaianBahan', 'sumberdana_id');
                renameInput('pemakaianBahan', 'satuankecil_id');
                hitungTotal();

                $("#tblInputPemakaianBahan > tbody tr:last .integer2").maskMoney({
                    "defaultZero": true,
                    "allowZero": true,
                    "decimal": ",",
                    "thousands": ".",
                    "precision": 0
                });
                //                        $('.currency').each(function(){this.value = formatNumber(this.value)});
                $("#tblInputPemakaianBahan > tbody tr:last .number").maskMoney({
                    "defaultZero": true,
                    "allowZero": true,
                    "decimal": ",",
                    "thousands": "",
                    "precision": 0,
                    "symbol": null,
                    "allowDecimal": true
                });
                //                        $('.number').each(function(){this.value = formatNumber(this.value)});
                $("#dialogAlkes").dialog('close');
            },
            'cache': false
        });

        function renameInput(modelName, attributeName) {
            var i = -1;
            $('#tblInputPemakaianBahan tr.pemakaian_bahan').each(function() {
                if ($(this).has('input[name$="[obatalkes_id]"]').length) {
                    i++;
                }
                $(this).find('input[id=' + modelName + '_0_' + attributeName + ']').attr('name', modelName + '[' + i + '][' + attributeName + ']');
                $(this).find('input[id=' + modelName + '_0_' + attributeName + ']').attr('id', modelName + '_' + i + '_' + attributeName + '');
                $(this).find('select[id=' + modelName + '_0_' + attributeName + ']').attr('name', modelName + '[' + i + '][' + attributeName + ']');
                $(this).find('select[id=' + modelName + '_0_' + attributeName + ']').attr('id', modelName + '_' + i + '_' + attributeName + '');
            });
        }
    }

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
            }
        });
        hitungTotal();
    }

    function removeAlatMedis(obj) {
        myConfirm("Apakah Anda akan menghapus pemakaian alat medis?", "Perhatian!", function(r) {
            if (r) {
                $(obj).parent().parent().remove();

                renameInputAfterRemoveAlatMedis('pemakaianAlat', 'daftartindakan_id');
                renameInputAfterRemoveAlatMedis('pemakaianAlat', 'alatmedis_id');
                renameInputAfterRemoveAlatMedis('pemakaianAlat', 'hargajual');
                renameInputAfterRemoveAlatMedis('pemakaianAlat', 'hargasatuan');
                renameInputAfterRemoveAlatMedis('pemakaianAlat', 'harganetto');

                renameInputAfterRemoveAlatMedis('pemakaianBahan', 'sumberdana_id');
                renameInputAfterRemoveAlatMedis('pemakaianBahan', 'qty');
                renameInputAfterRemoveAlatMedis('pemakaianBahan', 'satuankecil_id');
                renameInputAfterRemoveAlatMedis('pemakaianBahan', 'subtotal');
            }
        });
        hitungTotal();
    }

    function renameInputAfterRemove(modelName, attributeName) {
        var i = -1;
        $('#tblInputPemakaianBahan tr.pemakaian_bahan').each(function() {
            if ($(this).has('input[name$="[obatalkes_id]"]').length) {
                i++;
            }
            $(this).find('input[name$="[' + attributeName + ']"]').attr('name', modelName + '[' + i + '][' + attributeName + ']');
            $(this).find('input[name$="[' + attributeName + ']"]').attr('id', modelName + '_' + i + '_' + attributeName + '');
            $(this).find('select[name$="[' + attributeName + ']"]').attr('name', modelName + '[' + i + '][' + attributeName + ']');
            $(this).find('select[name$="[' + attributeName + ']"]').attr('id', modelName + '_' + i + '_' + attributeName + '');
        });
    }

    function renameInputAfterRemoveAlatMedis(modelName, attributeName) {
        var i = -1;
        $('#tblInputPemakaianBahan tr.pemakaian_alat').each(function() {
            if ($(this).has('input[name$="[alatmedis_id]"]').length) {
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
        var harga = unformatNumber($(obj).parents("#tblInputPemakaianBahan tr").find('input[name$="[hargajual]"]').val());
        var subtotal = qty * harga;
        $(obj).parents("#tblInputPemakaianBahan tr").find('input[name$="[subtotal]"]').val(formatNumber(subtotal));
        hitungTotal();
        //    $('.currency').each(function(){this.value = formatNumber(this.value)});
        //    $('.number').each(function(){this.value = formatNumber(this.value)});
    }

    function hitungTotal() {
        var total = 0;
        $('#tblInputPemakaianBahan').find('input[name$="[subtotal]"]').each(function() {
            total = total + unformatNumber(this.value);
        });
        //    $('#totPemakaianBahan').val(formatNumber(total));
    }

    function inputAlatmedis(idAlat) {
        var idDaftartindakan = $('#daftartindakanPemakaianBahan option:selected').val();
        if (idDaftartindakan == '') {
            myAlert('Belum ada Tindakan');
            return false;
        }

        var is_ada = false;
        $('#tblInputPemakaianBahan tbody tr.pemakaian_alat').each(function() {
            if ($(this).find(".daftartindakan_id").val() == idDaftartindakan) {
                $(this).remove();
            }
        });

        jQuery.ajax({
            'url': '<?php echo $this->createUrl('addFormPemakaianAlat') ?>',
            'data': {
                idAlat: idAlat,
                idDaftartindakan: idDaftartindakan
            },
            'type': 'post',
            'dataType': 'json',
            'success': function(data) {
                if (!sudahAdaAlat(idAlat)) {
                    $('#tblInputPemakaianBahan #trPemakaianBahan').detach();
                    $('#tblInputPemakaianBahan > tbody').append(data.form);
                    renameInput('pemakaianAlat', 'alatmedis_id');
                    renameInput('pemakaianAlat', 'hargajual');
                    renameInput('pemakaianAlat', 'hargasatuan');
                    renameInput('pemakaianAlat', 'harganetto');
                    renameInput('pemakaianAlat', 'qty');
                    renameInput('pemakaianAlat', 'subtotal');
                    renameInput('pemakaianAlat', 'daftartindakan_id');
                    renameInput('pemakaianAlat', 'sumberdana_id');
                    hitungTotal();
                }

                $("#tblInputPemakaianBahan > tbody tr:last .currency").maskMoney({
                    "symbol": "Rp ",
                    "defaultZero": true,
                    "allowZero": true,
                    "decimal": ",",
                    "thousands": ".",
                    "precision": 0
                });
                $('.currency').each(function() {
                    this.value = formatNumber(this.value)
                });
                $("#tblInputPemakaianBahan > tbody tr:last .number").maskMoney({
                    "defaultZero": true,
                    "allowZero": true,
                    "decimal": ",",
                    "thousands": ".",
                    "precision": 0,
                    "symbol": null
                });
                $('.number').each(function() {
                    this.value = formatNumber(this.value)
                });
            },
            'cache': false
        });

        function sudahAdaAlat(idAlat) {
            var ada;
            $('#tblInputPemakaianBahan').find('input[name$="[alatmedis_id]"]').each(function() {
                var cek = true;
                if (this.value != idAlat) {
                    ada = cek && ada;
                } else {
                    myAlert('Sudah ada!');
                    ada = cek && true;
                }
            });

            return ada;
        }

        function renameInput(modelName, attributeName) {
            var i = -1;
            $('#tblInputPemakaianBahan tr.pemakaian_alat').each(function() {
                if ($(this).has('input[name$="[alatmedis_id]"]').length) {
                    i++;
                }
                $(this).find('input[id=' + modelName + '_0_' + attributeName + ']').attr('name', modelName + '[' + i + '][' + attributeName + ']');
                $(this).find('input[id=' + modelName + '_0_' + attributeName + ']').attr('id', modelName + '_' + i + '_' + attributeName + '');
                $(this).find('select[id=' + modelName + '_0_' + attributeName + ']').attr('name', modelName + '[' + i + '][' + attributeName + ']');
                $(this).find('select[id=' + modelName + '_0_' + attributeName + ']').attr('id', modelName + '_' + i + '_' + attributeName + '');
            });
        }
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
        'width' => 600,
        'height' => 600,
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